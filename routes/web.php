<?php

use App\Http\Controllers\CompetitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CompetitorController::class, 'index']);
