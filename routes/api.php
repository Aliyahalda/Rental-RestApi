<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/rental', [RentalController::Class, 'index']);
Route::post('/rental/store', [RentalController::Class, 'store']);
Route::get('/rental/show/{id}', [RentalController::Class, 'show']);
Route::patch('/rental/update/{id}', [RentalController::class, 'update']);
Route::delete('/rental/delete/{id}', [RentalController::Class, 'destroy']);
Route::get('/rental/trash/all', [RentalController::Class, 'trash']);
Route::get('/rental/restore/{id}', [RentalController::Class, 'restore']);
Route::get('/rental/permanentDelete/{id}', [RentalController::Class, 'permanentDelete']);








