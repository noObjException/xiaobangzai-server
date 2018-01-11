<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberGroups extends Model
{
    use SoftDeletes;

    protected $table = 'member_groups';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('id', function(Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function members()
    {
        return $this->hasMany('App\Models\Members', 'group_id', 'id');
    }
}
