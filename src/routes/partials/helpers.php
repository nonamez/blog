<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/auth', function() {
    $user = auth()->user();

	return new App\Http\Resources\Users\User($user);
})->middleware('auth');

// Helpers for posts examples
Route::get('sleep/{time}', function($time) {
	sleep(intval($time));

	return response()->json(['quote' => Illuminate\Foundation\Inspiring::quote()]);
});