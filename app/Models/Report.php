<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $append = ['qr_code_url'];

    protected $fillable = [
        'user_id',
        'serial_number',
        'location',
        'suburb',
        'plot_number',
        'valuation_date',
        'signing_valuer',
        'market_value',
        'forced_sale_value',
        'gps_coordinates',
        'qr_code'
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
            $model->serial_number = (string) Str::uuid();
        });
    }
}
