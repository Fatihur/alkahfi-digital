<?php

use App\Http\Controllers\Api\DuitkuController;
use Illuminate\Support\Facades\Route;

Route::post('/duitku/callback', [DuitkuController::class, 'callback'])
    ->name('duitku.callback');
