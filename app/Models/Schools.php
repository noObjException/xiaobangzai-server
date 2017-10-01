<?php

namespace App\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
