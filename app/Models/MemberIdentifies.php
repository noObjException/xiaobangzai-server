<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberIdentifies extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'member_identifies';

    public function setPicturesAttribute($pictures)
    {
        if (is_array($pictures)) {
            $this->attributes['pictures'] = json_encode($pictures);
        }
    }

    public function getPicturesAttribute($pictures)
    {
        return json_decode($pictures, true);
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Members', 'openid', 'openid');
    }
}
