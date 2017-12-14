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
    protected $to_user;
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
     * @param string $to_user
     * @param string $template_id
     * @param array $data
     * @param string $url
     * @internal param $toUser
     */
    public function __construct(string $to_user, string $template_id, array $data, string $url = '')
    {
        $this->to_user      = $to_user;
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
        $template_message = Wechat::app()->template_message;

        $data = [
            'touser'      => $this->to_user,
            'template_id' => $this->template_id,
            'url'         => $this->url,
            'data'        => $this->data,
        ];

        $template_message->send($data);
    }
}
