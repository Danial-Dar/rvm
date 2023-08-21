<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Rvm\CampaignHours\Http\Controller\CampaignHourController;

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

Route::get('/get-campaign-hours', [CampaignHourController::class,'index']);
Route::post('/update-campaign-hours', [CampaignHourController::class,'store']);
