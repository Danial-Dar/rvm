<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallFlowStep extends Model
{
    use HasFactory;

    protected $table = "call_flows_steps";

    public function callFlow()
    {
        return $this->belongsTo(CallFlow::class, 'call_flow_id', 'id');
    }
}
