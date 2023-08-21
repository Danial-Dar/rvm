<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

// ,WithHeadings
class CalleridContactExport implements FromCollection, WithHeadings
{
    protected $list_id;
    protected $company_id;
    protected $by;

    public function __construct($id, $by = 'company'/*company|list|super */)
    {
        $this->by = $by;
        if ($by == 'company') {
            $this->company_id = $id;
        } else {
            $this->list_id = $id;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $contact_list_contacts = Contact::select(
            'number',
            'reputation_score',
            'created_at',
        )->when($this->by == 'company', function ($q) {
            return $q->Where('company_id', $this->company_id);
        })->when($this->by == 'list', function ($q) {
            return $q->Where('contact_list_id', $this->list_id);
        })
        ->where('reputation_checked', true)
        ->orderBy('id', 'desc')
        ->whereType('cir')->get();

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
