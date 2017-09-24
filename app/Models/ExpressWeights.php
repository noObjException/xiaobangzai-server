<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressWeights extends Model
{
    use SoftDeletes;

    protected $table = 'express_weights';
}
