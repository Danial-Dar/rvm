<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsBillingSetting extends Model
{
    use HasFactory;
    protected $table = 'sms_billing_settings';

    public const PER_MESSAGE = 'PER_MESSAGE';
    public const MONTHLY = 'MONTHLY';
    public const INBOUND = 'INBOUND';
    public const OUTBOUND = 'OUTBOUND';
}
