<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NovaSetting extends Model
{
    use HasFactory;

    protected $table = 'nova_settings';

    public $incrementing = false;
}
