<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value', 'type'];

    public static function getValue($key)
    {
        $seting = (new static())::firstWhere('key', $key);

        return $seting ? $seting->value : '';
    }
}
