<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberIdentifies
 *
 * @property int $id
 * @property string $openid
 * @property string $username 用户名
 * @property string $school 学校
 * @property string $college 学院
 * @property string $study_no 学号
 * @property mixed $pictures 证件照
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Members $member
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberIdentifies onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereCollege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies wherePictures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereStudyNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIdentifies whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberIdentifies withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberIdentifies withoutTrashed()
 * @mixin \Eloquent
 */
class MemberIdentifies extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'member_identifies';

    public function setPicturesAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['pictures'] = json_encode($pictures);
        }
    }

    public function getPicturesAttribute($pictures)
    {
        return json_decode($pictures, true);
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Members', 'openid', 'openid');
    }
}
