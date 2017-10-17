<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ChangedCredit' => [
            'App\Listeners\ChangedCreditListener',
        ],
        'App\Events\CreateMissionOrder' => [ // 生成任务订单 事件
            'App\Listeners\CreateMissionOrder\SendTemplateMessage' // 发通知
        ],
        'App\Events\PayMissionOrder' => [ // 支付任务订单 事件
            'App\Listeners\PayMissionOrder\SettleCredit',       // 计算积分(支付时用于抵扣了部分金额)
            'App\Listeners\PayMissionOrder\SendTemplateMessage' // 发通知
        ],
        'App\Events\CompletedMissionOrder' => [ // 完成任务订单 事件
            'App\Listeners\PayMissionOrder\SettleAccounts',     // 计算账目(平台拿多少, 配送员拿多少, 记录日志)
            'App\Listeners\PayMissionOrder\SettleCredit',       // 计算积分(积分奖励)
            'App\Listeners\CompletedMissionOrder\SendTemplateMessage' // 发通知
        ],
        'App\Events\acceptMissionOrder' => [ // 接单 事件
            'App\Listeners\acceptMissionOrder\SendTemplateMessage' // 发通知
        ],
        'App\Events\CancelMissionOrder' => [ // 取消订单 事件
            'App\Listeners\CancelMissionOrder\SendTemplateMessage' // 发通知
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
