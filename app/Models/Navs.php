<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Navs
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $image
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Navs onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navs whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Navs withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Navs withoutTrashed()
 * @mixin \Eloquent
 */
class Navs extends Model
{
    use SoftDeletes;
}
