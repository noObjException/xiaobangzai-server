<?php
namespace App\Api\V1\Controllers\Common;

use App\Api\BaseController;
use Dingo\Api\Http\Request;

class PictureController extends BaseController
{
    public function store(Request $request)
    {
        $upload_dir = $request->get('upload_dir', '');

        $path = $request->file('image')->store($upload_dir);

        $data = 'images/users/' . $path;

        return $this->response->array(compact('data'));
    }
}