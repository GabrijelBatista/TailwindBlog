<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);

Route::get('getCategories', [CategoryController::class, 'get_categories']);
Route::get('getArticles', [CategoryController::class, 'get_articles']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('addCategory', [CategoryController::class, 'add_category']);
    Route::post('deleteCategory', [CategoryController::class, 'delete_category']);
    Route::post('addArticle', [CategoryController::class, 'add_article']);
    Route::post('deleteArticle', [CategoryController::class, 'delete_article']);
    Route::post('editArticle', [CategoryController::class, 'edit_article']);
});
