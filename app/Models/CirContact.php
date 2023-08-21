<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CirContact extends Model
{
    use HasFactory;

    protected $table = 'contacts';
    protected $fillable = [
         'number',
        'contact_list_id',
        'created_at',
        'updated_at',
        'status',
        'raw_number',
        'user_id',
        'company_id',
        'company_name',
        'first_name',
        'last_name',
        'address',
        'address2',
        'city',
        'state',
        'zip',
        'additional1',
        'additional2',
        'additional3',
        'robokiller_status',
        'robokiller_response',
        'nomorobo_status',
        'nomorobo_response',
        'ftc_status',
        'ftc_response',
        'internal_flag',
        'reputation_score',
        'reputation_checked',
        'is_repute_billed',
        'reputation_date',
        'type',
        'cir_state',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contactList()
    {
        return $this->belongsTo(ContactList::class);
    }

    // public function reputation()
    // {
    //     return $this->belongsTo(NumberReputation::class, 'contact_id', 'id');
    // }
}
