<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCampaignContact extends Model
{
    use HasFactory;
    protected $table = "sms_campaign_contacts";

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
    public function sms_campaign()
    {
        return $this->belongsTo(SmsCampaign::class,'sms_campaign_id','id');
    }
}
