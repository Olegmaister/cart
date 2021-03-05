<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;

/**@var \core\services\cart\CartItem $item */
/**@var \common\entities\Products\Product $product */
/**@var \core\services\cart\Cart $cart */

$discounts = $cart->getCost()->getDiscounts();
$currency = new ApiCurrency();
?>
<div class="js-product-cart checkout-cart__item">
	<?php foreach ($cart->getItems() as $item) : ?>
			<?php
			$product = $item->getProduct();
			$discountsProduct = $discounts[$product->product_id.$item->getOption()] ??  null;

			$modification = null;

			 ?>

			<article class="cart-card js-cart-card">
				<a href="<?= isset($product->url->keyword) ? LanguageHelper::langUrl($product->url->keyword) : '#' ?>" class="cart-card__img-link">
                    <?php if($product->inSale()) : ?>
                        <span class="cart-card__label"><?= Yii::t('app', 'sale') ?></span>
                    <?php endif;?>
                    <img loading="lazy" src="<?=ProductHelper::correctedImgPath($product->image) ?>" alt="" class="cart-card__img">
				</a>
				<div class="cart-card__info">
                    <a href="<?= isset($product->url->keyword) ? LanguageHelper::langUrl($product->url->keyword) : '#' ?>" target="_blank" class="cart-card__name title-h6"><?=$product->description->name?></a>
                    <div class="cart-card__prices">
                        <!--если скидки на товар нет-->
                        <?php if(!$discountsProduct->getStock()) :?>
                            <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price'])?></span>
                        <?php endif;?>
                        <!--если есть скидка на товар-->
                        <?php if($discountsProduct->getStock()):?>
                            <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($discountsProduct->getDiscountPrice())?>
                                        <span style="font-size: 8px">(-<?= $discountsProduct->getPercent() ?>%)</span>
                                    </span>
                            <span class="cart-card__price--old"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price']) ?></span>
                        <?php endif;?>
                    </div>
				</div>
				<div class="cart-card__parameters">
					<div class="cart-card__size"><?=$item->getOptionName()?></div>
					<img loading="lazy" src="<?=$item->getProductColorImage()?>" class="cart-card__color" alt="">
				</div>


				<div class="cart-card__handle-counter handle-counter" data-handle-counter>
					<button type="button" class="handle-counter__minus counter-minus"><span>-</span></button>
					<input
                        data-product-id="<?=$product->product_id?>"
                        data-option="<?=$item->getOption()?>"
                        class="js-change-quantity-product-cart handle-counter__number" type="text" value="<?=$item->getQuantity()?>">
					<button type="button" class="handle-counter__plus counter-plus"><span>+</span></button>
				</div>

				<i
                    data-product-id="<?=$product->product_id?>"
                    data-option="<?=$item->getOption()?>"
                    class="js-remove-product-cart cart-card__delete" tabindex="0" title="Удалить из списка"></i>
            </article>

		<?php endforeach?>
</div>


<?php
    $cost = $cart->getCost();
?>

<!--items-->
<div class="cart-amount">
    <div class="cart-amount-col cart-amount-col--left cart-amount__price-box">
        <div class="cart-amount-col cart-amount-col-child cart-amount-col--left cart-amount-col-child--left">
            <div class="cart-amount__txt"><?= Yii::t('app', 'sum') ?>:</div>
        </div>
        <div class="cart-amount-col cart-amount-col-child cart-amount-col--left cart-amount-col-child--right">
            <div class="cart-amount__price">
                <span><?= $currency->getCurrencySign() ?></span> <span class="js-cart-popup-cost-total"><?= $currency->getPrice($cost->getTotal())?></span>
            </div>
        </div>
    </div>
    <div class="cart-amount-col cart-amount-col--right">
        <div class="cart-amount-col cart-amount-col-child-right cart-amount-col-child-right--left">
            <button class="btn btn--red btn--full btn--lg-l">
                <a href="<?= LanguageHelper::langUrl('checkout/simplecheckout') ?>" class="btn__inner"><?= Yii::t('app', 'checkout') ?></a>
            </button>
        </div>
        <div class="cart-amount-col cart-amount-col-child-right cart-amount-col-child-right--right">
            <button class="btn btn--black btn--full btn--lg-l js-modal-close-cart">
                <span class="btn__inner"><?= Yii::t('app', 'continue shopping') ?></span>
            </button>
        </div>
    </div>
</div>