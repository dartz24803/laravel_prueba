<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingToken extends Model
{
    use HasFactory;

    protected $table = 'tracking_token';

    public $timestamps = false;

    protected $fillable = [
        'base',
        'token',
        'fecha'
    ];
}
