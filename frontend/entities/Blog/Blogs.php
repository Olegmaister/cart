<?php
namespace frontend\entities\Blog;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class Blogs extends Model
{
    private $id;
    private $count;
    private $page;
    private $provider;

    const DISPLAY_ON_PAGE = 12;

    public function __construct(
        ActiveDataProvider $provider,
        int $id,
        int $count,
        int $page = 1,
        $config = []
    )
    {
        $this->id = $id;
        $this->count = $count;
        $this->page = $page;
        $this->provider = $provider;
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
    public function getId(): int
    {
        return $this->id;
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