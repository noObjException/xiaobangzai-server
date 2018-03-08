<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Swipers
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string $image
 * @property int $sort
 * @property int $status
 * @property string|null $desc
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Swipers onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Swipers whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Swipers withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Swipers withoutTrashed()
 * @mixin \Eloquent
 */
class Swipers extends Model
{
    use SoftDeletes;
}
