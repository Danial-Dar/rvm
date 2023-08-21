<?php

namespace App\Jobs;

use App\Models\FtcDnc;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use App\Models\InternalAppNumber;
use App\Models\ReputationHistory;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;

class ReputationCheckNumber implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $access_token;
    protected $company_id;
    protected $user_id;
    protected $list_id;
    protected $number_id;
    protected $number;

    public $timeout = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($numberToBeChecked_id, $token = '')
    {
        $this->number_id = $numberToBeChecked_id;
        $this->access_token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        //Log::info('ReputationNumber : Start...........................');
        $this->number = Contact::find($this->number_id);
        if (!$this->number) {
            $this->fail('Contact not Found ');
        }
        if ($this->number->status != 'active') {
            $this->fail('Contact is having status '.$this->number->status);
        }
        $this->company_id = $this->number->company_id;
        $this->user_id = $this->number->user_id;

        if (!$this->access_token) {
            if (!(
                $this->access_token = Cache::remember('robokillerAccessToken', 8460000000, function () {
                    return getRobokillerAccessToken();
                })
            )) {
                $this->fail('Something got Wrong Acesstoken Not Find for robokiller');

                return;
            }
        }

        $number = $this->number;

        //ROBOKILLER 

        $checkrobokiller = config('services.robokiller');
        $checknomorobo = config('services.nomorobo');


        if ( $checkrobokiller=='yes' && $response_robokiller = $this->getRoboKillerResponse($number->raw_number, $this->access_token)) {
            $number->robokiller_status = $response_robokiller['reputation'];
            $number->robokiller_response = json_encode($response_robokiller);
            //Log::info('Robokiller:'.$response_robokiller['reputation'].' : '.$number->robokiller_status);
        } else {
            $number->robokiller_status = 'neutral';
            $number->robokiller_response = null;
            Log::error('Robokiller: Request Error');
        }

        //NOMOROBO
        if ($checknomorobo=='yes' && $response_nomorobo = $this->getNomoRoboResponse($number->raw_number,$this->access_token)) {
            if (
                isset($response_nomorobo['add_ons'])
                && $response_nomorobo['add_ons']['status'] == 'successful'
            ) {
                $number->nomorobo_status = $response_nomorobo['add_ons']['results']['nomorobo_spamscore']['result']['score'] ?? 1;
            //0 means a robocall 1 meanz not
            } else {
                $number->nomorobo_status = 1;
            }
            //Log::info('Nomorobo : '.$number->nomorobo_status);
            $number->nomorobo_response = json_encode($response_nomorobo);
        } else {
            $number->nomorobo_status = 1;
            $number->nomorobo_response = null;
           // Log::error('Nomorobo : '.'Request Error');
        }

        //internal number
        $internal_number = InternalAppNumber::Where('raw_number', $number->raw_number)->first();
        $number->internal_flag = ($internal_number) ? 'Y' : 'N';

        //ftc
        $ftc_number = FtcDnc::Where('raw_number', $number->raw_number)->first();

        $number->ftc_status = ($ftc_number) ? 'Y' : 'N';

        $number->reputation_checked = true;
        $number->reputation_score = calculateCIRScore($number);
        $number->reputation_date = date('Y-m-d H:i:s');
        $number->save();

        $historyData = $number->only([
            'number',
            'raw_number',
            'robokiller_status',
            'number',
            'company_id',
            'user_id',
            'contact_list_id',
            'cir_state',
            'robokiller_response',
            'nomorobo_status',
            'nomorobo_response',
            'ftc_status',
            'ftc_response',
            'internal_flag',
            'reputation_score',
            'created_at',
            'updated_at',
        ]);
        $historyData['contact_id'] = $number->id;
        ReputationHistory::insert($historyData);
        //Log::info('ReputationCheckNumber : Ended ...........................');

        return true;
    }

    private function getRoboKillerResponse($number, $accessToken)
    {
        try {
            $response = Http::withToken($accessToken, 'Bearer')
            ->get('https://enterprise-api.robokiller.com/v1/reputation', ['from' => $number]);
            $json_response_robokiller = $response->json();
            //Log::alert(json_encode($json_response_robokiller));
            if ($response->ok()) {
                return $json_response_robokiller;
            } else {
                throw new Exception(json_encode($json_response_robokiller));
                return false;
            }
        } catch (\Exception $e) {
           // Log::alert('RoboKillerResponce:'.$e->getMessage(), $e->getTrace());
            return false;
        }
    }

    private function getNomoRoboResponse($number,$access_token)
    {
        try {
            $response = Http::withToken($access_token, 'Basic')
            ->get('https://lookups.twilio.com/v1/PhoneNumbers/'.$number.'/', ['AddOns' => 'nomorobo_spamscore']);
            $json_response_nomoRobo = $response->json();
           // Log::alert(json_encode($json_response_nomoRobo));
            if ($response->successful()) {
                return $json_response_nomoRobo;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //Log::alert('NomoRoboResponce:'.$e->getMessage(), $e->getTrace());

            return false;
        }
    }
}
