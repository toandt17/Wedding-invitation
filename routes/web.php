<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\WeddingCardController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/wedding/{slug}/rsvp', [RsvpController::class, 'store'])->name('wedding.rsvp');

Route::get('/wedding/{slug}', [WeddingCardController::class, 'show'])
    ->name('wedding.show');
