<?php

namespace App\Api\V1\Controllers;


use App\Api\BaseController;
use App\Models\Cubes;
use App\Models\Navs;
use App\Models\Notices;
use App\Models\Swipers;

class IndexController extends BaseController
{
    public function index()
    {
        $swipers = Swipers::all();
        $navs    = Navs::all();
        $notices = Notices::all();
        $cubes   = Cubes::all();

        $data    = [
            'swipers' => $swipers,
            'navs'    => $navs,
            'notices' => $notices,
            'cubes'   => $cubes
        ];
        return $this->response->array(compact('data'));
    }
}