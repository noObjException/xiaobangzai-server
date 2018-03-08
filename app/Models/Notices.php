<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Notices
 *
 * @property int $id
 * @property string $title
 * @property string|null $url
 * @property string $sort
 * @property string $status
 * @property string|null $content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notices onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Notices whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notices withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Notices withoutTrashed()
 * @mixin \Eloquent
 */
class Notices extends Model
{
    use SoftDeletes;
}
