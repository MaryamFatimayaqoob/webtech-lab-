<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserRoleController;
use Illuminate\Support\Facades\Route;

/*
| PUBLIC
*/
Route::get('/', function () {
    return view('welcome');
});

/*
| AUTH ROUTES
*/
require __DIR__.'/auth.php';

/*
| AUTHENTICATED AREA
*/
Route::middleware('auth')->group(function () {

    /*
    | DASHBOARD
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    | PROFILE
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    | EMPLOYEES (READ ALL USERS)
    */
    Route::get('/employees', [EmployeeController::class, 'index'])
        ->name('employees.index');

    /*
    | HR + ADMIN ONLY (CRUD)
    */
    Route::middleware('role:admin,hr')->group(function () {

        Route::get('/employees/create', [EmployeeController::class, 'create'])
            ->name('employees.create');

        Route::post('/employees', [EmployeeController::class, 'store'])
            ->name('employees.store');

        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])
            ->name('employees.edit');

        Route::put('/employees/{employee}', [EmployeeController::class, 'update'])
            ->name('employees.update');
    });

    /*
    | ADMIN ONLY
    */
    Route::middleware('role:admin')->group(function () {

        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])
            ->name('employees.destroy');

        /*
        | ADMIN PANEL
        */
        Route::get('/admin/users', [UserRoleController::class, 'index'])
            ->name('admin.users');

        Route::put('/admin/users/{user}/role', [UserRoleController::class, 'updateRole'])
            ->name('admin.users.role');
    });

});