<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DNC extends Model
{
    use HasFactory;

    protected $table = "dnc";

    protected $fillable = [
        'number',
        'user_id',
        'user_type',
        'raw_number',
        'company_id'
    ];

    protected static function booted()
    {
        static::creating(function ($setting) {
        if(Auth::check()) {
            $setting->user_id = Auth::id();
        }
        });
    }
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
