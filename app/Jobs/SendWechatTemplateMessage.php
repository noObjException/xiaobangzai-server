<?php

namespace App\Jobs;

use App\Services\Wechat;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWechatTemplateMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var
     */
    protected $toUser;
    /**
     * @var
     */
    protected $template_id;
    /**
     * @var
     */
    protected $data;
    /**
     * @var string
     */
    protected $url;


    /**
     * Create a new job instance.
     * @param $toUser
     * @param $template_id
     * @param $data
     * @param string $url
     */
    public function __construct($toUser, $template_id, $data, $url = '')
    {

        $this->toUser      = $toUser;
        $this->template_id = $template_id;
        $this->data        = $data;
        $this->url         = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notice = Wechat::app()->notice;

        $data = [
            'touser'      => $this->toUser,
            'template_id' => $this->template_id,
            'url'         => $this->url,
            'data'        => $this->data,
        ];

        $notice->send($data);
    }
}
