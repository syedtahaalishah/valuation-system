<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $append = ['qr_code_url'];

    protected $fillable = [
        'suburb',
        'qr_code',
        'user_id',
        'location',
        'plot_number',
        'market_value',
        'serial_number',
        'valuation_date',
        'signing_valuer',
        'gps_coordinates',
        'valuing_company',
        'forced_sale_value',
        'insurance_replacement_value',
    ];

    public function getRouteKeyName()
    {
        return 'serial_number';
    }

    public function getQrCodeUrlAttribute()
    {
        return asset('qrcodes/' . $this->qr_code);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->serial_number = (string) strtolower(Str::random(12));
        });
    }
}
