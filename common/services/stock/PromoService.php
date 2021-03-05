<?php
namespace common\services\stock;


use backend\helpers\AjaxHelper;
use common\entities\Stock\StockPromo;
use common\helpers\DateHelper;
use common\repositories\Stock\PromoRepository;
use frontend\forms\order\OrderForm;

class PromoService
{
    private $repository;

    public function __construct(PromoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function checkPromo(string $promoToken)
    {
        //проверка существования токена
        $promo = $this->repository->validationСheckIsset($promoToken);

        //проверка по дате
        $this->checkDate($promo);

        //проверка на количество
        $this->checkCount($promo);

        return true;
    }


    public function getPromo(OrderForm $form)
    {
        $promoToken = AjaxHelper::getParamPost('promo-code');

        if(!$promo = $this->repository->getByToken($promoToken))
            return false;


        return $promo;
    }


    public function recountPromo(OrderForm $form)
    {
        $promoToken = AjaxHelper::getParamPost('promo-code');

        if(!$promo = $this->repository->getByToken($promoToken))
            return false;

        //if($promo->stock->date_from)
        //    return false;

        $promo->reduceCount();


        $this->repository->save($promo);

    }


    //если у акции указана дата, проверяем что она валидна
    private function checkDate(StockPromo $stockPromo)
    {
        if(isset($stockPromo->stock->date_from)){
            if($stockPromo->stock->date_from < DateHelper::getCurrentTime() && $stockPromo->stock->date_to > DateHelper::getCurrentTime() ){
               return true;
            }else{
                throw new \DomainException('Время действия акции истекло');
            }
        }
    }

    //проверка на кол-во
    private function checkCount(StockPromo $stockPromo)
    {
        if($stockPromo->count < 1)
            throw new \DomainException('Закончились');
    }

}