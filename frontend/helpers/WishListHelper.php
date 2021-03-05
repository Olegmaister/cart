<?php

namespace frontend\helpers;

use common\entities\Products\Product;
use common\helpers\ProductHelper;
use frontend\models\WishList;
use frontend\repositories\ProductRepository;
use Yii;
use yii\db\Query;

class WishListHelper
{
   public const SHOW_LIMIT_COUNT = 9;

    /**
     * @param int $customerId
     * @param int $productId
     * @return bool
     */
    public function addProduct(int $customerId, int $productId): bool
    {
        $model = WishList::findOne([
            'customer_id' => $customerId,
            'product_id' => $productId,
        ]);

        if ($model) {
            return true;
        }

        $model = new WishList();
        $model->customer_id = $customerId;
        $model->product_id = $productId;

        return $model->save();
    }

    /**
     * @param int $customerId
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getProductsList(int $customerId, int $limit = self::SHOW_LIMIT_COUNT, int $offset = 0): array
    {
        $products = Product::find()
            ->leftJoin('wish_list wl', 'wl.product_id = product.product_id')
            ->where(['wl.customer_id' => $customerId])
            ->limit($limit)
            ->orderBy(['created_at' => SORT_DESC])
            ->groupBy('product.mpn')
            ->offset($offset)
            ->all();

        $mpn = array_column($products, 'mpn');
        $queryRelate = ProductRepository::getProductByMpnWishList($mpn);
        $relate = ProductHelper::getIndexColumn($queryRelate, 'mpn');

        return [
            'products' => $products,
            'relate' => $relate,
        ];
    }

    /**
     * @param int $customerId
     * @param int $productId
     * @return bool
     */
    public function isProductInWishList(int $customerId, int $productId): bool
    {
        return (bool)WishList::findOne([
            'customer_id' => $customerId,
            'product_id' => $productId,
        ]);
    }

    /**
     * @param int $customerId
     * @param bool $uniq
     * @return int
     */
    public function getProductCount(int $customerId, $uniq = false): int
    {
        $data = (new Query())
            ->select('id')
            ->from('wish_list')
            ->where(['customer_id' => $customerId]);

        if ($uniq) {
            $data->leftJoin('product', 'wish_list.product_id = product.product_id')
            ->groupBy('product.mpn');
        }

        return (int)$data->count();
    }

    /**
     * @param array $productsList
     * @param int $customerId
     * @return bool
     */
    public function deleteProductsList(array $productsList, int $customerId): bool
    {
        return (bool)WishList::deleteAll([
            'customer_id' => $customerId,
            'product_id' => $productsList,
        ]);
    }

    /**
     * @param int $customerId
     * @return bool
     */
    public function deleteAllProducts(int $customerId): bool
    {
        return (bool)WishList::deleteAll([
            'customer_id' => $customerId,
        ]);
    }


    /**
     * @param int $id
     * @return int
     * @throws \yii\db\Exception
     */
    public function getTotalCountForProduct(int $id): int
    {
        $sql = 'SELECT COUNT(id) FROM wish_list WHERE product_id = :ID';

        return (int)Yii::$app->db->createCommand($sql)
            ->bindValue('ID', $id)
            ->queryScalar();
    }
}
