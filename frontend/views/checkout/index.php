<?php

/* @var $this yii\web\View */
/* @var $cart \core\services\cart\Cart */

/* @var $model \frontend\forms\order\OrderForm */
/* @var $user bool */

/* @var $phone string */

use common\entities\Stores\Store;
use common\helpers\LanguageHelper;
use frontend\components\ApiCurrency;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Checkout';

$classJs = 'hidden';

$storeCityList = Store::getStoreCityList();
$storeList = Store::getStoreList();
$currency = new ApiCurrency();
?>

    <div data-auth="<?= $user ?>" data-phone="<?= $phone ?>" class="js-order-user-auth"></div>
<?php $form = ActiveForm::begin([
    'id' => 'js-checkout-form',
    'enableClientValidation' => true,
]) ?>

    <section class="pg-wrapper checkout">
        <nav class="breadcrumbs">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                        <span itemprop="name" content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'ordering') ?></span>
                </li>
            </ul>
        </nav>

        <h1 class="checkout-title title-h2 title--black"><?= Yii::t('app', 'ordering') ?></h1>

        <section class="row">
            <!--Корзина-->
            <?php echo $this->render('common/_cart', ['cart' => $cart]) ?>
            <!-- /Корзина-->

            <!--Формы-->
            <article class="col-lg-6">

                <!--Регистрация обычная-->
                <?php echo $this->render('common/_client') ?>
                <!--/Регистрация обычная-->

                <!--include form payer and recipient-->
                <?php echo $this->render('common/_payer_recipient',
                    [
                        'model' => $model,
                        'form' => $form,
                        'settings' => $settings
                    ]) ?>
                <!--/include form payer and recipient-->
                <?= $form->field($model, 'cost')->hiddenInput() ?>
                <!--Отправка зарубеж - получаем данные-->
                <section class="checkout-abroad js-show-abroad">
                    <p class="checkout-abroad__title title-h3 title--black"><?= Yii::t('app', 'Delivery and payment of the order') ?></p>
                    <div class="checkout-abroad__form abroad-form">
                        <p class="abroad-form__title"><?=
                            $settings['delivery_ukrposhta_other_countries_title'] ?? '' ?></p>
                        <p class="abroad-form__text"><?=
                            $settings['delivery_ukrposhta_other_countries_text'] ?? '' ?></p>
                        <div class="abroad-form__inputs pg-row">
                            <div class="field pg-col-50 pg-col-sm-100">
                                <?= $form->field($model->foreignersUp, 'city', [
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'City')]
                                ])->textInput() ?>
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-50 pg-col-sm-100">
                                <?= $form->field($model->foreignersUp, 'state', [
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Region / State')]
                                ])->textInput() ?>
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-50 pg-col-sm-100">
                                <?= $form->field($model->foreignersUp, 'street', [
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Street')]
                                ])->textInput() ?>
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-25 pg-col-sm-50">
                                <?= $form->field($model->foreignersUp, 'house', [
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'House')]
                                ])->textInput() ?>
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-25 pg-col-sm-50">
                                <?= $form->field($model->foreignersUp, 'apartment', [
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Apartment')]
                                ])->textInput() ?>
                            </div>
                            <div class="field pg-col-25 pg-col-sm-50">
                                <?= $form->field($model->foreignersUp, 'porch', [
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Porch')]
                                ])->textInput() ?>
                            </div>
                            <div class="field pg-col-25 pg-col-sm-50">
                                <?= $form->field($model->foreignersUp, 'index', [
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Index')]
                                ])->textInput() ?>
                                <span class="field-required js-field-required">*</span>
                            </div>
                        </div>


                        <div class="abroad-form__prices">
                            <span class="title-h6 title--black"><?= Yii::t('app', 'cost of delivery') ?></span>
                            <span class="title-h6 title--black abroad-form__prices-country js-abroad-country">(Германия)</span>
                            <!--конвертация мать его?-->
                            <span class="title-h6 title--red ml-2">eur</span>
                            <span class="title-h6 title--red abroad-form__prices-euro js-abroad-euro">-</span>
                            <span class="title-h6 title--red ml-2">usd</span>
                            <span class="title-h6 title--red abroad-form__prices-euro js-abroad-usd">-</span>
                        </div>
                        <div class="abroad-form__payment-method">
                            <p class="abroad-form__payment-method-title"><?=
                                isset($settings['payment_credit_card_title']) ? $settings['payment_credit_card_title'] : '' ?></p>
                            <img loading="lazy" src="/images/checkout/visa-bank.svg" alt=""
                                 class="abroad-form__payment-method-img">
                            <img loading="lazy" src="/images/checkout/american-express-bank.png" alt=""
                                 class="abroad-form__payment-method-img">
                        </div>
                        <div class="abroad-form__about-payment">
                            <img loading="lazy" src="/images/checkout/way-for-pay-bank.png" alt=""
                                 class="abroad-form__about-payment-img">
                            <p class="abroad-form__about-payment-text"><?=
                                isset($settings['payment_credit_card_text']) ? $settings['payment_credit_card_text'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <?= Html::button('<span class="btn__inner title-h5 title--white">' . Yii::t('app', 'checkout') . '</span>', ['class' => 'js-check-form-sub btn btn-primary btn-lg btn-block abroad-form__submit btn btn--primary btn--primary-red btn--primary-medium']) ?>
                        </div>
                    </div>
                </section>
                <!--/Отправка зарубеж - получаем данные-->

                <!--Выбор способа доставки-->
                <section class="checkout-delivery js-show-delivery"
                         data-error-choice="<?= Yii::t('app', 'Choose one of the payment options!') ?>">
                    <p class="checkout-delivery__title title-h3 title--black"><?= Yii::t('app', 'Choice of delivery method') ?></p>
                    <div class="checkout-delivery__choices">

                        <?= $form->field($model->delivery, 'method', [
                            'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'cost of delivery')]
                        ])->hiddenInput() ?>


                        <!--Курьером Новой Почты по адресу-->
                        <div class="checkout-delivery__item js-delivery-item">
                            <label class="checkout-delivery__label js-delivery-choices">
                                <input data-id="1" type="radio"
                                       class="js-delivery-method checkout-delivery__input js-delivery-input"
                                       name="delivery"
                                       value="<?= isset($settings['courier_new_mail_title']) ? $settings['courier_new_mail_title'] : '' ?>">
                                <span class="checkout-delivery__input-fake"></span>
                                <span class="checkout-delivery__label-text"><?= isset($settings['courier_new_mail_title']) ? $settings['courier_new_mail_title'] : '' ?></span>
                            </label>
                            <p class="checkout-delivery__description text text--gray4"><?= isset($settings['courier_new_mail_text']) ? $settings['courier_new_mail_text'] : '' ?></p>
                            <div class="checkout-delivery__form pg-row js-delivery-form">

                                <div class="field pg-col-50 pg-col-sm-100">
                                    <?= $form->field($model->courierNp, 'city', [
                                        'inputOptions' => ['class' => 'js-courierNp-city field-input', 'placeholder' => Yii::t('app', 'City')]
                                    ])->dropDownList($model->delivery->getCities(), ['promt' => Yii::t('app', 'Select city')]) ?>
                                </div>

                                <div class="field pg-col-50 pg-col-sm-100">
                                    <?= $form->field($model->courierNp, 'street', [
                                        'inputOptions' => ['class' => 'js-courierNp-street field-input', 'placeholder' => Yii::t('app', 'Street')]
                                    ])->textInput() ?>
                                    <span class="field-required js-field-required">*</span>
                                </div>

                                <div class="field pg-col-25 pg-col-sm-50">
                                    <?= $form->field($model->courierNp, 'house', [
                                        'inputOptions' => ['class' => 'js-courierNp-house field-input', 'placeholder' => Yii::t('app', 'House')]
                                    ])->textInput() ?>
                                    <span class="field-required js-field-required">*</span>
                                </div>

                                <div class="field pg-col-25 pg-col-sm-50">
                                    <?= $form->field($model->courierNp, 'apartment', [
                                        'inputOptions' => ['class' => 'js-courierNp-apartment field-input', 'placeholder' => Yii::t('app', 'Apartment')]
                                    ])->textInput() ?>
                                </div>

                                <div class="field pg-col-25 pg-col-sm-50">
                                    <?= $form->field($model->courierNp, 'porch', [
                                        'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Porch')]
                                    ])->textInput() ?>
                                </div>

                                <div class="checkout-delivery__prices pg-col-100">
                                    <span class="title-h6 title--black"><?= Yii::t('app', 'cost of delivery') ?>:</span>
                                    <span class="title-h6 title--red js-order-cost-address"></span>
                                    <span class="title-h6 title--red checkout-delivery__currency js-delivery-currency"
                                          style="display: none"> <?= $currency->getCurrencySign() ?></span>
                                </div>
                            </div>
                        </div>
                        <!--/Курьером Новой Почты по адресу-->

                        <!--В отделение Новой Почты-->
                        <div class="checkout-delivery__item js-delivery-item">
                            <label class="checkout-delivery__label js-delivery-choices">
                                <input data-id="2" type="radio"
                                       class="js-delivery-method checkout-delivery__input js-delivery-input"
                                       name="delivery"
                                       value="<?= isset($settings['in_new_post_office_title']) ? $settings['in_new_post_office_title'] : '' ?>">
                                <span class="checkout-delivery__input-fake"></span>
                                <span class="checkout-delivery__label-text"><?= isset($settings['in_new_post_office_title']) ? $settings['in_new_post_office_title'] : '' ?></span>
                            </label>
                            <p class="checkout-delivery__description text text--gray4"><?= isset($settings['in_new_post_office_text']) ? $settings['in_new_post_office_text'] : '' ?></p>
                            <div class="checkout-delivery__form pg-row js-delivery-form">

                                <div class="field pg-col-50 pg-col-sm-100">
                                    <?= $form->field($model->officeNp, 'city', [
                                        'inputOptions' => ['class' => 'field-input custom-select custom-select--lg', 'placeholder' => Yii::t('app', 'City')]
                                    ])->dropDownList($model->delivery->getCities(), ['promt' => Yii::t('app', 'Select city')]) ?>
                                </div>

                                <div class="field pg-col-50 pg-col-sm-100">
                                    <?= $form->field($model->officeNp, 'branch', [
                                        'inputOptions' => ['class' => 'field-input custom-select custom-select--lg js-officenpform-branch', 'placeholder' => Yii::t('app', 'department')]
                                    ])->dropDownList([]) ?>
                                </div>

                                <div class="checkout-delivery__prices pg-col-100">
                                    <span class="title-h6 title--black"><?= Yii::t('app', 'cost of delivery') ?>:</span>
                                    <span class="title-h6 title--red js-order-cost-office-np"></span>
                                    <span class="title-h6 title--red"><?= $currency->getCurrencySign() ?></span>

                                </div>
                            </div>
                        </div>
                        <!--/В отделение Новой Почты-->

                        <!--Бронирование товаров в магазине-->
                        <div class="checkout-delivery__item js-delivery-item">
                            <label class="checkout-delivery__label js-delivery-choices">
                                <input type="radio" data-id="4"
                                       class="checkout-delivery__input js-delivery-input js-delivery-method"
                                       name="delivery"
                                       value="<?= isset($settings['reservation_goods_title']) ? $settings['reservation_goods_title'] : '' ?>">
                                <span class="checkout-delivery__input-fake"></span>
                                <span class="checkout-delivery__label-text"><?= isset($settings['reservation_goods_title']) ? $settings['reservation_goods_title'] : '' ?></span>
                            </label>
                            <p class="checkout-delivery__description text text--gray4"><?= isset($settings['reservation_goods_title']) ? $settings['reservation_goods_text'] : '' ?></p>
                            <div class="checkout-delivery__form pg-row js-delivery-form">


                                <div class="field pg-col-50 pg-col-sm-100">
                                    <?= $form->field($model->storeReservation, 'city', [
                                        'inputOptions' => ['class' => 'js-nice-select field-input custom-select custom-select--lg', 'placeholder' => Yii::t('app', 'City')]
                                    ])->dropDownList(['promt' => Yii::t('app', 'Select city'), $model->storeReservation->getCityList()])->label(false) ?>
                                </div>

                                <div class="field pg-col-50 pg-col-sm-100">
                                    <?= $form->field($model->storeReservation, 'store', [
                                        'inputOptions' => ['class' => 'js-delivery-office field-input custom-select custom-select--lg js-storereservationform-city', 'placeholder' => Yii::t('app', 'Store')]
                                    ])->dropDownList([])->label(false) ?>
                                </div>

                                <div class="checkout-delivery__address pg-col-100 text-center">
                                    <a href="<?= LanguageHelper::langUrl('our-stores#1') ?>" target="_blank"
                                       class="checkout-delivery__address-map text-medium text--black2 text--dashed-black2"><?= Yii::t('app', 'See address on the map') ?></a>
                                </div>
                            </div>
                        </div>
                        <!--/Бронирование товаров в магазине-->

                        <button class="checkout-delivery__submit btn btn--primary btn--primary-red btn--primary-medium js-verify-delivery"
                                type="button">
                            <span class="btn__inner title-h5 title--white"><?= Yii::t('app', 'Further') ?></span>
                        </button>
                    </div>
                </section>
                <!--/Выбор способа доставки-->

                <!--Выбор способа оплаты-->
                <section class="checkout-payment js-show-payment"
                         data-error-choice="<?= Yii::t('app', 'Choose one of the delivery options!') ?>"
                         data-error-empty="<?= Yii::t('app', 'Please fill in the required fields!') ?>">
                    <p class="checkout-payment__title title-h3 title--black"><?= Yii::t('app', 'Choosing a payment method') ?></p>

                    <div class="checkout-payment__choices">
                        <!--Способы оплаты-->
                        <?= $form->field($model->paymentForm, 'paymentMethod2', [
                            'inputOptions' => ['class' => 'js-payment-way']
                        ])->radioList([]) ?>
                        <?= $form->field($model->paymentForm, 'paymentMethod', [
                            'inputOptions' => ['class' => 'js-payment-way']
                        ])->hiddenInput() ?>
                        <!--/Способы оплаты-->
                        <!--Дополнительные поля для способа оплаты-->
                        <?= $form->field($model->paymentForm, 'typePayment')->radioList([]) ?>
                        <?= $form->field($model->paymentForm, 'parts')->hiddenInput() ?>

                        <?= $form->field($model, 'comment', [
                            'inputOptions' => ['class' => 'textarea-1', 'placeholder' => Yii::t('app', 'Comment on the order')]
                        ])->textarea() ?>

                        <div class="form-group">
                            <?= Html::button('<span class="btn__inner title-h5 title--white">' . Yii::t('app', 'checkout') . '</span>', ['class' => 'js-check-form-sub btn btn-primary btn-lg btn-block abroad-form__submit btn btn--primary btn--primary-red btn--primary-medium']) ?>
                        </div>
                        <div class="checkbox-1 mt-4 text-center">
                            <input id="no-call" type="checkbox" checked name="OrderForm[noCallMe]">
                            <label for="no-call"><?= Yii::t('app', 'Can\'t call me back') ?></label>
                        </div>
                        <!--/Дополнительные поля для способа оплаты-->
                    </div>
                </section>

            </article>
            <!--/Формы-->
        </section>
    </section>

<?php ActiveForm::end() ?>