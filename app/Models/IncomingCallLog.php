<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingCallLog extends Model
{
    use HasFactory;

    protected $table = "incoming_call_logs";

    protected $appends = ['my_duration', 'my_created_at'];
    protected $fillable = [
        'CallSid',
'AccountSid',
'From',
'To',
'Called',
'CallStatus',
'ApiVersion',
'Direction',
'campaign_id',
'user_id',
'company_id',
'campaign_contact_id',
'response'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class,'campaign_id','id');
    }
    public function campaign_contact()
    {
        return $this->belongsTo(CampaignContact::class,'campaign_contact_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
    public function getMyDurationAttribute()
    {
        return gmdate("H:i:s", ($this->duration !== null) ? $this->duration : 0);
    }
    public function getMyCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
    }
}
