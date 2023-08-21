<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = "qa_departments";

    public function topic()
    {
        return $this->belongsToMany(Topic::class, 'department_has_topics');
    }
}
