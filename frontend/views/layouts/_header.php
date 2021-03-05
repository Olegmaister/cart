<?php

use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;
use yii\helpers\Html;

$langPrefix = strstr(Yii::$app->language, '-', true);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
      lang="<?= Yii::$app->language ?>"
      data-currency="<?= (new ApiCurrency())->getCurrencySign() ?>"
      data-form="<?= md5('prof' . date('Y-m')) ?>"
      data-lang="<?= $langPrefix=='ru' ? '' : $langPrefix ?>"
>
<head>

    <!-- Закрываем от идексации -->
    <meta name="robots" content="noindex, nofollow">

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
    <meta charset="<?= Yii::$app->charset ?>">
    <?php $this->registerCsrfMetaTags() ?>

    <!-- Тайтлы не заданы поставил дефолтные по урл страницы!!! -->
    <?php $page = (Yii::$app->request->get('page')) ? ' - '.Yii::t('app', 'page').' '.Yii::$app->request->get('page') : '' ?>
    <?php $title = ($this->title) ? $this->title : 'PROF1GROUP ' . Yii::$app->request->pathInfo ?>


    <title><?= Html::encode($title . $page)  ?></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700&subset=latin,latin-ext,cyrillic,cyrillic-ext&display=swap' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,700&display=swap" rel="stylesheet">

    <?= $this->render('common/__header_schema_org') ?>

    <?= ProductHelper::checkCanonical($this->context) ?>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmrQBiFOqtN9GPp2fn9xhc4CsCaN7vXiI&language=<?= Yii::$app->language === 'ua-UA' ? 'uk' : explode('-', Yii::$app->language)[0] ?>">
    </script>
    <?php if (isset($youtube)): ?>
        <script src="https://www.youtube.com/iframe_api" defer></script>
    <?php endif ?>
    <!--[if lt IE 10]>
    <script>
        window.open('https://browser-update.org/uk/update-browser.html', '_self');
    </script>
    <![endif]-->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G6EM9PH1ZP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-G6EM9PH1ZP');
    </script>

    <?php $this->head() ?>
</head>