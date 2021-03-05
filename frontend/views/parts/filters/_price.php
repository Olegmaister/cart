<?php
use frontend\components\ApiCurrency;
$currency = new ApiCurrency();

// Если $get['price_max_val'] то конвертировать не надо
if (isset($get['price_max_val'])) {
    $min = isset($filtersData['minPriceVal']) ? $filtersData['minPriceVal'] : $filtersData['minPrice'];
    $max = isset($filtersData['maxPriceVal']) ? $filtersData['maxPriceVal'] : $filtersData['maxPrice'] + 1;
    $valMin = $filtersData['minPrice'];
    $valMax = $filtersData['maxPrice'] != $filtersData['minPrice'] ? $filtersData['maxPrice'] : $filtersData['maxPrice'];//+1
} else {
    $min = isset($filtersData['minPriceVal']) ? $currency->getPrice($filtersData['minPriceVal']) : $currency->getPrice($filtersData['minPrice']);
    $max = isset($filtersData['maxPriceVal']) ? $currency->getPrice($filtersData['maxPriceVal']) : $currency->getPrice($filtersData['maxPrice']) + 1;
    $valMin = $currency->getPrice($filtersData['minPrice']);
    $valMax = $filtersData['maxPrice'] != $filtersData['minPrice'] ? $currency->getPrice($filtersData['maxPrice']) : $currency->getPrice($filtersData['maxPrice']);//+1
}

$min = round($min); //floor($min)
$valMin = round($valMin); //round($valMin)
$valMax = ceil($valMax); //ceil($valMax)
$max = round($max);

/*
d($min);
d($valMin);
d($valMax);
dd($max);
*/

//$step = 1;
$step = ($filtersData['maxPrice'] == $filtersData['minPrice']) ? (int) 0 : 1;

?>
<div class="filter-price">
    <div class="filter-price__values">
        <div class="filter-price__number">
            <?= Yii::t('app', 'from') ?>
            <span class="js-filter-price-min"></span>
            <?= $currency->getSimbol() ?>
        </div>
        <div class="filter-price__number">
            <?= Yii::t('app', 'to') ?>
            <span class="js-filter-price-max"></span>
            <?= $currency->getSimbol() ?>
        </div>
    </div>
    <div class="range js-filter-price"
         data-value-min="<?= $valMin ?>"
         data-value-max="<?= $valMax ?>"
         data-step="<?= $step ?>"
         data-min="<?= $min ?>"
         data-max="<?= $max ?>"
    >
    </div>
</div>