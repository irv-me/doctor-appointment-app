<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController; // <-- AÑADE ESTA LÍNEA

Route::get('/', function () {
    return view(('admin.dashboard'));
})->name('dashboard');

// Gestión de usuarios
Route::resource('roles', RoleController::class);
