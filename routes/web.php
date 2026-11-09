<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Any web route serves the main application layout, letting Vue Router
| handle the client-side Single Page Application navigation seamlessly.
|
*/

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
