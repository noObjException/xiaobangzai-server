<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Members  extends Authenticatable implements JWTSubject
{
    use SoftDeletes, Notifiable;

    protected $guarded = [];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('id', function(Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function level()
    {
        return $this->hasOne('App\Models\MemberLevels', 'id', 'level_id');
    }

    public function group()
    {
        return $this->hasOne('App\Models\MemberGroups', 'id', 'group_id');
    }

    public function express_missions()
    {
        return $this->hasMany('App\Models\MissionExpress', 'user_id', 'id');
    }

    /**
     * 接单数
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accept_orders()
    {
        return $this->hasMany('App\Models\MissionExpress', 'accept_order_user_id', 'id');
    }

    /**
     * 学生认证信息
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function identify()
    {
        return $this->hasOne('App\Models\MemberIdentifies', 'openid', 'openid');
    }
}
