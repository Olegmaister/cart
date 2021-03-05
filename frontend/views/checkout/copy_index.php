<?php

/* @var $this yii\web\View */
/* @var $cart \core\services\cart\Cart */

/* @var $model \frontend\forms\order\OrderForm */

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Shopping Cart', 'url' => ['/shop/cart/index']];
$this->params['breadcrumbs'][] = $this->title;

$classJs = 'hidden';

?>

<section class="pg-wrapper checkout">
    <nav class="breadcrumbs">
        <ul class="breadcrumbs__list">
            <li class="breadcrumbs__item">
                <a class="breadcrumbs__link" href="/">Главная</a>
            </li>
            <li class="breadcrumbs__item">
                <a class="breadcrumbs__link" href="/catalog">каталог товаров</a>
            </li>
            <li class="breadcrumbs__item">
                <span class="breadcrumbs__link breadcrumbs__link--current">Военная одежда</span>
            </li>
        </ul>
    </nav>

    <h1 class="checkout-title title-h2 title--black">ОФОРМЛЕНИЕ ЗАКАЗА</h1>

    <section class="checkout-main">
        <!--Формы-->
        <article class="checkout-body">
            <!--Регистрация обычная-->
            <div class="checkout-user-status-btns pg-row pg-justify-space-between">
                <div class="pg-col-50">
                    <button
                        class="checkout-user-status-btn btn btn--secondary btn--secondary-black btn--secondary-bg-gray btn--secondary-medium">
                        <span class="btn__inner title-h5">Я ПОСТОЯННЫЙ КЛИЕНТ</span>
                    </button>
                </div>
                <div class="pg-col-50">
                    <button
                        class="checkout-user-status-btn btn btn--secondary btn--secondary-black btn--secondary-bg-gray btn--secondary-medium">
                        <span class="btn__inner title-h5">ХОЧУ ЗАРЕГИСТРИРОВАТЬСЯ</span>
                    </button>
                </div>
            </div>
            <!--/Регистрация обычная-->

            <!--Форма основные данные пользователя-->
            <section class="checkout-payer">
                <div class="login-buttons">
                    <div class="login-buttons-col">
                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl" onclick="window.location.href = '/customer/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                            <span class="btn__inner title-h5"><i></i>Вход через google</span>
                        </button>
                    </div>
                    <div class="login-buttons-col">
                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb" onclick="window.location.href = '/customer/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
                            <span class="btn__inner title-h5"><i></i>Вход через facebook</span>
                        </button>
                    </div>
                </div>
                <div class="checkout-payer-data">
                    <div class="checkout-payer-data__head">
                        <p class="checkout-payer-data__title title-h4 title--black">Платильщик:</p>
                        <div class="checkout-payer-data__form pg-row">
                            <div class="field pg-col-50">
                                <input class="field-input" name="user-name" type="text" placeholder="Имя" required>
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-50">
                                <input class="field-input" name="user-surname" type="text" placeholder="Фамилия" required>
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-50">
                                <input class="field-input" name="user-phone" type="tel" placeholder="Телефон" required>
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-50">
                                <input class="field-input" name="user-email" type="email" placeholder="E-mail">
                            </div>
                            <div class="field pg-col-50">
                                <select class="custom-select custom-select--lg js-user-country" name="user-country" data-nice-select>
                                    <option selected disabled value="Не выбран">Выбрать страну получателя</option>
                                    <option value="Украина">Украина</option>
                                    <option value="Польша">Польша</option>
                                </select>
                            </div>
                            <div class="field pg-col-50">
                                <button class="btn btn--primary btn--primary-red btn--primary-medium js-payer-data-btn" type="button">
                                    <span class="btn__inner title-h5 title--white">Далее</span>
                                </button>
                            </div>
                            <div class="field field__accept pg-col-50">
                                <input class="field__checkbox field__checkbox--red" type="checkbox" id="accept-terms"
                                       name="accept-terms">
                                <label class="field__checkbox-fake" for="accept-terms"></label>
                                <p class="text-medium text--gray4">С пользовательским
                                    <a href="#"	class="text--red text--dashed-red">соглашениeм</a>
                                    ознакомлен.
                                </p>
                            </div>
                            <div class="pg-col-50 text-center">
							<span class="checkout-payer-data__recipient text-medium text--black2 text--dashed-black2 js-show-recipient-data"
                                  tabindex="0">указать данные получателя</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/Форма основные данные пользователя-->

            <!--Данные получателя-->
            <section class="checkout-recipient js-show-recipient">
                <p class="checkout-recipient__title title-h6 title--red text-center">Заполните пожалуйста обязательные поля!</p>
                <div class="checkout-recipient__data">
                    <button class="checkout-recipient__close js-hide-recipient">
                        <svg class="checkout-recipient__close-icon" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.75 0L18 2.24999L2.25006 17.9999L6.58121e-05 15.7499L15.75 0Z"/>
                            <path d="M0 2.24999L2.24999 2.46558e-06L17.9999 15.7499L15.7499 17.9999L0 2.24999Z"/>
                        </svg>
                    </button>
                    <p class="checkout-recipient__data-title title-h4 title--black">Получатель:</p>
                    <div class="checkout-recipient__data__form pg-row">
                        <div class="field pg-col-50">
                            <input class="field-input" name="user-name" type="text" placeholder="Имя" required>
                            <span class="field-required js-field-required">*</span>
                        </div>
                        <div class="field pg-col-50">
                            <input class="field-input" name="user-surname" type="text" placeholder="Фамилия" required>
                            <span class="field-required js-field-required">*</span>
                        </div>
                        <div class="field pg-col-50">
                            <input class="field-input" name="user-phone" type="tel" placeholder="Телефон" required>
                            <span class="field-required js-field-required">*</span>
                        </div>
                        <div class="field pg-col-50">
                            <input class="field-input" name="user-email" type="email" placeholder="E-mail">
                        </div>
                    </div>
                </div>
            </section>
            <!--/Данные получателя-->

            <!--Отправка зарубеж - получаем данные-->
            <section class="checkout-abroad js-show-abroad">
                <p class="checkout-abroad__title title-h3 title--black">Доставка и оплата заказа</p>
                <div class="checkout-abroad__form abroad-form">
                    <p class="abroad-form__title">Доставка Укрпочтой в другие страны</p>
                    <p class="abroad-form__text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                    <div class="abroad-form__inputs pg-row">
                        <div class="field pg-col-50">
                            <input class="field-input" name="user-city" type="text" placeholder="Город">
                            <span class="field-required js-field-required">*</span>
                        </div>
                        <div class="field pg-col-50">
                            <input class="field-input" name="user-region" type="text" placeholder="Область / Штат">
                            <span class="field-required js-field-required">*</span>
                        </div>
                        <div class="field pg-col-50">
                            <input class="field-input" name="user-street" type="text" placeholder="Улица">
                            <span class="field-required js-field-required">*</span>
                        </div>
                        <div class="field pg-col-25">
                            <input class="field-input" name="user-build" type="text" placeholder="Дом">
                            <span class="field-required js-field-required">*</span>
                        </div>
                        <div class="field pg-col-25">
                            <input class="field-input" name="user-flat" type="text" placeholder="Квартира">
                        </div>
                        <div class="field pg-col-25">
                            <input class="field-input" name="user-porch" type="text" placeholder="Подъезд">
                        </div>
                        <div class="field pg-col-25">
                            <input class="field-input" name="user-index" type="text" placeholder="Индекс">
                            <span class="field-required js-field-required">*</span>
                        </div>
                    </div>
                    <div class="abroad-form__prices">
                        <span class="title-h6 title--black">Стоимость доставки (Германия):</span>
                        <span class="title-h6 title--red">800 грн (25 EUR)</span>
                    </div>
                    <div class="abroad-form__payment-method">
                        <p class="abroad-form__payment-method-title">Оплата банковской картой</p>
                        <img loading="lazy" src="/images/checkout/visa-bank.svg" alt="" class="abroad-form__payment-method-img">
                        <img loading="lazy" src="/images/checkout/american-express-bank.png" alt="" class="abroad-form__payment-method-img">
                    </div>
                    <div class="abroad-form__about-payment">
                        <img loading="lazy" src="/images/checkout/way-for-pay-bank.png" alt="" class="abroad-form__about-payment-img">
                        <p class="abroad-form__about-payment-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                    </div>
                    <div class="field abroad-form__textarea">
                        <textarea class="field-input" name="user-comment" placeholder="Комментарий"></textarea>
                    </div>
                    <button class="abroad-form__submit btn btn--primary btn--primary-red btn--primary-medium" type="button">
                        <span class="btn__inner title-h5 title--white">оформить заказ</span>
                    </button>
                </div>
            </section>
            <!--/Отправка зарубеж - получаем данные-->

            <!--Выбор способа доставки-->
            <section class="checkout-delivery js-show-delivery">
                <p class="checkout-delivery__title title-h3 title--black">Выбор способа доставки</p>
                <div class="checkout-delivery__choices">

                    <!--Курьером Новой Почты по адресу-->
                    <div class="checkout-delivery__item js-delivery-item">
                        <label class="checkout-delivery__label js-delivery-choices">
                            <input type="radio" class="checkout-delivery__input js-delivery-input"
                                   name="delivery" value="Курьером Новой Почты по адресу">
                            <span class="checkout-delivery__input-fake"></span>
                            Курьером Новой Почты по адресу
                        </label>
                        <p class="checkout-delivery__description text text--gray4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                        <div class="checkout-delivery__form pg-row js-delivery-form">
                            <div class="field pg-col-50">
                                <input class="field-input" name="user-city" type="text" placeholder="Город">
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-50">
                                <input class="field-input" name="user-street" type="text" placeholder="Улица">
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-25">
                                <input class="field-input" name="user-build" type="text" placeholder="Дом">
                                <span class="field-required js-field-required">*</span>
                            </div>
                            <div class="field pg-col-25">
                                <input class="field-input" name="user-flat" type="text" placeholder="Квартира">
                            </div>
                            <div class="field pg-col-25">
                                <input class="field-input" name="user-porch" type="text" placeholder="Подьезд">
                            </div>
                            <section class="checkout-delivery__prices pg-col-100">
                                <span class="title-h6 title--black">Стоимость доставки:</span>
                                <span class="title-h6 title--red">800 грн</span>
                            </section>
                        </div>
                    </div>
                    <!--/Курьером Новой Почты по адресу-->

                    <!--В отделение Новой Почты-->
                    <div class="checkout-delivery__item js-delivery-item">
                        <label class="checkout-delivery__label js-delivery-choices">
                            <input type="radio" class="checkout-delivery__input js-delivery-input"
                                   name="delivery" value="В отделение Новой Почты">
                            <span class="checkout-delivery__input-fake"></span>
                            В отделение Новой Почты
                        </label>
                        <p class="checkout-delivery__description text text--gray4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                        <div class="checkout-delivery__form pg-row js-delivery-form">
                            <div class="field pg-col-50">
                                <select class="custom-select custom-select--lg js-delivery-city-office"
                                        name="user-country"
                                        data-nice-select>
                                    <option selected disabled value="Не выбран">Выбрать город</option>
                                    <option value="Киев">Киев</option>
                                    <option value="Харьков">Харьков</option>
                                    <option value="Николаев">Николаев</option>
                                    <option value="Днепр">Днепр</option>
                                    <option value="Львов">Львов</option>
                                </select>
                            </div>
                            <div class="field pg-col-50">
                                <select class="custom-select custom-select--lg js-delivery-office"
                                        name="user-country"
                                        data-nice-select>
                                    <option selected disabled value="Не выбран">Выбрать отделение</option>
                                    <option value="1">№1</option>
                                    <option value="2">№2</option>
                                    <option value="3">№3</option>
                                    <option value="4">№4</option>
                                    <option value="5">№5</option>
                                </select>
                            </div>
                            <div class="checkout-delivery__prices pg-col-100">
                                <span class="title-h6 title--black">Стоимость доставки:</span>
                                <span class="title-h6 title--red">800 грн</span>
                            </div>
                        </div>
                    </div>
                    <!--/В отделение Новой Почты-->

                    <!--Бронирование товаров в магазине-->
                    <div class="checkout-delivery__item js-delivery-item">
                        <label class="checkout-delivery__label js-delivery-choices">
                            <input type="radio" class="checkout-delivery__input js-delivery-input"
                                   name="delivery" value="Бронирование товаров в магазине">
                            <span class="checkout-delivery__input-fake"></span>
                            Бронирование товаров в магазине
                        </label>
                        <p class="checkout-delivery__description text text--gray4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                        <div class="checkout-delivery__form pg-row js-delivery-form">
                            <div class="field pg-col-50">
                                <select class="custom-select custom-select--lg js-delivery-city-office"
                                        name="user-country"
                                        data-nice-select>
                                    <option selected disabled value="Не выбран">Выбрать город</option>
                                    <option value="Киев">Киев</option>
                                    <option value="Харьков">Харьков</option>
                                    <option value="Николаев">Николаев</option>
                                    <option value="Днепр">Днепр</option>
                                    <option value="Львов">Львов</option>
                                </select>
                            </div>
                            <div class="field pg-col-50">
                                <select class="custom-select custom-select--lg js-delivery-office"
                                        name="user-country"
                                        data-nice-select>
                                    <option selected disabled value="Не выбран">Выбрать магазин</option>
                                    <option value="1">№1</option>
                                    <option value="2">№2</option>
                                    <option value="3">№3</option>
                                    <option value="4">№4</option>
                                    <option value="5">№5</option>
                                </select>
                            </div>
                            <div class="checkout-delivery__address pg-col-100 text-center">
                                <span class="checkout-delivery__address-map text-medium text--black2 text--dashed-black2 js-show-recipient-data" tabindex="0">смотреть адрес на карте</span>
                            </div>
                        </div>
                    </div>
                    <!--/Бронирование товаров в магазине-->

                    <button class="checkout-delivery__submit btn btn--primary btn--primary-red btn--primary-medium js-verify-delivery" type="button">
                        <span class="btn__inner title-h5 title--white">далее</span>
                    </button>
                </div>
            </section>
            <!--/Выбор способа доставки-->

            <!--Выбор способа оплаты-->
            <section class="checkout-payment js-show-payment">
                <p class="checkout-payment__title title-h3 title--black">Выбор способа оплаты</p>
                <div class="checkout-payment__choices">

                    <!--Наложным платежом (при получении в отделении)-->
                    <div class="checkout-payment__item js-payment-choices">
                        <label class="checkout-payment__label">
                            <input type="radio" class="checkout-payment__input"
                                   name="payment" value="Курьером Новой Почты по адресу">
                            <span class="checkout-payment__input-fake"></span>
                            Наложным платежом (при получении в отделении)
                        </label>
                        <p class="checkout-payment__description text text--gray4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                    </div>
                    <!--/Наложным платежом (при получении в отделении)-->

                    <!--Оплата банковской картой-->
                    <div class="checkout-payment__item js-payment-item">
                        <label class="checkout-payment__label js-payment-choices">
                            <input type="radio" class="checkout-payment__input js-payment-input"
                                   name="payment" value="Курьером Новой Почты по адресу">
                            <span class="checkout-payment__input-fake"></span>
                            Оплата банковской картой
                            <img loading="lazy" src="/images/checkout/visa-bank.svg" class="checkout-payment__logo" alt="">
                        </label>
                        <p class="checkout-payment__description text text--gray4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                        <div class="checkout-payment__subitem js-payment-form">
                            <label class="checkout-payment__label">
                                <input type="radio" class="checkout-payment__input"
                                       name="payment-system" value="Курьером Новой Почты по адресу">
                                <span class="checkout-payment__input-fake"></span>
                                <img loading="lazy" src="/images/checkout/liqupay.jpg" class="checkout-payment__logo" alt="">
                            </label>

                            <label class="checkout-payment__label">
                                <input type="radio" class="checkout-payment__input"
                                       name="payment-system" value="Курьером Новой Почты по адресу">
                                <span class="checkout-payment__input-fake"></span>
                                <img loading="lazy" src="/images/checkout/way-for-pay-bank.png" class="checkout-payment__logo" alt="">
                            </label>
                           <?php if (defined('IS_DEV')): ?>
                            <label class="checkout-payment__label">
                                <input type="radio" class="checkout-payment__input"
                                       name="payment-system" value="Курьером Новой Почты по адресу">
                                <span class="checkout-payment__input-fake"></span>
                                <img loading="lazy" src="/images/checkout/PayPal.svg" class="checkout-payment__logo" alt="">
                            </label>
                          <?php endif ?>
                        </div>
                    </div>
                    <!--/Оплата банковской картой-->

                    <!--Оплата частями-->
                    <div class="checkout-payment__item js-payment-item">
                        <label class="checkout-payment__label js-payment-choices">
                            <input type="radio" class="checkout-payment__input js-payment-input"
                                   name="payment" value="Курьером Новой Почты по адресу">
                            <span class="checkout-payment__input-fake"></span>
                            Оплата частями
                            <img loading="lazy" src="/images/checkout/pay-part.svg" class="checkout-payment__logo" alt="">
                        </label>
                        <p class="checkout-payment__description text text--gray4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                        <div class="checkout-payment__pay-part js-payment-form">
                            <p class="checkout-payment__pay-part-description">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam
                            </p>
                            <div class="checkout-payment__pay-part-range js-pay-part-range"
                                 data-value="1" data-min="1"
                                 data-step="1" data-max="12"
                                 data-max-text="До 12 мес"></div>
                        </div>
                    </div>
                    <!--/Оплата частями-->

                    <!--Безналичный расчет (счет - фактура)-->
                    <div class="checkout-payment__item js-payment-item">
                        <label class="checkout-payment__label js-payment-choices">
                            <input type="radio" class="checkout-payment__input js-payment-input"
                                   name="payment" value="Курьером Новой Почты по адресу">
                            <span class="checkout-payment__input-fake"></span>
                            Безналичный расчет (счет - фактура)
                        </label>
                        <p class="checkout-payment__description text text--gray4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin</p>
                        <a href="/images/checkout/visa-bank.svg"
                           class="checkout-payment__download title-h6 title--red js-payment-form"
                           download="/images/checkout/visa-bank.svg">скачать счет фактуру</a>
                    </div>
                    <!--/Безналичный расчет (счет - фактура)-->

                    <button class="checkout-delivery__submit btn btn--primary btn--primary-red btn--primary-medium js-verify-payment"
                            type="button">
                        <span class="btn__inner title-h5 title--white">оформить заказ</span>
                    </button>

                </div>
            </section>
            <!--/Выбор способа оплаты-->

        </article>
        <!--/Формы-->

        <!--Корзина-->
        <section class="checkout-aside">
            <div class="js-sticky-cart">
                <div class="checkout-cart">
                    <p class="checkout-cart__title title-h3 title--black2"><?= Yii::t('app', 'your order') ?></p>
                    <div class="checkout-cart__item">
                        <article class="cart-card">
                            <a href="#" class="cart-card__img-link">
                                <img loading="lazy" src="/images/product-brands/products/2.png" alt="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="#" class="cart-card__name title-h6">Куртка демисезонная утепляющая "URSUS
                                    POWER-FILL"</a>
                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 2100</span>
                                    <span class="cart-card__price cart-card__price--old title-h6 text--gray6">₴ 3100</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size">m</div>
                                <img loading="lazy" src="https://prof1group.ua/image/color/000000099.jpg" class="cart-card__color" alt="">
                            </div>
                            <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                                <button class="handle-counter__minus counter-minus">
                                    <span>-</span>
                                </button>
                                <input class="handle-counter__number" type="text" value="3">
                                <button class="handle-counter__plus counter-plus">
                                    <span>+</span>
                                </button>
                            </div>
                            <i class="cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                        </article>

                        <article class="cart-card">
                            <a href="#" class="cart-card__img-link">
                                <img loading="lazy" src="/images/product-brands/products/2.png" alt="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="#" class="cart-card__name title-h6">Куртка демисезонная утепляющая "URSUS
                                    POWER-FILL"</a>
                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 2100</span>
                                    <span class="cart-card__price cart-card__price--old title-h6 text--gray6">₴ 3100</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size">m</div>
                                <img loading="lazy" src="https://prof1group.ua/image/color/000000099.jpg" class="cart-card__color" alt="">
                            </div>
                            <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                                <button class="handle-counter__minus counter-minus">
                                    <span>-</span>
                                </button>
                                <input class="handle-counter__number" type="text" value="3">
                                <button class="handle-counter__plus counter-plus">
                                    <span>+</span>
                                </button>
                            </div>
                            <i class="cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                        </article>

                        <article class="cart-card">
                            <a href="#" class="cart-card__img-link">
                                <img loading="lazy" src="/images/product-brands/products/2.png" alt="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="#" class="cart-card__name title-h6">Куртка демисезонная утепляющая "URSUS
                                    POWER-FILL"</a>
                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 2100</span>
                                    <span class="cart-card__price cart-card__price--old title-h6 text--gray6">₴ 3100</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size">m</div>
                                <img loading="lazy" src="https://prof1group.ua/image/color/000000099.jpg" class="cart-card__color" alt="">
                            </div>
                            <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                                <button class="handle-counter__minus counter-minus">
                                    <span>-</span>
                                </button>
                                <input class="handle-counter__number" type="text" value="3">
                                <button class="handle-counter__plus counter-plus">
                                    <span>+</span>
                                </button>
                            </div>
                            <i class="cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                        </article>

                        <article class="cart-card">
                            <a href="#" class="cart-card__img-link">
                                <img loading="lazy" src="/images/product-brands/products/2.png" alt="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="#" class="cart-card__name title-h6">Куртка демисезонная утепляющая "URSUS
                                    POWER-FILL"</a>
                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 2100</span>
                                    <span class="cart-card__price cart-card__price--old title-h6 text--gray6">₴ 3100</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size">m</div>
                                <img loading="lazy" src="https://prof1group.ua/image/color/000000099.jpg" class="cart-card__color" alt="">
                            </div>
                            <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                                <button class="handle-counter__minus counter-minus">
                                    <span>-</span>
                                </button>
                                <input class="handle-counter__number" type="text" value="3">
                                <button class="handle-counter__plus counter-plus">
                                    <span>+</span>
                                </button>
                            </div>
                            <i class="cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                        </article>

                        <article class="cart-card">
                            <a href="#" class="cart-card__img-link">
                                <img loading="lazy" src="/images/product-brands/products/2.png" alt="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="#" class="cart-card__name title-h6">Куртка демисезонная утепляющая "URSUS
                                    POWER-FILL"</a>
                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 2100</span>
                                    <span class="cart-card__price cart-card__price--old title-h6 text--gray6">₴ 3100</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size">m</div>
                                <img loading="lazy" src="https://prof1group.ua/image/color/000000099.jpg" class="cart-card__color" alt="">
                            </div>
                            <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                                <button class="handle-counter__minus counter-minus">
                                    <span>-</span>
                                </button>
                                <input class="handle-counter__number" type="text" value="3">
                                <button class="handle-counter__plus counter-plus">
                                    <span>+</span>
                                </button>
                            </div>
                            <i class="cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                        </article>

                        <article class="cart-card">
                            <a href="#" class="cart-card__img-link">
                                <img loading="lazy" src="/images/product-brands/products/2.png" alt="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="#" class="cart-card__name title-h6">Куртка демисезонная утепляющая "URSUS
                                    POWER-FILL"</a>
                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 2100</span>
                                    <span class="cart-card__price cart-card__price--old title-h6 text--gray6">₴ 3100</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size">m</div>
                                <img loading="lazy" src="https://prof1group.ua/image/color/000000099.jpg" class="cart-card__color" alt="">
                            </div>
                            <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                                <button class="handle-counter__minus counter-minus">
                                    <span>-</span>
                                </button>
                                <input class="handle-counter__number" type="text" value="3">
                                <button class="handle-counter__plus counter-plus">
                                    <span>+</span>
                                </button>
                            </div>
                            <i class="cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                        </article>

                        <article class="cart-card">
                            <a href="#" class="cart-card__img-link">
                                <img loading="lazy" src="/images/product-brands/products/2.png" alt="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="#" class="cart-card__name title-h6">Куртка демисезонная утепляющая "URSUS
                                    POWER-FILL"</a>
                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 2100</span>
                                    <span class="cart-card__price cart-card__price--old title-h6 text--gray6">₴ 3100</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size">m</div>
                                <img loading="lazy" src="https://prof1group.ua/image/color/000000099.jpg" class="cart-card__color" alt="">
                            </div>
                            <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                                <button class="handle-counter__minus counter-minus">
                                    <span>-</span>
                                </button>
                                <input class="handle-counter__number" type="text" value="3">
                                <button class="handle-counter__plus counter-plus">
                                    <span>+</span>
                                </button>
                            </div>
                            <i class="cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                        </article>

                        <article class="cart-card">
                            <a href="#" class="cart-card__img-link">
                                <img loading="lazy" src="/images/product-brands/products/2.png" alt="" class="cart-card__img">
                            </a>
                            <div class="cart-card__info">
                                <a href="#" class="cart-card__name title-h6">Куртка демисезонная утепляющая "URSUS
                                    POWER-FILL"</a>
                                <div class="cart-card__prices">
                                    <span class="cart-card__price title-h4 title--red">₴ 2100</span>
                                    <span class="cart-card__price cart-card__price--old title-h6 text--gray6">₴ 3100</span>
                                </div>
                            </div>
                            <div class="cart-card__parameters">
                                <div class="cart-card__size">m</div>
                                <img loading="lazy" src="https://prof1group.ua/image/color/000000099.jpg" class="cart-card__color" alt="">
                            </div>
                            <div class="cart-card__handle-counter handle-counter" data-handle-counter>
                                <button class="handle-counter__minus counter-minus">
                                    <span>-</span>
                                </button>
                                <input class="handle-counter__number" type="text" value="3">
                                <button class="handle-counter__plus counter-plus">
                                    <span>+</span>
                                </button>
                            </div>
                            <i class="cart-card__delete" tabindex="0" title="Удалить из списка"></i>
                        </article>
                    </div>
                </div>
                <div class="checkout-promo promo-form">
                    <div class="promo-form__field">
                        <input type="text" name="promo-code" class="promo-form__input" placeholder="Ввести промокод">
                    </div>
                    <button class="promo-form__button btn btn--primary btn--primary-red">
                        <span class="btn__inner title-h4">ипользовать</span>
                    </button>
                </div>
                <div class="checkout-total-price">
                    <div class="checkout-total-price__discount">
                        <span class="title-h3 title--black"><?= Yii::t('app', 'discount') ?> - </span>
                        <span class="title-h3 title--red">5%</span>
                    </div>
                    <div class="checkout-total-price__delivery">
                        <span class="title-h3 title--black">Доставка: </span>
                        <span class="title-h3 title--red"><span class="title-h5">₴</span>70</span>
                    </div>
                    <div class="checkout-total-price__sum">
                        <span class="title-h3 title--black"><?= Yii::t('app', 'sum') ?>: </span>
                        <span class="title-h3 title--red">
						<span class="title-h5">₴</span><span class="title--red title-h2">3500</span>
					</span>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Корзина-->
    </section>


</section>


<!--<div class="cabinet-index">-->

<!--cart-->
<!--    --><? //= $this->render('_cart', [
//        'cart' => $cart,
//    ]) ?>
<!--/cart-->


<!--    <div class="wrapper-clearance-data">-->
<!--        --><?php //$form = ActiveForm::begin([
//            'enableClientValidation' => false,
//        ]) ?>

<!--        <div class="panel panel-default">-->
<!--            <div class="panel-heading">Платильщик</div>-->
<!--            <div class="panel-body">-->
<!--                --><? //= $form->field($model, 'firstName')->textInput() ?>
<!--                --><? //= $form->field($model, 'lastName')->textInput() ?>
<!--                --><? //= $form->field($model, 'phone')->textInput() ?>
<!--                --><? //= $form->field($model, 'email')->textInput() ?>
<!---->
<!--                <br>-->
<!--                <p>Указать данные получателя</p>-->
<!--                --><? //= $form->field($model, 'checkboxRecipient')->checkbox([
//                        1 => 'Указать данные получателя'
//                ]) ?>
<!---->
<!--                <div class="js-order-show-recipient">-->
<!--                    --><? //= $form->field($model->recipient, 'firstName')->textInput() ?>
<!--                    --><? //= $form->field($model->recipient, 'lastName')->textInput() ?>
<!--                    --><? //= $form->field($model->recipient, 'phone')->textInput() ?>
<!--                    --><? //= $form->field($model->recipient, 'email')->textInput() ?>
<!--                </div>-->
<!---->
<!---->
<!--                <hr>-->
<!--                --><? //= $form->field($model->delivery, 'country')->dropDownList([
//                    'UA' => 'Украина',
//                    'PL' => 'Польша'
//                ]);?>
<!--            </div>-->
<!--        </div>-->
<!---->
<!---->
<!--        <button class="btn btn-success js-order-button-step-delivery">Далее</button>-->
<!---->
<!--        <div class="js-order-show-step-delivery-ukraine hidden">-->
<!--            <p>Выбор способа доставки</p>-->
<!--            <div class="panel panel-default">-->
<!--                --><? //=$form->field($model->delivery, 'method')->radioList(
//                    $model->delivery->deliveryMethodsListUkraine()
//                );?>
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="js-order-show-step-delivery-other hidden">-->
<!--            <p>Выбор способа доставки</p>-->
<!--            <div class="panel panel-default">-->
<!--                --><? //=$form->field($model->delivery, 'methodOther')->radioList(
//                    $model->delivery->deliveryMethodsListOther()
//                );?>
<!--            </div>-->
<!--        </div>-->
<!---->
<!---->
<!--        <div class="--><?php //if($formShow != 1) echo $classJs?><!-- js-delivery-method js-delivery-1">-->
<!--            <p>способ доставки1: Курьером новой почты по адресу</p>-->
<!--            <div class="panel panel-default">-->
<!--                <div class="panel-heading">Customer</div>-->
<!--                <div class="panel-body">-->
<!--                    --><? //= $form->field($model->courierNp, 'city')->dropDownList(['prompt' => '', $model->delivery->getCities()]) ?>
<!--                    --><? //= $form->field($model->courierNp, 'street')->textInput() ?>
<!--                    --><? //= $form->field($model->courierNp, 'house')->textInput() ?>
<!--                    --><? //= $form->field($model->courierNp, 'apartment')->textInput() ?>
<!--                    --><? //= $form->field($model->courierNp, 'porch')->textInput() ?>
<!--                    <br>-->
<!--                    --><? //= $form->field($model->courierNp, 'cost')->textInput(['readonly' => 'readonly']) ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="--><?php //if($formShow != 2) echo $classJs?><!-- js-delivery-method js-delivery-2">-->
<!--            <p>способ доставки2: В отделение Новой Почты</p>-->
<!--            <div class="panel panel-default">-->
<!--                <div class="panel-heading">Customer</div>-->
<!--                <div class="panel-body">-->
<!--                    --><? //= $form->field($model->officeNp, 'city')->dropDownList(['prompt' => '', $model->delivery->getCities()]) ?>
<!--                    --><? //= $form->field($model->officeNp, 'branch')->dropDownList([]) ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="--><?php //if($formShow != 3) echo $classJs?><!-- js-delivery-method js-delivery-3">-->
<!--            <p>способ доставки3: Укр почта</p>-->
<!--            <div class="panel panel-default">-->
<!--                <div class="panel-heading">Customer</div>-->
<!--                <div class="panel-body">-->
<!--                    --><? //= $form->field($model->foreignersUp, 'city')->dropDownList(['prompt' => '', $model->delivery->getCities()]) ?>
<!--                    --><? //= $form->field($model->foreignersUp, 'street')->textInput() ?>
<!--                    --><? //= $form->field($model->foreignersUp, 'house')->textInput() ?>
<!--                    --><? //= $form->field($model->foreignersUp, 'apartment')->textInput() ?>
<!--                    --><? //= $form->field($model->foreignersUp, 'porch')->textInput() ?>
<!--                    --><? //= $form->field($model->foreignersUp, 'index')->textInput() ?>
<!--                    <br>-->
<!--                    --><? //= $form->field($model->foreignersUp, 'cost')->textInput(['readonly' => 'readonly']) ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <hr>-->
<!--        <div class="">-->
<!--            <p>способ Оплаты: Доставка курьером новой почты</p>-->
<!--            <div class="panel panel-default">-->
<!--                <div class="panel-body">-->
<!--                    --><? //= $form->field($model->paymentForm, 'paymentMethod')->radioList([]) ?>
<!--                    --><? //= $form->field($model->paymentForm, 'typePayment')->radioList([]) ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div id="js-slider-parts-privat">-->
<!--            <p>Оплата частями приват</p>-->
<!--            --><? //= Slider::widget([
//                'model' => $model->paymentForm,
//                'name' => 'paymentInstallments',
//                'sliderColor' => Slider::TYPE_DANGER,
//                'handleColor' => Slider::TYPE_DANGER,
//                'pluginOptions' => [
//                    'orientation' => 'horizontal',
//                    'handle' => 'round',
//                    'min' => 2,
//                    'max' => 12,
//                    'step' => 1
//                ],
//            ]);
//            ?>
<!--        </div>-->
<!---->
<!--        --><? //= $form->field($model, 'promoToken')->dropDownList(['prompt' => '', $model->getPromoCode()],[
//                'class' => 'form-control js-customer-promo-token'
//        ]) ?>
<!---->
<!--        <div class="form-group">-->
<!--            --><? //= Html::submitButton('Checkout', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
<!--        </div>-->
<!---->
<!--        --><?php //ActiveForm::end() ?>
<!--    </div>-->

<!--</div>-->

