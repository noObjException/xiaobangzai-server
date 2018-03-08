<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ExpressTypes
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property int $sort
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressTypes onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressTypes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressTypes whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressTypes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressTypes whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressTypes whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressTypes whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressTypes whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressTypes withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressTypes withoutTrashed()
 * @mixin \Eloquent
 */
class ExpressTypes extends Model
{
    use SoftDeletes;

    protected $table = 'express_types';
}
