<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiotimeTemp extends Model
{
    use HasFactory;

    protected $table = 'biotime_temp';

    public $timestamps = false;

    protected $fillable = [
        'emp_code',
        'punch_time',
        'work_code'
    ];
}
