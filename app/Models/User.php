<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Nova\Auth\Impersonatable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Impersonatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['balance', 'formated_number', 'credit'];

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
    public function campaignStats()
    {
        return $this->hasMany(CampaignStats::class,'user_id','id');
    }
    public function campaign_contacts()
    {
        return $this->hasMany(CampaignContact::class,'user_id','id');
    }

    public function settings()
    {
        return $this->hasMany(UserSetting::class,'user_id','id');
    }

    public function teams(){
        return $this->belongsToMany(Team::class);
    }

    public function getBalanceAttribute()
    {
        if ($this->role == 'admin') {
            $balance = Balance::sum('amount');
        }elseif ($this->role == 'company') {
            $balance = Balance::where('company_id', $this->company_id)->sum('amount');
        }elseif ($this->role == 'user') {
            $balance = Balance::where('company_id', $this->company_id)->sum('amount');
        }elseif ($this->role == 'agent') {
            $balance = Balance::where('company_id', $this->company_id)->sum('amount');
        }
        return number_format($balance,2);
    }

    public function getCreditAttribute()
    {
        if ($this->role == 'user') {
            $balance = Balance::where('company_id', $this->company_id)->sum('amount');
            $credit_limit = CompanySetting::Where('company_id', $this->company_id)->Where('key','credit_limit')->first();

            if($credit_limit) {
            if ($credit_limit->value > ($balance * -1)) {
                $value = false;
            }else {
                $value = true;
            }
            return $value;
            }
            return false;
        }
    }

    public function getFormatedNumberAttribute()
    {
        if ($this->role == 'admin') {
            $balance = Balance::sum('amount');
        }elseif ($this->role == 'company') {
            $balance = Balance::where('company_id', $this->company_id)->sum('amount');
        }elseif ($this->role == 'user') {
            $balance = Balance::where('company_id', $this->company_id)->sum('amount');
        }elseif ($this->role == 'agent') {
            $balance = Balance::where('company_id', $this->company_id)->sum('amount');
        }
        return $balance;
    }


    public function canImpersonate()
    {
        return true;
    }

    public function canBeImpersonated()
    {
        return true;
    }

}
