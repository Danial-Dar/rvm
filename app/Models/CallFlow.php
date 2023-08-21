<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallFlow extends Model
{
    use HasFactory;

    protected $table = "call_flows";

    public function numbers()
    {
        return $this->belongsToMany(CallFlowNumber::class, 'call_flows_has_numbers');
    }


}
