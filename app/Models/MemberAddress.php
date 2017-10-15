<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberAddress extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'member_address';

    public function college()
    {
        return $this->hasOne('App\Models\SchoolAreas', 'id', 'college_id');
    }

    public function area()
    {
        return $this->hasOne('App\Models\SchoolAreas', 'id', 'area_id');
    }
}
