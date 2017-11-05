<?php
namespace App\Api\V1\Controllers\Member;


use App\Api\BaseController;
use App\Api\V1\Requests\Member\IdentifyPost;
use App\Models\MemberIdentifies;
use App\Models\Schools;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Http\Response;

class IdentifyController extends BaseController
{
    /**
     * 申请学生认证
     *
     * @param IdentifyPost $request
     * @param MemberIdentifies $identifyModel
     * @param Schools $schoolModel
     * @return Response
     */
    public function store(IdentifyPost $request, MemberIdentifies $identifyModel, Schools $schoolModel): Response
    {
        $params = $request->json()->all();

        $params['openid'] = current_member_openid();

        $school_id = $params['school_college'][0];
        $college_id = $params['school_college'][1];

        $params['school'] = $schoolModel->findOrFail($school_id)->title;
        $params['college'] = $schoolModel->findOrFail($college_id)->title;

        unset($params['school_college']);

        throw_unless($identifyModel->create($params), new StoreResourceFailedException('申请失败'));

        return $this->response->created();
    }
}