<?php

namespace core\services\cart\storage;

use Yii;


class SessionStorage implements StorageInterface
{
    private $key;
    private $session;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function load(): array
    {
        return Yii::$app->session->get($this->key, []);
    }

    public function save(array $items): void
    {
        Yii::$app->session->set($this->key, $items);
    }
} 