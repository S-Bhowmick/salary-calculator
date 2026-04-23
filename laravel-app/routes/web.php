<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\SalaryCalculation;
use App\Models\JobRole;
use App\Models\LocationBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    $jobRoles = JobRole::where('is_active', true)->orderBy('role_name')->get();
    $locations = LocationBonus::where('is_active', true)->orderBy('location_name')->get();

    return view('home', compact('jobRoles', 'locations'));
})->middleware('auth')->name('home');

Route::post('/calculate', function (Request $request) {
    $request->validate([
        'jobTitle' => 'required',
        'experience' => 'required|integer|min:0',
        'location' => 'required',
    ]);

    $jobRole = JobRole::where('role_name', $request->jobTitle)
        ->where('is_active', true)
        ->first();

    $locationBonus = LocationBonus::where('location_name', $request->location)
        ->where('is_active', true)
        ->first();

    if (!$jobRole) {
        return redirect()->route('home')->with('error', 'Selected job role not found.');
    }

    if (!$locationBonus) {
        return redirect()->route('home')->with('error', 'Selected location not found.');
    }

    $baseSalary = $jobRole->base_salary;
    $experience = (int) $request->experience;
    $experienceBonus = $experience * $jobRole->experience_increment;
    $locationBonusAmount = $locationBonus->bonus_amount;

    $annualGrossSalary = $baseSalary + $experienceBonus + $locationBonusAmount;
    $monthlyGrossSalary = $annualGrossSalary / 12;

    // Simple estimated deductions for demo purpose
    $estimatedTax = $annualGrossSalary * 0.20;
    $estimatedNationalInsurance = $annualGrossSalary * 0.08;
    $estimatedPension = $annualGrossSalary * 0.05;

    $annualNetSalary = $annualGrossSalary - $estimatedTax - $estimatedNationalInsurance - $estimatedPension;
    $estimatedNetMonthlySalary = $annualNetSalary / 12;

    SalaryCalculation::create([
        'user_id' => auth()->id(),
        'job_title' => $jobRole->role_name,
        'experience' => $experience,
        'location' => $locationBonus->location_name,
        'calculated_salary' => $annualGrossSalary,
    ]);

    return redirect()->route('home')->with([
        'base_salary' => $baseSalary,
        'experience_bonus' => $experienceBonus,
        'location_bonus' => $locationBonusAmount,
        'salary' => $annualGrossSalary,

        'annual_gross_salary' => $annualGrossSalary,
        'monthly_gross_salary' => $monthlyGrossSalary,
        'estimated_tax' => $estimatedTax,
        'estimated_national_insurance' => $estimatedNationalInsurance,
        'estimated_pension' => $estimatedPension,
        'estimated_net_monthly_salary' => $estimatedNetMonthlySalary,
    ]);
})->middleware('auth')->name('calculate.salary');

Route::get('/dashboard', function () {
    $calculations = SalaryCalculation::where('user_id', auth()->id())->latest()->get();

    return view('dashboard', compact('calculations'));
})->middleware('auth')->name('dashboard');

Route::delete('/calculation/{id}', function ($id) {
    $calculation = SalaryCalculation::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $calculation->delete();

    return redirect()->route('dashboard')->with('success', 'Calculation deleted successfully.');
})->middleware('auth')->name('calculation.delete');

Route::post('/favorite-calculation/{id}', function ($id) {
    $calculation = SalaryCalculation::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $calculation->is_favorite = !$calculation->is_favorite;
    $calculation->save();

    return redirect()->route('dashboard')->with('success', 'Favorite status updated successfully.');
})->middleware('auth')->name('calculation.favorite');

Route::post('/compare-calculations', function (Request $request) {
    $selectedIds = $request->input('selected_calculations', []);

    if (count($selectedIds) < 2) {
        return redirect()->route('dashboard')->with('success', 'Please select at least 2 calculations to compare.');
    }

    if (count($selectedIds) > 3) {
        return redirect()->route('dashboard')->with('success', 'You can compare maximum 3 calculations at a time.');
    }

    $comparisons = SalaryCalculation::whereIn('id', $selectedIds)
        ->where('user_id', auth()->id())
        ->get();

    return view('compare', compact('comparisons'));
})->middleware('auth')->name('calculations.compare');

Route::get('/download-report', function () {
    $calculations = SalaryCalculation::where('user_id', auth()->id())->latest()->get();
    $user = auth()->user();

    $pdf = Pdf::loadView('report-pdf', compact('calculations', 'user'));

    return $pdf->download('salary-report.pdf');
})->middleware('auth')->name('report.download');

Route::get('/admin', function () {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $users = User::withCount('salaryCalculations')->latest()->get();
    $calculations = SalaryCalculation::latest()->get();
    $jobRoles = JobRole::latest()->get();
    $locationBonuses = LocationBonus::latest()->get();

    $totalUsers = User::count();
    $totalCalculations = SalaryCalculation::count();
    $totalJobRoles = JobRole::count();
    $totalLocations = LocationBonus::count();

    $mostSelectedJobRole = SalaryCalculation::select('job_title', DB::raw('COUNT(*) as total'))
        ->groupBy('job_title')
        ->orderByDesc('total')
        ->first();

    $mostSelectedLocation = SalaryCalculation::select('location', DB::raw('COUNT(*) as total'))
        ->groupBy('location')
        ->orderByDesc('total')
        ->first();

    $averageSalary = round(SalaryCalculation::avg('calculated_salary') ?? 0, 2);
    $highestSalary = SalaryCalculation::max('calculated_salary') ?? 0;

    $totalActiveRoles = JobRole::where('is_active', true)->count();
    $totalActiveLocations = LocationBonus::where('is_active', true)->count();

    return view('admin', compact(
        'users',
        'calculations',
        'jobRoles',
        'locationBonuses',
        'totalUsers',
        'totalCalculations',
        'totalJobRoles',
        'totalLocations',
        'mostSelectedJobRole',
        'mostSelectedLocation',
        'averageSalary',
        'highestSalary',
        'totalActiveRoles',
        'totalActiveLocations'
    ));
})->middleware('auth')->name('admin.panel');

Route::post('/admin/job-role/add', function (Request $request) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $request->validate([
        'role_name' => 'required|string|max:255',
        'base_salary' => 'required|integer|min:0',
        'experience_increment' => 'required|integer|min:0',
    ]);

    JobRole::create([
        'role_name' => $request->role_name,
        'base_salary' => $request->base_salary,
        'experience_increment' => $request->experience_increment,
        'is_active' => true,
    ]);

    return redirect()->route('admin.panel')->with('success', 'Job role added successfully.');
})->middleware('auth')->name('admin.jobrole.add');

Route::post('/admin/location/add', function (Request $request) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $request->validate([
        'location_name' => 'required|string|max:255',
        'bonus_amount' => 'required|integer|min:0',
    ]);

    LocationBonus::create([
        'location_name' => $request->location_name,
        'bonus_amount' => $request->bonus_amount,
        'is_active' => true,
    ]);

    return redirect()->route('admin.panel')->with('success', 'Location bonus added successfully.');
})->middleware('auth')->name('admin.location.add');

Route::patch('/admin/user/{id}/toggle-active', function ($id) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $user = User::findOrFail($id);

    if ($user->id === auth()->id()) {
        return redirect()->route('admin.panel')->with('success', 'You cannot deactivate your own account.');
    }

    $user->is_active = !$user->is_active;
    $user->save();

    return redirect()->route('admin.panel')->with('success', 'User status updated successfully.');
})->middleware('auth')->name('admin.user.toggle');

Route::patch('/admin/user/{id}/promote', function ($id) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $user = User::findOrFail($id);

    if (!$user->is_admin) {
        $user->is_admin = true;
        $user->save();
    }

    return redirect()->route('admin.panel')->with('success', 'User promoted to admin successfully.');
})->middleware('auth')->name('admin.user.promote');

Route::patch('/admin/job-role/{id}/toggle-active', function ($id) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $role = JobRole::findOrFail($id);
    $role->is_active = !$role->is_active;
    $role->save();

    return redirect()->route('admin.panel')->with('success', 'Job role status updated successfully.');
})->middleware('auth')->name('admin.role.toggle');

Route::patch('/admin/location/{id}/toggle-active', function ($id) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $location = LocationBonus::findOrFail($id);
    $location->is_active = !$location->is_active;
    $location->save();

    return redirect()->route('admin.panel')->with('success', 'Location status updated successfully.');
})->middleware('auth')->name('admin.location.toggle');

Route::delete('/admin/calculation/{id}', function ($id) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $calculation = SalaryCalculation::findOrFail($id);
    $calculation->delete();

    return redirect()->route('admin.panel')->with('success', 'Calculation deleted by admin.');
})->middleware('auth')->name('admin.calculation.delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';