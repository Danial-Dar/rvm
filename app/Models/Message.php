<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "messages";

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
