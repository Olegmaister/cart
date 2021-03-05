<?php
namespace api\services\stock;


use common\entities\Brands\Brand;
use common\entities\Categories\Category;
use common\entities\Customer;
use common\entities\Products\ProductStoreOption;
use common\entities\Stock\Stock;
use common\entities\Stock\StockBrand;
use common\entities\Stock\StockCategory;
use common\entities\Stock\StockCustomer;
use common\entities\Stock\StockPresent;
use common\entities\Stock\StockProduct;
use common\entities\Stock\StockPromo;
use common\entities\UrlAlias;
use common\helpers\StringHelper;
use common\repositories\Order\StockRepository;
use yii\helpers\ArrayHelper;

class StockBaseService
{
    private $repository;

    public function __construct(StockRepository $repository)
    {
        $this->repository = $repository;
    }

    public function stockExists($guid)
    {
        return Stock::find()->where(['guid' => $guid])->count('*');
    }


    protected function getGuids($data, $key = 'guid')
    {

        $resArray = [];
        foreach ($data as $datum) {
            $current = ArrayHelper::getValue($datum,$key);
            if(empty($current))
                break;
            $resArray[] = $current;
        }

        return $resArray;
    }

    public function getClass(string $type)
    {
        foreach ($this->getClassList() as $key=>$class) {
            if($type === $key){
                return $class;
            }
        }
        throw new \DomainException('class not found. class: '. __CLASS__ .': line '.  __LINE__);
    }

    public function getClassStock(string $type)
    {
        foreach ($this->getClassStockList() as $key=>$class) {
            if($type === $key){
                return $class;
            }
        }
        throw new \DomainException('class not found. class: '. __CLASS__ .': line '.  __LINE__);
    }

    public function getRow(string $type)
    {
        foreach ($this->getRowList() as $key=>$class) {
            if($type === $key){
                return $class;
            }

        }

        throw new \DomainException('row not found. class '.__CLASS__.': line '.__LINE__);
    }

    public function getSyncRow($type)
    {
        foreach ($this->getSynchronizationRow() as $key=>$class) {
            if($type === $key){
                return $class;
            }

        }

        throw new \DomainException('row not found. class '.__CLASS__.': line '.__LINE__);
    }

    public function getUrl(Stock $stock, $name)
    {
        $query = "stock_id={$stock->id}";
        $keyword = StringHelper::getSlug($name);
        $controllers = 'stocks';
        $action = 'one';
        $id = $stock->id;
        $slug = UrlAlias::create($query, $keyword,$controllers, $action, $id);

        return $slug;
    }


    private function getClassList()
    {
        return [
            'brand' => Brand::class,
            'category' => Category::class,
            'product' => ProductStoreOption::class,
            'present' => ProductStoreOption::class,
            'customer' => Customer::class
        ];
    }

    private function getClassStockList()
    {
        return[
          'brand' => StockBrand::class,
          'category' => StockCategory::class,
          'product' => StockProduct::class,
          'present' => StockPresent::class,
          'promo' => StockPromo::class,
          'customer' => StockCustomer::class

        ];
    }


    private function getRowList()
    {
        return [
            'brand' => 'brand_id',
            'category' => 'category_id',
            'product' => 'product_id',
            'present' => 'product_id',
            'customer' => 'customer_id'
        ];
    }

    private function getSynchronizationRow()
    {
        return [
            'brand' => 'guid_group_price',
            'category' => 'guid',
            'product' => 'GUID_1C',
            'present' => 'GUID_1C',
            'customer' => 'type_id'
        ];
    }


}