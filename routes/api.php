<?php

use App\Events\PodcastProcessed;
use App\Http\Controllers\Banners\BannerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\CampaignController as ApiCampaignController;
use App\Http\Controllers\Api\ContactListController as ApiContactListController;
use App\Http\Controllers\Api\DncController as ApiDncController;
use App\Http\Controllers\ContactUs\ContactUsController;
use App\Http\Controllers\Nova\AgentController;
use App\Http\Controllers\Nova\Campaign\CampaignController as CampaignCampaignController;
use App\Http\Controllers\Nova\DncController;
use App\Http\Controllers\Nova\EmailController;
use App\Http\Controllers\Sms\CampaignController;
use App\Http\Controllers\Nova\ContactListController;
use App\Http\Controllers\Nova\LeadController;
use App\Http\Controllers\Nova\MyNumberController;
use App\Http\Controllers\Nova\SmsContactListController;
use App\Http\Controllers\Nova\NewBotController;
use App\Http\Resources\ContactUsResource;
use App\Models\ContactUs;
use App\Models\MyNumber;
use App\Models\User;
use Laravel\Nova\Notifications\NovaNotification;
use Laravel\Nova\URL;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/t', function () {
    event(new \App\Events\UpdateProgressBar(359));
    dd('Event Run Successfully.');
});
Route::post('/new_bot', [NewBotController::class, 'new_bot']);

Route::get('get-call-status/{id}/{status}', [AgentController::class, 'getCallStatus']);
// Route::get('/t', function () {
//     // PodcastProcessed::dispatch();
//     $from_numbers = MyNumber::Where('user_id', 2)->Where('platform', 'sw')->pluck('raw_number')->toArray();
//     // dd($from_numbers);
//     $rand = array_rand($from_numbers);
//     // dd($from_numbers[$rand]);
// });

Route::get('banners',[BannerController::class,'index']);
Route::get('contact-us',[ContactUsController::class,'index']);
Route::get('/contact-us/{id}', function (string $id) {
    return new ContactUsResource(ContactUs::findOrFail($id));
});
Route::get('reply-mail',[ContactUsController::class,'replyMail']);

Route::group(['middleware' => ['throttle:none']], function ($router) {
    Route::post('store-leads', [LeadController::class, 'store']);

    Route::post('store-contact-list', [ContactListController::class, 'storeContactList']);

    Route::post('store-cir-contact-list', [ContactListController::class, 'storeCirContactList']);

    Route::post('cir-contact-list-webhook', [ContactListController::class, 'storeCirContactListWebhook']);

    Route::post('store-sms-contact-list', [SmsContactListController::class, 'store']);

    Route::post('store-dnc-list', [DncController::class, 'storeDnc']);

    Route::post('import-callzy-number', [MyNumberController::class, 'importCallzyNumber']);
});

Route::post('dtmf', [ApiController::class, 'dtmf']);

Route::post('call-from', [ApiController::class, 'callFrom']);

Route::get('test', [CampaignCampaignController::class, 'test']);

Route::post('login', [ApiController::class, 'login']);
Route::post('sign-up', [ApiController::class, 'signUp']);

    //Route::post('upload/emailss', [EmailController::class, 'uploadList']);

Route::middleware('nova:api')->group( function () {
    // Route::post('upload/dnc-list', [DncController::class, 'uploadList']);
   // Route::post('upload/email', [EmailController::class, 'uploadList']);
    Route::post('campaign', [CampaignController::class, 'store']);
});

Route::get('/user/sms_campaigns/{id}/conversations', [CampaignController::class, 'loadSmsConversations']);
Route::get('/user/sms_campaigns/{id}/conversations/{conversation_id}/messages', [CampaignController::class, 'messages']);

Route::post('/relay/test', function(Request $request) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/jwt',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "expires_in": 10000,
        "resource": "'.$request->resource.'"
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Basic ZTJhYjA2MmEtZDg2Ni00YzdhLWJjNWQtZTY4Y2U1Y2Q2OTRlOlBUYzdmZTVkMDczNDg0ODQ3MjUwY2M4MjU5NzUxYmIxNjBhZmJkYjExZmRjNDAxY2Mx'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response, 1);
    return [
        'jwt_token' => $response['jwt_token'],
        'project_id' => 'e2ab062a-d866-4c7a-bc5d-e68ce5cd694e'
    ];
});
Route::post('/upload', [ApiContactListController::class, 'upload']);
// api routes

Route::middleware('auth:api')->group( function () {
Route::prefix('/campaigns')->group(function(){
    Route::get('/', [ApiCampaignController::class, 'index']);
    Route::post('/store', [ApiCampaignController::class, 'store']);
    Route::get('/{id}', [ApiCampaignController::class, 'show']);
    Route::delete('/delete/{id}', [ApiCampaignController::class,'destroy']);
    Route::post('/change-action/{id}', [ApiCampaignController::class, 'actionUpdate']);
});

Route::prefix('/contact-lists')->group(function(){
    Route::get('/', [ApiContactListController::class, 'index']);
    Route::post('/store', [ApiContactListController::class, 'store']);
    Route::get('/{id}', [ApiContactListController::class, 'show']);
    Route::delete('/delete/{id}', [ApiContactListController::class,'destroy']);
});

Route::prefix('/dncs')->group(function(){
    Route::get('/', [ApiDncController::class, 'index']);
    Route::post('/store', [ApiDncController::class, 'store']);
    Route::post('/upload', [ApiDncController::class, 'upload']);
    Route::get('/{id}', [ApiDncController::class, 'show']);
    Route::delete('/delete/{id}', [ApiDncController::class,'destroy']);
});
});
