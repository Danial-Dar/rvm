<?php

use Illuminate\Support\Facades\Route;
use Rvm\UserSetting\Http\Controllers\UserSettingController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/get-nova-settings', [UserSettingController::class, 'index']);
Route::post('settings', [UserSettingController::class, 'store']);
Route::post('password', [UserSettingController::class, 'updatePassword']);
