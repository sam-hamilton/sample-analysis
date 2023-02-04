<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/analysis/{id}', function (Request $request) {
    return [
        'data' => [
            'result' => 'Positive',
            'failed' => false,
            'readings' => [
                [
                    'name' => 'control',
                    'value' => 1
                ],
                [
                    'name' => 'detect',
                    'value' => rand(1, 100) / 100
                ]
            ],
        ]
    ];
});
