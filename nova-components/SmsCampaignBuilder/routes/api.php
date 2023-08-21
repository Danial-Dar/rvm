<?php

use App\Http\Controllers\Sms\CampaignController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Sms\SmsCampaignBuilder\Http\Controller\CampaignController;

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

Route::post('/store', [CampaignController::class, 'store']);

Route::get('/get_campaign_contact_list', [CampaignController::class, 'getCampaignContactList']);
Route::post('/sms_contact-lists/validate_csv', [CampaignController::class, 'validateCsv']);
Route::post('/get_banned_words', [CampaignController::class, 'getSmsBannedWord']);
Route::post('/sms_contact-lists', [CampaignController::class, 'ajaxStore']);
