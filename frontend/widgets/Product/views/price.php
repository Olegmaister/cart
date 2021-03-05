<?php

/* @var \frontend\services\ProductService $service*/
/* @var \common\entities\Products\Product $product*/
/* @var \frontend\components\ApiCurrency $currency**/

?>
<div class="product-card__prices">
    <!--если товара в распродаже-->
    <?php if($product['sale']) :?>
        <div class="product-card__price product-card__price--new<?= (!$product['stock_status']) ? ' gray' : '' ?>">
            <span class="product-card__price-currency--new"><?= $currency->getSimbol() ?></span>
            <span class="product-card__price-new js-product-new-price"><?= $currency->getPrice($product['price']) ?></span>
        </div>
        <!--если старая цена(old_price не равна 0)-->
        <?php if($product['price_old'] != 0):?>
            <div class="product-card__price product-card__price--old">
                <span class="product-card__price-currency--old"><?= $currency->getSimbol() ?></span>
                <span class="js-product-old-price"><?= $currency->getPrice($product['price_old']) ?></span>
            </div>
        <?php endif;?>
    <?php endif;?>

    <?php if(!$product['sale']) :?><!--если товар не состоит в распродаже-->
        <?php $discount = $service->getStockProduct($product); ?><!--получение возможной скидки по товару-->

        <?php
        if(!empty($discount)) { ?>

            <?php if($discount->isExist()) :?><!--если есть скидка-->
                <div class="product-card__price product-card__price--new<?= (!$product['stock_status']) ? ' gray' : '' ?>">
                    <span class="product-card__price-currency--new"><?= $currency->getSimbol() ?></span>
                    <span class="product-card__price-new js-product-new-price"><?= $currency->getPrice($discount->getDiscountPrice()) ?></span>
                </div>
            <!--old-->
                <div class="product-card__price product-card__price--old">
                    <span class="product-card__price-currency--old"><?= $currency->getSimbol() ?></span>
                    <span class="js-product-old-price"><?= $currency->getPrice($discount->getPrice()) ?></span>
                </div>
            <?php endif; ?>

            <?php if (!$discount->isExist()) : ?><!--если нет скидки-->
                <div class="product-card__price product-card__price--new<?= (!$product['stock_status']) ? ' gray' : '' ?>">
                    <span class="product-card__price-currency--new"><?= $currency->getSimbol() ?></span>
                    <span class="product-card__price-new js-product-new-price"><?= $currency->getPrice($discount->getPrice()) ?></span>
                </div>
                <div class="product-card__price product-card__price--old">
                    <span class="product-card__price-currency--old"></span>
                    <span class="js-product-old-price"></span>
                </div>
            <?php endif;?>
        <?php }?>

    <?php endif;?>
</div>

