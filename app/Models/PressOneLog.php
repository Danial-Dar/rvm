<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PressOneLog extends Model
{
    use HasFactory;

    protected $table = "press_one_logs";
    protected $fillable = [
        'campaign_contact_id',
        'number',
        'raw_number',
        'keypress',
        'is_opt_in',
        'request_data',
        'response_data',
    ];
}
