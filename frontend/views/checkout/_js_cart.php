<?php
/* @var $cart \core\services\cart\Cart */

use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;

$discounts = $cart->getCost($promo)->getDiscounts();
$currency = new ApiCurrency();
?>

<div class="sticky-cart">
    <div class="checkout-cart">
        <p class="checkout-cart__title title-h3 title--black2"><?= Yii::t('app', 'your order') ?></p>
        <div class="checkout-cart__item">
            <?php foreach ($cart->getItems() as $item) :?>
                <?php
                $product = $item->getProduct();
                $discountsProduct = $discounts[$product->product_id] ??  null;

                ?>
                <article class="cart-card">
                    <a href="#" class="cart-card__img-link">
                        <?php if($product->inSale()) :?>
                            <span class="cart-card__label"><?= Yii::t('app', 'sale') ?></span>
                        <?php endif;?>
                        <img loading="lazy" src="<?= ProductHelper::correctedImgPath($product->image) ?>" alt="" class="cart-card__img">
                    </a>
                    <div class="cart-card__info">
                        <a href="#" class="cart-card__name title-h6"><?=$product->description['name']?></a>
                        <div class="cart-card__prices">
                            <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price']) ?></span>
                        </div>
                    </div>
                    <div class="cart-card__parameters">
                        <div class="cart-card__size"><?=$item->getOptionName()?></div>
                        <img loading="lazy" src="<?=$item->getProductColorImage()?>" class="cart-card__color" alt="">
                    </div>
                    <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                        <button type="button" data-product-id="<?=$product->product_id?>" class="handle-counter__minus counter-minus">
                            <span>-</span>
                        </button>

                        <input
                                data-product-id="<?=$product->product_id?>"
                                data-option="<?=$item->getOption()?>"
                                class="handle-counter__number js-change-quantity-product-cart" type="text" value="<?=$item->getQuantity()?>">

                        <button type="button" class="handle-counter__plus counter-plus">
                            <span>+</span>
                        </button>
                    </div>
                    <i
                            data-product-id="<?=$product->product_id?>"
                            data-option="<?=$item->getOption()?>"
                            class="js-remove-product-cart cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                </article>
            <?php endforeach;?>
        </div>
    </div>
    <div class="checkout-promo promo-form">
        <div class="promo-form__field">
            <input type="text" name="promo-code" value="" class="js-promo-data-input promo-form__input" placeholder="Ввести промокод">
        </div>
        <button type="button" class="js-promo-apply promo-form__button btn btn--primary btn--primary-red">
            <span class="btn__inner title-h4">ипользовать</span>
        </button>
    </div>
    <div class="checkout-total-price">
        <div class="checkout-total-price__discount checkout-total-price__col">
            <?php
            //получение скидки (сумма скидки)
            $discountMoney = $cart->getCost($promo)->getDiscount();

            //получение скидки (%)
            $discountPercent = $cart->getCost($promo)->getDiscountPercent($discountMoney);
            ?>
            <span class="title-h3 title--black"><?= Yii::t('app', 'discount') ?>:</span>
            <?php
            if ( $discountPercent && $discountMoney ) : ?>
                <span class="title-h3 title--red">
                    <span class="js-discount-percent">
                       <?= '-' . $discountPercent?></span>%
                    <span class="js-discount-money">  <span class='title-h5'><?= $currency->getCurrencySign() ?></span><?=$discountMoney?></span></span>
            <?php endif;?>
        </div>
        <div class="checkout-total-price__delivery checkout-total-price__col">
            <span class="title-h3 title--black"><?= Yii::t('app', 'delivery') ?>: </span>
            <span class="js-order-cart-delivery-cost title-h3 title--red"><span class="title-h5"><?= $currency->getCurrencySign() ?></span><span class="js-order-delivery-cost"></span></span>
        </div>
        <?php
        $cost = $cart->getCost($promo);
        $discount = $cart->getCost($promo)->getDiscounts();
        ?>
        <div class="checkout-total-price__sum checkout-total-price__col">
            <span class="title-h3 title--black"><?= Yii::t('app', 'sum') ?>: </span>
            <span class="title-h3 title--red">
            <span class="title-h5"><?= $currency->getCurrencySign() ?></span>
            <span class="js-cart-popup-cost-total title--red title-h3"><?= $currency->getPrice($cost->getTotal()) ?></span>
        </span>
        </div>
    </div>
</div>
<div
        data-weight="<?=$cart->getWeight()?>"
        data-cost="<?=$cost->getTotal()?>"
        class="js-order-info-data">

</div>
