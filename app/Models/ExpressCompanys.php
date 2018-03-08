<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ExpressCompanys
 *
 * @property int $id
 * @property string $title
 * @property int $sort
 * @property int $status
 * @property string|null $name 标识(常用拼音表示)
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressCompanys onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressCompanys whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressCompanys whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressCompanys whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressCompanys whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressCompanys whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressCompanys whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressCompanys whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ExpressCompanys whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressCompanys withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ExpressCompanys withoutTrashed()
 * @mixin \Eloquent
 */
class ExpressCompanys extends Model
{
    use SoftDeletes;

    protected $table = 'express_companys';
}
