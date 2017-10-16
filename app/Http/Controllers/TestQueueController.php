<?php
namespace App\Http\Controllers;


use App\Jobs\SendWechatTemplateMessage;
use App\Models\MissionExpress;

class TestQueueController extends Controller
{
    public function index()
    {
        $model = MissionExpress::first();

        SendWechatTemplateMessage::dispatch($model, '测试队列');
    }
}