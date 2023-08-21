<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

// ,WithHeadings
class CalleridContactExportByGivenPayroll implements FromCollection, WithHeadings
{
    protected $contacts;

    public function __construct($contacts)
    {
        // dd($contacts);
      $this->contacts=$contacts->map(function ($value) {
            $data=[
                'number'=>$value->number,
                'company'=>$value->company->name,
                'status'=>$value->status,
                'reputation_score'=>($value->reputation_score)??'Pending',
                // 'created_at'=>$value->created_at
            ];
            return $data;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->contacts;
    }

    public function headings(): array
    {
        return [
            'Number',
            'Company',
            'Status',
            'Reputation Scope',
            // 'Date Created',
        ];
    }
}
