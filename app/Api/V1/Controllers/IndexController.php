<?php

namespace App\Api\V1\Controllers;


use App\Api\BaseController;
use App\Models\Navs;
use App\Models\Swipers;

class IndexController extends BaseController
{
    public function index()
    {
        $swipers = Swipers::all();
        $navs    = Navs::all();
        $data    = [
            'swipers' => $swipers,
            'navs'    => $navs
        ];
        return $this->response->array(compact('data'));
    }
}