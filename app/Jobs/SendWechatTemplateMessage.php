<?php

namespace App\Jobs;

use App\Models\MissionExpress;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendWechatTemplateMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var MissionExpress
     */
    protected $missionExpress;
    /**
     * @var string
     */
    private $title;

    /**
     * Create a new job instance.
     *
     * @param MissionExpress $missionExpress
     * @param string $title
     * @internal param MissionExpress $missionExpress
     * @internal param MissionExpress $express
     */
    public function __construct(MissionExpress $missionExpress, $title = '')
    {
        $this->missionExpress = $missionExpress;
        $this->title = $title;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \DB::table('queue_test')->insert(['content' => $this->missionExpress, 'title' => $this->title]);
    }
}
