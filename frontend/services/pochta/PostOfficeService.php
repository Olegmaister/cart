<?php
namespace frontend\services\pochta;

use common\entities\Country;
use common\repositories\CountryRepository;

class PostOfficeService
{
    private $repository;

    public function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCodeCountry(int $code)
    {
        /**@var Country $country*/
        $country = $this->repository->getCode($code);
        return $country->getAlpha2();

    }

}