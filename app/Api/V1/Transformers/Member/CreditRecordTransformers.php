<?php

namespace App\Api\V1\Transformers\Member;


use App\Models\CreditRecords;
use League\Fractal\TransformerAbstract;

class CreditRecordTransformers extends TransformerAbstract
{
    public function transform(CreditRecords $lesson)
    {
        $lesson = $lesson->toArray();
        return [
            'title'     => $lesson['action'],
            'value'      => $lesson['value'],
            'created_at' => $lesson['created_at']
        ];
    }
}