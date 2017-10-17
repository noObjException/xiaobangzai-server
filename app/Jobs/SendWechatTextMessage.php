<?php

namespace App\Jobs;

use App\Services\Wechat;
use EasyWeChat\Message\Text;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWechatTextMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    protected $openId;

    /**
     * @var
     */
    protected $content;

    /**
     * Create a new job instance.
     *
     * @param $openId
     * @param $content
     * @internal param $data
     */
    public function __construct($openId, $content)
    {
        $this->openId  = $openId;
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $staff = Wechat::app()->staff;

        $message = new Text(['content' => $this->content]);

        $staff->message($message)->to($this->openId)->send();
    }
}
