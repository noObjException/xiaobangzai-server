<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberAddress extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'member_address';
}
