<?php

use App\Http\Controllers\BoxController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\IngredientsRequiredController;
use App\Http\Controllers\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('ingredients', [IngredientsController::class, 'index']);
Route::post('ingredients', [IngredientsController::class, 'store']);

Route::get('ingredients-required', [IngredientsRequiredController::class, 'index']);

Route::get('recipes', [RecipeController::class, 'index']);
Route::post('recipes', [RecipeController::class, 'store']);

Route::get('box', [BoxController::class, 'index']);
Route::post('box', [BoxController::class, 'store']);
