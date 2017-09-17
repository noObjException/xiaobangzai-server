<?php

namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;

class ExpressTypeTransformers extends TransformerAbstract
{
    public function transform($lesson)
    {
        return [
            'id'   => $lesson['id'],
            'name' => $lesson['name']
        ];
    }
}