<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $table = "balances";

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y');
    }

    public function getAmountAttribute($value)
    {
        return '$'.number_format($value, 2);
    }
}
