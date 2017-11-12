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
            'expressWeights'   => $this->getExpressWeights(),
            'settings'         => get_setting('GET_EXPRESS_SETTING'),
            'defaultAddress'   => $addressRepository->getDefaultAddress(),
        ];
    }

    protected function getExpressCompanies()
    {
        return ExpressCompanys::where(['status' => '1'])
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->pluck('title');
    }

    protected function getArriveTimes()
    {
        return ArriveTimes::where(['status' => '1'])
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->pluck('title');
    }

    protected function getExpressTypes()
    {
        return ExpressTypes::where(['status' => '1'])
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->pluck('title');
    }

    protected function getExpressWeights()
    {
        return ExpressOptions::where(['status' => '1'])
            ->orderBy('sort', 'desc')
            ->orderBy('id', 'desc')
            ->pluck('title');
    }
}