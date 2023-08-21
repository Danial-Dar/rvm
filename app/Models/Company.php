<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    public function company_settings()
    {
        return $this->hasOne(CompanySettings::class,'company_id','id');
    }

    public function reputation_histories()
    {
        return $this->hasMany(ReputationHistory::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function getSentAttribute()
    {
        $sent = CampaignStats::Where('company_id', $this->id)->sum('sent_count');
        return $sent;
    }

    public function getPendingAttribute()
    {
        $total = CampaignStats::Where('company_id', $this->id)->sum('contact_count');
        $sent = CampaignStats::Where('company_id', $this->id)->sum('sent_count');
        $dnc = CampaignStats::Where('company_id', $this->id)->sum('dnc_count');
        if ($total > 0) {
            $pending = (($sent - $dnc) / $total) * 100;
            return number_format((float)$pending, 2, '.', '').' %';
        }
        return 0;
    }

    public function getDncAttribute()
    {
        $dnc = CampaignStats::Where('company_id', $this->id)->sum('dnc_count');
        
        return $dnc;
    }

    public function getCustomStatusAttribute()
    {
        if ($this->status == 1) {
            return 'Active';
        }else {
            return 'InActive';
        }
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
    }

    public function setDocumentAttribute($value)
    {
        if($value != null)
            $this->attributes['document'] = json_encode( explode( ',', $value ) );
    }

    public function setBalanceAttribute($value){

    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getUserCountAttribute()
    {
        return $this->users->count();
    }
}
