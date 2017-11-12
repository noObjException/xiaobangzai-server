<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressOptions extends Model
{
    use SoftDeletes;

    protected $table = 'express_options';
}
