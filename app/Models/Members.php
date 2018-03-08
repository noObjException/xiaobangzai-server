<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\Members
 *
 * @property int $id
 * @property string|null $openid
 * @property string|null $realname
 * @property string|null $nickname
 * @property string|null $mobile
 * @property int $point 积分
 * @property float $balance
 * @property int $status
 * @property int $gender
 * @property string|null $avatar
 * @property string|null $province
 * @property string|null $city
 * @property string|null $area
 * @property int $group_id
 * @property int $level_id
 * @property int $is_follow
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $is_staff 是否是配送员
 * @property int $is_identify 是否通过认证
 * @property string|null $wx_mini_openid 小程序openid
 * @property string|null $wx_union_id 微信unionid
 * @property string|null $follow_channel 关注途径
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MissionExpress[] $accept_orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MissionExpress[] $express_missions
 * @property-read \App\Models\MemberGroups $group
 * @property-read \App\Models\MemberIdentifies $identify
 * @property-read \App\Models\MemberLevels $level
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Members onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members today()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereFollowChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereIsFollow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereIsIdentify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereIsStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereRealname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereWxMiniOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Members whereWxUnionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Members withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Members withoutTrashed()
 * @mixin \Eloquent
 */
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

    public function scopeToday($query)
    {
        return $query->where('created_at', '>=', Carbon::today());
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
