<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ExpressOptions
 *
 * @property int $id
 * @property string $title 规格
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property float|null $price 价格
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressOptions onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressOptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressOptions whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressOptions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressOptions wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressOptions whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressOptions whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressOptions whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressOptions whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressOptions withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressOptions withoutTrashed()
 * @mixin \Eloquent
 */
class ExpressOptions extends Model
{
    use SoftDeletes;

    protected $table = 'express_options';
}
