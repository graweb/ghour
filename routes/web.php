<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

//HOME
Route::get('/', [HomeController::class, 'index'])->name('home');

//PROJECTS
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('project_store');
Route::post('/projects/edit', [ProjectController::class, 'edit'])->name('project_edit');
Route::post('/projects/update', [ProjectController::class, 'update'])->name('project_update');
Route::post('/projects/remove', [ProjectController::class, 'remove'])->name('project_remove');
Route::post('/projects/destroy', [ProjectController::class, 'destroy'])->name('project_destroy');

//TASKS
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('task_store');
Route::post('/tasks/edit', [TaskController::class, 'edit'])->name('task_edit');
Route::post('/tasks/update', [TaskController::class, 'update'])->name('task_update');
Route::post('/tasks/remove', [TaskController::class, 'remove'])->name('task_remove');
Route::post('/tasks/destroy', [TaskController::class, 'destroy'])->name('task_destroy');
Route::post('/tasks/stop', [TaskController::class, 'stop'])->name('task_stop');
Route::post('/tasks/done', [TaskController::class, 'done'])->name('task_done');
Route::post('/tasks/paid', [TaskController::class, 'paid'])->name('task_paid');
Route::post('/tasks/finish', [TaskController::class, 'finish'])->name('task_finish');

//USERS
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users/store', [UserController::class, 'store'])->name('user_store');
Route::post('/users/edit', [UserController::class, 'edit'])->name('user_edit');
Route::post('/users/update', [UserController::class, 'update'])->name('user_update');
Route::post('/users/remove', [UserController::class, 'remove'])->name('user_remove');
Route::post('/users/destroy', [UserController::class, 'destroy'])->name('user_destroy');
Route::post('/users/update_current_project_id', [UserController::class, 'updateCurrentProjectId'])->name('user_update_update_current_project_id');

//REPORTS
Route::get('/reports', [ReportController::class, 'index'])->name('reports');

//PDF
Route::post('/invoice', [PdfController::class, 'invoice'])->name('invoice_pdf');
Route::post('/report', [PdfController::class, 'report'])->name('report_pdf');
