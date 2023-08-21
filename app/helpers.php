<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Aws\S3\S3Client;
use App\Http\Helpers\Aws;

if (!function_exists('ConnectAWS3')) {
    function ConnectAWS3()
    {
        $SPACES_KEY = 'UZ6NP5UFPUOZ7YXEFWMI';
        $SPACES_SECRET = 'pNQcb/oLy+YmfiBUgYEFkP2E88Scr6yv2UnFqkw/94k';
        try {
            return $client = new Aws\S3\S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'endpoint' => 'https://nyc3.digitaloceanspaces.com',
            'credentials' => [
                'key' => $SPACES_KEY,
                'secret' => $SPACES_SECRET,
            ],
        ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
if (!function_exists('getRobokillerAccessToken')) {
    function getRobokillerAccessToken()
    {
        $params['username'] = Setting::getValue('robokiller_username');
        $params['password'] = Setting::getValue('robokiller_password');
        $response = null;
        try {
            $response = Http::retry(3, 100)->post('https://enterprise-api.robokiller.com/v1/account/login', $params);
        } catch (\Exception $e) {
            Log::alert('Robokiller connection:'.$e->getMessage(), $e->getTrace());
            // return $e instanceof ConnectionException;
        }
        if ($response != null) {
            $responseJson = $response->json();
            if ($response->ok() && isset($responseJson['access_token'])) {
                return $responseJson['access_token'];
            } else {
                return false;
            }
        }
        else{
            return false;
        }
    }
}

if (!function_exists('validateNumber')) {
    function validateNumber($value)
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        try {
            $number = $phoneUtil->parse($value, 'US');
            $isValid = $phoneUtil->isValidNumber($number);

            return $isValid;
        } catch (\libphonenumber\NumberParseException $e) {
            // dd($e);
            return false;
        }
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($value)
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

        try {
            $number = $phoneUtil->parse($value, 'US');
            // $isValid = $phoneUtil->isValidNumber($number);
            $formatNumber = $phoneUtil->format($number, \libphonenumber\PhoneNumberFormat::E164);

            return $formatNumber;
        } catch (\libphonenumber\NumberParseException $e) {
            // dd($e);
            return false;
        }
    }
}

if (!function_exists('call48Login')) {
    function call48Login()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => 'https://apicontrol.call48.com/api/v4/admin_login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'user_name=callzy-stg&password=lavjU3NEK1W83',
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
        ],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            Log::alert('call48Login:'.$error_msg);
        }

        curl_close($curl);
        // echo $response;
        return $response;
    }
}
if (!function_exists('maskUsNumber')) {
    function maskUsNumber($value)
    {
        if (preg_match('/^\+\d(\d{3})(\d{3})(\d{4})$/', $value, $matches)) {
            $result = $matches[1].'-'.$matches[2].'-'.$matches[3];

            return $result;
        } else {
            Log::error('Invalid PhoneNumber Given');

            return '';
        }
    }
}

if (!function_exists('getStateCodeNumber')) {
    function getStateCodeNumber($formatedNumber)
    {
        if (preg_match('/^\+\d(\d{3})/', $formatedNumber, $matches)) {
            $result = $matches[1];
            // Log::alert("getStateCodeNumber result:".$result);
            return $result;
        } else {
            Log::error('Invalid PhoneNumber Given to getCountryCodeNumber');

            return '';
        }
    }
}

if (!function_exists('calculateCIRScore')) {
    function calculateCIRScore($number)
    {
        $score = 0;
        $checks = 2;

        $checkrobokiller = config('services.robokiller');
        $checknomorobo   = config('services.nomorobo');
        if($checkrobokiller=='yes' && $checknomorobo=='yes'){

          $checks = 4;

            if ($number->robokiller_status == 'negative') {
                --$checks;
            }
            if ($number->nomorobo_status == 1) {
                --$checks;
            }

        }
        

        

        // Instead of Showing Nomorobo etc.
        // It should show a score out of 1 and the way that would be calculated is

        // if it’s not flagged on anything is 100%
        // CLEAN if it’s reported on say 1/5  -> 0
        // it’s 80% Clean if it’s reported on 2/5 -> 20
        // it’s 60% Clean and

        // inStatus //0 means a robocall 1 meanz not

        
        if ($number->internal_flag == 'Y') {
            --$checks;
        }
        if ($number->ftc_status == 'Y') {
            --$checks;
        }

         $score =
           // (($checks == 4) ? 100
             //   : (($checks == 3) ? 75
                     (($checks == 2) ? 50
                        : (($checks == 1) ? 25 : 0));

         if($checkrobokiller=='yes' && $checknomorobo=='yes'){

            $score =
           (($checks == 4) ? 100
                : (($checks == 3) ? 75
                     : (($checks == 2) ? 50
                        : (($checks == 1) ? 25 : 0))));
         }

       

        // if they click on the color it’ll show them like Nomorobo – Flagged, FTC – Flagged, Internal Testing – Flagged Etc.
        return $score;
    }
}

if (!function_exists('connectAwsS3')) {
    function connectAwsS3()
    {
        $SPACES_KEY = 'LXN3CWYQSMF7BNLWMOL4';
        $SPACES_SECRET = 'EQgbUayx5GvwNRRRbwYLH6p1KFjXLuBuWcqKv4DjYe4';

        try {
            return $client = new S3Client([
                'version' => 'latest',
                'region' => 'nyc3',
                'endpoint' => 'https://rvm.nyc3.digitaloceanspaces.com',
                'credentials' => [
                    'key' => $SPACES_KEY,
                    'secret' => $SPACES_SECRET,
                ],
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
