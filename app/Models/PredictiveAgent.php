<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PredictiveAgent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'agents';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class,'current_campaign','id');
    }
}
