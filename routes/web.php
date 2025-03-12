<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/app/login');
});

Route::get('/app/{any}', function () {
    return view('welcome');
});

// Verification Email
Route::get('/check-email/{token}', [AuthController::class, 'validEmail']);
