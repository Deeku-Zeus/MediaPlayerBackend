<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Define an open API route
Route::get('/v1/test', function () {
    return response()->json([
        'message' => 'This is public data.',
        'data' => [
            'item1' => 'Value 1',
            'item2' => 'Value 2',
        ]
    ]);
});
