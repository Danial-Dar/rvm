<?php

namespace App\Http\Controllers\Sms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon;
use Carbon\CarbonPeriod;
use App\Models\User;
use App\Models\DNC;
use App\Models\SmsCampaign;
use App\Models\SmsContactList;
use App\Models\SmsContact;
use App\Models\SmsCampaignContact;
class ReportController extends Controller
{
    public function index(Request $request){

        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        if (!$company_id){
            //TODO! implement proper error handling.
            abort(403, 'Please define company of user.');
        }
        $campaig_q  = SmsCampaign::query();
        $contact_q= SmsContactList::query();
        if (auth()->user()->role == "user") {
            $campaig_q->Where('user_id', $user_id)->where('company_id',$company_id);
            $contact_q->Where('user_id', $user_id)->where('company_id',$company_id);
        }
        $sms_campaign = $campaig_q->get();

        $sms_contact_lists = $contact_q->get();

        return view('sms.reports.index',compact('sms_campaign','sms_contact_lists'));

    }

    public function getCounters(Request $request){
        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        $list_id = $request->list_id;

        $listQ = SmsContactList::query();
        $contactQ = SmsContact::query();
        $statsUserWhere = '';
        $statsCompanyWhere = '';
        $campaignIdWhere = '';

        $inboundCallsPerSecond = '';
        $outgoingCallsPerSecond = '';

        if($role == "user"){
            $statsUserWhere = sprintf('and user_id ='.$user_id.' and company_id::BIGINT = '.$company_id.'');
            $listQ->where('user_id',$user_id)->where('company_id',$company_id);
            $contactQ->where('user_id',$user_id)->where('company_id',$company_id);

            $inboundCallsPerSecond = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT= '.$company_id.'';
            $outgoingCallsPerSecond = 'AND c.user_id::BIGINT ='.$user_id.' AND c.company_id::BIGINT= '.$company_id.'';

        }

        $inboundCampaignIdWhere = '';
        $outgoingCampaignIdWhere = '';
        if($campaign_id != null){
             $campaignIdWhere = 'and sms_campaign_id::BIGINT ='.$campaign_id.'';
             $campaign = SmsCampaign::find($campaign_id);
             $contactQ->whereIn('sms_contact_list_id', json_decode($campaign->sms_contact_list_id));
            //  $noOfCallsPerCampaignIdWhere = 'AND c.id='.$campaign_id.'';
            //  $avgCallDurationCampaignIdWhere = 'AND c.id='.$campaign_id.'';

             $inboundCampaignIdWhere = 'AND c.id='.$campaign_id.'';
             $outgoingCampaignIdWhere = 'AND c.id='.$campaign_id.'';
        }

        $dateWhere = sprintf("where created_at::Date between '$start_date'::DATE AND '$end_date'::DATE");
        // dd($campaignIdWhere );
        $campaignConter = sprintf("select sum(contact_count) as contact_count, sum(sent_count) as sent_count,sum(dnc_count) as dnc_count from sms_campaign_stats %s %s %s %s", $dateWhere, $campaignIdWhere,$statsUserWhere, $statsCompanyWhere);
        $campaignConterData = collect(\DB::select(\DB::raw($campaignConter)))->first();


        $totalLists = $listQ->where('status','active')->whereBetween('created_at',[$start_date,$end_date])->count();
        if($list_id != null){
            $contactQ->where('sms_contact_list_id', $list_id);
        }
        $totalContacts = $contactQ->where('status','active')->whereBetween('created_at',[$start_date,$end_date])->count();

        // $billing = $this->billingData($start_date,$end_date,$campaign_id);

        // $inboundDateWhere = sprintf("WHERE icl.updated_at::Date between '$start_date'::DATE AND '$end_date'::DATE");
        // $outgoingDateWhere = sprintf("WHERE cc.updated_at::Date between '$start_date'::DATE AND '$end_date'::DATE");

        // $inboundCall  = "SELECT icl.\"Direction\" as call_type, count(*) AS call_count FROM incoming_call_logs icl
        //     LEFT JOIN campaigns c on c.id = icl.campaign_id
        //     $inboundDateWhere
        //     $inboundCallsPerSecond
        //     $inboundCampaignIdWhere
        //     AND icl.campaign_id IS NOT NULL AND icl.\"Direction\" IS NOT NULL
        //     GROUP BY icl.\"Direction\";
        // ";
        // $inboundCallData = collect(\DB::select(\DB::raw($inboundCall)))->first();
        // $outgoingCall  = "SELECT cc.status as call_type, count(*) AS call_count FROM campaign_contacts cc
        //     LEFT JOIN campaigns c on c.id = cc.campaign_id
        //     $outgoingDateWhere
        //     $outgoingCallsPerSecond
        //     $outgoingCampaignIdWhere
        //     AND cc.campaign_id IS NOT NULL AND cc.status = 'initiated'
        //     GROUP BY cc.status;
        // ";
        // $outgoingCallData = collect(\DB::select(\DB::raw($outgoingCall)))->first();
        // $start  = new \Carbon\Carbon($start_date);
        // $end    = new \Carbon\Carbon($end_date);
        // $totalDuration = $end->diffInSeconds($start);

        return response()->json(
            [
                'campaignCounters'=>$campaignConterData,
                'totalLists'=>$totalLists,
                'totalContacts'=>$totalContacts,
                // 'billingPrice'=> $billing,
                // 'inboundCall'=> $inboundCallData,
                // 'outgoingCall'=> $outgoingCallData,
                // 'totalDuration'=> $totalDuration,
                // 'testsql'=>$outgoingCall,
            ]
        );

    }

    public function getSendRatesPerDay(Request $request){

        $user = Auth::user();
        $user_id = $user->id;
        $company_id = $user->company_id;
        $role = $user->role;

        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $campaign_id = $request->campaign_id;
        // $list_id = $request->list_id;
        $campaignIdWhere = '';
        if($campaign_id != null){
            $campaignIdWhere = 'and sms_campaign_id='.$campaign_id.'';
       }
       $userIdWhere = '';
       $companyIdWhere = '';
       if($role == "user"){
            $userIdWhere = 'AND user_id ='.$user_id.' AND company_id= '.$company_id.'';
        }

        $campaignContact = "SELECT TRIM(LEADING '0' FROM to_char( updated_at::timestamp , 'HH12pm' )) as hour, to_char( updated_at::timestamp , 'Day') as weekday, count(*) as value
            FROM sms_campaign_contacts
            where updated_at::date BETWEEN '$start_date'::DATE AND '$end_date'::DATE
            AND status = 'initiated'
            $campaignIdWhere
            $userIdWhere
            $companyIdWhere
            GROUP BY hour,weekday
        ";
        $campaignContactPerDay = collect(\DB::select(\DB::raw($campaignContact)))->toArray();
        return response()->json(
            [
                'sendRatesPerDay'=>$campaignContactPerDay,
                // 'testsql'=>$campaignContact,
            ]
        );

    }

    public function getCallbackPieChart()
    {
        return json_decode('{"noOfCallsPerCampaign":[{"campaign_id":84,"name":"Press1 1-24-22","call_backs":1},{"campaign_id":85,"name":"RVM - Shawn 1-24-22","call_backs":14},{"campaign_id":86,"name":"RVM - BBB - 1-25-22","call_backs":29},{"campaign_id":87,"name":"RVM - Houzz - 1-25-22","call_backs":44},{"campaign_id":88,"name":"RVM - Angies - 1-25-22","call_backs":32},{"campaign_id":89,"name":"Press 1 1-25-22","call_backs":1},{"campaign_id":90,"name":"CO4(M1)","call_backs":9},{"campaign_id":91,"name":"CO5(M4)","call_backs":12},{"campaign_id":92,"name":"CO6(F4)","call_backs":10},{"campaign_id":105,"name":"CA13(M1)","call_backs":3},{"campaign_id":106,"name":"CA14(M4)","call_backs":3},{"campaign_id":107,"name":"CA15(F4)","call_backs":2},{"campaign_id":108,"name":"OH1(M1)","call_backs":3},{"campaign_id":109,"name":"OH2(M4)","call_backs":2},{"campaign_id":110,"name":"OH3(F4)","call_backs":4},{"campaign_id":115,"name":"BBB - Bill Supported Part 1","call_backs":2956},{"campaign_id":116,"name":"BBB - Bill Unsupported Part 1","call_backs":3151},{"campaign_id":117,"name":"BBB - Bill Unsupported Part 2","call_backs":2621},{"campaign_id":118,"name":"Yelp - Successful Drop.Co Drops","call_backs":6677},{"campaign_id":120,"name":"TX1(M1)","call_backs":4},{"campaign_id":122,"name":"TX3(F4)","call_backs":14},{"campaign_id":123,"name":"TX2(M4)","call_backs":6},{"campaign_id":135,"name":"31012022","call_backs":2},{"campaign_id":136,"name":"NY1(M1)","call_backs":19},{"campaign_id":137,"name":"NY2(M4)","call_backs":22},{"campaign_id":138,"name":"NY3(F4)","call_backs":15},{"campaign_id":143,"name":"Shawn 11-7-21 9493654020","call_backs":597},{"campaign_id":144,"name":"Press1 1-31-22","call_backs":1629},{"campaign_id":145,"name":"PRESS1TEST","call_backs":150},{"campaign_id":151,"name":"OH P1","call_backs":1993},{"campaign_id":152,"name":"OH4(M1)","call_backs":1126},{"campaign_id":153,"name":"OH5(M4)","call_backs":947},{"campaign_id":154,"name":"OH6(F4)","call_backs":795},{"campaign_id":155,"name":"949","call_backs":50},{"campaign_id":156,"name":"MS Press1","call_backs":364},{"campaign_id":157,"name":"CA Press1","call_backs":244},{"campaign_id":158,"name":"PHIL DATA","call_backs":44},{"campaign_id":159,"name":"PHIL DATA P1","call_backs":37},{"campaign_id":160,"name":"PHIL DATA P1","call_backs":231},{"campaign_id":161,"name":"PHIL DATA","call_backs":284},{"campaign_id":163,"name":"Press1 2-3-22","call_backs":6}],"avgCallDurationPerCampaign":[{"campaign_id":84,"name":"Press1 1-24-22","avg_duration":"6.0000000000000000"},{"campaign_id":85,"name":"RVM - Shawn 1-24-22","avg_duration":"43.2142857142857143"},{"campaign_id":86,"name":"RVM - BBB - 1-25-22","avg_duration":"24.3448275862068966"},{"campaign_id":87,"name":"RVM - Houzz - 1-25-22","avg_duration":"8.7272727272727273"},{"campaign_id":88,"name":"RVM - Angies - 1-25-22","avg_duration":"9.3750000000000000"},{"campaign_id":89,"name":"Press 1 1-25-22","avg_duration":"1.00000000000000000000"},{"campaign_id":90,"name":"CO4(M1)","avg_duration":"4.4444444444444444"},{"campaign_id":91,"name":"CO5(M4)","avg_duration":"55.8333333333333333"},{"campaign_id":92,"name":"CO6(F4)","avg_duration":"10.9000000000000000"},{"campaign_id":105,"name":"CA13(M1)","avg_duration":"5.3333333333333333"},{"campaign_id":106,"name":"CA14(M4)","avg_duration":"12.0000000000000000"},{"campaign_id":107,"name":"CA15(F4)","avg_duration":"16.0000000000000000"},{"campaign_id":108,"name":"OH1(M1)","avg_duration":"9.0000000000000000"},{"campaign_id":109,"name":"OH2(M4)","avg_duration":"274.0000000000000000"},{"campaign_id":110,"name":"OH3(F4)","avg_duration":"5.2500000000000000"},{"campaign_id":115,"name":"BBB - Bill Supported Part 1","avg_duration":"15.9790257104194858"},{"campaign_id":116,"name":"BBB - Bill Unsupported Part 1","avg_duration":"14.5804506505871152"},{"campaign_id":117,"name":"BBB - Bill Unsupported Part 2","avg_duration":"14.7375047691720717"},{"campaign_id":118,"name":"Yelp - Successful Drop.Co Drops","avg_duration":"13.8005092107233788"},{"campaign_id":120,"name":"TX1(M1)","avg_duration":"5.7500000000000000"},{"campaign_id":122,"name":"TX3(F4)","avg_duration":"59.2142857142857143"},{"campaign_id":123,"name":"TX2(M4)","avg_duration":"20.5000000000000000"},{"campaign_id":135,"name":"31012022","avg_duration":"3.5000000000000000"},{"campaign_id":136,"name":"NY1(M1)","avg_duration":"10.0000000000000000"},{"campaign_id":137,"name":"NY2(M4)","avg_duration":"13.7727272727272727"},{"campaign_id":138,"name":"NY3(F4)","avg_duration":"31.4000000000000000"},{"campaign_id":143,"name":"Shawn 11-7-21 9493654020","avg_duration":"11.8542713567839196"},{"campaign_id":144,"name":"Press1 1-31-22","avg_duration":"13.7470841006752609"},{"campaign_id":145,"name":"PRESS1TEST","avg_duration":"15.2866666666666667"},{"campaign_id":151,"name":"OH P1","avg_duration":"22.6823883592574009"},{"campaign_id":152,"name":"OH4(M1)","avg_duration":"19.0550621669626998"},{"campaign_id":153,"name":"OH5(M4)","avg_duration":"24.6620908130939810"},{"campaign_id":154,"name":"OH6(F4)","avg_duration":"27.9937106918238994"},{"campaign_id":155,"name":"949","avg_duration":"20.0200000000000000"},{"campaign_id":156,"name":"MS Press1","avg_duration":"6.6703296703296703"},{"campaign_id":157,"name":"CA Press1","avg_duration":"8.4221311475409836"},{"campaign_id":158,"name":"PHIL DATA","avg_duration":"16.5227272727272727"},{"campaign_id":159,"name":"PHIL DATA P1","avg_duration":"1.00000000000000000000"},{"campaign_id":160,"name":"PHIL DATA P1","avg_duration":"24.5411255411255411"},{"campaign_id":161,"name":"PHIL DATA","avg_duration":"24.0598591549295775"},{"campaign_id":163,"name":"Press1 2-3-22","avg_duration":"10.6666666666666667"}]}');
    }

    public function getCallBackDuration()
    {
        return json_decode('{"callbacks":[{"value":3103,"id":"US-AK"},{"value":15447,"id":"US-AL"},{"value":94,"id":"US-ALBERTA"},{"value":14779,"id":"US-AR"},{"value":19756,"id":"US-AZ"},{"value":844,"id":"US-BRITISH COLUMBIA"},{"value":204578,"id":"US-CA"},{"value":17680,"id":"US-CO"},{"value":4874,"id":"US-CT"},{"value":2582,"id":"US-DC"},{"value":3298,"id":"US-DE"},{"value":55244,"id":"US-FL"},{"value":28865,"id":"US-GA"},{"value":353,"id":"US-HI"},{"value":6537,"id":"US-IA"},{"value":1743,"id":"US-ID"},{"value":23288,"id":"US-IL"},{"value":14129,"id":"US-IN"},{"value":4563,"id":"US-KS"},{"value":4796,"id":"US-KY"},{"value":50718,"id":"US-LA"},{"value":21501,"id":"US-MA"},{"value":165,"id":"US-MANITOBA"},{"value":9349,"id":"US-MD"},{"value":1586,"id":"US-ME"},{"value":15166,"id":"US-MI"},{"value":25220,"id":"US-MN"},{"value":13226,"id":"US-MO"},{"value":61278,"id":"US-MS"},{"value":2035,"id":"US-MT"},{"value":15012,"id":"US-NC"},{"value":4833,"id":"US-ND"},{"value":1873,"id":"US-NE"},{"value":1243,"id":"US-NH"},{"value":9910,"id":"US-NJ"},{"value":4339,"id":"US-NM"},{"value":51,"id":"US-NOVA SCOTIA - PRINCE EDWARD ISLAND"},{"value":5513,"id":"US-NV"},{"value":51010,"id":"US-NY"},{"value":135261,"id":"US-OH"},{"value":3643,"id":"US-OK"},{"value":735,"id":"US-ONTARIO"},{"value":11219,"id":"US-OR"},{"value":33342,"id":"US-PA"},{"value":5631,"id":"US-PUERTO RICO"},{"value":107,"id":"US-QUEBEC"},{"value":4450,"id":"US-RI"},{"value":147,"id":"US-SASKATCHEWAN"},{"value":15748,"id":"US-SC"},{"value":3158,"id":"US-SD"},{"value":17938,"id":"US-TN"},{"value":null,"id":"US-TURKS & CAICOS ISLANDS"},{"value":105883,"id":"US-TX"},{"value":6795,"id":"US-UT"},{"value":23791,"id":"US-VA"},{"value":2868,"id":"US-VT"},{"value":35101,"id":"US-WA"},{"value":10749,"id":"US-WI"},{"value":996,"id":"US-WV"},{"value":766,"id":"US-WY"}]}');
    }

    public function get_callback_heat_map()
    {
        return json_decode('{"callbacks":[{"value":186,"id":"US-AK"},{"value":1476,"id":"US-AL"},{"value":2,"id":"US-ALBERTA"},{"value":714,"id":"US-AR"},{"value":708,"id":"US-AZ"},{"value":5,"id":"US-BRITISH COLUMBIA"},{"value":2553,"id":"US-CA"},{"value":600,"id":"US-CO"},{"value":235,"id":"US-CT"},{"value":82,"id":"US-DC"},{"value":93,"id":"US-DE"},{"value":2105,"id":"US-FL"},{"value":635,"id":"US-GA"},{"value":5,"id":"US-HI"},{"value":68,"id":"US-IA"},{"value":93,"id":"US-ID"},{"value":551,"id":"US-IL"},{"value":349,"id":"US-IN"},{"value":97,"id":"US-KS"},{"value":72,"id":"US-KY"},{"value":90,"id":"US-LA"},{"value":321,"id":"US-MA"},{"value":4,"id":"US-MANITOBA"},{"value":360,"id":"US-MD"},{"value":48,"id":"US-ME"},{"value":292,"id":"US-MI"},{"value":150,"id":"US-MN"},{"value":181,"id":"US-MO"},{"value":425,"id":"US-MS"},{"value":43,"id":"US-MT"},{"value":531,"id":"US-NC"},{"value":21,"id":"US-ND"},{"value":72,"id":"US-NE"},{"value":89,"id":"US-NH"},{"value":474,"id":"US-NJ"},{"value":193,"id":"US-NM"},{"value":1,"id":"US-NOVA SCOTIA - PRINCE EDWARD ISLAND"},{"value":278,"id":"US-NV"},{"value":1118,"id":"US-NY"},{"value":5891,"id":"US-OH"},{"value":105,"id":"US-OK"},{"value":5,"id":"US-ONTARIO"},{"value":246,"id":"US-OR"},{"value":1173,"id":"US-PA"},{"value":8,"id":"US-PUERTO RICO"},{"value":10,"id":"US-QUEBEC"},{"value":214,"id":"US-RI"},{"value":1,"id":"US-SASKATCHEWAN"},{"value":616,"id":"US-SC"},{"value":115,"id":"US-SD"},{"value":1744,"id":"US-TN"},{"value":3779,"id":"US-TX"},{"value":186,"id":"US-UT"},{"value":636,"id":"US-VA"},{"value":12,"id":"US-VT"},{"value":425,"id":"US-WA"},{"value":109,"id":"US-WI"},{"value":48,"id":"US-WV"},{"value":13,"id":"US-WY"}]}');
    }

    public function getCallSentToDestination()
    {
        return json_decode('{"callbacks":[{"value":6486,"id":"US-AK"},{"value":22840,"id":"US-AL"},{"value":1224,"id":"US-ALBERTA"},{"value":11,"id":"US-ANGUILLA"},{"value":18,"id":"US-ANTIGUA\/BARBUDA"},{"value":16532,"id":"US-AR"},{"value":10,"id":"US-AS"},{"value":31572,"id":"US-AZ"},{"value":54,"id":"US-BAHAMAS"},{"value":38,"id":"US-BARBADOS"},{"value":24,"id":"US-BERMUDA"},{"value":15049,"id":"US-BRITISH COLUMBIA"},{"value":7,"id":"US-BRITISH VIRGIN ISLANDS"},{"value":820857,"id":"US-CA"},{"value":94,"id":"US-CAYMAN ISLANDS"},{"value":29,"id":"US-CNMI"},{"value":42106,"id":"US-CO"},{"value":22334,"id":"US-CT"},{"value":8406,"id":"US-DC"},{"value":4919,"id":"US-DE"},{"value":48,"id":"US-DOMINICA"},{"value":163,"id":"US-DOMINICAN REPUBLIC"},{"value":135998,"id":"US-FL"},{"value":56426,"id":"US-GA"},{"value":11,"id":"US-GRENADA"},{"value":43,"id":"US-GU"},{"value":8406,"id":"US-HI"},{"value":16673,"id":"US-IA"},{"value":13242,"id":"US-ID"},{"value":76799,"id":"US-IL"},{"value":34861,"id":"US-IN"},{"value":94,"id":"US-JAMAICA"},{"value":17304,"id":"US-KS"},{"value":25023,"id":"US-KY"},{"value":29714,"id":"US-LA"},{"value":42806,"id":"US-MA"},{"value":242,"id":"US-MANITOBA"},{"value":34087,"id":"US-MD"},{"value":8317,"id":"US-ME"},{"value":47145,"id":"US-MI"},{"value":30409,"id":"US-MN"},{"value":40830,"id":"US-MO"},{"value":230,"id":"US-MONTSERRAT"},{"value":315638,"id":"US-MS"},{"value":2879,"id":"US-MT"},{"value":52094,"id":"US-NC"},{"value":2124,"id":"US-ND"},{"value":8096,"id":"US-NE"},{"value":100,"id":"US-NEW BRUNSWICK"},{"value":66,"id":"US-NEWFOUNDLAND AND LABRADOR"},{"value":7233,"id":"US-NH"},{"value":38595,"id":"US-NJ"},{"value":7816,"id":"US-NM"},{"value":272,"id":"US-NOVA SCOTIA - PRINCE EDWARD ISLAND"},{"value":17835,"id":"US-NV"},{"value":92071,"id":"US-NY"},{"value":907749,"id":"US-OH"},{"value":25128,"id":"US-OK"},{"value":2842,"id":"US-ONTARIO"},{"value":29687,"id":"US-OR"},{"value":54772,"id":"US-PA"},{"value":5081,"id":"US-PUERTO RICO"},{"value":1377,"id":"US-QUEBEC"},{"value":5048,"id":"US-RI"},{"value":185,"id":"US-SASKATCHEWAN"},{"value":20974,"id":"US-SC"},{"value":2465,"id":"US-SD"},{"value":21,"id":"US-SINT MAARTEN"},{"value":38,"id":"US-ST. KITTS & NEVIS"},{"value":161,"id":"US-ST. LUCIA"},{"value":192,"id":"US-ST. VINCENT & GRENADINES"},{"value":34154,"id":"US-TN"},{"value":52,"id":"US-TRINIDAD & TOBAGO"},{"value":10,"id":"US-TURKS & CAICOS ISLANDS"},{"value":162552,"id":"US-TX"},{"value":275,"id":"US-USVI"},{"value":15538,"id":"US-UT"},{"value":41300,"id":"US-VA"},{"value":4087,"id":"US-VT"},{"value":51339,"id":"US-WA"},{"value":26994,"id":"US-WI"},{"value":16957,"id":"US-WV"},{"value":2256,"id":"US-WY"},{"value":18,"id":"US-YUKON-NW TERR. - NUNAVUT"}]}');
    }

    public function getCampaignStats()
    {
        return json_decode('{"campaginStats": [{"name":"CALLZY-VICI","campaign_type":"rvm","sent_count":14536,"fail_count":300,"calls_back_count":395,"avg_calls_duration":"25.8658227848101266","failed_percentage":"2.02","sent_percentage":"97.98"},{"name":"TX6(M4)","campaign_type":"rvm","sent_count":29400,"fail_count":300,"calls_back_count":606,"avg_calls_duration":"18.4636963696369637","failed_percentage":"1.01","sent_percentage":"98.99"},{"name":"TX Press 1","campaign_type":"press-1","sent_count":29511,"fail_count":400,"calls_back_count":361,"avg_calls_duration":"14.4349030470914127","failed_percentage":"1.34","sent_percentage":"98.66"},{"name":"CourtesyCalls","campaign_type":"rvm","sent_count":1285,"fail_count":500,"calls_back_count":65,"avg_calls_duration":"44.0000000000000000","failed_percentage":"28.01","sent_percentage":"71.99"},{"name":"MissingLender","campaign_type":"rvm","sent_count":221,"fail_count":600,"calls_back_count":6,"avg_calls_duration":"17.6666666666666667","failed_percentage":"73.08","sent_percentage":"26.92"},{"name":"Subscription","campaign_type":"rvm","sent_count":82,"fail_count":240,"calls_back_count":5,"avg_calls_duration":"54.8000000000000000","failed_percentage":"74.53","sent_percentage":"25.47"},{"name":"Recerts","campaign_type":"rvm","sent_count":17,"fail_count":440,"calls_back_count":0,"avg_calls_duration":null,"failed_percentage":"96.28","sent_percentage":"3.72"},{"name":"MadeFinal30Days","campaign_type":"rvm","sent_count":1191,"fail_count":340,"calls_back_count":103,"avg_calls_duration":"40.9708737864077670","failed_percentage":"22.21","sent_percentage":"77.79"},{"name":"2ndPayNeverCleared","campaign_type":"rvm","sent_count":568,"fail_count":343,"calls_back_count":17,"avg_calls_duration":"12.5882352941176471","failed_percentage":"37.65","sent_percentage":"62.35"},{"name":"2ndPayNSF40Days","campaign_type":"rvm","sent_count":2405,"fail_count":533,"calls_back_count":90,"avg_calls_duration":"30.6777777777777778","failed_percentage":"18.14","sent_percentage":"81.86"},{"name":"2ndPayNSF7Days","campaign_type":"rvm","sent_count":394,"fail_count":345,"calls_back_count":23,"avg_calls_duration":"47.7826086956521739","failed_percentage":"46.68","sent_percentage":"53.32"},{"name":"1stPayNeverCleared","campaign_type":"rvm","sent_count":4236,"fail_count":765,"calls_back_count":123,"avg_calls_duration":"26.0569105691056911","failed_percentage":"15.30","sent_percentage":"84.70"},{"name":"1stPayNSF40Days","campaign_type":"rvm","sent_count":1319,"fail_count":456,"calls_back_count":78,"avg_calls_duration":"27.0641025641025641","failed_percentage":"25.69","sent_percentage":"74.31"},{"name":"1stPayNSF7Days","campaign_type":"rvm","sent_count":560,"fail_count":600,"calls_back_count":25,"avg_calls_duration":"21.6000000000000000","failed_percentage":"51.72","sent_percentage":"48.28"},{"name":"welcomeCall","campaign_type":"rvm","sent_count":1253,"fail_count":1130,"calls_back_count":70,"avg_calls_duration":"40.3714285714285714","failed_percentage":"47.42","sent_percentage":"52.58"},{"name":"missedcalls","campaign_type":"rvm","sent_count":1805,"fail_count":345,"calls_back_count":799,"avg_calls_duration":"31.2803504380475594","failed_percentage":"16.05","sent_percentage":"83.95"},{"name":"LA4(M4)","campaign_type":"rvm","sent_count":49443,"fail_count":6543,"calls_back_count":1575,"avg_calls_duration":"22.3473015873015873","failed_percentage":"11.69","sent_percentage":"88.31"},{"name":"LA Press 1","campaign_type":"press-1","sent_count":50019,"fail_count":7654,"calls_back_count":804,"avg_calls_duration":"18.0074626865671642","failed_percentage":"13.27","sent_percentage":"86.73"},{"name":"BATCH 1","campaign_type":"press-1","sent_count":646559,"fail_count":200222,"calls_back_count":4605,"avg_calls_duration":"11.7791530944625407","failed_percentage":"23.65","sent_percentage":"76.35"},{"name":"213","campaign_type":"press-1","sent_count":303311,"fail_count":103201,"calls_back_count":6565,"avg_calls_duration":"14.8624523990860625","failed_percentage":"25.39","sent_percentage":"74.61"},{"name":"CourtesyCalls","campaign_type":"rvm","sent_count":1279,"fail_count":200,"calls_back_count":35,"avg_calls_duration":"41.0857142857142857","failed_percentage":"13.52","sent_percentage":"86.48"},{"name":"MissingLender","campaign_type":"rvm","sent_count":222,"fail_count":30,"calls_back_count":6,"avg_calls_duration":"38.1666666666666667","failed_percentage":"11.90","sent_percentage":"88.10"}]}');
    }

    public function getListStats()
    {
        return json_decode('{"listStats":[{"id":775,"name":"Supported BBB","campaign_type":"rvm","sent_count":513276,"calls_back_count":19,"avg_calls_duration":"17.6842105263157895"},{"id":774,"name":"Supported Google","campaign_type":"rvm","sent_count":266493,"calls_back_count":2,"avg_calls_duration":"1.5000000000000000"},{"id":773,"name":"Supported Yelp","campaign_type":"rvm","sent_count":271645,"calls_back_count":8,"avg_calls_duration":"3.7500000000000000"},{"id":701,"name":"Supported Google","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"},{"id":703,"name":"Supported Google","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"},{"id":704,"name":"Supported Google","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"},{"id":710,"name":"Supported Google","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"},{"id":740,"name":"Supported Yahoo","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"},{"id":750,"name":"Supported Google","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"},{"id":760,"name":"Supported Yahoo","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"},{"id":780,"name":"Supported Qwew2","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"},{"id":790,"name":"Supported Yahoo","campaign_type":"rvm","sent_count":287681,"calls_back_count":1,"avg_calls_duration":"1.00000000000000000000"}]}');
    }

    public function getRecordingStats()
    {
        return json_decode('{"recordingStats":[{"id":284,"name":"CALLZY-VICI","recording_name":"CALLZY-VICI","campaign_type":"rvm","sent_count":14536,"calls_back_count":"395","avg_calls_duration":"25.8658227848101266"},{"id":283,"name":"TX6(M4)","recording_name":"CALLZY M4","campaign_type":"rvm","sent_count":29400,"calls_back_count":"606","avg_calls_duration":"18.4636963696369637"},{"id":282,"name":"TX Press 1","recording_name":"IVR RECORDING","campaign_type":"press-1","sent_count":29511,"calls_back_count":"361","avg_calls_duration":"14.4349030470914127"},{"id":281,"name":"CourtesyCalls","recording_name":"Courtesy Calls-17252379718","campaign_type":"rvm","sent_count":1285,"calls_back_count":"65","avg_calls_duration":"44.0000000000000000"},{"id":280,"name":"MissingLender","recording_name":"Missing Lender-17252379715","campaign_type":"rvm","sent_count":221,"calls_back_count":"6","avg_calls_duration":"17.6666666666666667"},{"id":279,"name":"Subscription","recording_name":"Subscription Deals NSF-17256005407","campaign_type":"rvm","sent_count":82,"calls_back_count":"5","avg_calls_duration":"54.8000000000000000"},{"id":278,"name":"Recerts","recording_name":"Recerts Today 3rdPayments-17256005402","campaign_type":"rvm","sent_count":17,"calls_back_count":"0","avg_calls_duration":null},{"id":277,"name":"MadeFinal30Days","recording_name":"Made Final 30 Days- 17257267486","campaign_type":"rvm","sent_count":1191,"calls_back_count":"103","avg_calls_duration":"40.9708737864077670"},{"id":276,"name":"2ndPayNeverCleared","recording_name":"2nd Pay Never Cleared-17256006284","campaign_type":"rvm","sent_count":568,"calls_back_count":"17","avg_calls_duration":"12.5882352941176471"},{"id":275,"name":"2ndPayNSF40Days","recording_name":"2nd Pay NSF 40 Days-17256006278","campaign_type":"rvm","sent_count":2405,"calls_back_count":"90","avg_calls_duration":"30.6777777777777778"},{"id":274,"name":"2ndPayNSF7Days","recording_name":"2nd Pay NSF 7 Days-17256006197","campaign_type":"rvm","sent_count":394,"calls_back_count":"23","avg_calls_duration":"47.7826086956521739"},{"id":273,"name":"1stPayNeverCleared","recording_name":"1st Pay Never Cleared-17256006150","campaign_type":"rvm","sent_count":4236,"calls_back_count":"123","avg_calls_duration":"26.0569105691056911"},{"id":272,"name":"1stPayNSF40Days","recording_name":"1st Pay NSF 40 Days-17256006148","campaign_type":"rvm","sent_count":1319,"calls_back_count":"78","avg_calls_duration":"27.0641025641025641"},{"id":271,"name":"1stPayNSF7Days","recording_name":"1st Pay NSF 7 Days- 17256006125","campaign_type":"rvm","sent_count":560,"calls_back_count":"25","avg_calls_duration":"21.6000000000000000"},{"id":270,"name":"welcomeCall","recording_name":"Welcome Call-7256006117","campaign_type":"rvm","sent_count":1253,"calls_back_count":"70","avg_calls_duration":"40.3714285714285714"},{"id":269,"name":"missedcalls","recording_name":"CALLZY M4","campaign_type":"rvm","sent_count":1805,"calls_back_count":"799","avg_calls_duration":"31.2803504380475594"},{"id":268,"name":"LA4(M4)","recording_name":"CALLZY M4","campaign_type":"rvm","sent_count":49443,"calls_back_count":"1575","avg_calls_duration":"22.3473015873015873"},{"id":267,"name":"LA Press 1","recording_name":"IVR RECORDING","campaign_type":"press-1","sent_count":50019,"calls_back_count":"804","avg_calls_duration":"18.0074626865671642"},{"id":266,"name":"BATCH 1","recording_name":"efrenmw3","campaign_type":"press-1","sent_count":646559,"calls_back_count":"4605","avg_calls_duration":"11.7791530944625407"},{"id":265,"name":"213","recording_name":"efrenmw3","campaign_type":"press-1","sent_count":303311,"calls_back_count":"6565","avg_calls_duration":"14.8624523990860625"},{"id":264,"name":"CourtesyCalls","recording_name":"Courtesy Calls-17252379718","campaign_type":"rvm","sent_count":1279,"calls_back_count":"35","avg_calls_duration":"41.0857142857142857"},{"id":263,"name":"MissingLender","recording_name":"Missing Lender-17252379715","campaign_type":"rvm","sent_count":222,"calls_back_count":"6","avg_calls_duration":"38.1666666666666667"},{"id":262,"name":"Subscription","recording_name":"Subscription Deals NSF-17256005407","campaign_type":"rvm","sent_count":27,"calls_back_count":"1","avg_calls_duration":"37.0000000000000000"},{"id":261,"name":"Recerts","recording_name":"Recerts Today 3rdPayments-17256005402","campaign_type":"rvm","sent_count":15,"calls_back_count":"1","avg_calls_duration":"1.00000000000000000000"},{"id":260,"name":"MadeFinal30Days","recording_name":"Made Final 30 Days- 17257267486","campaign_type":"rvm","sent_count":1266,"calls_back_count":"57","avg_calls_duration":"34.0175438596491228"},{"id":259,"name":"2ndPayNeverCleared","recording_name":"2nd Pay Never Cleared-17256006284","campaign_type":"rvm","sent_count":592,"calls_back_count":"3","avg_calls_duration":"21.6666666666666667"},{"id":258,"name":"2ndPayNSF40Days","recording_name":"2nd Pay NSF 40 Days-17256006278","campaign_type":"rvm","sent_count":2316,"calls_back_count":"51","avg_calls_duration":"36.8235294117647059"},{"id":257,"name":"2ndPayNSF7Days","recording_name":"2nd Pay NSF 7 Days-17256006197","campaign_type":"rvm","sent_count":629,"calls_back_count":"20","avg_calls_duration":"58.7000000000000000"},{"id":256,"name":"1stPayNeverCleared","recording_name":"1st Pay Never Cleared-17256006150","campaign_type":"rvm","sent_count":4058,"calls_back_count":"58","avg_calls_duration":"33.5000000000000000"},{"id":255,"name":"1stPayNSF40Days","recording_name":"1st Pay NSF 40 Days-17256006148","campaign_type":"rvm","sent_count":1200,"calls_back_count":"19","avg_calls_duration":"32.3684210526315789"},{"id":254,"name":"1stPayNSF7Days","recording_name":"1st Pay NSF 7 Days- 17256006125","campaign_type":"rvm","sent_count":592,"calls_back_count":"20","avg_calls_duration":"18.0500000000000000"},{"id":253,"name":"welcomeCall","recording_name":"Welcome Call-7256006117","campaign_type":"rvm","sent_count":1261,"calls_back_count":"30","avg_calls_duration":"25.3000000000000000"},{"id":252,"name":"missedcalls","recording_name":"CALLZY M1","campaign_type":"rvm","sent_count":1928,"calls_back_count":"791","avg_calls_duration":"25.1049304677623262"},{"id":251,"name":"MN1(M1)","recording_name":"CALLZY M1","campaign_type":"rvm","sent_count":26846,"calls_back_count":"690","avg_calls_duration":"18.2115942028985507"},{"id":250,"name":"MN Press 1","recording_name":"IVR RECORDING","campaign_type":"press-1","sent_count":27146,"calls_back_count":"422","avg_calls_duration":"18.3127962085308057"},{"id":249,"name":"CourtesyCalls","recording_name":"Courtesy Calls-17252379718","campaign_type":"rvm","sent_count":1267,"calls_back_count":"32","avg_calls_duration":"41.2812500000000000"},{"id":248,"name":"MissingLender","recording_name":"Missing Lender-17252379715","campaign_type":"rvm","sent_count":221,"calls_back_count":"9","avg_calls_duration":"38.1111111111111111"},{"id":247,"name":"Subscription","recording_name":"Subscription Deals NSF-17256005407","campaign_type":"rvm","sent_count":73,"calls_back_count":"11","avg_calls_duration":"37.0909090909090909"},{"id":246,"name":"Recerts","recording_name":"Recerts Today 3rdPayments-17256005402","campaign_type":"rvm","sent_count":23,"calls_back_count":"3","avg_calls_duration":"1.33333333333333330000"},{"id":245,"name":"MadeFinal30Days","recording_name":"Made Final 30 Days- 17257267486","campaign_type":"rvm","sent_count":1264,"calls_back_count":"87","avg_calls_duration":"47.6206896551724138"},{"id":244,"name":"2ndPayNeverCleared","recording_name":"2nd Pay Never Cleared-17256006284","campaign_type":"rvm","sent_count":601,"calls_back_count":"6","avg_calls_duration":"14.3333333333333333"},{"id":243,"name":"2ndPayNSF40Days","recording_name":"2nd Pay NSF 40 Days-17256006278","campaign_type":"rvm","sent_count":2298,"calls_back_count":"77","avg_calls_duration":"35.4545454545454545"},{"id":242,"name":"2ndPayNSF7Days","recording_name":"2nd Pay NSF 7 Days-17256006197","campaign_type":"rvm","sent_count":628,"calls_back_count":"29","avg_calls_duration":"71.6206896551724138"},{"id":241,"name":"1stPayNeverCleared","recording_name":"1st Pay Never Cleared-17256006150","campaign_type":"rvm","sent_count":3202,"calls_back_count":"47","avg_calls_duration":"16.5744680851063830"},{"id":240,"name":"1stPayNSF40Days","recording_name":"1st Pay NSF 40 Days-17256006148","campaign_type":"rvm","sent_count":1185,"calls_back_count":"30","avg_calls_duration":"56.5666666666666667"}]}');
    }

    public function getCampaignTypeRatio()
    {
        return '{"campaignRatio":[{"total":19,"campaign_type":"press-1"},{"total":115,"campaign_type":"rvm"}]}';
    }


    public function getCampaignSendRates()
    {
        return json_decode('{"campaignSendRates":[],"dateRange":[{"date":"2022-04-10","value":0},{"date":"2022-04-11","value":0},{"date":"2022-04-12","value":0},{"date":"2022-04-13","value":0},{"date":"2022-04-14","value":0},{"date":"2022-04-15","value":0},{"date":"2022-04-16","value":0}]}');
    }

    public function getInboundCallOvertime()
    {
        return json_decode('{"inboundCall":[{"value":61,"date":"2022-04-10"},{"value":4,"date":"2022-04-11"}],"dateRange":[{"date":"2022-04-10","value":0},{"date":"2022-04-11","value":0},{"date":"2022-04-12","value":0},{"date":"2022-04-13","value":0},{"date":"2022-04-14","value":0},{"date":"2022-04-15","value":0},{"date":"2022-04-16","value":0}]}');
    }

    public function getIvrOutboundStats()
    {
        return json_decode('{"ivrOutboundCalls":[{"total":439,"noinput_count":430,"transfered_count":5,"optout_count":4,"campaign_name":"213"},{"total":142,"noinput_count":107,"transfered_count":14,"optout_count":21,"campaign_name":"949"},{"total":10334,"noinput_count":9500,"transfered_count":249,"optout_count":585,"campaign_name":"BATCH 1"},{"total":20561,"noinput_count":20163,"transfered_count":163,"optout_count":235,"campaign_name":"LA Press 1"},{"total":12434,"noinput_count":12217,"transfered_count":86,"optout_count":131,"campaign_name":"MN Press 1"},{"total":12189,"noinput_count":11988,"transfered_count":72,"optout_count":129,"campaign_name":"TX Press 1"}]}');
    }

    public function getOutboundOptinHeatmap()
    {
        return json_decode('{"outboundOptin":[{"id":"US-CA","value":5},{"id":"US-MN","value":3},{"id":"US-IL","value":1},{"id":"US-KS","value":1},{"id":"US-LA","value":49},{"id":"US-TX","value":18},{"id":"US-AL","value":1},{"id":"US-LA","value":111},{"id":"US-NY","value":2},{"id":"US-WA","value":4},{"id":"US-TX","value":38},{"id":"US-GA","value":2},{"id":"US-OK","value":1},{"id":"US-MT","value":3},{"id":"US-CA","value":1},{"id":"US-TX","value":4},{"id":"US-NM","value":1},{"id":"US-MN","value":5},{"id":"US-MN","value":64},{"id":"US-MN","value":7},{"id":"US-CA","value":249},{"id":"US-CA","value":14},{"id":"US-MN","value":5}]}');
    }

    public function getIvrDncHeatmap()
    {
        return json_decode('{"ivrDncOptout":[{"id":"US-CA","value":4},{"id":"US-MN","value":12},{"id":"US-CO","value":1},{"id":"US-WV","value":1},{"id":"US-IN","value":1},{"id":"US-LA","value":61},{"id":"US-TX","value":39},{"id":"US-LA","value":173},{"id":"US-NY","value":2},{"id":"US-FL","value":3},{"id":"US-WA","value":2},{"id":"US-TX","value":61},{"id":"US-GA","value":1},{"id":"US-OK","value":7},{"id":"US-MT","value":3},{"id":"US-TX","value":12},{"id":"US-NM","value":1},{"id":"US-MN","value":4},{"id":"US-MN","value":99},{"id":"US-MN","value":10},{"id":"US-ND","value":1},{"id":"US-CA","value":585},{"id":"US-CA","value":21},{"id":"US-MN","value":1}]}');
    }

    public function getDncHeatmap()
    {
        return json_decode('{"dncHeatmap":[{"id":"US-CA","value":1},{"id":"US-AZ","value":2},{"id":"US-NC","value":6},{"id":"US-IL","value":2},{"id":"US-OH","value":5},{"id":"US-TX","value":4},{"id":"US-TN","value":14},{"id":"US-CA","value":2},{"id":"US-AL","value":22},{"id":"US-OH","value":8},{"id":"US-CA","value":1},{"id":"US-ONTARIO","value":1},{"id":"US-BAHAMAS","value":1},{"id":"US-TX","value":2},{"id":"US-MI","value":25},{"id":"US-MA","value":8},{"id":"US-MN","value":4}]}');
    }

    public function getStateStats()
    {
        return json_decode('stateStats: []');
    }
}
