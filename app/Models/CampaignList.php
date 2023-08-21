<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignList extends Model
{
    use HasFactory;

    protected $table = 'campaign_lists';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
    public function campaign()
    {
        return $this->belongsTo(Campaign::class,'campaign_id','id');

    }
}
