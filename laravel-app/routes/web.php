<?php

use App\Models\User;
use App\Models\SalaryCalculation;
use App\Models\JobRole;
use App\Models\LocationBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Home page Route
Route::get('/', function () {
    $jobRoles = JobRole::orderBy('role_name')->get();
    $locations = LocationBonus::orderBy('location_name')->get();

    return view('home', compact('jobRoles', 'locations'));
})->middleware('auth')->name('home');

// Salary calculation route
Route::post('/calculate', function (Request $request) {
    $request->validate([
        'jobTitle' => 'required',
        'experience' => 'required|integer|min:0',
        'location' => 'required',
    ]);

    $jobRole = JobRole::where('role_name', $request->jobTitle)->first();
    $locationBonus = LocationBonus::where('location_name', $request->location)->first();

    if (!$jobRole) {
        return redirect()->route('home')->with('error', 'Selected job role not found.');
    }

    if (!$locationBonus) {
        return redirect()->route('home')->with('error', 'Selected location not found.');
    }

    $baseSalary = $jobRole->base_salary;
    $experienceIncrement = $jobRole->experience_increment;
    $experience = (int) $request->experience;
    $bonusAmount = $locationBonus->bonus_amount;

    $finalSalary = $baseSalary + ($experience * $experienceIncrement) + $bonusAmount;

    SalaryCalculation::create([
        'user_id' => auth()->id(),
        'job_title' => $jobRole->role_name,
        'experience' => $experience,
        'location' => $locationBonus->location_name,
        'calculated_salary' => $finalSalary,
    ]);

    return redirect()->route('home')->with('salary', $finalSalary);
})->middleware('auth')->name('calculate.salary');

// Dashboard 
Route::get('/dashboard', function () {
    $calculations = SalaryCalculation::where('user_id', auth()->id())->latest()->get();

    return view('dashboard', compact('calculations'));
})->middleware('auth')->name('dashboard');

// admin
Route::get('/admin', function () {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $users = User::latest()->get();
    $calculations = SalaryCalculation::latest()->get();
    $jobRoles = JobRole::latest()->get();
    $locationBonuses = LocationBonus::latest()->get();

    $totalUsers = User::count();
    $totalCalculations = SalaryCalculation::count();
    $totalJobRoles = JobRole::count();
    $totalLocations = LocationBonus::count();

    return view('admin', compact(
        'users',
        'calculations',
        'jobRoles',
        'locationBonuses',
        'totalUsers',
        'totalCalculations',
        'totalJobRoles',
        'totalLocations'
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
    ]);

    return redirect()->route('admin.panel')->with('success', 'Location bonus added successfully.');
})->middleware('auth')->name('admin.location.add');

// Delete Calculation
Route::delete('/admin/calculation/{id}', function ($id) {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $calculation = SalaryCalculation::findOrFail($id);
    $calculation->delete();

    return redirect()->route('admin.panel')->with('success', 'Calculation deleted by admin.');
})->middleware('auth')->name('admin.calculation.delete');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';