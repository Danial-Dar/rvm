<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReputationHistory extends Model
{
    use HasFactory;
    protected $table = 'reputation_histories';

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
