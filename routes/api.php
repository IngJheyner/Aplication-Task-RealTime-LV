<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* ============================================
AUTH
=============================================== */
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
/* ============================================
AUTH
=============================================== */
Route::controller(AuthController::class)->group(function () {
    Route::post('/logout', 'logout');
});
/* ============================================
PROYECTOS
=============================================== */
Route::controller(ProjectController::class)->group(function () {

    Route::get('/projects', 'index');
    Route::get('/projects/{slug}', 'show');
    Route::get('/count/projects', 'countProjects');

    Route::post('/projects', 'store');

    Route::put('/projects', 'update');
    Route::put('/projects/pinned', 'pinnedProject');
});

/* ============================================
MIEMBROS
=============================================== */
Route::controller(MemberController::class)->group(function () {
    Route::get('/members', 'index');
    Route::post('/members', 'store');
    Route::put('/members', 'update');
});

/* ============================================
TAREAS
=============================================== */
Route::controller(TaskController::class)->group(function () {

    Route::post('/tasks', 'createTask');

    Route::patch('/tasks/not-started-to-pending', 'taskToNotStartedToPending');
    Route::patch('/tasks/not-started-to-completed', 'taskToNotStartedToCompleted');
    Route::patch('/tasks/pending-to-completed', 'taskToPendingToCompleted');
    Route::patch('/tasks/pending-to-not-started', 'taskToPendingToNotStarted');
    Route::patch('/tasks/completed-to-pending', 'taskToCompletedToPending');
    Route::patch('/tasks/completed-to-not-started', 'taskToCompletedToNotStarted');
});

});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
