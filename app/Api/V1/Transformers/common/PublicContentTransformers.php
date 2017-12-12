<?php
namespace App\Api\V1\Transformers\common;


use App\Models\PublicContents;
use League\Fractal\TransformerAbstract;

class PublicContentTransformers extends TransformerAbstract
{
    public function transform(PublicContents $lesson)
    {
        return [
            'content' => $lesson['content']
        ];
    }
}