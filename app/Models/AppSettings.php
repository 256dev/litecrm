<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSettings extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'organization_name',
        'phone',
        'email',
        'address',
    ];

    protected $casts = [
        'phone' => 'array',
    ];
}
