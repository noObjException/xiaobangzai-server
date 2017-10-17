<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreditRecords extends Model
{
    use SoftDeletes;

    protected $table = 'credit_records';

    protected $guarded = [];

    public function member()
    {
        return $this->hasOne('App\Models\Members', 'openid', 'openid');
    }
}
