<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;

/**@var \core\services\cart\Cart $cart */
/**@var \core\services\cart\CartItem $item */
/**@var \common\entities\Products\Product $product */

$discounts = $cart->getCost()->getDiscounts();
$currency = new ApiCurrency();
?>
<div class="wrapper-popup-cart">
    <div class="js-product-cart checkout-cart__item d-flex flex-column">
        <?php if ($cart->getItems()): ?>
            <?php foreach ($cart->getItems() as $item) : ?>
                <?php
                $product = $item->getProduct();
                //$productPresent = $item->getPresent()->getProduct();old
                $productPresent = [];
                $discountsProduct = $discounts[$product->product_id.$item->getOption()] ?? null;
                ?>
                <article class="cart-card js-cart-card">
                    <a href="<?= isset($product->url->keyword) ? LanguageHelper::langUrl($product->url->keyword) : '#' ?>"
                       target="_blank" class="cart-card__img-link">
                        <?php if($product->inSale()) :?>
                            <span class="cart-card__label"><?= Yii::t('app', 'sale') ?></span>
                        <?php endif;?>
                        <img loading="lazy" src="<?= ProductHelper::correctedImgPath($product->image) ?>" alt=""
                             class="cart-card__img">
                    </a>
                    <div class="cart-card__info">
                        <a href="<?= isset($product->url->keyword) ? LanguageHelper::langUrl($product->url->keyword) : '#' ?>"
                           target="_blank" class="cart-card__name title-h6"><?= $product->description['name'] ?></a>
                        <div class="cart-card__prices">
                            <!--если скидки на товар нет-->
                            <?php if (!$discountsProduct->getStock()) : ?>
                                <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price']) ?></span>
                            <?php endif; ?>
                            <!--если есть скидка на товар-->
                            <?php if ($discountsProduct->getStock()): ?>
                                <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($discountsProduct->getDiscountPrice()) ?>
                                        <span style="font-size: 8px">(-<?= $discountsProduct->getPercent() ?>%)</span>
                                    </span>
                                <span class="cart-card__price--old"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price']) ?></span>
                            <?php endif; ?>

                        </div>
                    </div>
                    <div class="cart-card__parameters">
                        <div class="cart-card__size"><?= $item->getOptionName() ?></div>
                        <img loading="lazy" src="<?= $item->getProductColorImage() ?>" class="cart-card__color" alt="">
                    </div>

                    <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                        <button type="button" class="handle-counter__minus counter-minus"><span>-</span></button>
                        <input data-product-id="<?= $product->product_id ?>"
                               data-option="<?= $item->getOption() ?>"
                               class="js-change-quantity-product-cart handle-counter__number"
                               type="text" value="<?= $item->getQuantity() ?>">
                        <button type="button" class="handle-counter__plus counter-plus"><span>+</span></button>
                    </div>

                    <i data-product-id="<?= $product->product_id ?>"
                       data-option="<?= $item->getOption() ?>"
                       class="js-remove-product-cart cart-card__delete" tabindex="0" title="<?= Yii::t('app', 'remove from list') ?>"></i>
                </article>


                <!--товар в подарок-->
                <?php $presents = $item->getPresent(); ?>

                <?php if(isset($presents)){?>
                    <?php foreach ($presents as $present){



                        $productPresent = $present->getProduct(); ?>

                        <article class="cart-card js-cart-card product-cart-presents">
                            <a href="<?= isset($productPresent->url->keyword) ? LanguageHelper::langUrl($productPresent->url->keyword) : '#' ?>" target="_blank" class="cart-card__img-link">
                                <img loading="lazy" src="<?= ProductHelper::correctedImgPath($productPresent->image) ?>" alt="<?=$productPresent->description->name?>" title="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="<?= isset($productPresent->url->keyword) ? LanguageHelper::langUrl($productPresent->url->keyword) : '#' ?>" target="_blank" class="cart-card__name title-h6"><?=$productPresent->description->name?></a>

                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 1</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size"><?=$present->getOptionName()?></div>
                                <img loading="lazy" src="<?=ProductHelper::getImageColor($productPresent->color)?>" class="cart-card__color" alt="color">
                            </div>

                            <div class="cart-card__handle-counter">
                                <?php if (true): ?>
                                    <div class="item-count"><?=$present->getQuantity()?> <?= Yii::t('app', 'pc.') ?></div>
                                <?php else: ?>
                                    <button type="button" class="handle-counter__minus counter-minus"><span>-</span></button>
                                    <input data-product-id="<?=$product->product_id?>"
                                           data-option="<?=$item->getOption()?>"
                                           class="js-change-quantity-product-cart handle-counter__number"
                                           type="text" value="<?=$present->getQuantity()?>">
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php }?>
                <?php }?>
                <!--/товар в подарок-->



            <?php endforeach; ?>
        <?php else: ?>
            <div class="title-h2 title--red text-center m-auto"><?= Yii::t('app', 'your basket is empty') ?></div>
        <?php endif; ?>

    </div>
    <?php
    $cost = $cart->getCost();
    ?>
    <!--items-->
    <?php if ($cart->getItems()): ?>
        <div class="cart-amount">
            <div class="cart-amount-col cart-amount-col--left cart-amount__price-box">
                <div class="cart-amount-col cart-amount-col-child cart-amount-col--left cart-amount-col-child--left">
                    <div class="cart-amount__txt"><?= Yii::t('app', 'sum') ?>:</div>
                </div>
                <div class="cart-amount-col cart-amount-col-child cart-amount-col--left cart-amount-col-child--right">
                    <div class="cart-amount__price">
                        <span><?= $currency->getCurrencySign() ?></span> <span class="js-cart-popup-cost-total"><?= $currency->getPrice($cost->getTotal()) + $currency->getPrice($cart->getPresentPrice()) ?></span>
                    </div>
                </div>
            </div>
            <div class="cart-amount-col cart-amount-col--right justify-content-end">
                <div class="cart-amount-col cart-amount-col-child-right cart-amount-col-child-right--left proceed-order">
                    <button class="btn btn--red btn--full btn--lg-l">
                        <a href="<?= LanguageHelper::langUrl('checkout/simplecheckout') ?>" class="btn__inner"><?= Yii::t('app', 'checkout') ?></a>
                    </button>
                </div>
                <div class="cart-amount-col cart-amount-col-child-right cart-amount-col-child-right--right">
                    <button class="btn btn--black btn--full btn--lg-l js-modal-close-cart">
                        <span class="btn__inner js-proceed-shopping" data-alt="<?= Yii::t('app', 'Apply changes') ?>"><?= Yii::t('app', 'continue shopping') ?></span>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
