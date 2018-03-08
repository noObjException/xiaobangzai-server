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
        $swipers = Swipers::all()->map(function ($item) {
            $item->image = url('') . $item->image;
            return $item;
        });
        $navs    = Navs::all()->map(function ($item) {
            $item->image = url('/uploads') .'/'. $item->image;
            return $item;
        });
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