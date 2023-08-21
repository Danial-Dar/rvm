<?php

namespace App\Models;

use App\Models\ContactList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';


    /*public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }*/

    /*public function contactList()
    {
        return $this->belongsTo(ContactList::class);
    }*/

    // public function reputation()
    // {
    //     return $this->belongsTo(NumberReputation::class, 'contact_id', 'id');
    // }
}
