<?php

namespace App\Exports;

use App\Models\SmsCampaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SmsCampaignExport implements FromCollection,WithHeadings
{
    protected $id;
    function __construct($id) {
        $this->id = $id;
     }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $export_campaign = SmsCampaign::where('id',$this->id)->get();
    	
    	return $export_campaign;
        // return SmsCampaign::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'campaign_name',
            'campaign_type',
            'forward_to_sms_number',
            'message',
            'allow_long_message',
            'sms_contact_list_id',
            'receive_response',
            'drops_per_hour',
            'user_id',
            'company_id',
            'start_date',
            'status',
            'created_at',
            'updated_at',
        ];
    }
}
