<?php

namespace App\Api\V1\Repositories\Mission;

use App\Api\BaseRepository;
use App\Api\V1\Repositories\Member\AddressRepository;
use App\Models\ArriveTimes;
use App\Models\ExpressCompanys;
use App\Models\ExpressTypes;
use App\Models\ExpressOptions;

class ExpressRepository extends BaseRepository
{
    public function getCreatePageData()
    {
        $addressRepository = new AddressRepository();

        return [
            'expressCompanies' => $this->getExpressCompanies(),
            'arriveTimes'      => $this->getArriveTimes(),
            'expressTypes'     => $this->getExpressTypes(),
            'expressOptions'   => $this->getExpressOptions(),
            'settings'         => get_setting('GET_EXPRESS_SETTING'),
            'defaultAddress'   => $addressRepository->getDefaultAddress(),
        ];
    }

    protected function getExpressCompanies()
    {
        return ExpressCompanys::where(['status' => '1'])
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->pluck('title');
    }

    protected function getArriveTimes()
    {
        return ArriveTimes::where(['status' => '1'])
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->pluck('title');
    }

    protected function getExpressTypes()
    {
        return ExpressTypes::where(['status' => '1'])
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->pluck('title');
    }

    protected function getExpressOptions()
    {
        return ExpressOptions::where(['status' => '1'])
            ->orderByDesc('sort')
            ->orderByDesc('id')
            ->get(['title as value', 'id as key', 'price']);
    }
}