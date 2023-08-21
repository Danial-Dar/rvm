<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $table = "qa_components";

    // public function phrase()
    // {
    //     return $this->belongsTo(Topic::class,'phrase_id','id');
    // }

}
