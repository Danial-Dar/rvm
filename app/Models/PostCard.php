<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCard extends Model
{
    use HasFactory;

     protected $table = 'post_cards';
    protected $fillable = [
         'use_type',
         'description',
        'size',
        'created_at',
        'updated_at',
        'status',
        'user_id',
        'company_id',
        'to',
        'from',
        'front',
        'back',
    ];



   /* public function To()
    {
        return $this->belongsTo(Address::class, 'to', 'id');
    }

    public function from()
    {
        return $this->belongsTo(Address::class, 'from', 'id');
    }*/

    public function Tooo()
    {
        return $this->belongsTo(Address::class, 'to', 'id');
    }

    public function Fromd()
    {
        return $this->belongsTo(Address::class, 'from', 'id');
    }
}
