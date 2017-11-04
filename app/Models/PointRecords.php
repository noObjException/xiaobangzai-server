<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PointRecords extends Model
{
    use SoftDeletes;

    protected $table = 'point_records';

    protected $guarded = [];

    public function member()
    {
        return $this->hasOne('App\Models\Members', 'openid', 'openid');
    }
}
