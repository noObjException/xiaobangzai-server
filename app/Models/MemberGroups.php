<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberGroups
 *
 * @property int $id
 * @property string $title
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Members[] $members
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberGroups onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberGroups whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberGroups whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberGroups whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberGroups whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberGroups whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberGroups whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberGroups whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberGroups withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberGroups withoutTrashed()
 * @mixin \Eloquent
 */
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
