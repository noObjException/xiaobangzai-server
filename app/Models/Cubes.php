<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Cubes
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $image
 * @property string $desc
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cubes onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cubes whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cubes withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cubes withoutTrashed()
 * @mixin \Eloquent
 */
class Cubes extends Model
{
    use SoftDeletes;
}
