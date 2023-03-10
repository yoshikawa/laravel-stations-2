<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AdminMovieController;

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

// Route::get('practice', function() {
//     return response('practice');
// });

// Route::get('practice2', function() {
//     $test = 'practice2';
//     return response($test);
// });

// Route::get('practice3', function() {
//     $test = 'test';
//     return response($test);
// });

Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3', [PracticeController::class, 'sample3']);
// chapter4
Route::get('/getPractice', [PracticeController::class, 'getPractice']);
// chapter6
Route::get('/movies', [MovieController::class, 'index']);
// chapter7
Route::get('/admin/movies', [AdminMovieController::class, 'index']);
