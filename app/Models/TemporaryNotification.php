<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemporaryNotification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "temporary_notifications";

    public function getDataAttribute($value) {
        return json_decode($value);
    }
}
