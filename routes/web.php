<?php

use App\Http\Controllers\LinkController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'name' => config('app.name'),
        'status' => 'OK',
        'version' => '1.0.0'
    ]);
});

Route::get('/{code}', [LinkController::class, 'redirect']);
