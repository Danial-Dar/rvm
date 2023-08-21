<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\CompanyLogs;
use App\Models\CompanySettings;
use App\Models\DNCTime;
use App\Models\NovaSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function created(Company $company)
    {
        $sw_auth_token = config('app.sw_auth_token');
        $sw_project_id = config('app.sw_project_id');
        $settings  = NovaSetting::first();
        // {"dailyLimitApiKey":22,"dailyLimitPassword":"abcabc","dailyLimit":22,"rvmCallPrice":22,"botCallPrice":22,"press1CallPrice":22,"numberPrice":22,"perMinPrice":22}
        if($settings !== null){
            $settings = json_decode($settings->fields, 1);
            foreach($settings as $key => $setting){
                // Log::error('------hellll----');
                // Log::error($setting);
                $companySetting = CompanySettings::updateOrCreate(
                    ['company_id' => $company->id, 'key' => $key]
                );
                $companySetting->key = $key;
                $companySetting->key_label = $key;
                $companySetting->value = $setting;
                $companySetting->company_id = $company->id;
                $companySetting->save();
            }
        }

        if (Auth::check()) {
            $daysArray = ['Monday','Tuesday','Wednesday','Thursday','Friday'];

            $d1 = strtotime("09:00am");
            $d2 = strtotime("05:00pm");
            $from_time = date("h:i:sa", $d1 );
            $to_time = date("h:i:sa", $d2 );
            foreach($daysArray as $key => $value){
                $dnc = new DNCTime();
                $dnc->user_id = auth()->user()->id;
                $dnc->company_id = $company->id;
                $dnc->user_type = auth()->user()->role;
                $dnc->day = $value;
                $dnc->from_time = $from_time;
                $dnc->to_time = $to_time;
                $dnc->save();
            }
        }



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vultik.signalwire.com/api/relay/rest/registry/beta/brands',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "name": "'.$company->name.'",
                "company_name": "'.$company->name.'",
                "contact_email": "'.$company->email.'",
                "contact_phone": "'.formatNumber($company->phone_number).'",
                "ein_issuing_country": "United States",
                "legal_entity_type": "NON_PROFIT",
                "ein": "14-1414141",
                "company_address": "'.$company->address.'",
                "company_vertical": "HEALTHCARE",
                "company_website": "www.example.com",
                "csp_brand_reference": null,
                "csp_self_registered": false
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                // 'Authorization: Basic Mjk5ZTI1YzEtNjIyYy00ZjJiLTkxZjItNDRlN2ZmZDQ5YzlmOlBUMGVhNDQxNzc2YmY3YTY4NjY3YmU1MzEzODdiMzM1YjIwOTJhNzBlZjI3N2Q0ZjRl'
                'Authorization: Basic '. base64_encode($sw_project_id.":".$sw_auth_token)
            ),
        ));


        $response = curl_exec($curl);

        curl_close($curl);

        $request_data = '{
            "name": "'.$company->name.'",
            "company_name": "'.$company->name.'",
            "contact_email": "'.$company->email.'",
            "contact_phone": "'.formatNumber($company->phone_number).'",
            "ein_issuing_country": "United States",
            "legal_entity_type": "NON_PROFIT",
            "ein": "14-1414141",
            "company_address": "'.$company->address.'",
            "company_vertical": "HEALTHCARE",
            "company_website": "www.example.com",
            "csp_brand_reference": null,
            "csp_self_registered": false
        }';

        $company_logs = new CompanyLogs;
        $company_logs->company_id = $company->id;
        $company_logs->request_data = $request_data;
        $company_logs->response_data = $response;
        $company_logs->save();

        if ($response != "Unauthorized") {
            $json_response = json_decode($response);
            if (property_exists($json_response, 'errors')) {
                // dd("inside second if");
                $company->sw_brand_id = "";

                $company->save();
            }
            else {
                // dd("inside if else");
                $company->sw_brand_id = $json_response->id;

                $company->save();
            }
        }

    }

    /**
     * Handle the Company "updated" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function updated(Company $company)
    {
        //
    }

    /**
     * Handle the Company "deleted" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function deleted(Company $company)
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function restored(Company $company)
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     *
     * @param  \App\Models\Company  $company
     * @return void
     */
    public function forceDeleted(Company $company)
    {
        //
    }
}
