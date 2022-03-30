<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Subscribe\SubscribeController;
use App\Http\Controllers\Subscribe\SubscriberTopicsController;
use App\Http\Controllers\Subscribe\TopicSubscribersController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'topics'], function () {
    Route::get('/', [SubscriberTopicsController::class, 'index']);
    Route::get('/{topic}/subscribers', [TopicSubscribersController::class, 'index']);

    Route::post('/{topic}/subscribe', [SubscribeController::class, 'subscribe']);

    Route::post('/{topic}/unsubscribe', [SubscribeController::class, 'unsubscribe']);
    Route::post('/unsubscribe', [SubscribeController::class, 'unsubscribeAll']);
});



