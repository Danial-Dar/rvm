<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ContactList;
use App\Models\Contact;
use App\Models\CampaignContact;
use App\Models\CampaignList;
use App\Models\Campaign;
use App\Models\MyGroup;
use App\Models\MyGroupNumber;
use App\Models\CampaignCallerId;
use App\Models\MyNumber;

class CampaignUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;
    // protected $caller_id;
    // protected $caller_id_individual;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    // ,$caller_id,$caller_id_individual
    public function __construct($campaign)
    {
        $this->campaign = $campaign;
        // $this->caller_id = $caller_id;
        // $this->caller_id_individual = $caller_id_individual;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign = $this->campaign;
        // $caller_id =  $this->caller_id;
        // $caller_id_individual =  $this->caller_id_individual;
        $user_id = $campaign->user_id;
        $company_id = $campaign->company_id;

        // -------------- add caller ids -------------------
        // $caller_ids = [];
        // if(isset($caller_id)){
        //     $caller_ids  = array_filter($caller_id, fn($value) => !is_null($value) && $value !== '');
        //     if(count($caller_ids) > 0){
        //         foreach ($caller_ids as $id) {

        //             $callerExplode = explode('_',$id);
                    
        //             $numberType  = "client_numbers";
        //             if($callerExplode[1] == 'callzy')
        //             {
        //                 $numberType  ="callzy_numbers";
        //             }elseif($callerExplode[1] == 'client'){
        //                 $numberType  ="client_numbers";
        //             }

        //             $campaignCallerId = new CampaignCallerId;
        //             $campaignCallerId->user_id = $user_id;
        //             $campaignCallerId->campaign_id = $campaign->id;
        //             $campaignCallerId->my_number_id = $callerExplode[0];
        //             $campaignCallerId->company_id = $company_id;
        //             $campaignCallerId->type = 'caller';
        //             $campaignCallerId->is_group = 0;
        //             $campaignCallerId->group_id = null;
        //             $campaignCallerId->caller_number_type= $numberType;
        //             $campaignCallerId->alpha_number_type= null;
        //             $campaignCallerId->save();
        //         }//foreach loop end
        //     }//count callerids end
        // }//isset callerids end

        // if(isset($caller_id_individual))
        // {
        //     $number = new MyNumber;
        //     $number->user_id = $user_id;
        //     $number->number = $caller_id_individual;
        //     $number->raw_number = preg_replace('/[^0-9]/', '', $caller_id_individual);
        //     $number->status = 'active';
        //     $number->type = 'individual';
        //     $number->company_id = $company_id;
        //     $number->save();
            
        //     $campaignCallerId = new CampaignCallerId;
        //     $campaignCallerId->user_id =$user_id;
        //     $campaignCallerId->campaign_id = $campaign->id;
        //     $campaignCallerId->my_number_id = $number->id;
        //     $campaignCallerId->company_id = $company_id;
        //     $campaignCallerId->type = 'caller';
        //     $campaignCallerId->is_group = 0;
        //     $campaignCallerId->group_id = null;
        //     $campaignCallerId->caller_number_type= 'individual';
        //     $campaignCallerId->alpha_number_type= null;
        //     $campaignCallerId->save();
        // }//isset individual end


        // unset($caller_id);
        $campaignUpdate = Campaign::find($campaign->id);
        $campaignUpdate->status = "played";
        $campaignUpdate->save();

    }//handle function end
}
