<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressCompanys extends Model
{
    use SoftDeletes;

    protected $table = 'express_companys';
}
