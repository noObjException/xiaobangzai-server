<?php

namespace App\Api\V1\Repositories\Member;

use App\Api\BaseRepository;
use App\Models\MemberAddress;

class AddressRepository extends BaseRepository
{
    public function getDefaultAddress()
    {
        $data = MemberAddress::where([
            ['user_id', current_user_id()],
            ['is_default', '1'],
        ])->select([
            'id',
            'realname',
            'college_id',
            'area_id',
            'mobile',
            'detail',
        ])->first();

        if (empty($data)) {
            return null;
        }

        $college = $data->college->title;
        $area    = $data->area->title;

        $data = $data->toArray();

        $data['college'] = $college;
        $data['area']    = $area;

        return $data;
    }
}