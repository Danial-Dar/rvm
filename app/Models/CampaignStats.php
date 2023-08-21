<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignStats extends Model
{
    use HasFactory;
    protected $table = "campaign_stats";

    protected $fillable = [
        'campaign_id',
        'contact_count',
        'sent_count',
        'initiated_count',
        'success_count',
        'failed_count',
        'optin_count',
        'optout_count',
        'price_sum',
        'last_ran',
        'company_id',
        'user_id',
        'dnc_count',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class,'campaign_id','id');
    }
}
