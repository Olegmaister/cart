<?php
namespace api\services\stock;

use api\forms\stock\PresentCreateForm;
use api\repositories\OneCRepository;
use common\entities\Products\Product;
use common\entities\Stock\Stock;
use common\entities\Stock\StockDescription;
use common\repositories\Order\StockRepository;
use common\repositories\UrlAliasRepository;
use common\services\TransactionManager;
use yii\helpers\ArrayHelper;

class StockPresentService extends StockBaseService
{
    private $repository;
    private $oneCRepository;
    private $aliasRepository;
    private $transactionManager;

    public function __construct(
        StockRepository $repository,
        OneCRepository $oneCRepository,
        UrlAliasRepository $aliasRepository,
        TransactionManager $transactionManager
    )
    {
        $this->repository = $repository;
        $this->oneCRepository = $oneCRepository;
        $this->aliasRepository = $aliasRepository;
        $this->transactionManager = $transactionManager;
        parent::__construct($this->repository);
    }

    public function create(PresentCreateForm $form)
    {
        if(!$form->checkGuids('guid') || !$form->checkGuids('guid_present')){
            throw new \DomainException('Вы не указали основной товар или товары в подарок');
        }

        //get main products guids
        $mainGuids = $form->getMainProductGuid();
        //get present products guids
        $presentGuids = $form->getPresentProductGuid();


        $mainIds = $this->getIdentifiersMain($form->type, $mainGuids);
        $presentIds = $this->getIdentifiers($form->type, $presentGuids);

        //create new stock
        $stock = Stock::apiCreate($form->api, $form->type, $form->method, $form->date_from, $form->date_to);

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


        //привязываем описание к акции
        $stock->setDescription($descriptions);

        //получение slug для акции
        $slug = $this->getUrl($stock,$description['name']);

        //check unique url
        if($this->aliasRepository->getByKeyword($slug->keyword)){
            throw new \DomainException('Данный url занят. class : '. __CLASS__.' line: '. __LINE__);
       }


        $this->transactionManager->wrap(function () use ($stock, $form,$description, $mainIds, $presentIds) {

            foreach ($mainIds as $prodId) {
                $stock->assingPresent($prodId, $presentIds);
            }

            $this->repository->save($stock);

            //получение slug для акции
            $slug = $this->getUrl($stock,$description['name']);

            $slug->save();

        });

        return $stock;

    }

    public function edit(PresentCreateForm $form)
    {
        if(!$form->checkGuids('guid') || !$form->checkGuids('guid_present')){
            throw new \DomainException('Вы не указали основной товар или товары в подарок');
        }

        //get stock by guid
        $stock = $this->repository->getByGuid($form->api);

        //get main products guids
        $mainGuids = $form->getMainProductGuid();
        //get present products guids
        $presentGuids = $form->getPresentProductGuid();


        $mainIds = $this->getIdentifiersMain($form->type, $mainGuids);
        $presentIds = $this->getIdentifiers($form->type, $presentGuids);


        //edit stock
        $stock->apiEdit(
            $form->method,
            $form->percent,
            $form->money,
            $form->date_from,
            $form->date_to
        );

        $stock->setActive(Stock::STATUS_ACTIVE);
        $stock->setSlider($form->slider);


        foreach ($stock->descriptions as $description) {
            /**@var StockDescription $description*/
            $desc = $form->getDescription();
            $description->apiEdit($desc['name'],$desc['description'],$desc['heading']);
            $stock->editChildDescription($description);

        }

        $stockClass = $this->getClassStock($form->type);
        $this->repository->removeChildrenByStockId($stockClass, $stock);


        $this->transactionManager->wrap(function () use ($stock, $form,$description, $mainIds, $presentIds) {

            foreach ($mainIds as $prodId) {
                $stock->assingPresent($prodId, $presentIds);
            }

            $this->repository->save($stock);

            //получение slug для акции
            $slug = $this->getUrl($stock,$description['name']);

            $slug->save();

        });

        return $stock;


    }

    private function getIdentifiers($type, $guids)
    {
        /*получение класса для запроса по типу
         *Если type = brand common\entities\Brands\Brand
         */
        $class = $this->getClass($type);

        /*получение названия поля идентификатора(внутреннего brand_id итд)*/
        $row = $this->getRow($type);

        /*получение названия поля для синхронизации с 1c*/
        $rowSynch = $this->getSyncRow($type);

        //выполнение запроса
        $objects = $this->oneCRepository->getIdentifiers($class, $row, $rowSynch, $guids);

        foreach ($objects as $object) {
            $ids[] = ArrayHelper::getValue($object,$this->getRow($type));
        }

        return $ids;

    }

    private function getIdentifiersMain($type, $guids)
    {
        /*получение класса для запроса по типу
         *Если type = brand common\entities\Brands\Brand
         */
        $class = $this->getClass($type);

        /*получение названия поля идентификатора(внутреннего brand_id итд)*/
        $row = $this->getRow($type);

        /*получение названия поля для синхронизации с 1c*/
        $rowSynch = $this->getSyncRow($type);

        //выполнение запроса
        $objects = $this->oneCRepository->getIdentifiers(Product::class, $row, 'guid', $guids);


        foreach ($objects as $object) {
            $ids[] = ArrayHelper::getValue($object,$this->getRow($type));
        }


        return $ids;

    }

}