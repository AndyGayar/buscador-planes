<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ParticipantController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de planes
Route::get('/plans', [PlanController::class, 'index']);
Route::get('/plans/{id}', [PlanController::class, 'show']);
Route::post('/plans', [PlanController::class, 'store']);

// Rutas de participantes
Route::post('/plans/{planId}/join', [ParticipantController::class, 'store']);
