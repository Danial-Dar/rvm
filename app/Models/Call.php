<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Call extends Model
{
    use HasFactory;

    protected $table = "calls";
    public $timestamps = false;
    protected $fillable = ['transaction_id','status','date'];
}
