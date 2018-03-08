<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PointRecords
 *
 * @property int $id
 * @property string $openid
 * @property string|null $nickname
 * @property string $action 操作
 * @property int $value 变化值
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Members $member
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointRecords onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PointRecords whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PointRecords whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PointRecords whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PointRecords whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PointRecords whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PointRecords whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PointRecords whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PointRecords whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointRecords withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointRecords withoutTrashed()
 * @mixin \Eloquent
 */
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
