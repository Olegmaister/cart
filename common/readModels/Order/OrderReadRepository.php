<?php
namespace common\readModels\Order;

use common\entities\Order;
use frontend\entities\Blog\Blogs;
use frontend\entities\Order\OrderProvider;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class OrderReadRepository
{

    private $count;

    /*
     * получение всех заказов пользователя
     */
    public function getAllByOrders($customerId, $page = 1)
    {

        //параметр для перехода на следующую страницу
        //передаем его через js
        //по умолчанию 1
        $page = (int)\Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;

        //формирование запроса
        $query =  Order::find()
            ->where(['customer_id' => $customerId])
            ->with(['items.product.description'])
            ->orderBy(['id' => SORT_DESC]);

        //получение общего кол-ва записей в таблице
        $this->getCount($query);

        //формирование объекта
        return new OrderProvider(
            //получение DataProvider
            $this->getProvider($query),
            $this->count,
            $page
        );
    }


    //получение кол-ва записей в таблице
    //по текущему запросу
    private function getCount(ActiveQuery $query)
    {
        $this->count = $query->count();
    }

    //формирование DataProvider
    private function getProvider($query) : ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Order::DISPLAY_ON_PAGE,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],

        ]);
    }
}