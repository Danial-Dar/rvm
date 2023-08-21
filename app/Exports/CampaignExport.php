<?php

namespace App\Exports;

use App\Models\Campaign;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CampaignExport implements FromCollection,WithHeadings
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
        // return Campaign::all();
        $export_campaign = Campaign::where('id',$this->id)->get();
    	
    	return $export_campaign;
        
    }
    public function headings(): array
    {
        return [
            'id',
            'name',
            'caller_id',
            'recording_id',
            'Contact_list',
            'user_id',
            'Start_date',
            'status',
            'deleted_at',
            'created_at',
            'updated_at',
            'alpha_number',
        ];
    }
}
