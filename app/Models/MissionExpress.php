<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionExpress extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'mission_express';
}
