<?php
/**
 * Created by PhpStorm.
 * User: vovam
 * Date: 10.12.2020
 * Time: 18:23
 */

namespace frontend\services\product;

use common\entities\Products\ProductDescription;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use common\services\mail\EmailSender;
use Yii;
use common\entities\Products\Product;
use common\models\StockWatch\StockWatch;
use yii\helpers\Html;

class StockWatchService
{
    /*
     * Проверка и рассылка уведомлений
     * Данный метод надо запускать из србытия  afterSave()
     *
     * Проверяем есть ли в наличии товар
     * Если он есть то проверяем есть ли неуведомленные пользователи
     * Если таковы есть то всем этим юзерам отправляем письмо
     * Еси отправилось нормально то помечаем статус 1 (Уведомлен)
     */
    public static function checkAndNotifyAllUsers($productId)
    {
        // есть ли в наличии товар
        if (self::checkAvailabilityProduct($productId)) {

            // Выбираем всех подписчиков по status=0 (не уведомлен) и product_id
            $subscribers = self::getSubscribers($productId);

            // Если есть пользователи неуведомленные то проходим цыклом и отправляем уведомление
            if ($subscribers) {

                $emailSender = new EmailSender();

                foreach ($subscribers as $user) {
                    Yii::$app->language = LanguageHelper::getLangById($user['language_id']);
                    $product = self::getProductDataByLang($productId, $user['language_id']);
                    $product['image'] = ProductHelper::correctedImgPath_228p($product['image']);
                    $prefix = ($user['language_id'] != 2) ? LanguageHelper::getPrefixById($user['language_id']) . '/' : '';
                    $product['link'] = Yii::$app->request->hostInfo . '/' . $prefix . $product['keyword'];
                    //$product['button'] = LanguageHelper::translateByLangId('app','Buy product', $user['language_id']);

                    // Отправляем письмо
                    $emailSender->sendAvailabilityProductEmail($product, $user['email'], $user['language_id']);

                    // Помечаем что отправили
                    $user->status = StockWatch::STATUS_ACTIVE;
                    $user->save();
                }
            }
        }
    }

    public static function setTrackingAvailability($postData)
    {
        if (isset($postData['email']) && isset($postData['product_id'])) {
            $stockWatch = StockWatch::findOne(['email' => $postData['email'], 'product_id' => $postData['product_id']]);
            if($stockWatch) {
                // отписываемся
                $stockWatch->status = StockWatch::STATUS_EXPECT;
                $stockWatch->delete();

                return [
                    'message' => Yii::t('big', 'You have canceled your stock notification subscription'),
                    'subscription' => false
                ];
            } else {
                // подписываемся
                $stockWatch = new StockWatch();
                $stockWatch->status = StockWatch::STATUS_EXPECT;
                $stockWatch->email = $postData['email'];
                $stockWatch->product_id = $postData['product_id'];
                $stockWatch->language_id = (new LanguageHelper())->getCurrentId();
                $stockWatch->save();

                return [
                    'message' => Yii::t('big', 'You have successfully subscribed to the product stock notifications'),
                    'subscription' => true
                ];
            }
        }

        return false;
    }

    public static function checkAvailabilityProduct($productId)
    {
        $product = Product::findOne(['product_id' => $productId]);
        if ($product !== null && $product->stock_status == 1) {
            return true;
        }

        return false;
    }

    public static function getSubscribers($productId)
    {
        return StockWatch::find()
            //->select('email, language_id')
            ->where(['product_id' => $productId, 'status' => 0])
            //->asArray()
            ->all();
    }

    public static function getAllSubscribers($email)
    {
        $subscribers = StockWatch::find()
            ->select('product_id, language_id')
            ->where(['email' => $email, 'status' => 0])
            ->asArray()
            ->all();

        if ($subscribers) {
            return $subscribers;
        }

        return [];
    }

    public static function getProductDataByLang($productId, $langId)
    {
        $product = Product::find()
            ->select('product.product_id, product.image, product.price, product.price_old, product_description.name, url_alias.keyword')
            ->leftJoin('product_description', 'product.product_id=product_description.product_id')
            ->leftJoin('url_alias', 'product.product_id=url_alias.id')
            ->where(['product.product_id' => $productId])
            ->andWhere(['product_description.language_id' => $langId])
            ->andWhere(['url_alias.controller' => 'products', 'action' => 'view'])
            ->asArray()
            ->one();

        return $product;
    }
}

