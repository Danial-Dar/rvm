<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsCampaign extends Model
{
    use HasFactory
    // ,SoftDeletes
    ;

    protected $table = 'sms_campaigns';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function SmsCampaignContacts()
    {
        return $this->hasMany(SmsCampaignContact::class, 'sms_campaign_id', 'id');
    }

    public function campaignStats()
    {
        return $this->hasOne(SmsCampaignStats::class, 'sms_campaign_id', 'id');
    }

    public function last_ran()
    {
        return $this->hasOne(SmsCampaignContact::class, 'sms_campaign_id', 'id')->WhereNotIn('status', ['pending', 'deleted'])->orderBy('updated_at', 'desc');
    }
}
