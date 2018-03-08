<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Schools
 *
 * @property int $id
 * @property int $pid
 * @property string $title
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Schools[] $children
 * @property-read \App\Models\Schools $parent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Schools onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schools whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schools whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schools whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schools wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schools whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schools whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schools whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Schools whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Schools withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Schools withoutTrashed()
 * @mixin \Eloquent
 */
class Schools extends Model
{
    use SoftDeletes, ModelTree, AdminBuilder;

    protected $table = 'schools';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTitleColumn('title');
        $this->setOrderColumn('sort');
        $this->setParentColumn('pid');
    }
}
