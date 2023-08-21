<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;
    protected $table = "qa_agents";

    public function campaign()
    {
        return $this->belongsTo(Campaign::class,'campaign_id','id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class,'group_id','id');
    }
    public function topic()
    {
        return $this->belongsTo(Topic::class,'topic_id','id');
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }
}
