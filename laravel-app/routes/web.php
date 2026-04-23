<?php

use App\Http\Controllers\ProfileController;
use App\Http\Requests\CalculateSalaryRequest;
use App\Http\Requests\StoreJobRoleRequest;
use App\Http\Requests\StoreLocationBonusRequest;
use App\Models\JobRole;
use App\Models\LocationBonus;
use App\Models\SalaryCalculation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $jobRoles = JobRole::where('is_active', true)->orderBy('role_name')->get();
    $locations = LocationBonus::where('is_active', true)->orderBy('location_name')->get();

    return view('home', compact('jobRoles', 'locations'));
})->middleware(['auth', 'verified', 'active'])->name('home');

Route::post('/calculate', function (CalculateSalaryRequest $request) {
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

    $estimatedTax = $annualGrossSalary * 0.20;
    $estimatedNationalInsurance = $annualGrossSalary * 0.08;
    $estimatedPension = $annualGrossSalary * 0.05;

    $annualNetSalary = $annualGrossSalary - $estimatedTax - $estimatedNationalInsurance - $estimatedPension;
    $estimatedNetMonthlySalary = $annualNetSalary / 12;

    $cityEstimatedMonthlyCost = $locationBonus->estimated_monthly_cost ?? 0;
    $cityRemainingBalance = $estimatedNetMonthlySalary - $cityEstimatedMonthlyCost;

    $rent = (float) ($request->rent ?? 0);
    $food = (float) ($request->food ?? 0);
    $transport = (float) ($request->transport ?? 0);
    $bills = (float) ($request->bills ?? 0);
    $other = (float) ($request->other ?? 0);

    $totalMonthlyExpenses = $rent + $food + $transport + $bills + $other;
    $remainingBalance = $estimatedNetMonthlySalary - $totalMonthlyExpenses;

    $savingsGoal = (float) ($request->savings_goal ?? 0);
    $monthsToGoal = null;

    if ($savingsGoal > 0 && $remainingBalance > 0) {
        $monthsToGoal = ceil($savingsGoal / $remainingBalance);
    }

    if ($cityRemainingBalance >= 500) {
        $affordabilityStatus = 'Comfortable';
    } elseif ($cityRemainingBalance >= 0) {
        $affordabilityStatus = 'Manageable';
    } else {
        $affordabilityStatus = 'Difficult';
    }

    SalaryCalculation::create([
        'user_id' => auth()->id(),
        'job_title' => $jobRole->role_name,
        'experience' => $experience,
        'location' => $locationBonus->location_name,
        'calculated_salary' => $annualGrossSalary,
    ]);

    return redirect()->route('home')->with([
        'selected_role' => $jobRole->role_name,
        'selected_location' => $locationBonus->location_name,

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

        'city_estimated_monthly_cost' => $cityEstimatedMonthlyCost,
        'city_remaining_balance' => $cityRemainingBalance,
        'affordability_status' => $affordabilityStatus,

        'rent' => $rent,
        'food' => $food,
        'transport' => $transport,
        'bills' => $bills,
        'other' => $other,
        'total_monthly_expenses' => $totalMonthlyExpenses,
        'remaining_balance' => $remainingBalance,

        'savings_goal' => $savingsGoal,
        'months_to_goal' => $monthsToGoal,
    ]);
})->middleware(['auth', 'verified', 'active'])->name('calculate.salary');

Route::get('/dashboard', function () {
    $calculations = SalaryCalculation::where('user_id', auth()->id())->latest()->get();

    return view('dashboard', compact('calculations'));
})->middleware(['auth', 'verified', 'active'])->name('dashboard');

Route::delete('/calculation/{id}', function ($id) {
    $calculation = SalaryCalculation::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $calculation->delete();

    return redirect()->route('dashboard')->with('success', 'Calculation deleted successfully.');
})->middleware(['auth', 'verified', 'active'])->name('calculation.delete');

Route::post('/favorite-calculation/{id}', function ($id) {
    $calculation = SalaryCalculation::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $calculation->is_favorite = !$calculation->is_favorite;
    $calculation->save();

    return redirect()->route('dashboard')->with('success', 'Favorite status updated successfully.');
})->middleware(['auth', 'verified', 'active'])->name('calculation.favorite');

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

    $locationCosts = LocationBonus::whereIn('location_name', $comparisons->pluck('location')->unique())
        ->pluck('estimated_monthly_cost', 'location_name');

    return view('compare', compact('comparisons', 'locationCosts'));
})->middleware(['auth', 'verified', 'active'])->name('calculations.compare');

Route::get('/download-report', function () {
    $calculations = SalaryCalculation::where('user_id', auth()->id())->latest()->get();
    $user = auth()->user();

    $pdf = Pdf::loadView('report-pdf', compact('calculations', 'user'));

    return $pdf->download('uk-salary-report-' . now()->format('Y-m-d') . '.pdf');
})->middleware(['auth', 'verified', 'active'])->name('report.download');

Route::get('/admin', function () {
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

    $jobRoleChartData = SalaryCalculation::select('job_title', DB::raw('COUNT(*) as total'))
        ->groupBy('job_title')
        ->orderByDesc('total')
        ->get();

    $userStatusChartLabels = ['Active Users', 'Inactive Users'];
    $userStatusChartData = [
        User::where('is_active', true)->count(),
        User::where('is_active', false)->count(),
    ];

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
        'totalActiveLocations',
        'jobRoleChartData',
        'userStatusChartLabels',
        'userStatusChartData'
    ));
})->middleware(['auth', 'verified', 'active', 'admin'])->name('admin.panel');

Route::post('/admin/job-role/add', function (StoreJobRoleRequest $request) {
    JobRole::create([
        'role_name' => $request->role_name,
        'base_salary' => $request->base_salary,
        'experience_increment' => $request->experience_increment,
        'is_active' => true,
    ]);

    return redirect()->route('admin.panel')->with('success', 'Job role added successfully.');
})->middleware(['auth', 'verified', 'active', 'admin'])->name('admin.jobrole.add');

Route::post('/admin/location/add', function (StoreLocationBonusRequest $request) {
    LocationBonus::create([
        'location_name' => $request->location_name,
        'bonus_amount' => $request->bonus_amount,
        'estimated_monthly_cost' => $request->estimated_monthly_cost,
        'is_active' => true,
    ]);

    return redirect()->route('admin.panel')->with('success', 'Location bonus added successfully.');
})->middleware(['auth', 'verified', 'active', 'admin'])->name('admin.location.add');

Route::patch('/admin/user/{id}/toggle-active', function ($id) {
    $user = User::findOrFail($id);

    if ($user->id === auth()->id()) {
        return redirect()->route('admin.panel')->with('success', 'You cannot deactivate your own account.');
    }

    $user->is_active = !$user->is_active;
    $user->save();

    return redirect()->route('admin.panel')->with('success', 'User status updated successfully.');
})->middleware(['auth', 'verified', 'active', 'admin'])->name('admin.user.toggle');

Route::patch('/admin/user/{id}/promote', function ($id) {
    $user = User::findOrFail($id);

    if (!$user->is_admin) {
        $user->is_admin = true;
        $user->save();
    }

    return redirect()->route('admin.panel')->with('success', 'User promoted to admin successfully.');
})->middleware(['auth', 'verified', 'active', 'admin'])->name('admin.user.promote');

Route::patch('/admin/job-role/{id}/toggle-active', function ($id) {
    $role = JobRole::findOrFail($id);
    $role->is_active = !$role->is_active;
    $role->save();

    return redirect()->route('admin.panel')->with('success', 'Job role status updated successfully.');
})->middleware(['auth', 'verified', 'active', 'admin'])->name('admin.role.toggle');

Route::patch('/admin/location/{id}/toggle-active', function ($id) {
    $location = LocationBonus::findOrFail($id);
    $location->is_active = !$location->is_active;
    $location->save();

    return redirect()->route('admin.panel')->with('success', 'Location status updated successfully.');
})->middleware(['auth', 'verified', 'active', 'admin'])->name('admin.location.toggle');

Route::delete('/admin/calculation/{id}', function ($id) {
    $calculation = SalaryCalculation::findOrFail($id);
    $calculation->delete();

    return redirect()->route('admin.panel')->with('success', 'Calculation deleted by admin.');
})->middleware(['auth', 'verified', 'active', 'admin'])->name('admin.calculation.delete');

Route::middleware(['auth', 'verified', 'active'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';