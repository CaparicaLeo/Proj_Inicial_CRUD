<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

// Rota para exibir o formulário de login
Route::get('/signin', function () {
    return view('signin');
})->name('login');

// Rota para processar o login
Route::post('/signin', [SignInController::class, 'create'])->name('login');

// Rota para exibir o formulário de registro
Route::get('/signup', function () {
    return view('signup');
})->name('signup');

// Rota para processar o registro
Route::post('/signup', [SignUpController::class, 'signup'])->name('signup');

// Rota para exibir a página inicial (ou lista de tasks)
Route::get('/home', [TaskController::class, 'index'])->name('home')->middleware('auth');

// Rota para criar uma nova task
Route::post('/tasks', [TaskController::class, 'store'])->name('task_register')->middleware('auth');

// Rota para carregar o formulário de edição
Route::get('edit/{id}', [TaskController::class, 'edit'])->name('task_edit')->middleware('auth');

// Rota para processar a atualização da task
Route::put('/task/update/{id}', [TaskController::class, 'update'])->name('task_update')->middleware('auth');

// Rota para deletar uma task
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware('auth');
