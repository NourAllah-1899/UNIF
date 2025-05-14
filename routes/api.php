<?php

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
use App\Http\Controllers\API\{
    UserController,
    TransactionController,
    CategoryController,
    CardController,
    BudgetController,
    ExpencesController
};
use App\Http\Controllers\{
    TransactionsController

};

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [UserController::class, 'show']);
    Route::put('/user', [UserController::class, 'update']);
    Route::apiResource('transactions', TransactionsController::class)->except(['update']);    
    Route::apiResource('categories', CategoryController::class)->only(['index', 'store']);
    Route::apiResource('cards', CardController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('budgets', BudgetController::class);    

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
