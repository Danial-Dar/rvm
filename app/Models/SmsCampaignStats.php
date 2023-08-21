<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCampaignStats extends Model
{
    use HasFactory;
    protected $table = "sms_campaign_stats";

    protected $fillable = [
        'sms_campaign_id',
        'contact_count',
        'sent_count',
        'initiated_count',
        'success_count',
        'failed_count',
        'last_ran',
        'company_id',
        'user_id',
        'dnc_count',
    ];

    public function campaign()
    {
        return $this->belongsTo(SmsCampaign::class,'sms_campaign_id','id');
    }
}
