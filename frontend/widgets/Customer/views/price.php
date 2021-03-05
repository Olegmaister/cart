<?php
/**@var OrderItemOutputPrice $orderItem */

use frontend\components\ApiCurrency;
use frontend\services\product\OrderItemOutputPrice;

$currency = new ApiCurrency();
?>
<!--если существует скидка на товар-->
<?php if ($orderItem->isExist()) : ?>
    <div class="c-table-col">
        <div class="c-table-col__txt c-table-col__txt--price d-block">
            <div class="text-nowrap"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($orderItem->getPrice()) ?><small class="text-dark ml-1">(<?= $orderItem->getQuantity() ?><?= Yii::t('app', 'pc.') ?>)</small></div>
            <span class="product-card__price product-card__price--old m-0"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($orderItem->getOriginPrice()) ?></span>
        </div>
    </div>
<?php else: ?>
    <!--если скидки нет-->
    <div class="c-table-col">
        <span class="c-table-col__txt c-table-col__txt--price d-inline-block">
            <?= $currency->getCurrencySign() ?> <?= $currency->getPrice($orderItem->getOriginPrice()) ?><small class="text-dark ml-1">(<?= $orderItem->getQuantity() ?><?= Yii::t('app', 'pc.') ?>)</small>
        </span>
    </div>
<?php endif; ?>
