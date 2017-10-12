<?php

namespace App\Listeners;

use App\Events\ChangedCredit;
use App\Models\CreditRecords;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangedCreditListener
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ChangedCredit $event
     */
    public function handle(ChangedCredit $event)
    {
        $member = $event->members;

        CreditRecords::create([
            'openid'   => $member->openid,
            'nickname' => $member->nickname,
            'action'   => $event->action,
            'value'    => $event->value,
        ]);

        $member->credit += $event->value;

        $member->save();
    }
}
