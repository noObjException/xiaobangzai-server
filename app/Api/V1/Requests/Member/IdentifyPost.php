<?php

namespace App\Api\V1\Requests\Member;


use App\Api\BaseRequest;

class IdentifyPost extends BaseRequest
{
    public function rules()
    {
        return [
            'username'       => 'required',
            'school_college' => 'required',
            'study_no'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required'       => '姓名不能为空!',
            'school_college.required' => '学校/学院不能为空!',
            'study_no.required'       => '学号不能为空!',
        ];
    }
}