<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balances extends Model
{
    use SoftDeletes;

    protected $table = 'balances';

    protected $guarded = [];

    public function member()
    {
        return $this->hasOne('App\Models\Members', 'id', 'user_id');
    }
}
