<?php

use App\Http\Controllers\CalculationController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeightController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:headmaster'])
    ->prefix('headmaster')
    ->as('headmaster.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'headmasterDashboard'])->name('dashboard');
        Route::get('calculation', [CalculationController::class, 'showForm'])->name('calculations.form');
        Route::get('calculation/promethee', [CalculationController::class, 'index'])->name('calculations.promethee');
        Route::post('calculation/save', [CalculationController::class, 'storeLolos'])->name('calculations.save');
        Route::get('form/result', [ResultController::class, 'showForm'])->name('results.form');
        Route::get('result', [ResultController::class, 'index'])->name('results.index');
        Route::get('result/export-pdf', [ResultController::class, 'exportPdf'])->name('results.export-pdf');
    });

Route::middleware(['auth', 'role:homeroom_teacher'])
    ->prefix('homeroom-teacher')
    ->as('homeroom-teacher.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'homeroomTeacherDashboard'])->name('dashboard');
        Route::resource('students', StudentController::class);
        Route::get('scores/{student}/{period}/edit', [ScoreController::class, 'edit'])->name('scores.edit');
        Route::put('scores/{student}/{period}', [ScoreController::class, 'update'])->name('scores.update');
        Route::resource('scores', ScoreController::class)->except(['edit', 'update']);
    });

Route::middleware(['auth', 'role:staff_student'])
    ->prefix('staff-student')
    ->as('staff-student.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'staffStudentDashboard'])->name('dashboard');
        Route::resource('weights', WeightController::class)->only([
            'index',
            'store'
        ]);
        Route::get('weights/edit-all', [WeightController::class, 'editAll'])->name('weights.editAll');
        Route::post('weights/update-all', [WeightController::class, 'updateAll'])->name('weights.updateAll');
        Route::resource('criterias', CriteriaController::class);
        Route::get('calculation', [CalculationController::class, 'showForm'])->name('calculations.form');
        Route::get('calculation/promethee', [CalculationController::class, 'index'])->name('calculations.promethee');
        Route::post('calculation/save', [CalculationController::class, 'storeLolos'])->name('calculations.save');
        Route::get('form/result', [ResultController::class, 'showForm'])->name('results.form');
        Route::get('result', [ResultController::class, 'index'])->name('results.index');
        Route::get('result/export-pdf', [ResultController::class, 'exportPdf'])->name('results.export-pdf');
    });

Route::middleware(['auth', 'role:administration'])
    ->prefix('administration')
    ->as('administration.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'administrationDashboard'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('students', StudentController::class);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
