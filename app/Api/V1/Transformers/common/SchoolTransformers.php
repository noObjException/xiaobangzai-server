<?php
namespace App\Api\V1\Transformers\common;

use App\Models\Schools;
use League\Fractal\TransformerAbstract;


class SchoolTransformers extends TransformerAbstract
{
    public function transform(Schools $lesson)
    {
        return [
            'name'   => $lesson['title'],
            'value'  => (String)$lesson['id'],
            'parent' => (String)$lesson['pid'],
        ];
    }
}