<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdminMovieController;
use App\Http\Controllers\SheetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
// chapter4
Route::get('/getPractice', [PracticeController::class, 'getPractice']);
// chapter6
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::prefix('/admin/movies')->group(function () {
    Route::get('/', [AdminMovieController::class, 'index']);
    Route::get('/create', [AdminMovieController::class, 'create']);
    Route::post('/store', [AdminMovieController::class, 'store']);
    Route::get('/{id}/edit', [AdminMovieController::class, 'edit']);
    Route::patch('/{id}/update', [AdminMovieController::class, 'update']);
    Route::delete('/{id}/destroy', [AdminMovieController::class, 'destroy']);
});
Route::get('/sheets', [SheetController::class, 'index']);
