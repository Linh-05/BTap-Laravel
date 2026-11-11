<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodJoinController;

Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'API is running smoothly',
        'data' => [
            'status' => 'OK',
            'timestamp' => now()->toIso8601String(),
        ],
    ]);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::post('/foods', [FoodController::class, 'create']);
    Route::delete('/foods/{id}', [FoodController::class, 'delete']);

});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/foods/inner-join', [FoodJoinController::class, 'innerJoin']);
Route::get('/foods/left-join', [FoodJoinController::class, 'leftJoin']);
Route::get('/foods/filter', [FoodJoinController::class, 'joinFilter']);

Route::get('/foods', [FoodController::class, 'index']);
//Route::post('/foods', [FoodController::class, 'create']);
Route::get('/foods/{id}', [FoodController::class, 'show']);
Route::put('/foods/{id}', [FoodController::class, 'update']);
//Route::delete('/foods/{id}', [FoodController::class, 'destroy']);

Route::get('/categories/{id}/foods', function ($id) {
    return response()->json(Category::with('foods')->findOrFail($id));
});
Route::post('/foods/{id}/detail', [FoodController::class, 'updateDetail']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);


