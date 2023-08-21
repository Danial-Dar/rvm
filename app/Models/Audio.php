<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = "qa_audio";
    protected $fillable = ['agent_id','topic_id','filename','status','job','length','user_id'];
    
    public function topic()
    {
        return $this->belongsTo(Topic::class,'topic_id','id');
    }

    public function scorecard()
    {
        return $this->belongsTo(Scorecard::class,'scorecard_id','id');
    }
    
    public function agent()
    {
        return $this->belongsTo(Agent::class,'agent_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    
    public function note()
    {
        return $this->belongsToMany(Note::class, 'call_has_notes');
    }
    
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m/d/Y');
    }
}
