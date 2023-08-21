<?php

namespace App\Exports;

use App\Models\IvrIncomingCallLog;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class IvrIncomingCallLogsExport implements FromCollection
{
    protected $id;

	 function __construct($id, $offset, $limit) {
	    $this->id = $id;
	    $this->offset = $offset;
	    $this->limit = $limit;
	 }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('ivr_incoming_call_logs')
        ->join('campaign_contacts', 'campaign_contacts.id', '=', 'ivr_incoming_call_logs.campaign_contact_id')
        ->where('campaign_contacts.campaign_id', '=', $this->id)
        ->select('ivr_incoming_call_logs.created_at', 'ivr_incoming_call_logs.from_number', 'ivr_incoming_call_logs.to_number' ,'ivr_incoming_call_logs.disposition')
        ->offset($this->offset)->limit($this->limit)->get();
    }
}
