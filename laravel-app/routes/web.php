<?php

use App\Http\Controllers\ProfileController;
use App\Models\SalaryCalculation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';