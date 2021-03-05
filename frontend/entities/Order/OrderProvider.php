<?php
namespace frontend\entities\Order;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\entities\Order;

class OrderProvider extends Model
{
    private $count;
    private $page;
    private $provider;

    const NEXT_PAGE = 1;

    public function __construct(
        ActiveDataProvider $provider,
        int $count,
        int $page,
        $config = []
    )
    {
        $this->provider = $provider;
        $this->count = $count;
        $this->page = $page;
        parent::__construct($config);

    }

    /**
     * @return ActiveDataProvider
     */
    public function getProvider(): ActiveDataProvider
    {
        return $this->provider;
    }

    //общее число записей
    public function getCount(): int
    {
        return $this->count;
    }

    //показывать/скрывать кнопку 'показать еще'
    public function showButton()
    {
        return $this->page * Order::DISPLAY_ON_PAGE < $this->count;
    }

    //получение следующей страницы
    public function getPage(): int
    {
        return $this->page + self::NEXT_PAGE;
    }
}