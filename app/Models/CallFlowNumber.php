<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CallFlowNumber extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "call_flow_numbers";

    protected $fillable = [
        'friendly_name',
        'phone_number',
        'area_code',
        'resource_id',
        'rate_center',
        'region',
        'iso_country',
        'capabilities',
        'created_at',
        'updated_at',
    ];
}
