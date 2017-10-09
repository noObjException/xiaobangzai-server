<?php
namespace App\Api\V1\Controllers\Staff;


use App\Api\BaseController;
use App\Api\V1\Transformers\common\SchoolTransformers;
use App\Models\Schools;
use Dingo\Api\Http\Request;

class StaffController extends BaseController
{
    public function index(Schools $model)
    {
        $data = $model->where('status', '1')->get();

        return $this->response->collection($data, new SchoolTransformers());
    }

    public function store(Request $request)
    {

    }


}