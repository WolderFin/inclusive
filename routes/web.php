<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/api/key/{key}', [IndexController::class, 'infoKey']);
Route::get('/api/uuid/{uuid}', [IndexController::class, 'infoUuid']);
