<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $table = "qa_topics";

    protected $fillable = ["title","status","department_id"];

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
}
