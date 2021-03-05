<?php

namespace core\services\cart\storage;

use common\entities\CartItemPresent;
use common\entities\Products\Product;
use common\repositories\CartItemRepository;
use core\services\cart\CartItem;
use common\entities\CartItem as EntitiesCartItem;
use core\services\cart\PresentItem;
use yii\db\Connection;
use yii\db\Query;

class DbStorage implements StorageInterface
{
    private $customerId;
    private $db;
    private $key;
    private $repository;

    public function __construct(
        $customerId,
        Connection $db,
        $key,
        CartItemRepository $repository
    )
    {
        $this->customerId = $customerId;
        $this->db = $db;
        $this->key = $key;
        $this->repository = $repository;
    }

    public function load(): array
    {
        //are there any products in the session
        if($cartSession = \Yii::$app->session->get($this->key)){
            $this->saveSessionCart($cartSession);
            \Yii::$app->session->remove($this->key);
        }

        $rows = \common\entities\CartItem::find()
            ->where(['customer_id' => $this->customerId])
            ->with('presents')
            ->asArray()
            ->all();

        return array_map(function (array $row) {
            /** @var Product $product */
            if ($product = Product::find()->active()
                ->with('categoryId')
                ->andWhere(['product_id' => $row['product_id']])->one()) {

                $optionName = null;
                $productColorImage = null;

                $productPresent = PresentItem::emptyBlank();



                $resArrayPresents = [];
                foreach ($row['presents'] as $itemPresent) {


                    $productPresent = $this->getByIdCartPresent($itemPresent['product_id']);

                    $present = PresentItem::create(
                        $itemPresent['product_id'],
                        $itemPresent['option'],
                        $itemPresent['option_name'],
                        $productPresent,
                        $itemPresent['quantity']
                    );

                    $resArrayPresents[] = $present;
                }

                return new CartItem(
                    $product,
                    $row['quantity'],
                    $row['option'],
                    $row['option_name'],
                    $row['product_color_image']
                );
            }
            return false;
        }, $rows);

    }

    public function save(array $items): void
    {

        $this->db->createCommand()->delete('{{%cart_items}}', [
        'customer_id' => $this->customerId,
        ])->execute();

        /* @var CartItem $item**/
        foreach ($items as $item) {
            $cartItem = \common\entities\CartItem::create($item, $this->customerId);
            $cartItem->save();
            $this->saveItemPresent($item->getPresent(),$cartItem->cart_id);
        }

    }
    public function saveItemPresent($presents, int $cartId)
    {
        if(empty($presents))
            return false;
        foreach ($presents as $present) {
            $cartItemPresent = CartItemPresent::create($present, $cartId);
            $cartItemPresent->save();
        }
    }

    public function saveSessionCart(array $items)
    {

        /**@var CartItem $item*/
        foreach ($items as $item) {
            /**@var \common\entities\CartItem $cartItem*/
            if($cartItem = $this->repository->getById($item->getId(),$this->customerId)){
                $cartItem->edit($item->getQuantity());
                $this->repository->save($cartItem);
            }else{
                $cartItem = EntitiesCartItem::create($item,$this->customerId);

                $this->repository->save($cartItem);
            }
        }

    }

    public function getByIdCartPresent($productId, $languageId = 2)
    {
        return Product::find()
            ->select(['product_id','image','color'])
            ->where(['product.product_id' => $productId])
            ->with(['url'],['description' => function($q){
                $q->where(['language_id' => \Yii::$app->language]);
                $q->select(['name']);
            }])
            ->one();
    }





}
