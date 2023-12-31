<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySettings extends Model
{
    use HasFactory;
    protected $table = 'company_settings';
    protected $fillable = ['company_id', 'key_label', 'value'];
}
