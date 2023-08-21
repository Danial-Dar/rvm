<?php

namespace App\Models;

use App\Models\Predictive\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class, 'team_user')->where('role', 'agent');
    }
}
