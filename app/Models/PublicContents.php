<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PublicContents
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $name
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PublicContents onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PublicContents whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PublicContents whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PublicContents whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PublicContents whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PublicContents whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PublicContents whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PublicContents whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PublicContents withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PublicContents withoutTrashed()
 * @mixin \Eloquent
 */
class PublicContents extends Model
{
    use SoftDeletes;

    protected $table = 'public_contents';

    protected $guarded = [];
}
