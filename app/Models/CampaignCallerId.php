<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CampaignCallerId extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "campaign_caller_ids";
    protected $with = ['my_numbers'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function my_numbers()
    {
        return $this->belongsTo(MyNumber::class,'my_number_id','id');
    }

}
