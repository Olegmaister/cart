<?php

$this->title = $title;

$lang = Yii::$app->language === 'ru' ? 'ru_RU' : 'uk_UA';
$langOther = Yii::$app->language === 'ru' ? 'uk_UA' : 'ru_RU';
Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => 'PROF1Group']);
Yii::$app->view->registerMetaTag(['property' => 'og:locale', 'content' => $lang]);
Yii::$app->view->registerMetaTag(['property' => 'og:locale:alternate', 'content' => $langOther]);
Yii::$app->view->registerMetaTag(['property' => 'og:type', 'content' => isset($type) ? $type : 'website']);
Yii::$app->view->registerMetaTag(['property' => 'og:title', 'content' => $title]);
//Yii::$app->view->registerMetaTag(['property' => 'twitter:title', 'content' => $title]);
//Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => '']);
//Yii::$app->view->registerMetaTag(['property' => 'og:site_name', 'content' => '']);

if (!empty($description)) {
    Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $description]);
    Yii::$app->view->registerMetaTag(['property' => 'og:description', 'content' => $description]);
    //Yii::$app->view->registerMetaTag(['property' => 'twitter:description', 'content' => $description]);
}

if (!empty($keywords)) {
    Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
}

if (isset($canonical) && !empty($canonical)) {
    Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => $canonical]);
}

if (isset($url) && !empty($url)) {
    Yii::$app->view->registerMetaTag(['property' => 'og:url', 'content' => $url]);
}

if (isset($price) && !empty($price)) {
    Yii::$app->view->registerMetaTag(['property' => 'product:price:currency', 'content' => 'UAH']);
    Yii::$app->view->registerMetaTag(['property' => 'product:price:amount', 'content' => $price]);
}

Yii::$app->view->registerMetaTag([
    'name' => 'robots', 'content' => (isset($robots) && !empty($robots)) ? $robots : 'all',
]);

if (!empty($image)) {
    Yii::$app->view->registerMetaTag(['name' => 'image', 'content' => $image]);
    Yii::$app->view->registerMetaTag(['name' => 'og:image', 'content' => $image]);
    Yii::$app->view->registerMetaTag(['property' => 'og:image:width', 'content' => isset($width) ? $width : '160']);
    Yii::$app->view->registerMetaTag(['property' => 'og:image:height', 'content' => isset($height) ? $height : '200']);
    //Yii::$app->view->registerMetaTag(['property' => 'og:image:secure_url', 'content' => $image]);
    //Yii::$app->view->registerMetaTag(['property' => 'twitter:card', 'content' => $image]);
    //Yii::$app->view->registerMetaTag(['property' => 'twitter:image', 'content' => $image]);
}
