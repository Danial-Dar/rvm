<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateSpecifcStats extends Model
{
    use HasFactory;

    protected $table = 'state_specific_stats';

    protected $appends = ['average_call_back_percentage'];


    public function getAverageCallBackPercentageAttribute() {
        if($this->campaign_contact_count > 0) {
            return ( number_format((((float)$this->incoming_call_log_count + (float)$this->ivr_call_log_count) / $this->campaign_contact_count ) * 100, 2) . '%');
        }

        return '0%';
    }
}
