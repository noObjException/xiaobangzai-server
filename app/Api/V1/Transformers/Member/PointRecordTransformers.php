<?php

namespace App\Api\V1\Transformers\Member;


use App\Models\PointRecords;
use League\Fractal\TransformerAbstract;

class PointRecordTransformers extends TransformerAbstract
{
    public function transform(PointRecords $lesson)
    {
        $lesson = $lesson->toArray();
        return [
            'title'     => $lesson['action'],
            'value'      => $lesson['value'],
            'created_at' => $lesson['created_at']
        ];
    }
}