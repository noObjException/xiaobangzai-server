<?php

namespace App\Api\V1\Controllers;


use App\Api\BaseController;
use App\Api\V1\Transformers\ExpressTypeTransformers;
use App\Models\ExpressTypes;

class ExpressTypeController extends BaseController
{
    public function index()
    {
        $lists = ExpressTypes::orderBy('sort', 'desc')->get();

        return $this->response->collection($lists, new ExpressTypeTransformers());
    }
}