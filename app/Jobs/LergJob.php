<?php

namespace App\Jobs;

use App\Models\Contact;
use App\Models\ContactUs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LergJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $lergs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lergs)
    {
        $this->lergs = $lergs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $l = $this->lergs;
        Contact::chunk(500, function ($contacts) use ($l){
            foreach ($contacts as $contact) {
                $len = strlen($contact->raw_number);
                // dd($l);
                if ($len == 12) {
                    $npa = substr($contact->raw_number, 1, 3);
                    $nxx = substr($contact->raw_number, 4, 3);
                    // dd($nxx);
                }
                else if ($len == 11) {
                    $npa = substr($contact->raw_number, 0, 3);
                    $nxx = substr($contact->raw_number, 3, 3);
                    // dd();
                }
                if ($npa == $l->NPA && $nxx == $l->NXX) {
                    $contact->lerg_rate_center = $l->Ratecenter;
                    $contact->lerg_state = $l->State;
                    $contact->lerg_category = $l->category;
                    $contact->lerg_company_name = $l->Company_Name;
                    $contact->save();
                }
            }

        });
        // Log::info($this->lergs);
    }
}
