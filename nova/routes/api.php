<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Nova\DncController;
use App\Http\Controllers\Nova\EmailController;
use App\Http\Controllers\Nova\DncTimeController;
use App\Http\Controllers\Nova\PaymentController;
use App\Http\Controllers\Nova\MyNumberController;
use Laravel\Nova\Http\Controllers\CardController;
use Laravel\Nova\Http\Controllers\LensController;
use App\Http\Controllers\Nova\AwsUploadController;
use Laravel\Nova\Http\Controllers\FieldController;
use Laravel\Nova\Http\Controllers\StyleController;
use Laravel\Nova\Http\Controllers\ActionController;
use Laravel\Nova\Http\Controllers\FilterController;
use Laravel\Nova\Http\Controllers\MetricController;
use Laravel\Nova\Http\Controllers\ScriptController;
use Laravel\Nova\Http\Controllers\SearchController;
use Laravel\Nova\Http\Controllers\SurveyController;
use App\Http\Controllers\Nova\ContactListController;
use Laravel\Nova\Http\Controllers\LensCardController;
use Laravel\Nova\Http\Controllers\TestCallController;
use Laravel\Nova\Http\Controllers\DashboardController;
use Laravel\Nova\Http\Controllers\MorphableController;
use App\Http\Controllers\Nova\SmsContactListController;
use Laravel\Nova\Http\Controllers\AttachableController;
use Laravel\Nova\Http\Controllers\LensActionController;
use Laravel\Nova\Http\Controllers\LensFilterController;
use Laravel\Nova\Http\Controllers\LensMetricController;
use App\Http\Controllers\Nova\Billing\BillingController;
use App\Http\Controllers\Nova\Company\CompanyController;
use Laravel\Nova\Http\Controllers\ImpersonateController;
use Laravel\Nova\Http\Controllers\UpdateFieldController;
use Laravel\Nova\Http\Controllers\AssociatableController;
use Laravel\Nova\Http\Controllers\DetailMetricController;
use Laravel\Nova\Http\Controllers\FieldDestroyController;
use Laravel\Nova\Http\Controllers\ResourceShowController;
use App\Http\Controllers\Nova\Campaign\CampaignController;
use Laravel\Nova\Http\Controllers\CreationFieldController;
use Laravel\Nova\Http\Controllers\DashboardCardController;
use Laravel\Nova\Http\Controllers\FieldDownloadController;
use Laravel\Nova\Http\Controllers\ResourceCountController;
use Laravel\Nova\Http\Controllers\ResourceIndexController;
use Laravel\Nova\Http\Controllers\ResourceStoreController;
use Laravel\Nova\Http\Controllers\ResourceAttachController;
use Laravel\Nova\Http\Controllers\ResourceDetachController;
use Laravel\Nova\Http\Controllers\ResourceSearchController;
use Laravel\Nova\Http\Controllers\ResourceUpdateController;
use Laravel\Nova\Http\Controllers\TrixAttachmentController;
use App\Http\Controllers\Nova\Recording\RecordingController;
use Laravel\Nova\Http\Controllers\DashboardMetricController;
use Laravel\Nova\Http\Controllers\ResourceDestroyController;
use Laravel\Nova\Http\Controllers\ResourcePreviewController;
use Laravel\Nova\Http\Controllers\ResourceRestoreController;
use Illuminate\Http\Middleware\CheckResponseForModifications;
use Laravel\Nova\Http\Controllers\NotificationReadController;
use Laravel\Nova\Http\Controllers\SoftDeleteStatusController;
use Laravel\Nova\Http\Controllers\UpdatePivotFieldController;
use Laravel\Nova\Http\Controllers\LensResourceCountController;
use Laravel\Nova\Http\Controllers\NotificationIndexController;
use Laravel\Nova\Http\Controllers\PivotFieldDestroyController;
use Laravel\Nova\Http\Controllers\CreationPivotFieldController;
use Laravel\Nova\Http\Controllers\NotificationDeleteController;
use App\Http\Controllers\Nova\Callerid\CirContactListController;
use Laravel\Nova\Http\Controllers\LensResourceDestroyController;
use Laravel\Nova\Http\Controllers\LensResourceRestoreController;
use Laravel\Nova\Http\Controllers\NotificationReadAllController;
use Laravel\Nova\Http\Controllers\ResourceForceDeleteController;
use Laravel\Nova\Http\Controllers\MorphedResourceAttachController;
use Laravel\Nova\Http\Controllers\AttachedResourceUpdateController;
use Laravel\Nova\Http\Controllers\RelatableAuthorizationController;
use Laravel\Nova\Http\Controllers\LensResourceForceDeleteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CallFlowController;
use App\Http\Controllers\Nova\AgentController;
use Laravel\Nova\Http\Controllers\RecordingController as RecAudioController;
use App\Http\Controllers\Nova\Dashboard\ReportController;
use App\Http\Controllers\Nova\QAController;
use App\Http\Controllers\Nova\AudioController;
use App\Http\Controllers\Nova\TopicController;
use App\Http\Controllers\Nova\ScorecardController;
use App\Http\Controllers\Nova\DepartmentController;
use App\Http\Controllers\Nova\LeadController;
use App\Http\Controllers\Nova\NotificationController;
use App\Http\Controllers\Nova\PredictiveController;
use App\Http\Controllers\Nova\SmsController;

Route::group(['prefix' => 'custom'], function () {
    Route::get('get-bot-user/{id}', [UserController::class, 'getBotUser']);
    Route::get('audio/{id}', [AudioController::class, 'index']);
    Route::get('agents', [QAController::class, 'getAgents']);
    Route::post('ivr-call-logs/{id}', [CampaignController::class, 'getIvrLogs']);
    Route::post('incoming-call-logs/{id}', [CampaignController::class, 'getIncomingLogs']);
    Route::post('call-back-logs/{id}', [CampaignController::class, 'getCallBackLogs']);
    Route::get('export-ivr-logs/{id}/{page}/{per_page}', [CampaignController::class, 'exportIvrLogs']);
    Route::get('export-incoming-logs/{id}/{page}/{per_page}', [CampaignController::class, 'exportIncomingLogs']);
    Route::get('export-call-back-logs/{id}/{page}/{per_page}', [CampaignController::class, 'exportCallBackLogs']);
    Route::post('get-callsent-to-destination/{id}', [CampaignController::class, 'getCallSentToDestination']);
    Route::post('get-callback/{id}', [CampaignController::class, 'getCallback']);
    Route::post('get-campaign-send-rates/{id}', [CampaignController::class, 'getCampaignSendRates']);
    Route::post('get-campaign-stats/{id}', [CampaignController::class, 'getCampaignStats']);
    Route::post('get-optin-data/{id}', [CampaignController::class, 'getOptIn']);
    Route::post('get-optout-data/{id}', [CampaignController::class, 'getOptOut']);
    Route::post('get-rvm-call-back/{id}', [CampaignController::class, 'getRvmCallBackData']);
    Route::get('campaign-finished', [CampaignController::class, 'campaignFinishedMail']);
    Route::get('lead-list-create/{name}', [LeadController::class, 'createLeadList']);
    Route::get('contact-list-create/{name}', [ContactListController::class, 'createContactList']);
    Route::get('cir-contact-list-create/{name}', [ContactListController::class, 'createCirContactList']);
    Route::get('sms-contact-list-create/{name}', [SmsContactListController::class, 'createSmsContatList']);
    Route::get('predictive-agents', [PredictiveController::class, 'getAgents']);

    Route::post('get-messages', [SmsController::class, 'getMessages']);
    Route::get('campaign-contacts/{id}', [SmsController::class, 'getCampaignContacts']);

    Route::post('payment', [PaymentController::class, 'payment']);
    Route::get('recordings', [RecordingController::class, 'index']);
    Route::get('topics', [QAController::class, 'getTopics']);
    Route::post('add-phrase', [QAController::class, 'addPhrase']);
    Route::post('my-numbers/{id}', [MyNumberController::class, 'updateMyNumber']);
    Route::get('billing/get-value-by-types', [BillingController::class, 'getvaluesByTypes']);
    Route::get('billing/get-value-by-main-types', [BillingController::class, 'getValuesByMainTypes']);
    Route::get('billing/payments', [BillingController::class, 'payments']);
    Route::get('balances', [BillingController::class, 'getBalances']);
    Route::get('get-payment-group-by-date', [BillingController::class, 'getPaymentGroupedByDate']);
    Route::get('get-usage-group-by-date', [BillingController::class, 'getUsageGroupedByDate']);
    Route::get('billing/get-value-by-campaign-id', [BillingController::class, 'getValuesByCampaignId']);
    Route::get('companies', [CompanyController::class, 'index']);
    Route::get('low-balance', [CompanyController::class, 'lowBalanceMail']);
    Route::get('users', [UserController::class, 'getUsers']);
    Route::post('get-company-balance', [CompanyController::class, 'companyBalance']);
    // dashboard routes
    Route::post('get-average-callback-duration', [ReportController::class, 'getAverageCallbackDuration']);
    Route::get('get-call-details', [QAController::class, 'getCallDetails']);
    Route::post('get-callback', [ReportController::class, 'getCallback']);
    Route::post('get-callsent-to-destination', [ReportController::class, 'getCallSentToDestination']);
    Route::post('get-sendrates-per-day', [ReportController::class, 'getSendRatesPerDay']);
    Route::post('get-calls-per-campaign', [ReportController::class, 'getCallsPerCampaign']);
    Route::post('get-average-calls-per-campaign', [ReportController::class, 'getAverageCallsPerCampaign']);
    Route::get('get-campaign-stats', [ReportController::class, 'getCampaignStats']);
    Route::get('get-list-stats', [ReportController::class, 'getListStats']);
    Route::get('get-recording-stats', [ReportController::class, 'getRecordingStats']);
    Route::post('get-ivr-outbound-stats', [ReportController::class, 'getIvrOutboundStats']);
    Route::get('get-state-stats', [ReportController::class, 'getStateStats']);
    Route::post('get-campaign-send-rates', [ReportController::class, 'getCampaignSendRates']);
    Route::post('get-ivr-dnc', [ReportController::class, 'getIvrDnc']);
    Route::post('get-dnc', [ReportController::class, 'getDnc']);
    Route::post('get-campaign-ratio', [ReportController::class, 'getCampaignRatio']);
    Route::post('get-inbound-call', [ReportController::class, 'getInboundCall']);
    Route::post('get-outbound-optin', [ReportController::class, 'getOutboundOptin']);
    Route::get('reports/spend-per-day', [ReportController::class, 'GetSpendPerDay']);
    Route::get('reports/spending-by-category', [ReportController::class, 'spendingByCategory']);
    Route::get('reports/spending-by-company', [ReportController::class, 'spendingByCompany']);
    Route::get('reports/payments-by-company', [ReportController::class, 'paymentsByCompany']);
    Route::get('company-campaign-data', [ReportController::class, 'companyCampaignData']);
    Route::post('get-dashboard-call-back', [ReportController::class, 'getDashboardCallBackData']);
    Route::post('get-dashboard-call-out', [ReportController::class, 'getDashboardCallOutData']);
    Route::get('get-number-callbacks/{id}', [CampaignController::class, 'getMyNumberCallBack']);
    Route::get('get-number-callreceviedrate/{id}', [CampaignController::class, 'getMyNumberCallSendRate']);
    Route::get('get-number-call-logs/{id}', [CampaignController::class, 'getMyNumberCallLogs']);
    Route::get('get-number-cards-data/{id}', [CampaignController::class, 'getMyNumberCardsData']);

    Route::post('get-contact-heatmap/{id}', [ContactListController::class, 'getContactHeatMap']);
    Route::post('get-dnc-contact-heatmap/{id}', [ContactListController::class, 'getDncContactHeatMap']);
    Route::post('get-lerg-piechart/{id}', [ContactListController::class, 'getLergPiechart']);
    Route::post('get-mobile-piechart/{id}', [ContactListController::class, 'getMobilePiechart']);
    Route::post('get-voip-piechart/{id}', [ContactListController::class, 'getVoipPiechart']);
    Route::post('get-fixed-piechart/{id}', [ContactListController::class, 'getFixedPiechart']);

    Route::get('get-user-notifications', [NotificationController::class, 'getUserNotifications']);

    Route::get('get-company-agents', [AgentController::class, 'getCompanyAgents']);
    Route::get('get-call-status/{status}', [AgentController::class, 'getCallStatus']);
});

// Scripts & Styles...
Route::get('/scripts/{script}', ScriptController::class)->middleware(CheckResponseForModifications::class);
Route::get('/styles/{style}', StyleController::class)->middleware(CheckResponseForModifications::class);

// Global Search...
Route::get('/search', SearchController::class);

// Impersonation...
Route::post('impersonate', [ImpersonateController::class, 'impersonate']);
Route::delete('impersonate', [ImpersonateController::class, 'stopImpersonating']);

Route::post('survey/save', [SurveyController::class, 'store']);
Route::post('test/call', [TestCallController::class, 'store']);
Route::post('recordings/get', [RecAudioController::class, 'store']);

Route::group(['prefix' => 'custom'], function () {
    Route::get('recordings', [RecordingController::class, 'index']);
    Route::post('my-numbers/{id}', [MyNumberController::class, 'updateMyNumber']);
    Route::get('get-my-number/{id}', [MyNumberController::class, 'getMyNumber']);
    Route::post('aws-upload-dropzone', [AwsUploadController::class, 'upload']);
    Route::post('aws-remove-dropzone', [AwsUploadController::class, 'remove']);
    Route::post('topic', [TopicController::class, 'store']);
    Route::get('topic/scorecard', [TopicController::class, 'index']);
    Route::get('scorecards', [ScorecardController::class, 'index']);
    Route::get('topics/{id}', [DepartmentController::class, 'indexTopics']);
    Route::post('topic/save', [DepartmentController::class, 'storeTopic']);

    Route::get('departments', [DepartmentController::class, 'index']);
    Route::get('phrases/{id}', [ScorecardController::class, 'indexPhrases']);
    Route::post('phrase/save', [ScorecardController::class, 'storePhrase']);

    Route::get('call-flows', [CallFlowController::class, 'index']);
    Route::post('call-flow-step', [CallFlowController::class, 'store']);

    Route::get('qa-call/{id}', [AudioController::class, 'getCall']);
});

Route::group(['prefix' => 'audio'], function () {
    Route::get('/type/{type}', [AudioController::class, 'calls']);
    Route::get('/filters', [AudioController::class, 'filters']);
    Route::post('/notes/store', [AudioController::class, 'storeNote']);
    Route::post('/filters/{type}', [AudioController::class, 'filtersApply']);
    Route::post('/create', [AudioController::class, 'store']);
});

Route::group(['prefix' => 'contact-lists'], function () {
    Route::post('upload', [ContactListController::class, 'store']);
});
Route::group(['prefix' => 'sms-contact-lists'], function () {
    Route::post('upload', [SmsContactListController::class, 'store']);
});

// Fields...
Route::get('/{resource}/field/{field}', FieldController::class);
Route::post('/{resource}/trix-attachment/{field}', [TrixAttachmentController::class, 'store']);
Route::delete('/{resource}/trix-attachment/{field}', [TrixAttachmentController::class, 'destroyAttachment']);
Route::delete('/{resource}/trix-attachment/{field}/{draftId}', [TrixAttachmentController::class, 'destroyPending']);
Route::get('/{resource}/creation-fields', CreationFieldController::class);
Route::get('/{resource}/{resourceId}/update-fields', UpdateFieldController::class);
Route::get('/{resource}/{resourceId}/creation-pivot-fields/{relatedResource}', CreationPivotFieldController::class);
Route::get('/{resource}/{resourceId}/update-pivot-fields/{relatedResource}/{relatedResourceId}', UpdatePivotFieldController::class);
Route::patch('/{resource}/creation-fields', [CreationFieldController::class, 'sync']);
Route::patch('/{resource}/{resourceId}/update-fields', [UpdateFieldController::class, 'sync']);
Route::patch('/{resource}/{resourceId}/creation-pivot-fields/{relatedResource}', [CreationPivotFieldController::class, 'sync']);
Route::patch('/{resource}/{resourceId}/update-pivot-fields/{relatedResource}/{relatedResourceId}', [UpdatePivotFieldController::class, 'sync']);
Route::get('/{resource}/{resourceId}/download/{field}', FieldDownloadController::class);
Route::delete('/{resource}/{resourceId}/field/{field}', FieldDestroyController::class);
Route::delete('/{resource}/{resourceId}/{relatedResource}/{relatedResourceId}/field/{field}', PivotFieldDestroyController::class);

// Dashboards...
Route::get('/dashboards/{dashboard}', DashboardController::class);
Route::get('/dashboards/cards/{dashboard}', DashboardCardController::class);

// Notifications...
Route::get('/nova-notifications', NotificationIndexController::class);
Route::post('/nova-notifications/read-all', NotificationReadAllController::class);
Route::post('/nova-notifications/{notification}/read', NotificationReadController::class);
Route::delete('/nova-notifications/{notification}/delete', NotificationDeleteController::class);

// Actions...
Route::get('/{resource}/actions', [ActionController::class, 'index']);
Route::post('/{resource}/action', [ActionController::class, 'store']);

// Filters...
Route::get('/{resource}/filters', FilterController::class);

// Lenses...
Route::get('/{resource}/lenses', [LensController::class, 'index']);
Route::get('/{resource}/lens/{lens}', [LensController::class, 'show']);
Route::get('/{resource}/lens/{lens}/count', LensResourceCountController::class);
Route::delete('/{resource}/lens/{lens}', LensResourceDestroyController::class);
Route::delete('/{resource}/lens/{lens}/force', LensResourceForceDeleteController::class);
Route::put('/{resource}/lens/{lens}/restore', LensResourceRestoreController::class);
Route::get('/{resource}/lens/{lens}/actions', [LensActionController::class, 'index']);
Route::post('/{resource}/lens/{lens}/action', [LensActionController::class, 'store']);
Route::get('/{resource}/lens/{lens}/filters', [LensFilterController::class, 'index']);

// Cards / Metrics...
Route::get('/metrics/{metric}', DashboardMetricController::class);
Route::get('/{resource}/metrics', [MetricController::class, 'index']);
Route::get('/{resource}/metrics/{metric}', [MetricController::class, 'show']);
Route::get('/{resource}/{resourceId}/metrics/{metric}', DetailMetricController::class);

Route::get('/{resource}/lens/{lens}/metrics', [LensMetricController::class, 'index']);
Route::get('/{resource}/lens/{lens}/metrics/{metric}', [LensMetricController::class, 'show']);

Route::get('/{resource}/cards', CardController::class);
Route::get('/{resource}/lens/{lens}/cards', LensCardController::class);

// Authorization Information...
Route::get('/{resource}/relate-authorization', RelatableAuthorizationController::class);

// Soft Delete Information...
Route::get('/{resource}/soft-deletes', SoftDeleteStatusController::class);

// Resource Management...
Route::get('/{resource}', ResourceIndexController::class);
Route::get('/{resource}/search', ResourceSearchController::class);
Route::get('/{resource}/count', ResourceCountController::class);
Route::delete('/{resource}/detach', ResourceDetachController::class);
Route::put('/{resource}/restore', ResourceRestoreController::class);
Route::delete('/{resource}/force', ResourceForceDeleteController::class);
Route::get('/{resource}/{resourceId}', ResourceShowController::class);
Route::get('/{resource}/{resourceId}/preview', ResourcePreviewController::class);
Route::post('/{resource}', ResourceStoreController::class);
Route::put('/{resource}/{resourceId}', ResourceUpdateController::class);
Route::delete('/{resource}', ResourceDestroyController::class);

// Associatable Resources...
Route::get('/{resource}/associatable/{field}', AssociatableController::class);
Route::get('/{resource}/{resourceId}/attachable/{field}', AttachableController::class);
Route::get('/{resource}/morphable/{field}', MorphableController::class);

// Resource Attachment...
Route::post('/{resource}/{resourceId}/attach/{relatedResource}', ResourceAttachController::class);
Route::post('/{resource}/{resourceId}/update-attached/{relatedResource}/{relatedResourceId}', AttachedResourceUpdateController::class);
Route::post('/{resource}/{resourceId}/attach-morphed/{relatedResource}', MorphedResourceAttachController::class);

Route::post('upload/dnc-list', [DncController::class, 'uploadList']);
Route::post('upload/email', [EmailController::class, 'uploadList']);
Route::post('upload/callzy-numbers', [MyNumberController::class, 'uploadCallzyNumbers']);

Route::group(['prefix' => 'campaigns'], function () {
    Route::patch('{campaign}', [CampaignController::class, 'update']);
    Route::get('stats/{id}', [CampaignController::class, 'getStats']);
    Route::get('{campaign}/send-speed', [CampaignController::class, 'getSendSpeed']);
    Route::put('{campaign}/send-speed', [CampaignController::class, 'updateSendSpeed']);
    Route::post('get-recording-filename', [CampaignController::class, 'getRadioFileName']);
});
Route::group(['prefix' => 'numbers'], function () {
    Route::post('get-states', [MyNumberController::class, 'getStates']);
    Route::post('get-ratecenter', [MyNumberController::class, 'getStateRateCenter']);
    Route::post('get-numbers', [MyNumberController::class, 'searchNumbers']);
    Route::post('get-sms-numbers', [MyNumberController::class, 'searchSmsNumbers']);
    Route::post('purchase-numbers', [MyNumberController::class, 'purchaseNumbers']);
    Route::post('purchase-sms-numbers', [MyNumberController::class, 'purchaseSmsNumbers']);
    Route::post('purchase-call-flow-numbers', [MyNumberController::class, 'purchaseCallFlowNumbers']);
});
Route::get('campaigns/change-status/{status}/{id}', [CampaignController::class, 'change_status']);
Route::get('campaigns/get_stats', [CampaignController::class, 'getStats']);
Route::get('campaigns/get_send_speed', [CampaignController::class, 'getSendSpeed']);
Route::post('campaigns/update_send_speed', [CampaignController::class, 'updateSendSpeed']);

Route::get('dnc-time', [DncTimeController::class, 'dncTime']);
Route::post('dnc-time', [DncTimeController::class, 'updateDncTime']);

Route::group(['prefix' => 'caller-id-contact-lists'], function () {
    Route::post('upload', [CirContactListController::class, 'store']);
    Route::post('upload/new', [CirContactListController::class, 'upload']);
    Route::post('getcompanies', [CirContactListController::class, 'getCompanies']);
});
