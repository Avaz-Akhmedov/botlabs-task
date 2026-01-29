<?php

use App\Http\Controllers\CallController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;

Route::post('/leads', LeadController::class);

Route::post('/leads/{lead}/calls', CallController::class);

Route::get('/managers/{manager}/leads', ManagerController::class);
