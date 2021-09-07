<?php

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);

Route::get('getCategories', [CategoryController::class, 'get_categories']);
Route::get('getArticles', [ArticleController::class, 'get_articles']);
Route::get('selectArticle/{title}', [ArticleController::class, 'select_article']);
Route::get('displayArticles/{id}/{sort}', [ArticleController::class, 'display_articles']);
Route::get('searchArticles/{data}', [ArticleController::class, 'search_articles']);

Route::post('subscribe', [SubscriberController::class, 'subscribe']);
Route::post('verify', [SubscriberController::class, 'verify']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::post('addCategory', [CategoryController::class, 'add_category']);
    Route::post('deleteCategory', [CategoryController::class, 'delete_category']);
    Route::post('addArticle', [ArticleController::class, 'add_article']);
    Route::post('deleteArticle', [ArticleController::class, 'delete_article']);
    Route::post('editArticle', [ArticleController::class, 'edit_article']);

    Route::post('disableSubscriber', [SubscriberController::class, 'disable_subscriber']);
    Route::get('getSubscribers', [SubscriberController::class, 'get_subscribers']);
});
