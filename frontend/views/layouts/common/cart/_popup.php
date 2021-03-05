<?php
use frontend\widgets\CartWidget;
?>
<div class="modal modal--cart">
    <div class="modal-content">
        <span class="modal__close modal__close--cart js-modal-close-cart"></span>
        <div class="modal__title"><?= Yii::t('app', 'basket') ?></div>

        <?php echo CartWidget::widget()?>
<?php /*
        <!--AMOUNT-->
<!--        <div class="cart-promo">-->
<!--            <div class="cart-promo-head js-toggle-other-slide">-->
<!--                <div class="cart-promo__close"></div>-->
<!--                <div class="cart-promo-head__link">-->
<!--                    <div class="link-line-dotted link-line-dotted--red">использовать промокод</div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="cart-promo-content">-->
<!--                <div class="subscribe-form subscribe-form--promo">-->
<!--                    <div class="subscribe-form-field">-->
<!--                        <input type="text" value="" placeholder="Ввести промокод" class="subscribe-form-input subscribe-form-input--red field_effect">-->
<!--                    </div>-->
<!--                    <div class="subscribe-form-but">-->
<!--                        <button class="btn btn--full btn--red">-->
<!--                            <span class="btn__inner">ипользовать</span>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
*/ ?>
    </div>
    <!--MODAL CONTENT-->
</div>
