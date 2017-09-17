<?php

namespace App\Api\V1\Transformers;

use App\Models\SchoolAreas;
use League\Fractal\TransformerAbstract;

class ChooseAreaTransformers extends TransformerAbstract
{
    public function transform(SchoolAreas $areas)
    {
        return [
            'name'   => $areas['title'],
            'value'  => (String)$areas['id'],
            'parent' => (String)$areas['pid'],
        ];
    }
}