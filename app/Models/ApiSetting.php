<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiSetting extends Model
{
    use HasFactory;
    protected $table = "api_settings";


    public function bots()
    {
        return $this->hasMany(Bot::class);
    }
}
