<?php
namespace common\services\api;

use common\api\urkpochta\CalculationShipment;

class UkrPochtaInternationalService
{
    private $serviceShipment;

    public function __construct(CalculationShipment $serviceShipment)
    {
        $this->serviceShipment = $serviceShipment;
    }

    public function deliveryPrice($weight,$currencyExchangeRate,$rate,$countryCode)
    {
        return $this->serviceShipment->InternationalDeliveryPrice(
            $weight,
            $currencyExchangeRate,
            $rate,
            $countryCode
        );
    }
}