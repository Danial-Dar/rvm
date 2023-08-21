<?php

namespace App\Models;

use App\Models\ContactList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';
    protected $fillable = [
         'email',
         'phone_number',
        'contact_list_id',
        'created_at',
        'updated_at',
        'status',
        'user_id',
        'company_id',
        'company_name',
        'first_name',
        'last_name',
        'address',
        'address2',
        'city',
        'state',
        'country',
        'zip',
        'description',
        'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getAddressAttribute($value){

       // echo "<pre>";print_r($value);exit;
       // $value->address = $value;
       // return $this->To = $value->address

        return $value;
    }

    /*public function contactList()
    {
        return $this->belongsTo(ContactList::class);
    }*/

    // public function reputation()
    // {
    //     return $this->belongsTo(NumberReputation::class, 'contact_id', 'id');
    // }
}
