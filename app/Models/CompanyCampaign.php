<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCampaign extends Model
{
    use HasFactory;

    protected $table = 'company_campaigns';

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
