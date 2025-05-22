<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MapController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/ping', [MapController::class, 'ping']);

Route::get('/api/search', [MapController::class, 'search']);
