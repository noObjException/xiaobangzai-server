<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Balances
 *
 * @property int $id
 * @property int $user_id
 * @property float $remaining_balance 当前剩余余额
 * @property float $cash_balance 申请提现余额
 * @property int $status 审核状态: -1,不通过, 0待审核, 1审核通过, 2提现到账
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Members $member
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Balances onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balances whereCashBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balances whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balances whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balances whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balances whereRemainingBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balances whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balances whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Balances whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Balances withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Balances withoutTrashed()
 * @mixin \Eloquent
 */
class Balances extends Model
{
    use SoftDeletes;

    protected $table = 'balances';

    protected $guarded = [];

    public function member()
    {
        return $this->hasOne('App\Models\Members', 'id', 'user_id');
    }
}
