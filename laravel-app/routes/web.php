<?php

use App\Models\User;
use App\Models\SalaryCalculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Redirect root to login if not logged in, otherwise show calculator
Route::get('/', function () {
    return view('home');
})->middleware('auth')->name('home');

// Salary calculation route
Route::post('/calculate', function (Request $request) {
    $jobTitle = $request->input('jobTitle');
    $experience = $request->input('experience');
    $location = $request->input('location');

    $baseSalary = 0;

    if ($jobTitle == "Software Developer") {
        $baseSalary = 30000 + ($experience * 2000);
    } elseif ($jobTitle == "Data Analyst") {
        $baseSalary = 28000 + ($experience * 1800);
    } elseif ($jobTitle == "Project Manager") {
        $baseSalary = 35000 + ($experience * 2500);
    } else {
        return redirect('/')->with('error', 'Invalid job title');
    }

    if ($location == "London") {
        $baseSalary += 5000;
    } elseif ($location == "Manchester") {
        $baseSalary += 2000;
    } elseif ($location == "Birmingham") {
        $baseSalary += 1500;
    }

    SalaryCalculation::create([
        'user_id' => auth()->id(),
        'job_title' => $jobTitle,
        'experience' => $experience,
        'location' => $location,
        'calculated_salary' => $baseSalary,
    ]);

    return redirect('/')->with('salary', $baseSalary);
})->middleware('auth')->name('calculate.salary');

Route::delete('/calculation/{id}', function ($id) {
    $calculation = SalaryCalculation::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $calculation->delete();

    return redirect()->route('dashboard')->with('success', 'Calculation deleted successfully.');
})->middleware('auth')->name('calculation.delete');

// Dashboard
Route::get('/dashboard', function () {
    $calculations = SalaryCalculation::where('user_id', auth()->id())->latest()->get();

    return view('dashboard', compact('calculations'));
})->middleware(['auth'])->name('dashboard');

// admin
Route::get('/make-me-admin', function () {
    $user = auth()->user();

    if (!$user) {
        return 'Please login first.';
    }

    $user->is_admin = true;
    $user->save();

    return 'You are now admin.';
})->middleware('auth');

Route::get('/admin', function () {
    if (!auth()->user()->is_admin) {
        abort(403, 'Unauthorized access');
    }

    $users = User::latest()->get();
    $calculations = SalaryCalculation::latest()->get();
    $totalUsers = User::count();
    $totalCalculations = SalaryCalculation::count();

    return view('admin', compact('users', 'calculations', 'totalUsers', 'totalCalculations'));
})->middleware('auth')->name('admin.panel');

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