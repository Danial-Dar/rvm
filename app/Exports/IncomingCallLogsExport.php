<?php

namespace App\Exports;

use App\Models\IncomingCallLog;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class IncomingCallLogsExport implements FromCollection
{
    protected $id;
    protected $val;

	 function __construct($id, $val, $offset, $limit) {
	    $this->id = $id;
	    $this->val = $val;
        $this->offset = $offset;
	    $this->limit = $limit;
     }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->val == 'call_back') {
            return DB::table('incoming_call_logs')->where('campaign_id', '=', $this->id)->select('created_at', 'From', 'To', 'duration')->get();
        }else {
            return DB::table('incoming_call_logs')
                ->join('campaign_contacts', 'incoming_call_logs.campaign_contact_id', '=', 'campaign_contacts.id')
                ->where('incoming_call_logs.campaign_id', $this->id)
                ->selectRaw("incoming_call_logs.created_at, incoming_call_logs.\"To\", incoming_call_logs.\"From\", TO_CHAR((incoming_call_logs.duration || 'second')::interval, 'HH24:MI:SS') as my_duration, campaign_contacts.alpha_number, campaign_contacts.caller_id_number")
                ->get();
            // return DB::table('incoming_call_logs')->where('campaign_id', '=', $this->id)->get();
        }
    }
}
