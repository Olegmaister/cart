<?php
namespace api\services\stock;

use api\forms\stock\CreateForm;
use api\repositories\OneCRepository;
use common\entities\Stock\Stock;
use common\entities\Stock\StockDescription;
use common\repositories\Order\StockRepository;
use common\repositories\UrlAliasRepository;
use common\services\TransactionManager;
use yii\helpers\ArrayHelper;

class StockService extends StockBaseService
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

    public function create(CreateForm $form)
    {
        //create stock
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

        //получение slug для акции
        $slug = $this->getUrl($stock,$description['name']);

        //проверка на уникальность
        if($this->aliasRepository->getByKeyword($slug->keyword)){
            throw new \DomainException('Данный url занят. Придумайте другое название');
        }

        //привязываем описание к акции
        $stock->setDescription($descriptions);

        //получение из запроса значение поля guid
        if(!$guids = $this->getGuids($form->data)){
            throw new \DomainException('Не указан ни один гуид');
        }

        $ids = $this->getIdentifiers($form->type, $guids);


        //получение id brand|category|product
        //TODO переписать
        if($form->type === Stock::TYPE_BRAND){
            $stock->assingBrand($ids, json_encode($form->segment));
        }

        if($form->type === Stock::TYPE_CATEGORY){
            $stock->assignCategory($ids, json_encode($form->segment));
        }

        if($form->type === Stock::TYPE_PRODUCT){
            $stock->assingProduct($ids, json_encode($form->segment));
        }

        if($form->type === Stock::TYPE_CUSTOMER){
            $stock->assingCustomer($ids, json_encode($form->segment));
        }

        $this->repository->save($stock);

        //получение slug для акции
        $slug = $this->getUrl($stock,$description['name']);

        $slug->save();

        return $stock;
    }

    public function edit(CreateForm $form)
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

        //получение из запроса значение поля guid
        if(!$guids = $this->getGuids($form->data)){
            throw new \DomainException('Не указан ни один гуид');
        }

        $ids = $this->getIdentifiers($form->type, $guids);


        $this->transactionManager->wrap(function () use ($stock, $form, $ids, $description) {
            //получение id brand|category|product
            //TODO переписать
            if($form->type === Stock::TYPE_BRAND){
                $stock->assingBrand($ids, json_encode($form->segment));
            }

            if($form->type === Stock::TYPE_CATEGORY){
                $stock->assignCategory($ids, json_encode($form->segment));
            }

            if($form->type === Stock::TYPE_PRODUCT){
                $stock->assingProduct($ids, json_encode($form->segment));
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





}
