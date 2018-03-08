<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MemberLevels
 *
 * @property int $id
 * @property string $title
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberLevels onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberLevels whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberLevels whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberLevels whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberLevels whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberLevels whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberLevels whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberLevels whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberLevels withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MemberLevels withoutTrashed()
 * @mixin \Eloquent
 */
class MemberLevels extends Model
{
    use SoftDeletes;

    protected $table = 'member_levels';
}
