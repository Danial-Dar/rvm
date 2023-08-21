<?php

use App\Http\Middleware\CheckUser;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Middleware\CheckCompany;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ReplyMailController;
use App\Http\Controllers\User\DidController;
use App\Http\Controllers\Admin\BotController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Sms\DomainController;
use App\Http\Controllers\Admin\NumberController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\UserDNCController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\User\CampaignController;
use App\Http\Controllers\Admin\AdminDNCController;
use App\Http\Controllers\Sms\OptOutWordController;
use App\Http\Controllers\User\RecordingController;
use App\Http\Controllers\Admin\ApiSettingController;
use App\Http\Controllers\User\ContactListController;
use App\Http\Controllers\User\UserDNCTimeController;
use App\Http\Controllers\User\UserSettingController;
use App\Http\Controllers\Sms\SmsBannedWordController;
use App\Http\Controllers\User\IncomingCallLogContoller;
use App\Http\Controllers\Cir\CirNumberManagerController;
use App\Http\Controllers\Company\CompanyBillingController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Sms\CampaignController as SmsCampaignController;
use App\Http\Controllers\Sms\ReportController as SmsReportController;
use App\Http\Controllers\Sms\BillingController as SmsBillingController;
use App\Http\Controllers\User\ReportController as UserReportController;
use App\Http\Controllers\User\MyNumberController as UserMyNumberController;
use App\Http\Controllers\Admin\RecordingController as AdminRecordingController;
use App\Http\Controllers\Sms\ContactListController as SmsContactListController;
use App\Http\Controllers\User\SmsBillingController as UserSmsBillingController;
use App\Http\Controllers\Admin\ContactListController as AdminContactListController;
use App\Http\Controllers\Company\SmsReportController as CompanySmsReportController;
use App\Http\Controllers\User\MyGroupNumberController as UserMyGroupNumberController;
use App\Http\Controllers\Cir\CirReportController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Laravel\Nova\Contracts\ImpersonatesUsers;
use Laravel\Nova\Notifications\NovaNotification;

Route::view('/swagger', 'swagger/swagger');

Route::post('client-forward', [\App\Http\Controllers\SignalForwardController::class, 'clientXml'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('ClientSignalForward');
Route::get('user/campaigns/get_stats', [CampaignController::class, 'getStats'])->name('user.campaign.getStats');
Route::get('user/test', [UserController::class, 'test'])->name('usertest');

Route::post('client-forward', [\App\Http\Controllers\SignalForwardController::class, 'clientXml'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('ClientSignalForward');
Route::post('client-input', [\App\Http\Controllers\SignalForwardController::class, 'clientInputXml'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('ClientInputSignalForward');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/impersonation', function (Request $request, ImpersonatesUsers $impersonator) {
    if ($impersonator->impersonating($request)) {
        $impersonator->stopImpersonating($request, Auth::guard(), User::class);
    }
});
Route::get('/', function () {
    // return view('welcome');
    return redirect('/space');
});

Auth::routes();

Route::group(['middleware'	=>	CheckUser::class], function() {
     //User Routes
    //  Route::get('user/dashboard', [UserDashboard::class, 'index'])->name('user.dashboard');
    //  Route::get('user/ajax_dashboard', [UserDashboard::class, 'ajaxDashboard'])->name('user.ajaxdashboard');
    //  Route::get('user/dashboard/results/{id}', [UserDashboard::class, 'dashboard_results'])->name('user.dashboard.result');
    //  Route::get('user/dashboard/per_hour_results', [UserDashboard::class, 'dashboard_campaign_per_hour_results'])->name('user.dashboard.per_hour_results');

    // Route::get('user/dashboard', [ReportController::class, 'index'])->name('user.dashboard');
    // Route::get('user/reports/results', [ReportController::class, 'getReportResults'])->name('user.reports_result');

    // new report routes
    Route::get('user/dashboard', [ReportController::class, 'counterIndex'])->name('user.dashboard');
    Route::get('user/reports/counters', [ReportController::class, 'getCounters'])->name('user.reports.counters');
    Route::get('user/reports/callback', [ReportController::class, 'callback'])->name('user.reports.callback');
    Route::get('user/reports/get_callback_heat_map', [ReportController::class, 'getCallback'])->name('user.reports.get_callback_heat_map');
    Route::get('user/reports/call_sent_destination', [ReportController::class, 'callSentToDestination'])->name('user.reports.call_sent_destination');
    Route::get('user/reports/get_call_sent_destination', [ReportController::class, 'getCallSentToDestination'])->name('user.reports.get_call_sent_destination');
    Route::get('user/reports/call_back_duration', [ReportController::class, 'callBackDuration'])->name('user.reports.call_back_duration');
    Route::get('user/reports/get_call_back_duration', [ReportController::class, 'getCallBackDuration'])->name('user.reports.get_call_back_duration');
    Route::get('user/reports/callback_pie', [ReportController::class, 'callbackPieChart'])->name('user.reports.callback_pie');
    Route::get('user/reports/get_callback_pie', [ReportController::class, 'getCallbackPieChart'])->name('user.reports.get_callback_pie');
    Route::get('user/reports/get_send_rates_per_day', [ReportController::class, 'getSendRatesPerDay'])->name('user.reports.get_send_rates_per_day');
    Route::get('user/reports/campagin_stats', [ReportController::class, 'getCampaignStats'])->name('user.reports.campagin_stats');
    Route::get('user/reports/list_stats', [ReportController::class, 'getListStats'])->name('user.reports.list_stats');
    Route::get('user/reports/recording_stats', [ReportController::class, 'getRecordingStats'])->name('user.reports.recording_stats');
    Route::get('user/reports/state_stats', [ReportController::class, 'getStateStats'])->name('user.reports.state_stats');
    Route::get('user/reports/campaign_ratio', [ReportController::class, 'getCampaignTypeRatio'])->name('user.reports.campaign_ratio');
    Route::get('user/reports/campaign_send_rates', [ReportController::class, 'getCampaignSendRates'])->name('user.reports.campaign_send_rates');
    Route::get('user/reports/inbound_call_overtime', [ReportController::class, 'getInboundCallOvertime'])->name('user.reports.inbound_call_overtime');
    Route::get('user/reports/ivr_outbound_stats', [ReportController::class, 'getIvrOutboundStats'])->name('user.reports.ivr_outbound_stats');
    Route::get('user/reports/outbound_optin_heatmap', [ReportController::class, 'getOutboundOptinHeatmap'])->name('user.reports.outbound_optin_heatmap');
    Route::get('user/reports/ivr_dnc_heatmap', [ReportController::class, 'getIvrDncHeatmap'])->name('user.reports.ivr_dnc_heatmap');

    Route::get('user/reports/dnc_heatmap', [ReportController::class, 'getDncHeatmap'])->name('user.reports.dnc_heatmap');
    // new report routes end


     // Route::get('user/my-numbers', [MyNumberController::class, 'index'])->name('user.mynumber');
     // Route::post('user/my-numbers/newnumber', [MyNumberController::class, 'store'])->name('user.mynumber.newnumber');
     // Route::get('user/my-numbers/delete/{id}', [MyNumberController::class, 'destroy'])->name('user.mynumber.delete');
     Route::get('user/campaigns', [CampaignController::class, 'index'])->name('user.campaign');
     Route::get('user/campaigns/create', [CampaignController::class, 'create'])->name('user.create.campaign');

     Route::post('user/campaigns/test_call', [CampaignController::class, 'testCallApi'])->name('user.campaigns.test_call');
     Route::post('user/campaigns/press1_test_call', [CampaignController::class, 'testCallApiPress1'])->name('user.campaigns.press1_test_call');

     Route::post('user/campaigns', [CampaignController::class, 'store'])->name('user.campaign.store');
     Route::get('user/edit-campaigns/{id}', [CampaignController::class, 'edit'])->name('user.campaign.edit');
     Route::post('user/update-campaigns/{id}', [CampaignController::class, 'update'])->name('user.campaign.update');
     Route::get('user/show-campaigns-contact-list/{campaign_id}', [CampaignController::class, 'showContactList'])->name('user.campaign.showContactList');
     Route::get('user/show-campaigns-contact-list-status', [CampaignController::class, 'showContactListStatus'])->name('user.campaign.showContactListStatus');
     Route::get('user/campaign/export/{id}', [CampaignController::class , 'exportCampaigns'])->name('user.campaign.exportCampaign');
     Route::get('user/campaigns/get_all_bot', [CampaignController::class, 'getAllBot'])->name('user.campaign.get_all_bot');
     Route::get('user/campaigns/get_caller_ids', [CampaignController::class, 'getAllCallerIds'])->name('user.campaign.get_caller_ids');
     Route::get('user/campaigns/get_caller_groups', [CampaignController::class, 'getAllCallerGroups'])->name('user.campaign.get_caller_groups');
     Route::get('user/campaigns/get_campaign_contact_list', [CampaignController::class, 'getCampaignContactList'])->name('user.campaign.get_campaign_contact_list');
     Route::get('user/campaigns/get_campaign_recordings', [CampaignController::class, 'getCampaignRecordings'])->name('user.campaign.get_campaign_recordings');
     Route::get('user/campaigns/get_stats', [CampaignController::class, 'getStats'])->name('user.campaign.getStats');
     Route::get('user/campaigns/get_send_speed', [CampaignController::class, 'getSendSpeed'])->name('user.campaign.get_send_speed');
     Route::post('user/campaigns/update_send_speed', [CampaignController::class, 'updateSendSpeed'])->name('user.campaign.update_send_speed');

     Route::get('user/recordings', [RecordingController::class, 'index'])->name('user.recording');
     Route::get('user/recordings/delete/{id}', [RecordingController::class, 'destroy'])->name('user.recording.delete');
     Route::post('user/recordings', [RecordingController::class, 'store'])->name('user.recording.store');
     Route::post('user/recording', [RecordingController::class, 'ajaxStore'])->name('user.recording.ajaxStore');

     Route::get('user/listen-recording', [RecordingController::class, 'listen'])->name('user.listen-recording');

     Route::get('user/contact-list', [ContactListController::class, 'index'])->name('user.contact-list');
     Route::post('user/contact-list', [ContactListController::class, 'store'])->name('user.contact-list.store');
     Route::post('user/contact-lists', [ContactListController::class, 'ajaxStore'])->name('user.contact-list.ajaxStore');
     Route::post('user/contact-lists/validate_csv', [ContactListController::class, 'validateCsv'])->name('user.contact-list.validate_csv');
     Route::get('user/contact-list/{id}', [ContactListController::class, 'show'])->name('user.contact-list.show');
     Route::get('user/reports' , [UserReportController::class, 'index'])->name('user.report');
     Route::get('user/contact-list/delete/{id}' , [ContactListController::class , 'destroy'])->name('user.contact-list.delete');
     Route::get('user/contact-list/campaigns/{id}' , [ContactListController::class , 'checkContactsCampaigns'])->name('user.contact-list.checkcampaigns');
     // waleed routes
     Route::get('user/contact-lists/export/{id}', [ContactListController::class, 'exportContactListContacts'])->name('user.contact-list.exportContactListContacts');
     Route::post('user/contact-lists/map_contacts/', [ContactListController::class, 'mapContactList'])->name('user.contact-list.mapContacts');
     Route::post('user/contact-lists/map_contacts_upload/', [ContactListController::class, 'mapContactListUpload'])->name('user.contact-list.mapContactsUpload');

     Route::get('user/dnc-list', [UserDNCController::class, 'index'])->name('user.dnc-list');
     Route::post('user/dnc-list', [UserDNCController::class, 'store'])->name('user.dnc-list.store');
     // Route::get('user/dnc-list/{id}', [UserDNCController::class, 'show'])->name('user.dnc-list.show');
     Route::get('user/dnc-delete/{id}', [UserDNCController::class, 'delete'])->name('user.dnc-delete.delete');
     Route::post('user/upload/dnc-list', [UserDNCController::class, 'uploadList'])->name('user.upload.dnc-list');

     Route::get('user/dnc-time', [UserDNCTimeController::class, 'index'])->name('user.dnc-time');
     Route::post('user/dnc-time', [UserDNCTimeController::class, 'store'])->name('user.dnc-time.store');
     Route::get('user/dnc-time-delete/{id}', [UserDNCTimeController::class, 'delete'])->name('user.dnc-time-delete.delete');

     Route::get('user/setting', [UserSettingController::class, 'index'])->name('user.user_setting');
     Route::post('user/setting', [UserSettingController::class, 'store'])->name('user.user_setting.store');
     Route::get('user/setting_delete/{id}', [UserSettingController::class, 'delete'])->name('user.user_setting_delete.delete');

     Route::get('user/campaigns/change-status/{status}/{id}' , [CampaignController::class, 'change_status'])->name('user.campaign.change_status');


     Route::get('user/my-numbers', [UserMyNumberController::class, 'index'])->name('user.my_numbers');
     Route::post('user/my-numbers/upload', [UserMyNumberController::class, 'upload_newnumber'])->name('user.my_numbers.upload');
     Route::post('user/my-numbers/search', [UserMyNumberController::class, 'search_newnumber'])->name('user.my_numbers.search');
     Route::post('user/my-numbers/purchase', [UserMyNumberController::class, 'purchase_newnumber'])->name('user.my_numbers.purchase');
     Route::get('user/my-numbers/delete/{id}', [UserMyNumberController::class, 'destroy'])->name('user.mynumber.delete');



     Route::get('user/test', [CampaignController::class, 'test'])->name('usertest');
     Route::get('user/test/forward_call', [UserMyNumberController::class, 'test_forward'])->name('usertestforward');

     Route::get('user/image', function ()
     {
         $filename = auth()->user()->user_image;

         $path = storage_path() . '/images/' .$filename;

         $file = File::get($path);

         $type = File::mimeType($path);

         $response = Response::make($file, 200);

         $response->header("Content-Type", $type);
         return $response;
     })->name('user_profile_image');

     // user my group routes waleed
     Route::get('user/my-groups/show/{id}', [UserMyGroupNumberController::class, 'showMyNumberGroup'])->name('user.my_groups.show');
     Route::post('user/my-groups/add', [UserMyGroupNumberController::class, 'addNewMyNumberGroup'])->name('user.my_groups.add');
     Route::post('user/my-groups/update/{id}', [UserMyGroupNumberController::class, 'updateMyNumberGroup'])->name('user.my_groups.update');
     Route::post('user/my-groups/update_my_number/{id}', [UserMyGroupNumberController::class, 'updateGroupMyNumber'])->name('user.my_groups.update_my_number');
     Route::get('user/my-groups/delete/{id}', [UserMyGroupNumberController::class, 'deleteMyNumberGroup'])->name('user.my_groups.delete');
     Route::post('user/my-groups/get_first_number', [UserMyGroupNumberController::class, 'getMyGroupFirstNumber'])->name('user.my_groups.getFirstNumber');
     // waleed user my group routes end

    //  user invoice routes
    Route::get('user/invoices', [InvoiceController::class, 'index'])->name('user.invoices');
    Route::get('user/invoice/{id}', [InvoiceController::class, 'viewInvoice'])->name('user.invoice.view');
    Route::post('user/invoice/update/{id}', [InvoiceController::class, 'updateInvoice'])->name('user.invoice.update');
    Route::get('user/invoice/delete/{id}', [InvoiceController::class, 'deleteInvoice'])->name('user.invoice.delete');
    // user invoice routes end

     // billing routes
     Route::get('user/billing', [BillingController::class, 'index'])->name('user.billing');
     Route::get('user/sms/billing', [SmsBillingController::class, 'index'])->name('user.sms.sbilling');
     Route::get('user/billing_data', [BillingController::class, 'getBillingData'])->name('user.billing.get_billing_data');

    //  incoming call logs table
    Route::get('user/incoming_call_log', [IncomingCallLogContoller::class, 'index'])->name('user.incoming_call_log');
    Route::post('user/get_incoming_call_log', [IncomingCallLogContoller::class, 'getIncomingCallLog'])->name('user.get_incoming_call_log');

    // sms campaign routes

    Route::get('user/sms_campaigns', [SmsCampaignController::class, 'index'])->name('user.sms_campaigns');
    Route::get('user/sms_campaigns/create', [SmsCampaignController::class, 'create'])->name('user.sms_campaigns.create');
    Route::post('user/sms_campaigns', [SmsCampaignController::class, 'store'])->name('user.sms_campaign.store');
    Route::get('user/edit-sms_campaigns/{id}', [SmsCampaignController::class, 'edit'])->name('user.sms_campaign.edit');
    Route::post('user/update-sms_campaigns/{id}', [SmsCampaignController::class, 'update'])->name('user.sms_campaign.update');
    Route::get('user/show-sms_campaigns-contact-list/{campaign_id}', [SmsCampaignController::class, 'showContactList'])->name('user.sms_campaigns.showContactList');
    Route::get('user/show-sms_campaigns-contact-list-status', [SmsCampaignController::class, 'showContactListStatus'])->name('user.sms_campaigns.showContactListStatus');
    Route::get('user/sms_campaigns/get_campaign_contact_list', [SmsCampaignController::class, 'getCampaignContactList'])->name('user.sms_campaigns.get_campaign_contact_list');
    Route::get('user/sms_campaigns/get_stats', [SmsCampaignController::class, 'getStats'])->name('user.sms_campaigns.getStats');
    Route::get('user/sms_campaigns/get_send_speed', [SmsCampaignController::class, 'getSendSpeed'])->name('user.sms_campaigns.get_send_speed');
    Route::post('user/sms_campaigns/update_send_speed', [SmsCampaignController::class, 'updateSendSpeed'])->name('user.sms_campaigns.update_send_speed');
    Route::get('user/sms_campaigns/export/{id}', [SmsCampaignController::class , 'exportCampaigns'])->name('user.sms_campaigns.exportCampaign');
    Route::get('user/sms_campaigns/change-status/{status}/{id}' , [SmsCampaignController::class, 'change_status'])->name('user.sms_campaigns.change_status');


    // sms banned words
    Route::post('user/get_banned_words' , [SmsBannedWordController::class, 'getSmsBannedWord'])->name('user.get_banned_words');

    // sms contact list routes
    Route::post('user/sms_contact-lists', [SmsContactListController::class, 'ajaxStore'])->name('user.sms_contact-list.ajaxStore');
    Route::post('user/sms_contact-lists/validate_csv', [SmsContactListController::class, 'validateCsv'])->name('user.sms_contact-list.validate_csv');
    Route::get('user/sms_contact-list', [SmsContactListController::class, 'index'])->name('user.sms_contact-list.contact-list');
    Route::post('user/sms_contact-list', [SmsContactListController::class, 'store'])->name('user.sms_contact-list.store');
    Route::get('user/sms_contact-list/{id}', [SmsContactListController::class, 'show'])->name('user.sms_contact-list.show');
    Route::get('user/sms_contact-list/delete/{id}' , [SmsContactListController::class , 'destroy'])->name('user.sms_contact-list.delete');
    Route::get('user/sms_contact-list/campaigns/{id}' , [SmsContactListController::class , 'checkContactsCampaigns'])->name('user.sms_contact-list.checkcampaigns');
    Route::get('user/sms_contact-lists/export/{id}', [SmsContactListController::class, 'exportContactListContacts'])->name('user.sms_contact-list.exportContactListContacts');
    Route::post('user/sms_contact-lists/map_contacts/', [SmsContactListController::class, 'mapContactList'])->name('user.sms_contact-list.mapContacts');
    Route::post('user/sms_contact-lists/map_contacts_upload/', [SmsContactListController::class, 'mapContactListUpload'])->name('user.sms_contact-list.mapContactsUpload');

    // sms report routes
    Route::get('user/sms_reports', [SmsReportController::class, 'index'])->name('user.sms_reports');
    Route::post('user/sms_reports/counters', [SmsReportController::class, 'getCounters'])->name('user.sms_reports.counters');
    Route::post('user/sms_reports/get_send_rates_per_day', [SmsReportController::class, 'getSendRatesPerDay'])->name('user.sms_reports.get_send_rates_per_day');
    Route::post('user/sms_reports/get_callback_pie', [SmsReportController::class, 'getCallbackPieChart'])->name('user.sms_reports.get_callback_pie');
    Route::get('user/sms_reports/get_call_back_duration', [SmsReportController::class, 'getCallBackDuration'])->name('user.sms_reports.get_call_back_duration');
    Route::get('user/sms_reports/get_callback_heat_map', [SmsReportController::class, 'get_callback_heat_map'])->name('user.sms_reports.get_callback_heat_map');
    Route::get('user/sms_reports/get_call_sent_destination', [SmsReportController::class, 'getCallSentToDestination'])->name('user.sms_reports.get_call_sent_destination');
    Route::get('user/sms_reports/campagin_stats', [SmsReportController::class, 'getCampaignStats'])->name('user.sms_reports.campagin_stats');
    Route::get('user/sms_reports/list_stats', [SmsReportController::class, 'getListStats'])->name('user.sms_reports.list_stats');
    Route::get('user/sms_reports/recording_stats', [SmsReportController::class, 'getRecordingStats'])->name('user.sms_reports.recording_stats');
    Route::get('user/sms_reports/campaign_ratio', [SmsReportController::class, 'getCampaignTypeRatio'])->name('user.sms_reports.campaign_ratio');
    Route::get('user/sms_reports/campaign_send_rates', [SmsReportController::class, 'getCampaignSendRates'])->name('user.sms_reports.campaign_send_rates');
    Route::get('user/sms_reports/inbound_call_overtime', [SmsReportController::class, 'getInboundCallOvertime'])->name('user.sms_reports.inbound_call_overtime');
    Route::get('user/sms_reports/ivr_outbound_stats', [SmsReportController::class, 'getIvrOutboundStats'])->name('user.sms_reports.ivr_outbound_stats');
    Route::get('user/sms_reports/outbound_optin_heatmap', [SmsReportController::class, 'getOutboundOptinHeatmap'])->name('user.sms_reports.outbound_optin_heatmap');
    Route::get('user/sms_reports/ivr_dnc_heatmap', [SmsReportController::class, 'getIvrDncHeatmap'])->name('user.sms_reports.ivr_dnc_heatmap');
    Route::get('user/sms_reports/dnc_heatmap', [SmsReportController::class, 'getDncHeatmap'])->name('user.sms_reports.dnc_heatmap');
    Route::get('user/sms_reports/state_stats', [SmsReportController::class, 'getStateStats'])->name('user.sms_reports.state_stats');

}); //user middleware end

Route::group(['middleware'	=>	CheckAdmin::class], function() {

    // user login by id
    Route::get('admin/user/login/{id}', [UserController::class, 'userLogin'])->name('user.login');
    //Admin Routes
    Route::get('admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('admin/reports/results/{id}', [ReportController::class, 'reports_results'])->name('admin.reports.result');
    Route::get('admin/reports/per_hour_results', [ReportController::class, 'reports_campaign_per_hour_results'])->name('admin.reports.per_hour_results');
    Route::get('admin/reports', [ReportController::class, 'index'])->name('admin.report');
    Route::get('admin/reports/results', [ReportController::class, 'getReportResults'])->name('admin.reports_result');
    // new report routes
    Route::get('admin/reports', [ReportController::class, 'counterIndex'])->name('admin.reports.counters_index');
    Route::get('admin/reports/counters', [ReportController::class, 'getCounters'])->name('admin.reports.counters');
    Route::get('admin/reports/callback', [ReportController::class, 'callback'])->name('admin.reports.callback');
    Route::get('admin/reports/get_callback_heat_map', [ReportController::class, 'getCallback'])->name('admin.reports.get_callback_heat_map');
    Route::get('admin/reports/call_sent_destination', [ReportController::class, 'callSentToDestination'])->name('admin.reports.call_sent_destination');
    Route::get('admin/reports/get_call_sent_destination', [ReportController::class, 'getCallSentToDestination'])->name('admin.reports.get_call_sent_destination');
    Route::get('admin/reports/call_back_duration', [ReportController::class, 'callBackDuration'])->name('admin.reports.call_back_duration');
    Route::get('admin/reports/get_call_back_duration', [ReportController::class, 'getCallBackDuration'])->name('admin.reports.get_call_back_duration');
    Route::get('admin/reports/callback_pie', [ReportController::class, 'callbackPieChart'])->name('admin.reports.callback_pie');
    Route::get('admin/reports/get_callback_pie', [ReportController::class, 'getCallbackPieChart'])->name('admin.reports.get_callback_pie');
    Route::get('admin/reports/get_send_rates_per_day', [ReportController::class, 'getSendRatesPerDay'])->name('admin.reports.get_send_rates_per_day');
    Route::get('admin/reports/campagin_stats', [ReportController::class, 'getCampaignStats'])->name('admin.reports.campagin_stats');
    Route::get('admin/reports/list_stats', [ReportController::class, 'getListStats'])->name('admin.reports.list_stats');
    Route::get('admin/reports/recording_stats', [ReportController::class, 'getRecordingStats'])->name('admin.reports.recording_stats');
    Route::get('admin/reports/state_stats', [ReportController::class, 'getStateStats'])->name('admin.reports.state_stats');
    Route::get('admin/reports/campaign_ratio', [ReportController::class, 'getCampaignTypeRatio'])->name('admin.reports.campaign_ratio');
    Route::get('admin/reports/campaign_send_rates', [ReportController::class, 'getCampaignSendRates'])->name('admin.reports.campaign_send_rates');
    Route::get('admin/reports/inbound_call_overtime', [ReportController::class, 'getInboundCallOvertime'])->name('admin.reports.inbound_call_overtime');
    Route::get('admin/reports/ivr_outbound_stats', [ReportController::class, 'getIvrOutboundStats'])->name('admin.reports.ivr_outbound_stats');
    Route::get('admin/reports/outbound_optin_heatmap', [ReportController::class, 'getOutboundOptinHeatmap'])->name('admin.reports.outbound_optin_heatmap');
    Route::get('admin/reports/ivr_dnc_heatmap', [ReportController::class, 'getIvrDncHeatmap'])->name('admin.reports.ivr_dnc_heatmap');
    Route::get('admin/reports/dnc_heatmap', [ReportController::class, 'getDncHeatmap'])->name('admin.reports.dnc_heatmap');
    // new report routes end
    Route::get('admin/users', [UserController::class, 'index'])->name('user');
    Route::post('admin/users/create', [UserController::class, 'create'])->name('user.create');
    Route::post('admin/users/update/', [UserController::class, 'update'])->name('user.update');
    Route::get('admin/users/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::get('admin/users/activate/{id}', [UserController::class, 'activate'])->name('user.activate');
    Route::get('admin/users/detail/{id}', [UserController::class, 'userDetail'])->name('user.detail');
    Route::get('admin/recordings', [AdminRecordingController::class, 'index'])->name('admin.recording');
    Route::get('admin/recordings/delete/{id}', [AdminRecordingController::class, 'destroy'])->name('admin.recording.delete');
    Route::post('admin/recordings/update/username', [AdminRecordingController::class, 'update'])->name('admin.recording.update.username');
    Route::get('admin/listen-recording', [RecordingController::class, 'listen'])->name('admin.listen-recording');

    Route::get('admin/company', [CompanyController::class, 'index'])->name('admin.company');
    Route::post('admin/company', [CompanyController::class, 'store'])->name('admin.company.store');
    Route::post('admin/update-company', [CompanyController::class, 'update'])->name('admin.company.update');
    Route::get('admin/company/delete/{id}', [CompanyController::class, 'destroy'])->name('admin.company.delete');

    Route::get('admin/logs', [LogController::class, 'index'])->name('admin.logs');
    Route::get('admin/logs/view/{date}', [LogController::class, 'show'])->name('admin.logs.view');

    Route::get('admin/billing', [BillingController::class, 'index'])->name('admin.billing');
    Route::get('admin/sms/billing', [SmsBillingController::class, 'index'])->name('admin.sms.billing');
    Route::get('admin/billing_data', [BillingController::class, 'getBillingData'])->name('admin.billing.get_billing_data');
    Route::get('admin/sms/billing_data', [SmsBillingController::class, 'getBillingData'])->name('admin.sms.billing.get_billing_data');
    Route::get('admin/billing/company/all', [BillingController::class, 'all_company'])->name('admin.billing.all_company');
    Route::get('admin/billing/company/{id}', [BillingController::class, 'specific_company'])->name('admin.billing.specific_company');
    Route::get('admin/billing/user/all/{id}', [BillingController::class, 'all_user'])->name('admin.billing.all_user');
    Route::get('admin/billing/user/{id}', [BillingController::class, 'specific_user'])->name('admin.billing.specific_user');

    // waleed admin routes
    Route::get('admin/dnc-list', [AdminDNCController::class, 'index'])->name('admin.dnc-list');
    Route::post('admin/dnc-list', [AdminDNCController::class, 'store'])->name('admin.dnc-list.store');
    // Route::get('admin/dnc-list/{id}', [AdminDNCController::class, 'show'])->name('admin.dnc-list.show');
    Route::get('admin/dnc-delete/{id}', [AdminDNCController::class, 'delete'])->name('admin.dnc-delete.delete');

    Route::get('admin/api-setting', [ApiSettingController::class, 'index'])->name('admin.api-setting');
    Route::post('admin/api-setting', [ApiSettingController::class, 'store'])->name('admin/api-setting.store');
    Route::get('admin/api-setting/bot', [BotController::class, 'index'])->name('admin.api-setting.bot');
    Route::post('admin/api-setting/bot/store', [BotController::class, 'store'])->name('admin.api-setting.bot.store');
    Route::post('admin/api-setting/bot/update', [BotController::class, 'update'])->name('admin.api-setting.bot.update');
    Route::get('admin/api-setting/bot/delete/{id}', [BotController::class, 'destroy'])->name('admin.api-setting.bot.delete');

    Route::get('admin/display/company/daily-limit/{id}', [UserController::class, 'company_user_setting'])->name('admin.show.company.dailylimit');
    Route::post('admin/update/company/daily-limit', [UserController::class, 'company_user_setting_update'])->name('admin.update.company.dailylimit');

    Route::get('admin/display/user/daily-limit/{id}', [UserController::class, 'user_setting'])->name('admin.show.user.dailylimit');
    Route::post('admin/update/user/daily-limit', [UserController::class, 'user_setting_update'])->name('admin.update.user.dailylimit');

    Route::get('admin/contact-list', [AdminContactListController::class, 'index'])->name('admin.contact-list');
    // Route::post('admin/contact-list', [AdminContactListController::class, 'store'])->name('admin.contact-list.store');
    Route::get('admin/contact-list/{id}', [AdminContactListController::class, 'show'])->name('admin.contact-list.show');
    Route::get('admin/contact-list/delete/{id}' , [AdminContactListController::class , 'destroy'])->name('admin.contact-list.delete');
    Route::get('admin/contact-list/campaigns/{id}' , [AdminContactListController::class , 'checkContactsCampaigns'])->name('admin.contact-list.checkcampaigns');
    Route::get('admin/contact-lists/export/{id}', [AdminContactListController::class, 'adminExportContactListContacts'])->name('admin.contact-list.adminExportContactListContacts');

    Route::get('admin/show-campaigns-contact-list/{campaign_id}', [AdminDashboard::class, 'showContactList'])->name('admin.dashboard.showContactList');
    Route::get('admin/show-campaigns-contact-list-status', [AdminDashboard::class, 'showContactListStatus'])->name('admin.dashboard.showContactListStatus');
    Route::get('admin/campaigns/change-status/{status}/{id}' , [CampaignController::class, 'change_status'])->name('admin.campaign.change_status');
    Route::get('admin/campaigns/get_stats', [CampaignController::class, 'getStats'])->name('admin.campaign.getStats');
    Route::post('admin/campaigns/update_send_speed/{id}', [CampaignController::class, 'updateSendSpeed'])->name('admin.campaign.update_send_speed');

    Route::get('admin/numbers', [NumberController::class, 'index'])->name('admin.numbers');
    Route::get('admin/sw_numbers', [NumberController::class, 'sw_index'])->name('admin.sw_numbers');
    Route::post('admin/sw_numbers/search', [NumberController::class, 'sw_search'])->name('admin.sw_numbers.search');
    Route::post('admin/my-groups/update_my_number/{id}', [UserMyGroupNumberController::class, 'updateGroupMyNumber'])->name('admin.my_groups.update_my_number');
    Route::get('admin/my-numbers/delete/{id}', [UserMyNumberController::class, 'destroy'])->name('admin.mynumber.delete');
    Route::post('admin/my-numbers/search', [UserMyNumberController::class, 'search_newnumber'])->name('admin.my_numbers.search');
    Route::post('admin/my-numbers/purchase', [UserMyNumberController::class, 'purchase_newnumber'])->name('admin.my_numbers.purchase');
    Route::get('admin/my-groups/show/{id}', [UserMyGroupNumberController::class, 'showMyNumberGroup'])->name('admin.my_groups.show');
    Route::post('admin/my-groups/update/{id}', [UserMyGroupNumberController::class, 'updateMyNumberGroup'])->name('admin.my_groups.update');
    Route::get('admin/my-groups/delete/{id}', [UserMyGroupNumberController::class, 'deleteMyNumberGroup'])->name('admin.my_groups.delete');

    Route::post('admin/upload/sw-list', [NumberController::class, 'uploadList'])->name('admin.upload.sw-list');
    Route::post('admin/contact-lists/validate_csv', [ContactListController::class, 'validateCsv'])->name('admin.contact-list.validate_csv');

     //  admin invoice routes
     Route::get('admin/invoices', [InvoiceController::class, 'index'])->name('admin.invoices');
     Route::get('admin/invoice/{id}', [InvoiceController::class, 'viewInvoice'])->name('admin.invoice.view');
     Route::post('admin/invoice/update/{id}', [InvoiceController::class, 'updateInvoice'])->name('admin.invoice.update');
     Route::get('admin/invoice/delete/{id}', [InvoiceController::class, 'deleteInvoice'])->name('admin.invoice.delete');
     // admin invoice routes end

    //  incoming call logs table
    Route::get('admin/incoming_call_log', [IncomingCallLogContoller::class, 'index'])->name('admin.incoming_call_log');
    Route::post('admin/get_incoming_call_log', [IncomingCallLogContoller::class, 'getIncomingCallLog'])->name('admin.get_incoming_call_log');

    // admin sms campaigns
    Route::get('admin/sms_campaigns', [SmsCampaignController::class, 'index'])->name('admin.sms_campaigns');
    Route::get('admin/show-sms_campaigns-contact-list/{campaign_id}', [SmsCampaignController::class, 'showContactList'])->name('admin.sms_campaigns.showContactList');
    Route::get('admin/show-sms_campaigns-contact-list-status', [SmsCampaignController::class, 'showContactListStatus'])->name('admin.sms_campaigns.showContactListStatus');
    Route::get('admin/sms_campaigns/get_stats', [SmsCampaignController::class, 'getStats'])->name('admin.sms_campaigns.getStats');
    Route::get('admin/sms_campaigns/get_send_speed', [SmsCampaignController::class, 'getSendSpeed'])->name('admin.sms_campaigns.get_send_speed');
    Route::post('admin/sms_campaigns/update_send_speed', [SmsCampaignController::class, 'updateSendSpeed'])->name('admin.sms_campaigns.update_send_speed');
    Route::get('admin/sms_campaigns/export/{id}', [SmsCampaignController::class , 'exportCampaigns'])->name('admin.sms_campaigns.exportCampaign');
    Route::get('admin/sms_campaigns/change-status/{status}/{id}' , [SmsCampaignController::class, 'change_status'])->name('admin.sms_campaigns.change_status');

    // admin sms contact list
    Route::get('admin/sms_contact-list', [SmsContactListController::class, 'index'])->name('admin.sms_contact-list.contact-list');
    Route::get('admin/sms_contact-list/{id}', [SmsContactListController::class, 'show'])->name('admin.sms_contact-list.show');
    Route::get('admin/sms_contact-list/delete/{id}' , [SmsContactListController::class , 'destroy'])->name('admin.sms_contact-list.delete');
    Route::get('admin/sms_contact-list/campaigns/{id}' , [SmsContactListController::class , 'checkContactsCampaigns'])->name('admin.sms_contact-list.checkcampaigns');
    Route::get('admin/sms_contact-lists/export/{id}', [SmsContactListController::class, 'exportContactListContacts'])->name('admin.sms_contact-list.exportContactListContacts');

    // admin sms banned words
    Route::get('admin/sms_banned_word', [SmsBannedWordController::class, 'index'])->name('admin.sms_banned_word');
    Route::post('admin/sms_banned_word', [SmsBannedWordController::class, 'store'])->name('admin.sms_banned_word.store');
    Route::get('admin/sms_banned_word/{id}', [SmsContactListController::class, 'edit'])->name('admin.sms_banned_word.edit');
    Route::post('admin/sms_banned_word/update/{id}', [SmsBannedWordController::class, 'update'])->name('admin.sms_banned_word.update');
    Route::get('admin/sms_banned_word/delete/{id}', [SmsBannedWordController::class, 'destroy'])->name('admin.sms_banned_word.delete');
});

Route::group(['middleware'	=>	CheckCompany::class], function() {
    // Route::get('company/dashboard', [UserDashboard::class, 'index'])->name('company.dashboard');
    // Route::get('company/dashboard', [ReportController::class, 'index'])->name('company.dashboard');
    // Route::get('company/reports/results', [ReportController::class, 'getReportResults'])->name('company.reports_result');
    // new report routes
    Route::get('company/dashboard', [ReportController::class, 'counterIndex'])->name('company.dashboard');
    Route::get('company/reports/counters', [ReportController::class, 'getCounters'])->name('company.reports.counters');
    Route::get('company/reports/callback', [ReportController::class, 'callback'])->name('company.reports.callback');
    Route::get('company/reports/get_callback_heat_map', [ReportController::class, 'getCallback'])->name('company.reports.get_callback_heat_map');
    Route::get('company/reports/call_sent_destination', [ReportController::class, 'callSentToDestination'])->name('company.reports.call_sent_destination');
    Route::get('company/reports/get_call_sent_destination', [ReportController::class, 'getCallSentToDestination'])->name('company.reports.get_call_sent_destination');
    Route::get('company/reports/call_back_duration', [ReportController::class, 'callBackDuration'])->name('company.reports.call_back_duration');
    Route::get('company/reports/get_call_back_duration', [ReportController::class, 'getCallBackDuration'])->name('company.reports.get_call_back_duration');
    Route::get('company/reports/callback_pie', [ReportController::class, 'callbackPieChart'])->name('company.reports.callback_pie');
    Route::get('company/reports/get_callback_pie', [ReportController::class, 'getCallbackPieChart'])->name('company.reports.get_callback_pie');
    Route::get('company/reports/get_send_rates_per_day', [ReportController::class, 'getSendRatesPerDay'])->name('company.reports.get_send_rates_per_day');
    Route::get('company/reports/campagin_stats', [ReportController::class, 'getCampaignStats'])->name('company.reports.campagin_stats');
    Route::get('company/reports/list_stats', [ReportController::class, 'getListStats'])->name('company.reports.list_stats');
    Route::get('company/reports/recording_stats', [ReportController::class, 'getRecordingStats'])->name('company.reports.recording_stats');
    Route::get('company/reports/state_stats', [ReportController::class, 'getStateStats'])->name('company.reports.state_stats');
    Route::get('company/reports/campaign_ratio', [ReportController::class, 'getCampaignTypeRatio'])->name('company.reports.campaign_ratio');
    Route::get('company/reports/campaign_send_rates', [ReportController::class, 'getCampaignSendRates'])->name('company.reports.campaign_send_rates');
    Route::get('company/reports/inbound_call_overtime', [ReportController::class, 'getInboundCallOvertime'])->name('company.reports.inbound_call_overtime');
    Route::get('company/reports/ivr_outbound_stats', [ReportController::class, 'getIvrOutboundStats'])->name('company.reports.ivr_outbound_stats');
    Route::get('company/reports/outbound_optin_heatmap', [ReportController::class, 'getOutboundOptinHeatmap'])->name('company.reports.outbound_optin_heatmap');

    Route::get('company/reports/ivr_dnc_heatmap', [ReportController::class, 'getIvrDncHeatmap'])->name('company.reports.ivr_dnc_heatmap');
    Route::get('company/reports/dnc_heatmap', [ReportController::class, 'getDncHeatmap'])->name('company.reports.dnc_heatmap');
    // new report routes end

    // Route::get('company/dashboard/results/{id}', [UserDashboard::class, 'dashboard_results'])->name('company.dashboard.result');
    // Route::get('company/dashboard/per_hour_results', [UserDashboard::class, 'dashboard_campaign_per_hour_results'])->name('company.dashboard.per_hour_results');

    Route::get('company/recordings', [RecordingController::class, 'index'])->name('company.recording');
    Route::get('company/listen-recording', [RecordingController::class, 'listen'])->name('company.listen-recording');

    Route::get('company/contact-list', [ContactListController::class, 'index'])->name('company.contact-list');
    Route::get('company/campaigns', [CampaignController::class, 'index'])->name('company.campaign');
    // Route::get('company/campaigns/change-status/{status}/{id}' , [CampaignController::class, 'change_status'])->name('company.campaign.change_status');
    // Route::get('company/show-campaigns-contact-list/{campaign_id}', [CampaignController::class, 'showContactList'])->name('company.campaign.showContactList');
    // Route::get('company/show-campaigns-contact-list-status', [CampaignController::class, 'showContactListStatus'])->name('company.campaign.showContactListStatus');
    // Route::get('company/campaign/export/{id}', [CampaignController::class , 'exportCampaigns'])->name('company.campaign.exportCampaign');
    // waleed routes
    Route::get('company/user_campaigns/{id}', [UserDashboard::class, 'getCompanyUserCampaigns'])->name('company.user_campaigns');
    Route::get('company/ajax_dashboard', [UserDashboard::class, 'ajaxDashboard'])->name('company.ajaxdashboard');
    Route::get('company/dashboard/results/{id}', [UserDashboard::class, 'dashboard_results'])->name('company.dashboard.result');
    Route::get('company/dashboard/per_hour_results', [UserDashboard::class, 'dashboard_campaign_per_hour_results'])->name('company.dashboard.per_hour_results');
    // waleed routes end

    // Route::get('company/dnc-list', [UserDNCController::class, 'index'])->name('company.dnc-list');
    Route::get('company/dnc-time', [UserDNCTimeController::class, 'index'])->name('company.dnc-time');
    Route::post('company/dnc-time', [UserDNCTimeController::class, 'store'])->name('company.dnc-time.store');

    // user dnc list
    Route::get('company/dnc-list', [UserDNCController::class, 'index'])->name('company.dnc-list');
    Route::post('company/dnc-list', [UserDNCController::class, 'store'])->name('company.dnc-list.store');
    // Route::get('company/dnc-list/{id}', [UserDNCController::class, 'show'])->name('user.dnc-list.show');
    Route::get('company/dnc-delete/{id}', [UserDNCController::class, 'delete'])->name('company.dnc-delete.delete');
    Route::post('company/upload/dnc-list', [UserDNCController::class, 'uploadList'])->name('company.upload.dnc-list');

    //comapny admin billings
    Route::get('company-admin/billing', [CompanyBillingController::class, 'index'])->name('company_admin.billing');
    Route::get('company-admin/sms/billing', [CompanyBillingController::class, 'index'])->name('company_admin.sms.billing');
    Route::get('company-admin/billing/user/all', [CompanyBillingController::class, 'all_user'])->name('company_admin.billing.all_user');
    Route::get('company-admin/billing/user/{id}', [CompanyBillingController::class, 'specific_user'])->name('company_admin.billing.specific_user');

    // company routes waleed
    Route::get('company/user', [UserController::class, 'companyUser'])->name('company.company_user');
    Route::post('company/users/create', [UserController::class, 'create'])->name('company.user.create');
    Route::post('company/users/update/', [UserController::class, 'update'])->name('company.user.update');
    Route::get('company/users/delete/{id}', [UserController::class, 'delete'])->name('company.user.delete');
    Route::get('company/users/activate/{id}', [UserController::class, 'activate'])->name('company.user.activate');

    // user settings
    Route::get('company/setting', [UserSettingController::class, 'index'])->name('company.user_setting');
    Route::post('company/setting', [UserSettingController::class, 'store'])->name('company.user_setting.store');
    Route::get('company/setting_delete/{id}', [UserSettingController::class, 'delete'])->name('company.user_setting_delete.delete');

    //  company invoice routes
    Route::get('company/invoices', [InvoiceController::class, 'index'])->name('company.invoices');
    Route::get('company/invoice/{id}', [InvoiceController::class, 'viewInvoice'])->name('company.invoice.view');
    Route::post('company/invoice/update/{id}', [InvoiceController::class, 'updateInvoice'])->name('company.invoice.update');
    Route::get('company/invoice/delete/{id}', [InvoiceController::class, 'deleteInvoice'])->name('company.invoice.delete');
    // company invoice routes end

    Route::get('company/my-numbers', [UserMyNumberController::class, 'index'])->name('company.my_numbers');

     // billing routes
     Route::get('company/billing', [BillingController::class, 'index'])->name('company.billing');
     Route::get('company/sms/billing', [SmsBillingController::class, 'index'])->name('company.sms.billing');
     Route::get('company/billing_data', [BillingController::class, 'getBillingData'])->name('company.billing.get_billing_data');

     //  incoming call logs table
    Route::get('company/incoming_call_log', [IncomingCallLogContoller::class, 'index'])->name('company.incoming_call_log');
    Route::post('company/get_incoming_call_log', [IncomingCallLogContoller::class, 'getIncomingCallLog'])->name('company.get_incoming_call_log');

});

Route::middleware(['auth'])->group(function () {


});

Route::post('signal-forward', [\App\Http\Controllers\SignalForwardController::class, 'adminXml'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('SignalForward');
Route::post('client-forward', [\App\Http\Controllers\SignalForwardController::class, 'clientXml'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('ClientSignalForward');
Route::post('fs-simulation', [\App\Http\Controllers\User\CampaignController::class, 'fsSimulation'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('campaignFsSimulation');
Route::post('press_one_action', [\App\Http\Controllers\User\CampaignController::class, 'pressOneAction'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('campaignPressOneAction');
Route::post('test-signalwire', [\App\Http\Controllers\SignalForwardController::class, 'testSample'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('testSample');

Route::get('recordings/download/{id}', [RecordingController::class, 'download'])->name('recording.download');

Route::get('/user/chat', function(){
    return view('user.chat.index');
});
