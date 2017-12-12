<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicContents extends Model
{
    use SoftDeletes;

    protected $table = 'public_contents';

    protected $guarded = [];
}
