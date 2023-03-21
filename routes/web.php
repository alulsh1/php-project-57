<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LabelController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::resource('tasks', TaskController::class);

Route::resource('task_statuses', TaskStatusController::class)->only([
    'index'
]);
Route::resource('labels', LabelController::class)->only([
    'index'
]);


Route::middleware('taskauf')->group(function () {
Route::resource('labels', LabelController::class)->only([
    'create', 'store', 'update', 'destroy' ,'edit','show'
]); 

Route::resource('task_statuses', TaskStatusController::class)->only([
    'create', 'store', 'update', 'destroy' ,'edit','show'
]); 

});

Route::get('/', function () {
    return view('nav');
})->name('nav');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
