<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    use HasFactory;

    protected $table = "qa_phrase";
    
    protected $fillable = ["title","user_id","scorecard_id", "flag_type", "min_count","speaker","first_x","last_x", "time"];

    public function scorecard()
    {
        return $this->belongsTo(Scorecard::class,'scorecard_id','id');
    }

    // public function component()
    // {
    //     return $this->belongsToMany(Component::class, 'phrase_has_components');
    // }
    
}
