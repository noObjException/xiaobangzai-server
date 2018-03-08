<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\SchoolAreas
 *
 * @property int $id
 * @property int $pid
 * @property string $title
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SchoolAreas[] $children
 * @property-read \App\Models\SchoolAreas $parent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SchoolAreas onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolAreas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolAreas whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolAreas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolAreas wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolAreas whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolAreas whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolAreas whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SchoolAreas whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SchoolAreas withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SchoolAreas withoutTrashed()
 * @mixin \Eloquent
 */
class SchoolAreas extends Model
{
    use SoftDeletes, ModelTree, AdminBuilder;

    protected $table = 'school_areas';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTitleColumn('title');
        $this->setOrderColumn('sort');
        $this->setParentColumn('pid');
    }
}
