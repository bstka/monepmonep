<?php

use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramTargetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name("login");
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name("logout");

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


// ! API ROUTES !

Route::middleware(['auth'])->prefix('api')->group(function () {

    // ! Programs
    Route::prefix('programs')->group(function () {
        Route::get('/', [ProgramController::class, 'getAllProgramsByUserInstance']);
        Route::get('/year/{year}/{stepId}/{subStepId}', [ProgramController::class, 'getAllProgramsByUserInstanceAndYear'])->whereNumber(['year', 'stepId', 'subStepId']);
        Route::get('/target/{programId}/{targetId}', [ProgramController::class, 'getTargetById'])->whereNumber(['programId', 'targetId']);
        Route::post('/target/{programId}/{targetId}', [ProgramTargetController::class, 'insertTargetReport'])->whereNumber(['programId', 'targetId']);
        Route::put('/target/{programId}/{targetId}/{fileId}', [ProgramTargetController::class, 'updateTargetReport'])->whereNumber(['programId', 'targetId', 'fileId']);
        Route::delete('/target/{programId}/{targetId}/{fileId}', [ProgramTargetController::class, 'deleteTargetReport'])->whereNumber(['programId', 'targetId', 'fileId']);

        //! Verifications
        Route::post('/target/validate/{fileId}', [ProgramTargetController::class, 'validateTargetReport'])->middleware(['role:satgas|setkab'])->whereNumber(['fileId']);
        Route::delete('/target/validate/{fileId}', [ProgramTargetController::class, 'unvalidateTargetReport'])->middleware(['role:satgas|setkab'])->whereNumber(['fileId']);
    });
});
