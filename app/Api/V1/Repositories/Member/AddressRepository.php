<?php

namespace App\Api\V1\Repositories\Member;

use App\Api\BaseRepository;
use App\Models\MemberAddress;

class AddressRepository extends BaseRepository
{
    public function getDefaultAddress()
    {
        $data = MemberAddress::where([
            ['openid', current_member_openid()],
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
            return [];
        }

        $college = $data->college->title;
        $area    = $data->area->title;

        $data = $data->toArray();

        $data['college'] = $college;
        $data['area']    = $area;

        return $data;
    }
}