<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function scopeToday($query)
    {
        return $query->where('created_at', '>=', Carbon::today());
    }

    public function member()
    {
        return $this->hasOne('App\Models\Members', 'id', 'user_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Models\Members', 'id', 'accept_order_user_id');
    }
}
