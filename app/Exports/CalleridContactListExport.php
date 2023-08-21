<?php

namespace App\Exports;

use App\Models\ContactList;
use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
// ,WithHeadings
class CalleridContactListExport implements FromCollection ,WithHeadings
{

	protected $company_id;

	 function __construct($company_id) {
	    $this->company_id = $company_id;
	 }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$contact_list_contacts = Contact::select([
            'number',
            'reputation_score',
            'created_at',
        ]);
        if($this->company_id){
            $contact_list_contacts=$contact_list_contacts->Where('company_id', $this->company_id);
        }
        $contact_list_contacts=$contact_list_contacts->where('reputation_checked', true)->orderBy('id', 'desc')->get();
    	return $contact_list_contacts;
    }

    public function headings(): array
    {
        return [
            'Number',
            'Reputation Scope',
            'Date Created',
        ];
    }
}
