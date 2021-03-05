<?php

namespace common\services;

use Yii;
use frontend\services\ProductService;
use frontend\repositories\ProductRepository;
use frontend\services\CategoriesService;
use common\helpers\LanguageHelper;
use frontend\services\BlogService;

class RedisService
{
    private $lang;
    private $langId;

    public function __construct()
    {
        $this->lang = Yii::$app->language;
        $this->langId = LanguageHelper::getCurrentId();
    }


    /*********************** Главная страница  **********************/

    // Получить данные для левого меню (каталог или категории)
    public static function getLeftMenuData()
    {
        $data = Yii::$app->redis->get('leftMenu_' . Yii::$app->language);
        if ($data) {
            return json_decode($data, true);
        } else {
            $categories = CategoriesService::getFullTreeSecondLevelCategories();
            Yii::$app->redis->set('leftMenu_' . Yii::$app->language, json_encode($categories));
            return $categories;
        }
    }

    public function getBrandsForHome()
    {
        if ($brandRedis = Yii::$app->redis->get('brandsForHome_' . $this->lang)) {
            return json_decode($brandRedis, true);
        } else {
            $brands = ProductRepository::getBrads($this->langId);
            Yii::$app->redis->set('brandsForHome_' . $this->lang, json_encode($brands));
            return $brands;
        }
    }

    public function getItemsGroupForHome()
    {
        if ($redis = Yii::$app->redis->get('itemsGroupForHome_' . $this->lang)) {
            return json_decode($redis, true);
        } else {
            $items = ProductService::getItemsForHome();
            Yii::$app->redis->set('itemsGroupForHome_' . $this->lang, json_encode($items));
            return $items;
        }
    }

    public function getVideoForHome()
    {
        if ($videoRedis = Yii::$app->redis->get('videoForHome')) {
            return json_decode($videoRedis, true);
        } else {
            // Сбрасываем при изменение, добавлении или удаление - ProductVideo
            $video = ProductRepository::getVideoByMainPage(); // теги + дата
            Yii::$app->redis->set('videoForHome', json_encode($video));
            return $video;
        }
    }

    public function getSliderByHomePage()
    {
        if ($sliderRedis = Yii::$app->redis->get('sliderForHome_' . $this->lang)) {
            return json_decode($sliderRedis, true);
        } else {
            // Сбрасываем при изменение, добавлении или удаление - Sliders
            $slider = ProductRepository::getSliderMain($this->langId);
            Yii::$app->redis->set('sliderForHome_' . $this->lang, json_encode($slider));
            return $slider;
        }
    }

    public function getSeoBlockByHomePage()
    {
        if ($seoBlockRedis = Yii::$app->redis->get('seoBlockForHome_' . $this->lang)) {
            return json_decode($seoBlockRedis, true);
        } else {
            $seoBlock = ProductRepository::getSeoBlock('page_home', $this->langId);
            Yii::$app->redis->set('seoBlockForHome_' . $this->lang, json_encode($seoBlock));
            return $seoBlock;
        }
    }

    public function getPhones()
    {
        if ($redis = Yii::$app->redis->get('settingsPhones')) {
            return json_decode($redis, true);
        } else {
            $settings = ProductRepository::getPhones();
            Yii::$app->redis->set('settingsPhones', json_encode($settings));
            return $settings;
        }
    }

    public function getSettings()
    {
        if ($redis = Yii::$app->redis->get('settings')) {
            return json_decode($redis, true);
        } else {
            $querySettings = ProductRepository::getSettingsByGroup(['sub_group' => 'main']);
            $settings = ProductService::getGroupedSettings($querySettings);
            Yii::$app->redis->set('settings', json_encode($settings));
            return $settings;
        }
    }

    public function getQuerySettings()
    {
        if ($redis = Yii::$app->redis->get('querySettings')) {
            return json_decode($redis, true);
        } else {
            $querySettings = ProductRepository::getSettingsByGroupArr(['sub_group' => 'main']);
            Yii::$app->redis->set('querySettings', json_encode($querySettings));
            return $querySettings;
        }
    }

    public function getBlogDataByHomePage()
    {
        if ($blogDataRedis = Yii::$app->redis->get('blogDataForHome_' . $this->lang)) {
            return json_decode($blogDataRedis, true);
        } else {
            $blogData = BlogService::getAllData($this->langId);
            Yii::$app->redis->set('blogDataForHome_' . $this->lang, json_encode($blogData));
            return $blogData;
        }
    }

    /*********************** Карточка товара  **********************/

    // Items группы для PRODUCT (для карточки товара)
    public function getItemsForProduct()
    {
        if ($redis = Yii::$app->redis->get('itemsGroupForProduct_' . $this->lang)) {
             return json_decode($redis, true);
        } else {
            $items = ProductService::getItemsForProduct();
            Yii::$app->redis->set('itemsGroupForProduct_' . $this->lang, json_encode($items));
            return $items;
        }
    }

    // Настойки (Оплата VISA, Курьерами Новой Почты) для PRODUCT
    public function getSettingsForProduct()
    {
        if ($redis = Yii::$app->redis->get('settingsForProduct_' . $this->lang)) {
            return json_decode($redis, true);
        } else {
            $settings = ProductRepository::getSettingsByGroup(['sub_group' => 'product']);
            $settingsTranslated = ProductService::getTranslatedValues($settings);
            Yii::$app->redis->set('settingsForProduct_' . $this->lang, json_encode($settingsTranslated));
            return $settingsTranslated;
        }
    }
}