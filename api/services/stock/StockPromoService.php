<?php
namespace api\services\stock;

use api\forms\stock\PromoCreateForm;
use api\repositories\OneCRepository;
use common\entities\Stock\Stock;
use common\entities\Stock\StockDescription;
use common\repositories\Order\StockRepository;
use common\repositories\UrlAliasRepository;


class StockPromoService extends StockBaseService
{
    private $repository;
    private $oneCRepository;
    private $aliasRepository;

    public function __construct(
        StockRepository $repository,
        OneCRepository $oneCRepository,
        UrlAliasRepository $aliasRepository
    )
    {
        $this->repository = $repository;
        $this->oneCRepository = $oneCRepository;
        $this->aliasRepository = $aliasRepository;
        parent::__construct($this->repository);
    }

    public function create(PromoCreateForm $form)
    {
        //create stock
        $stock = Stock::apiCreate(
            $form->api,
            $form->type,
            $form->method,
            $form->date_from,
            $form->date_to
        );

        $stock->setPercent($form->percent);
        $stock->setMoney($form->money);
        $stock->setActive($form->active);
        $stock->setSlider($form->slider);

        $description = $form->getDescription();

        $descriptions = StockDescription::apiCreate(
            $description['name'],
            $description['heading'],
            $description['description']
        );

        //получение slug для акции
        //$slug = $this->getUrl($stock,$description['name']);

        //проверка на уникальность
        //if($this->aliasRepository->getByKeyword($slug->keyword)){
        //    throw new \DomainException('Данный url занят. Придумайте другое название');
        //}

        //привязываем описание к акции
        $stock->setDescription($descriptions);


        //перенести в форму
        $resPromo = [];
        foreach ($form->data as $datum) {
            if($this->checkCount($datum['count'])){
                throw new \DomainException('не заполнено обязательное поле count');
            }
            if($this->checkToken($datum['token'])){
                throw new \DomainException('не заполнено обязательное поле token');
            }

            $resPromo[] = $this->createElement(
                $datum['count'],
                $datum['token']
            );
        }


        $stock->assignPromo($resPromo);

        $this->repository->save($stock);

        //получение slug для акции
        //$slug = $this->getUrl($stock,$description['name']);

        //$slug->save();

        return $stock;

    }

    public function edit(PromoCreateForm $form)
    {
        /* @var Stock $stock**/
        $stock = $this->repository->getByGuid($form->api);

        //edit stock
        $stock->apiEdit(
            $form->method,
            $form->percent,
            $form->money,
            $form->date_from,
            $form->date_to
        );

        $stock->setActive(1);
        $stock->setSlider($form->slider);


        foreach ($stock->descriptions as $description) {
            /**@var StockDescription $description*/
            $desc = $form->getDescription();
            $description->apiEdit($desc['name'],$desc['description'],$desc['heading']);
            $stock->editChildDescription($description);

        }

        $stockClass = $this->getClassStock($form->type);
        $this->repository->removeChildrenByStockId($stockClass, $stock);

        //перенести в форму
        $resPromo = [];
        foreach ($form->data as $datum) {
            if($this->checkCount($datum['count'])){
                throw new \DomainException('не заполнено обязательное поле count');
            }
            if($this->checkToken($datum['token'])){
                throw new \DomainException('не заполнено обязательное поле token');
            }

            $resPromo[] = $this->createElement(
                $datum['count'],
                $datum['token']
            );
        }

        $stock->assignPromo($resPromo);

        $this->repository->save($stock);

        return $stock;

    }

    private function checkCount($count)
    {
        return $this->checkForEmpty($count);
    }

    private function checkToken($token)
    {
        return $this->checkForEmpty($token);
    }

    private function checkForEmpty($data)
    {
        return !isset($data) || empty($data);
    }

    private function createElement($count, $token)
    {
        return ['count' => $count, 'promoToken' => $token];
    }

}
