<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\ContactList;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReputationCheckContactList implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $access_token;
    protected $company_id;
    protected $user_id;
    protected $list_id;
    protected $list;
    public $timeout = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($list_id)
    {
        $this->list_id = $list_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('ReputationCheckContactList : Start...........................');
        $this->list = ContactList::find($this->list_id);
        if ($this->list->status != 'active') {
            Log::info('Inside status check');
            $this->fail('This ContactList is having status '.$this->list->status);
        }
        $this->user_id = $this->list->user_id;
        $this->company_id = $this->list->company_id;

        $this->list->reputation_check_status = 'inprocess';
        $this->list->save();

        Log::info('After saving inprocess');

        $numbers = Contact::where([
            'contact_list_id' => $this->list_id,
            'reputation_checked' => false,
        ])->get();

        foreach ($numbers as $number) {
            if (!$this->alreadyCheckedTill($number, Carbon::now()->toDateString())) {
                dispatch(new ReputationCheckNumber(
                    $number->id,
                    $this->access_token
                ));
            }
        }
        $list_id = $this->list_id;
        dispatch(function () use ($list_id) {
            $list = ContactList::find($list_id);
            if (Contact::where([
                'contact_list_id' => $list_id,
                'reputation_checked' => false,
            ])->count() == 0) {
                $list->reputation_check_status = 'complete';
            } else {
                $list->reputation_check_status = 'failed';
            }
            $list->save();
        });
        Log::info('ReputationCheckContactList : Ended ...........................');
    }

    private function alreadyCheckedTill(&$number, $date)
    {
        $Checkednumber = Contact::where([/* From Today's Checked */
            'reputation_checked' => true,
            'number' => $number->number,
        ])->whereDate('reputation_date', '<=', $date)->first();

        if ($Checkednumber) {
            Log::debug('Already checked Number '.$number->number);

            $number->robokiller_status   = $Checkednumber->robokiller_status;
            $number->robokiller_response = $Checkednumber->robokiller_response;
            $number->nomorobo_status     = $Checkednumber->nomorobo_status;
            $number->nomorobo_response   = $Checkednumber->nomorobo_response;
            $number->internal_flag       = $Checkednumber->internal_flag;
            $number->ftc_status          = $Checkednumber->ftc_status;

            $number->reputation_checked = true;
            $number->reputation_date = date('Y-m-d H:i:s');
            $number->reputation_score = $Checkednumber->reputation_score;
            $number->save();

            return true;
        }

        return false;
    }
}
