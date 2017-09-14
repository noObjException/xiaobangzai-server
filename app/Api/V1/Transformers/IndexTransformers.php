<?php
namespace App\Api\V1\Transformers;

use League\Fractal\TransformerAbstract;

class IndexTransformers extends TransformerAbstract
{
    public function transform($lesson)
    {
        return [
            'id' => $lesson['id']
        ];
    }
}