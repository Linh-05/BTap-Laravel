<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

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

Route::get('/foods', [FoodController::class, 'index']);
Route::post('/foods', [FoodController::class, 'create']);
Route::get('/foods/{id}', [FoodController::class, 'show']);
Route::put('/foods/{id}', [FoodController::class, 'update']);
Route::delete('/foods/{id}', [FoodController::class, 'destroy']);

Route::get('/categories/{id}/foods', function ($id) {
    return response()->json(Category::with('foods')->findOrFail($id));
    });
Route::post('/foods/{id}/detail', [FoodController::class, 'updateDetail']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
