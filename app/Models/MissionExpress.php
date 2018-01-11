<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionExpress extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'mission_express';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('id', function(Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function member()
    {
        return $this->hasOne('App\Models\Members', 'openid', 'openid');
    }

    public function staff()
    {
        return $this->hasOne('App\Models\Members', 'openid', 'accept_order_openid');
    }
}
