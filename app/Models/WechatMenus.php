<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\WechatMenus
 *
 * @property int $id
 * @property int $pid
 * @property string $title 菜单名
 * @property string $url
 * @property int $sort
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WechatMenus[] $children
 * @property-read \App\Models\WechatMenus $parent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WechatMenus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus wherePid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WechatMenus whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WechatMenus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WechatMenus withoutTrashed()
 * @mixin \Eloquent
 */
class WechatMenus extends Model
{
    use SoftDeletes, ModelTree, AdminBuilder;

    protected $table = 'wechat_menus';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTitleColumn('title');
        $this->setOrderColumn('sort');
        $this->setParentColumn('pid');
    }
}
