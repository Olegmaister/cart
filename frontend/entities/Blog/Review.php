<?php
namespace frontend\entities\Blog;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class Review extends Model
{

    private $provider;
    private $count;
    private $page;

    const DISPLAY_ON_PAGE = 16;

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

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    public function showButton()
    {
        return $this->page * self::DISPLAY_ON_PAGE < $this->count;
    }



}
