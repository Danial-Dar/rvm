<?php

namespace App\Models\Predictive;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user');
    }
}
