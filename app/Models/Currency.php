<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'number', 'decimal', 'currency', 'currency_locations'
    ];

    protected $casts = [
        'currency_locations' => 'array',
    ];
}
