<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'key_label', 'key_description', 'key', 'value'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeWhereCompany($query, $company_id)
    {
        $query->where('company_id', $company_id);
    }

    public static function setSettings($settings, $company_id)
    {
        foreach ($settings as $key => $value) {
            self::updateOrCreate(
                [
                    'key' => $key,
                    'company_id' => $company_id,
                ],
                [
                    'key' => $key,
                    'company_id' => $company_id,
                    'value' => $value,
                ]
            );
        }
    }

    public static function getAllSettings($company_id)
    {
        return static::whereCompany($company_id)->get()->mapWithKeys(function ($item) {
            return [$item['key'] => $item['value']];
        });
    }

    public static function getSettings($settings, $company_id)
    {
        return static::whereIn('key', $settings)->whereCompany($company_id)
            ->get()->mapWithKeys(function ($item) {
                return [$item['key'] => $item['value']];
            });
    }

    public static function getSetting($key, $company_id)
    {
        $setting = static::whereOption($key)->whereCompany($company_id)->first();

        if ($setting) {
            return $setting->value;
        } else {
            return null;
        }
    }

    public function setkeyLabelAttribute($value)
    {
        $this->attributes['key_label'] = $value;
        $this->attributes['key'] = $value;
    }
}
