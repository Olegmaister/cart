<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;
use \common\entities\Products\Product;

/* @var $cart \core\services\cart\Cart */
/** @var int $deliveryCost*/
/** @var int $totalAmount*/

$discounts = $cart->getCost($promo)->getDiscounts();
$currency = new ApiCurrency();

?>
<div class="sticky-cart">
    <div class="checkout-cart">
        <div class="d-flex align-items-center mb-3">
            <p class="title-h3 title--black2 mb-0 mr-auto"><?= Yii::t('app', 'your order') ?></p>
            <a href="#" class="js-edit-cart px-3 ttu-link"><?= Yii::t('app', 'edit') ?></a>
        </div>
        <div class="checkout-cart__item js-product-cart">
            <?php foreach ($cart->getItems() as $item) :?>
                <?php
                $product = $item->getProduct();
                $discountsProduct = $discounts[$product->product_id.$item->getOption()] ??  null; ?>

                <article class="cart-card js-cart-card">
                    <a href="<?= isset($product->url->keyword) ? LanguageHelper::langUrl($product->url->keyword) : '#' ?>" target="_blank" class="cart-card__img-link">
                        <?php if($product->inSale()) : ?>
                            <span class="cart-card__label"><?= Yii::t('app', 'sale') ?></span>
                        <?php endif;?>
                        <img loading="lazy" src="<?= ProductHelper::correctedImgPath($product->image) ?>" alt="<?=$product->description['name']?>" title="<?=$product->description['name']?> - Prof1group" class="cart-card__img">
                    </a>
                    <div class="cart-card__info">
                        <a href="<?= isset($product->url->keyword) ? LanguageHelper::langUrl($product->url->keyword) : '#' ?>" target="_blank" class="cart-card__name title-h6"><?=$product->description['name']?></a>

                        <div class="cart-card__prices">
                            <!--если скидки на товар нет и товар не распродаже-->
                            <?php if(!$discountsProduct->getStock() && $product->sale != Product::SALE) :?>
                                <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price']) ?></span>
                            <?php endif;?>

                            <!--если скидки на товар нет -->
                            <?php if($product->sale == Product::SALE) :?>
                                <span class="cart-card__price title-h4 title--red"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price']) ?></span>
                                <span class="cart-card__price--old"><?= $currency->getCurrencySign() ?> <?= $currency->getPrice($product['price_old'])?></span>
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
                    <div class="cart-card__parameters">
                        <div class="cart-card__size"><?=$item->getOptionName()?></div>
                        <img loading="lazy" src="<?=$item->getProductColorImage()?>" class="cart-card__color" alt="color">
                    </div>

                    <div class="cart-card__handle-counter">
                        <?php if (true): ?>
                            <div class="item-count"><?=$item->getQuantity()?> <?= Yii::t('app', 'pc.') ?></div>
                        <?php else: ?>
                            <button type="button" class="handle-counter__minus counter-minus"><span>-</span></button>
                            <input data-product-id="<?=$product->product_id?>"
                                   data-option="<?=$item->getOption()?>"
                                   class="js-change-quantity-product-cart handle-counter__number"
                                   type="text" value="<?=$item->getQuantity()?>">
                            <button type="button" class="handle-counter__plus counter-plus"><span>+</span></button>

                            <i data-product-id="<?=$product->product_id?>"
                               data-option="<?=$item->getOption()?>"
                               class="js-remove-product-cart cart-card__delete" tabindex="0" title="<?= Yii::t('app', 'remove from list') ?>"></i>
                        <?php endif; ?>
                    </div>
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



            <?php endforeach;?>
        </div>
    </div>
    <div class="checkout-promo promo-form">
        <div class="promo-form__field">
            <input type="text" name="promo-code" value="<?=$promoToken?>" class="js-promo-data-input promo-form__input" placeholder="<?= Yii::t('app', 'Enter promo code') ?>">
        </div>
        <button type="button" class="js-promo-apply promo-form__button btn btn--primary btn--primary-black">
            <span class="btn__inner title-h4"><?= Yii::t('app', 'to apply') ?></span>
        </button>
    </div>
    <span class="js-promo-error"></span>
    <div class="checkout-total-price">
        <div class="checkout-total-price__discount checkout-total-price__col">
            <?php
            //получение скидки (сумма скидки)
            $discountMoney = $currency->getPrice($cart->getCost($promo)->getDiscount());

            //получение скидки (%)
            $discountPercent = $cart->getCost($promo)->getDiscountPercent($discountMoney);
            ?>
            <span class="title-h3 title--black"><?= Yii::t('app', 'discount') ?>:</span>


            <span class="title-h3 title--red">
                    <span class="js-discount-percent">

					</span>
						<?php
                        if ($discountMoney) {
                            echo "<span class='title-h5'>{$currency->getCurrencySign()}</span><span class='js-discount-money'> $discountMoney</span>";
                        }
                        ?>
					</span>
        </div>

        <div class="checkout-total-price__delivery checkout-total-price__col">
            <span class="title-h3 title--black"><?= Yii::t('app', 'delivery') ?>: </span>
            <span class="title-h3 title--red">

                    <?php if($deliveryCost):?>
                        <span class="title-h5 js-currency"><?= $currency->getCurrencySign() ?></span>
                    <?php else:?>
                        <span class="title-h5 js-currency"></span>
                    <?php endif;?>

					<span class="js-order-cart-delivery-cost"><?=$deliveryCost?></span>
				</span>
        </div>
        <?php
        $cost = $cart->getCost($promo);
        $discount = $cart->getCost($promo)->getDiscounts();
        ?>
        <div class="checkout-total-price__sum checkout-total-price__col">
            <span class="title-h3 title--black"><?= Yii::t('app', 'sum') ?>: </span>
            <span class="title-h3 title--red">
                    <span class="title-h5"><?= $currency->getCurrencySign() ?></span>
                        <span data-cost="<?=$currency->getPrice($cost->getTotal() + $cart->getPresentPrice())?>" class="js-cart-popup-cost-total title--red title-h3">
                            <?= $currency->getPrice($totalAmount + $cart->getPresentPrice()) ?>
                        </span>
                </span>
        </div>
    </div>
</div>
<div
    data-weight="<?=$cart->getWeight()?>"
    data-cost="<?=$currency->getPrice($cost->getTotal() + $cart->getPresentPrice())?>"
    class="js-order-info-data">
</div>