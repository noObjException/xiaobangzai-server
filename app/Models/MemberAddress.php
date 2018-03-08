<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberAddress
 *
 * @property int $id
 * @property string $realname
 * @property string $mobile
 * @property int $college_id
 * @property int $area_id
 * @property string|null $detail
 * @property int $is_default
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $user_id
 * @property-read \App\Models\SchoolAreas $area
 * @property-read \App\Models\SchoolAreas $college
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereCollegeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereRealname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberAddress whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberAddress withoutTrashed()
 * @mixin \Eloquent
 */
class MemberAddress extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'member_address';

    public function college()
    {
        return $this->hasOne('App\Models\SchoolAreas', 'id', 'college_id');
    }

    public function area()
    {
        return $this->hasOne('App\Models\SchoolAreas', 'id', 'area_id');
    }
}
