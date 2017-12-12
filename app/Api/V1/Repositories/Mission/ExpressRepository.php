<?php

namespace App\Api\V1\Repositories\Mission;

use App\Api\BaseRepository;
use App\Api\V1\Repositories\Member\AddressRepository;
use App\Models\ArriveTimes;
use App\Models\ExpressCompanys;
use App\Models\ExpressTypes;
use App\Models\ExpressOptions;
use App\Models\PublicContents;

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
            'priceRule'        => $this->getPriceRule(),
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
            ->get(['id as key', 'title as value', 'price']);
    }

    protected function getPriceRule()
    {
        if ($content = PublicContents::where('name', 'PRICE_RULE')->first(['content'])) {
            return $content->content;
        }
        return null;
    }
}