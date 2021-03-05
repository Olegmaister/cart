<?php
namespace common\services\api;

use common\api\NovaPoshta;
use common\repositories\CityRepository;
use Yii;

class NovaPoshtaService
{
    private $cityRepository;
    private $novaPoshta;
    const FREE_DELIVERY = 2000;

    private $defaultCostDelivery = 100;

    public function __construct(
        CityRepository $cityRepository,
        NovaPoshta $novaPoshta
    )
    {
        $this->novaPoshta = $novaPoshta;
        $this->cityRepository = $cityRepository;
    }

    public function branches($cityId)
    {
        $city = $this->cityRepository->getById($cityId);

        $data = $this->novaPoshta->getWarehouses($city->reff);

        $resArray = [];

        $langData = 'DescriptionRu';

        if (Yii::$app->language === 'ua-UA') {
            $langData = 'Description';
        }

        foreach ($data as $datum) {
            $resArray[$datum['SiteKey']] = $datum[$langData];
        }

        return $resArray;
    }

    public function getDocumentPrice($cityId, $weight, $cost)
    {
        //получение города repository
        $city = $this->cityRepository->getById($cityId);


        //если города нет возвращаем по умолчанию стоимость доставки 100гр
        if(!$city)
            return null;

        //получение реффера api service
        //$cityReff = $this->novaPoshta->getCityRef($city->name);
        //получение цены api service

        $result = $this->novaPoshta->getDocumentPrice($city->reff, $weight, $cost);

        return $result['data'][0]['Cost'];
    }

    /**
     * @return int
     */
    public function getDefaultCostDelivery(): int
    {
        return $this->defaultCostDelivery;
    }
}
