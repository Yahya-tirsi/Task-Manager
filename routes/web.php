<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    $projects = App\Models\Project::all();
    return view('welcome', compact('projects'));
});

Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

// Route to delete a project
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Route to update a project 
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('tasks.index');
// Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])->name('projects.tasks.index');
Route::post('/projects/{project}/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/projects/{project}/tasks', [TaskController::class, 'store2'])->name('tasks.store');

// Route to update task status
Route::put('/tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');

Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::get('/allprojects', [ProjectController::class, 'index'])->name("projects.index");

Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

// Get tasks for each project
Route::get("/tasks/project/index", [TaskController::class, "tsksProject"])->name("tasks.project.index");

// Authentication Routes
Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');