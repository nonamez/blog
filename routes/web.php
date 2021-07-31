<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::domain('cv.' . config('app.domain'))->group(function () {
    Route::view('/', 'cv.index');
});

require_once base_path('routes/partials/auth.php');
require_once base_path('routes/partials/blog.php');
require_once base_path('routes/partials/dashboard.php');
require_once base_path('routes/partials/helpers.php');
