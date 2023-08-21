<?php

namespace App\Jobs;

use App\Models\ContactList;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CirContactListDispatcher implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    protected $list;
    protected $meta;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ContactList $contactList, $meta)
    {
        $this->list = $contactList;
        $this->meta = $meta;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $chainArray = [];
        $i = 0;
        while ($this->meta->chunk_total > $i) {
            $contacts_chunk = Cache::pull($this->meta->unique.'.'.$i++);
            array_push($chainArray, new UploadCirNumbersFromlistInput(
                $this->list->id,
                $contacts_chunk ?? []
            ));
        }
        array_push($chainArray, new ReputationCheckContactList(
            $this->list->id,
        ));

        Bus::chain($chainArray)->dispatch();
    }
}
