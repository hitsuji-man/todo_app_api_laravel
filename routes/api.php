<?php

use App\Http\Controllers\Api\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * API用のルート設定
 * プレフィックスは既に「api」になっているため、URLは「/api/todos」のようになります
 */

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// APIバージョン管理
Route::prefix('v1')->group(function() {
    // TODOリソースのCRUD操作
    Route::apiResource('todos', TodoController::class);

    // 完了状態を切り替えるカスタムルート
    Route::patch('todos/{todo}/toggle-complete', [TodoController::class, 'toggleComplete']);
});
