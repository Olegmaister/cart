<?php

use common\helpers\ProductHelper;
use common\helpers\LanguageHelper;

/**@var \frontend\services\ProductService $productService */

/*
	Под удаление
	Перенес все в  _items-common
*/


?>

<section class="product-card__body">
    <section class="product-card__img-slider js-product-card-img-slider <?= isset($className) ? $className : '' ?>">
        <?php foreach ($itemsCommon as $relate): ?>
            <?php
            $discount = null;
            $discount = $productService->getStockProduct($relate);

            if ($discount->isExist()) {
                $price = $currency->getPrice($discount->getDiscountPrice());
                $old_price = $currency->getPrice($discount->getPrice());
            } elseif (!$discount->isExist()) {
                $price = $currency->getPrice($discount->getPrice());
                $old_price = 0;
            }
            ?>
            <a class="product-card__img-link <?= isset($relate->favorite) ? 'is-favorite-selected' : '' ?> <?=
            isset($relate->compare) ? 'is-compare-selected' : '' ?>"
               data-product-id="<?= $relate->product_id ?>"
               data-product-name="<?= isset($relate->description->name) ? $relate->description->name : '' ?>"
               data-product-price="<?= $price ?>"
               data-product-old-price="<?= $old_price ?>"
               data-product-label='<?= ProductHelper::checkGroupProduct($relate, true) ?>'
               data-sizes='<?= ProductHelper::getSizesJson($relate->sizes) ?>'

               href="<?= isset($relate->url->keyword) ? LanguageHelper::langUrl($relate->url->keyword) : '#' ?>">
                <img data-lazy="<?= ProductHelper::correctedImgPath($relate->image) ?>"
                     title="<?= isset($relate->description) ? $relate->description->name : '' ?> - Prof1group"
                     alt="<?= isset($relate->description) ? $relate->description->name : '' ?>"
                     class="product-card__img">
            </a>
        <?php endforeach ?>
    </section>
    <section
            class="product-card__color-slider js-product-card-color-slider <?= isset($className) ? $className . '_c' : '' ?>">
        <?php if (isset($itemsCommon[1])): ?>
            <?php foreach ($itemsCommon as $relate): ?>
                <article class="product-card__color js-product-card-color">
                    <img data-product-id="<?= $relate->product_id ?>"
                         data-lazy="/images/colors/<?= $relate->colorName['image'] ?>"
                         title="P1G"
                         alt="P1G"
                         class="product-card__color-img">
                </article>
            <?php endforeach ?>
        <?php endif ?>
    </section>
</section>
