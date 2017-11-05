<?php
namespace App\Api;


use Dingo\Api\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
}