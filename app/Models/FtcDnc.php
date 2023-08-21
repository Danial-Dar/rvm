<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FtcDnc extends Model
{
    use HasFactory;
    protected $table = 'ftc_dncs';
     protected $fillable = [
        'number',
        'raw_number',
        'robocall_status',
        'ftc_response',
        'log_id',
        'ftc_status'
    ];
}
