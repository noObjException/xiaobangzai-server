<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MissionExpress
 *
 * @property int $id
 * @property string $openid
 * @property string $order_num 订单号
 * @property float $price 价格
 * @property float $total_price 最后支付的总价格
 * @property string|null $pay_type 支付方式:1微信支付,2余额支付
 * @property int $status 状态:-1作废,0未付款,1已付款,未发货/接单,2进行中,3已完成
 * @property string|null $remark 备注
 * @property float $bounty 追加赏金
 * @property mixed $address 送货地址
 * @property string $express_com 快递公司
 * @property string $express_type 快递类型
 * @property string $express_option 快递重量
 * @property float $option_price
 * @property string|null $start_time 开始时间
 * @property string|null $finish_time 完成时间
 * @property string $arrive_time 要求送达时间
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $accept_order_openid 接单人openid
 * @property string|null $pickup_code 取货码
 * @property mixed|null $extra_costs 额外费用
 * @property mixed|null $deductible_fees 抵扣部分, 如: 积分,余额,优惠券等
 * @property float|null $to_staff_money 给配送员的钱
 * @property int $user_id
 * @property int|null $accept_order_user_id
 * @property float|null $arrived_amount 支付到账金额
 * @property string|null $pay_time
 * @property-read \App\Models\Members $member
 * @property-read \App\Models\Members $staff
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MissionExpress onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress today()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereAcceptOrderOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereAcceptOrderUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereArriveTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereArrivedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereBounty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereDeductibleFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereExpressCom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereExpressOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereExpressType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereExtraCosts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereFinishTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereOpenid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereOptionPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereOrderNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress wherePayTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress wherePayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress wherePickupCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereToStaffMoney($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MissionExpress whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MissionExpress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MissionExpress withoutTrashed()
 * @mixin \Eloquent
 */
class MissionExpress extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'mission_express';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('id', function(Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function scopeToday($query)
    {
        return $query->where('created_at', '>=', Carbon::today());
    }

    public function member()
    {
        return $this->hasOne('App\Models\Members', 'id', 'user_id');
    }

    public function staff()
    {
        return $this->hasOne('App\Models\Members', 'id', 'accept_order_user_id');
    }
}
