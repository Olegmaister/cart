<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;

/* @var $cart \frontend\services\cart\Cart */

$discounts = $cart->getCost()->getDiscounts();
$currency = new ApiCurrency();
?>
<div class="js-wrapper-header-cart xxx header-ordering-col header-ordering-col_cart">
    <div class="header-ordering__icon header-ordering__icon_cart">
        <svg width="29" height="25" viewBox="0 0 29 25" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M7.68564 17.5686L6.17005 5.84314H27.2648L23.9817 17.5686H7.68564Z"
                  stroke-width="2"/>
            <path d="M7.72051 17.4706L5.52443 1H0.583252" stroke-width="2"/>
            <circle class="_circle" cx="11.0147" cy="21.8627" r="2.19608"/>
            <circle class="_circle" cx="20.897" cy="21.8627" r="2.19608"/>
        </svg>
        <span class="js-cart-quantity-items">
			<?php
			if (!$cart->getQuantity() == 0) {
				echo $cart->getQuantity();
			} ?>
		</span>
    </div>
    <div class="cart-m-popup">
        <div class="cart-m-popup-inner">

            <?php foreach ($cart->getItems() as $item) :
                $product = $item->getProduct();
                $discountsProduct = $discounts[$product->product_id.$item->getOption()] ?? null;
                ?>
				<div class="cart-m-popup-prod js-header-product-cart">
					<div class="cart-m-popup-prod-img">
                        <a href="<?= isset($product->url->keyword) ? LanguageHelper::langUrl($product->url->keyword) : '#' ?>">
                            <img width="50" src="<?= ProductHelper::correctedImgPath($product->image) ?>" alt="">
                        </a>

					</div>
					<div class="cart-m-popup-prod-center">
                        <a href="<?= isset($product->url->keyword) ? LanguageHelper::langUrl($product->url->keyword) : '#' ?>" target="_blank" class="cart-card__name title-h6"><?=$product->description->name?></a>
                        <div class="cart-card__prices">
                            <!--если скидки на товар нет-->
                            <?php if(!$discountsProduct->getStock()) :?>
                                <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price']) ?></span>
                            <?php endif;?>
                            <!--если есть скидка на товар-->
                            <?php if($discountsProduct->getStock()):?>
                                <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($discountsProduct->getDiscountPrice())?>
                                        <span style="font-size: 8px">(-<?=$discountsProduct->getPercent()?>%)</span>
                                    </span>
                                <span class="cart-card__price--old"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price'])?></span>
                            <?php endif;?>

                        </div>
					</div>
					<div data-product-id="<?=$product->product_id?>"
						 data-option="<?=$item->getOption()?>"
						 class="js-header-remove-product-cart cart-m-popup-prod__close"></div>
				</div>
            <?php endforeach;?>

        </div>
        <div class="cart-m-popup-but">
            <a href="<?= LanguageHelper::langUrl('checkout/simplecheckout') ?>" class="but but-red"><span><?= Yii::t('app', 'checkout') ?></span></a>
        </div>
    </div>
</div>
