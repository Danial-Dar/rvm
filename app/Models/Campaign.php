<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use React\Dns\Model\Record;

class Campaign extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'campaigns';
    protected $with = ["recording","recordingOptout","recordingOptin","recordingOutput"];

    protected $casts = [
        'start_date' => 'date:Y-m-d h:i:s a',
        'contact_list_id' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($setting) {
            $setting->user_id = Auth::user()->id;
            $setting->company_id = Auth::user()->company_id;
            $setting->status = 'preprocessing';
        });
    }

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function recording()
    {
        return $this->belongsTo(Recording::class, 'recording_id', 'id');
    }

    public function Voicemail()
    {
        return $this->belongsTo(Recording::class, 'voicemail_id');
    }

    public function voiceMailRecording()
    {
        return $this->belongsTo(Recording::class, 'voice_mail_recording_id');
    }

    public function recordingOptout()
    {
        return $this->belongsTo(Recording::class, 'optout_recording_id', 'id');
    }

    public function recordingOptin()
    {
        return $this->belongsTo(Recording::class, 'recording_optin_id', 'id');
    }

    public function recordingOutput()
    {
        return $this->belongsTo(Recording::class, 'recording_output_id', 'id');
    }

    public function campaignStats()
    {
        return $this->hasOne(CampaignStats::class, 'campaign_id', 'id');
    }

    public function campaignContacts()
    {
        return $this->hasMany(CampaignContact::class, 'campaign_id', 'id');
    }

    // public function campaignCallerId()
    // {
    //     return $this->hasMany(CampaignCallerId::class,'campaign_id','id');
    // }
    public function last_ran()
    {
        return $this->hasOne(CampaignContact::class, 'campaign_id', 'id')->WhereNotIn('status', ['pending', 'deleted'])->orderBy('updated_at', 'desc');

        // return $this->hasOne(CampaignContact::class,'campaign_id','id');
    }

    public function getContactListIdAttribute($info)
    {
        $contactListArray = json_decode($info, true);

        return $contactListArray;
    }

    public function getStatusAttribute($value)
    {
        if ($value == 'played') {
            $check_if_in_dnc = DNCTime::whereRaw("day = TRIM(TO_CHAR(NOW(), 'Day')) AND TO_CHAR(NOW(), 'HH24:MI:SS')::TIME BETWEEN from_time::TIME AND to_time::TIME")->where('user_id', $this->user_id)->count();
            if($check_if_in_dnc != 0) {
                return 'played';
            }
            return 'outside of hours';
        }

        return $value;
    }

    public function progress()
    {
        $campaign_stat = CampaignStats::where('campaign_id', $this->id)->first();
        if ($campaign_stat->initiated_count > 0) {
            return $campaign_stat->sent_count / $campaign_stat->initiated_count;
        }

        return 0;
    }

    public function getCampaignTypeAttribute($value)
    {
        if ($value == 'ivr-test') {
            return 'press-1';
        }
        if ($value == 'rvm-test') {
            return 'rvm';
        }

        return $value;
    }

    public function setScheduleDeliveryAttribute()
    {
    }

    //caller_id
    public function setCallerIdAttribute()
    {
        $this->attributes['caller_id'] = '["(222) 222-2222"]';
    }

    public function setCiForwardNumberAttribute($value)
    {
        $this->attributes['raw_ci_forward_number'] = formatNumber($value);
        $this->attributes['ci_forward_number'] = $value;
    }


    public function setVmForwardNumberAttribute($value)
    {
        $this->attributes['vm_forward_number'] = $value;
        $this->attributes['raw_vm_forward_number'] = formatNumber($value);
    }

    public function setDifferentNumberTypesAttribute($value)
    {

    }

    public function setStateAttribute($value)
    {

    }

    public function setNumberOfCallerIdAttribute($value)
    {

    }

    public function setTransferToNumberAttribute($value)
    {
        $this->attributes['transfer_to_number'] = $value;
        $this->attributes['raw_transfer_to_number'] = formatNumber($value);
    }
}
