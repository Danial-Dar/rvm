<?php

namespace App\Exports;

use App\Models\ContactList;
use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// ,WithHeadings
class ContactListExport implements FromCollection
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
    	$contact_list_contacts = Contact::select('number')->where('contact_list_id',$this->id)->get();

    	return $contact_list_contacts;
    }
    public function headings(): array
     {
         return [
             // 'id',
             'number',
             // 'contact_list_id',
             // 'created_at',
             // 'updated_at',
             // 'status',
         ];
     }
}
