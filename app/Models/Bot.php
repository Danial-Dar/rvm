<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    protected $table = "bots";

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    protected $guarded = [];
}
