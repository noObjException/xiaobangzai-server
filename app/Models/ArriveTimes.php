<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ArriveTimes
 *
 * @property int $id
 * @property string $title
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArriveTimes onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArriveTimes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArriveTimes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArriveTimes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArriveTimes whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArriveTimes whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArriveTimes whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArriveTimes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArriveTimes withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArriveTimes withoutTrashed()
 * @mixin \Eloquent
 */
class ArriveTimes extends Model
{
    use SoftDeletes;

    protected $table = 'arrive_times';
}
