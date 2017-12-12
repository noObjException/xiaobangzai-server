<?php
namespace App\Api\V1\Controllers\Common;


use App\Api\BaseController;
use App\Api\V1\Transformers\common\PublicContentTransformers;
use App\Models\PublicContents;

class PublicContentController extends BaseController
{
    /**
     * @param PublicContents $model
     * @param $name
     * @return \Dingo\Api\Http\Response
     */
    public function show(PublicContents $model, $name)
    {
        $data = $model->where('name', $name)->firstOrFail();

        return $this->response->item($data, new PublicContentTransformers());
    }
}