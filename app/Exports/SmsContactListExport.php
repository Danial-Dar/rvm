<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\SmsContactList;
use App\Models\SmsContact;
class SmsContactListExport implements FromCollection,WithHeadings
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
        // return SmsContact::all();
        $contact_list_contacts = SmsContact::select('number','raw_number','status','created_at','updated_at')->where('sms_contact_list_id',$this->id)->get();

    	return $contact_list_contacts;
    }

    public function headings(): array
    {
        return [
            'number',
            'raw_number',
            'status',
            'created_at',
            'updated_at',
        ];
    }
}
