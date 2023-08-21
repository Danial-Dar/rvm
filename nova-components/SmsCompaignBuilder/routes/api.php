<?php

use Illuminate\Support\Facades\Route;
use Sms\SmsCompaignBuilder\Http\Controller\CompaignController;

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

Route::post('/store', [CompaignController::class, 'store']);

Route::get('/get_campaign_contact_list', [CompaignController::class, 'getCampaignContactList']);
Route::post('/sms_contact-lists/validate_csv', [CompaignController::class, 'validateCsv']);
Route::post('/get_banned_words', [CompaignController::class, 'getSmsBannedWord']);
Route::post('/sms_contact-lists', [CompaignController::class, 'ajaxStore']);
