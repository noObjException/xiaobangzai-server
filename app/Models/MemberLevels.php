<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberLevels extends Model
{
    use SoftDeletes;

    protected $table = 'member_levels';
}
