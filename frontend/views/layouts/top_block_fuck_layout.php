<?php

use common\helpers\LanguageHelper;

?>

<div class="header-col header-col_right">
    <div class="header-row mob-show-x766 _flex">
        <div class="header-row-col-mob header-row-col-mob_left">
            <div class="header-logo">
                <a href="/" class="header-logo__img header-logo__img--mob"></a>
            </div>
        </div>
        <div class="header-row-col-mob header-row-col-mob_right">
            <div class="header-ordering clearfix">
                <div class="header-ordering__icon header-ordering__icon_fav"></div>
                <div class="header-ordering__icon header-ordering__icon_comp"></div>
            </div>
            <div class="header-ordering-col header-ordering-col_cart header-ordering-col_full">
                <div class="header-ordering__icon header-ordering__icon_cart">
                    <svg width="29" height="25" viewBox="0 0 29 25" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.68564 17.5686L6.17005 5.84314H27.2648L23.9817 17.5686H7.68564Z"
                              stroke-width="2"></path>
                        <path d="M7.72051 17.4706L5.52443 1H0.583252" stroke-width="2"></path>
                        <circle class="_circle" cx="11.0147" cy="21.8627" r="2.19608"></circle>
                        <circle class="_circle" cx="20.897" cy="21.8627" r="2.19608"></circle>
                    </svg>
                    <span>2</span>
                </div>
                <div class="cart-m-popup">
                    <div class="cart-m-popup-inner">
                        <div class="cart-m-popup-prod">
                            <div class="cart-m-popup-prod-img">
                                <img loading="lazy" src="/images/cart/1.png" alt="">
                            </div>
                            <div class="cart-m-popup-prod-center">
                                <a href="#" class="cart-m-popup-prod__name">
                                    Куртка демисезонная
                                    утепляющая "URSUS POWER-FILL"
                                </a>
                                <div class="cart-m-popup-prod__price">
                                    ₴ 2100
                                </div>
                            </div>
                            <div class="cart-m-popup-prod__close"></div>
                        </div>
                        <div class="cart-m-popup-prod">
                            <div class="cart-m-popup-prod-img">
                                <img loading="lazy" src="/images/cart/1.png" alt="">
                            </div>
                            <div class="cart-m-popup-prod-center">
                                <a href="#" class="cart-m-popup-prod__name">
                                    Куртка демисезонная
                                    утепляющая "URSUS POWER-FILL"
                                </a>
                                <div class="cart-m-popup-prod__price">
                                    ₴ 2100
                                </div>
                            </div>
                            <div class="cart-m-popup-prod__close"></div>
                        </div>
                        <div class="cart-m-popup-prod">
                            <div class="cart-m-popup-prod-img">
                                <img loading="lazy" src="/images/cart/1.png" alt="">
                            </div>
                            <div class="cart-m-popup-prod-center">
                                <a href="#" class="cart-m-popup-prod__name">
                                    Куртка демисезонная
                                    утепляющая "URSUS POWER-FILL"
                                </a>
                                <div class="cart-m-popup-prod__price">
                                    ₴ 2100
                                </div>
                            </div>
                            <div class="cart-m-popup-prod__close"></div>
                        </div>
                        <div class="cart-m-popup-prod">
                            <div class="cart-m-popup-prod-img">
                                <img loading="lazy" src="/images/cart/1.png" alt="">
                            </div>
                            <div class="cart-m-popup-prod-center">
                                <a href="#" class="cart-m-popup-prod__name">
                                    Куртка демисезонная
                                    утепляющая "URSUS POWER-FILL"
                                </a>
                                <div class="cart-m-popup-prod__price">
                                    ₴ 2100
                                </div>
                            </div>
                            <div class="cart-m-popup-prod__close"></div>
                        </div>
                    </div>
                    <div class="cart-m-popup-but">
                        <a href="#" class="but but-red"><span><?= Yii::t('app', 'checkout') ?></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-row header-row_burgers mob-show-x766 _flex">
        <div class="header-burgers">
            <div class="header-burgers-col header-burgers-col_left">
                <div class="header-burgers-cat">
                    <div class="header-burgers-cat__but js-toggle-show js-toggle-show_cat">
                        Каталог
                        <span class="material-icons b_arrow">arrow_drop_down</span>
                    </div>
                    <ul class="header-cat-menu hidden-content_hidden">
                        <li class="header-cat-menu__item">
                            <div class="header-cat-menu__icon">
                                <img loading="lazy" src="/images/slider-content/glasses.svg" alt="">
                            </div>
                            <a class="header-cat-menu__link" href="">Очки</a>
                        </li>
                        <li class="header-cat-menu__item">
                            <div class="header-cat-menu__icon">
                                <img loading="lazy" src="/images/slider-content/backpack.svg" alt="">
                            </div>
                            <a class="header-cat-menu__link" href="">Рюкзаки / Сумки</a>
                        </li>
                        <li class="header-cat-menu__item">
                            <div class="header-cat-menu__icon">
                                <img loading="lazy" src="/images/slider-content/Subtract.svg" alt="">
                            </div>
                            <a class="header-cat-menu__link" href="">Одежда</a>
                        </li>
                        <li class="header-cat-menu__item">
                            <div class="header-cat-menu__icon">
                                <img loading="lazy" src="/images/slider-content/shoes.svg" alt="">
                            </div>
                            <a class="header-cat-menu__link" href="">Обувь</a>
                        </li>
                        <li class="header-cat-menu__item">
                            <div class="header-cat-menu__icon">
                                <img loading="lazy" src="/images/slider-content/equipment.svg" alt="">
                            </div>
                            <a class="header-cat-menu__link" href="">Снаряжение</a>
                        </li>
                        <li class="header-cat-menu__item">
                            <div class="header-cat-menu__icon">
                                <img loading="lazy" src="/images/slider-content/protection.svg" alt="">
                            </div>
                            <a class="header-cat-menu__link" href="">Средства защиты</a>
                        </li>
                        <li class="header-cat-menu__item">
                            <div class="header-cat-menu__icon">
                                <img loading="lazy" src="/images/slider-content/optics.svg" alt="">
                            </div>
                            <a class="header-cat-menu__link" href="">Оптика / Прицелы</a>
                        </li>
                        <li class="header-cat-menu__item">
                            <div class="header-cat-menu__icon">
                                <img loading="lazy" src="/images/slider-content/Bivach.svg" alt="">
                            </div>
                            <a class="header-cat-menu__link" href="">Бивачное снаряжение</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header-burgers-col header-burgers-col_middle">
                <div class="header-burger header-burger_search js-toggle-show js-toggle-show_search">
                    <div class="header-ordering__icon header-ordering__icon_search header-ordering__icon_search-icon"></div>
                </div>
            </div>
            <div class="header-burgers-col header-burgers-col_right">
                <div class="header-burger header-burger_menu js-toggle-show js-toggle-show_menu">
                    <div class="header-ordering__icon header-ordering__icon_menu"></div>
                </div>
                <div class="header-burger-content hidden-content_hidden">
                    <div class="header-burger-content-inner">
                        <div class="header-burger-content-row">
                            <div class="burger-header-options clearfix">
                                <div class="burger-header-options-col burger-header-options-col--cur">
                                    <div class="switch  s_select_box">
                                        <div class="switch__title _cur s_select_box_value">
                                            <span>₴</span>
                                            <div class="material-icons b_arrow b_arrow_dark">arrow_drop_down
                                            </div>
                                        </div>
                                        <div class="switch-content">
                                            <ul class="currency_list">
                                                <li>€</li>
                                                <li>$</li>
                                                <li>₴</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="burger-header-options-col burger-header-options-col--lang">
                                    <div class="switch s_select_box">
                                        <div class="switch__title _lang s_select_box_value">
                                            <span>ru</span>
                                            <div class="material-icons b_arrow b_arrow_dark">arrow_drop_down
                                            </div>
                                        </div>
                                        <div class="switch-content">
                                            <ul>
                                                <li><a href="<?= LanguageHelper::getLink('ru') ?>">ru</a></li>
                                                <li><a href="<?= LanguageHelper::getLink('ua') ?>">ua</a></li>
                                                <li><a href="<?= LanguageHelper::getLink('en') ?>">en</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="burger-header-options-col burger-header-options-col--prof">
                                    <div class="switch__title _prof">
                                        <a href="#" class="js-open-modal-login"><?= Yii::t('app', 'entrance') ?></a>
                                        <div class="material-icons b_arrow b_arrow_dark">arrow_drop_down</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="header-burger-content-row">
                            <div class="header-burger-content-col">
                                <ul class="header-burger-menu-shop">
                                    <li class="active"><a href=""><?= Yii::t('app', 'shops') ?></a></li>
                                    <li><a href="/brands"><?= Yii::t('app', 'brands') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'stocks') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'sell-out') ?></a></li>
                                </ul>
                            </div>
                            <div class="header-burger-content-col">
                                <ul class="header-burger-menu-shop">
                                    <li><a href=""><?= Yii::t('app', 'magazine') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'contacts') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'new items') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'hits') ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="header-burger-content-row">
                            <div class="header-burger-content-col">
                                <ul class="header-burger-menu">
                                    <li><a href=""><?= Yii::t('app', 'video reviews') ?></a></li>
                                    <li><a href="">Оптовикам</a></li>
                                    <li><a href=""><?= Yii::t('app', 'payment') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'delivery') ?></a></li>
                                    <li><a href="">Дисконт</a></li>
                                    <li><a href=""><?= Yii::t('app', 'shops') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'stocks') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'about') ?></a></li>
                                    <li><a href="">Новости</a></li>
                                    <li><a href=""><?= Yii::t('app', 'contacts') ?></a></li>
                                </ul>
                            </div>
                            <div class="header-burger-content-col">
                                <ul class="header-burger-menu">
                                    <li><a href=""><?= Yii::t('app', 'shops') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'stocks') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'about') ?></a></li>
                                    <li><a href="">Новости</a></li>
                                    <li><a href=""><?= Yii::t('app', 'contacts') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'shops') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'stocks') ?></a></li>
                                    <li><a href=""><?= Yii::t('app', 'about') ?></a></li>
                                    <li><a href="">Новости</a></li>
                                    <li><a href=""><?= Yii::t('app', 'contacts') ?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="header-burger-content-buttons">
                            <div class="header-burger-content-buttons-col">
                                <a href="" class="but but-red but_call-mob"><span><?= Yii::t('app', 'back call') ?></span></a>
                            </div>
                            <div class="header-burger-content-buttons-col phones-dropdown js-phones-dropdown">
                                <div class="but but_phone-mob phones-dropdown__label">
                                    <span>+38 (050) 555-55-55</span>
                                </div>
                                <div class="phones-dropdown__box">
                                    <ul class="phones-dropdown__list">
                                        <li class="phones-dropdown__item">
                                            <a class="phones-dropdown__phone" href="tel:+380675557777">+38 (067)
                                                555-77-77</a>
                                        </li>
                                        <li class="phones-dropdown__item">
                                            <a class="phones-dropdown__phone" href="tel:+380665558888">+38 (066)
                                                555-88-88</a>
                                        </li>
                                        <li class="phones-dropdown__item">
                                            <a class="phones-dropdown__phone" href="tel:+380505555555">+38 (050)
                                                555-55-55</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--INNER-->
                </div>
                <!--CONTENT-->
            </div>
            <div class="search-form search-form_mob hidden-content_hidden">
                <div class="search-form-inner">
                    <input type="text" placeholder="<?= Yii::t('app', 'Search') ?>" class="search-form__field field_effect">
                    <div class="search-form__close"></div>
                    <button class="search-form__but"><i></i></button>
                </div>
            </div>
            <div id="overlay-search"></div>
        </div>
        <!--BURGERS-->
    </div>
    <div class="header-row mob-show-x1279 mob-show-x1279_hide-x766">
        <div class="header-row-col header-row-col_right">
            <div class="header-row-col-mob header-row-col-mob_left">
                <div class="header-ordering-col header-ordering-col_call">
                    <a href="" class="link-call s_open_modal"><?= Yii::t('app', 'back call') ?></a>
                </div>
                <div class="header-options-col header-options-col_tel">
                    <div class="switch s_select_box">
                        <div class="switch__title s_select_box_value">
                            <span>+38 (050) 555-55-55</span>
                            <div class="material-icons b_arrow">arrow_drop_down</div>
                        </div>
                        <div class="switch-content switch-content_big">
                            <ul>
                                <li>
                                    <a href="tel:+380675557777">+38 (067) 555-77-77</a>
                                </li>
                                <li>
                                    <a href="tel:+380665558888">+38 (066) 555-88-88</a>
                                </li>
                                <li>
                                    <a href="tel:+380505555555">+38 (050) 555-55-55</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-options-col header-options-col_ord">
                    <div class="header-ordering clearfix">
                        <div class="header-ordering__icon header-ordering__icon_search">
                            <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle cx="15.8392" cy="15.8392" r="10.2"
                                        transform="rotate(-45 15.8392 15.8392)" stroke-width="2"/>
                                <path d="M27.7185 27.7186L22.7688 22.7688" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="header-ordering__icon header-ordering__icon_fav">
                            <svg width="32" height="21" viewBox="0 0 32 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z"
                                      stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="header-ordering__icon header-ordering__icon_comp">
                            <img loading="lazy" src="" alt="">

                        </div>
                    </div>
                </div>
            </div>
            <div class="header-row-col-mob header-row-col-mob_right">
                <div class="header-options-col header-options-col_cur">
                    <div class="switch s_select_box">
                        <div class="switch__title _cur s_select_box_value">
                            <span>&#8372;</span>
                            <div class="material-icons b_arrow">arrow_drop_down</div>
                        </div>
                        <div class="switch-content">
                            <ul class="currency_list">
                                <li>€</li>
                                <li>$</li>
                                <li>₴</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-options-col header-options-col_lang">
                    <div class="switch s_select_box">
                        <div class="switch__title _lang s_select_box_value">
                            <span>ru</span>
                            <div class="material-icons b_arrow">arrow_drop_down</div>
                        </div>
                        <div class="switch-content">
                            <ul>
                                <li><a href="<?= LanguageHelper::getLink('en') ?>">en</a></li>
                                <li><a href="<?= LanguageHelper::getLink('ua') ?>">ua</a></li>
                                <li><a href="<?= LanguageHelper::getLink('ru') ?>">ru</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-options-col header-options-col_prof">
                    <div class="switch__title _prof">
                        <a href="#" class="js-open-modal-login"><?= Yii::t('app', 'entrance') ?></a>
                        <div class="material-icons b_arrow">arrow_drop_down</div>
                    </div>
                </div>
                <div class="header-ordering-col header-ordering-col_cart">
                    <div class="header-ordering__icon header-ordering__icon_cart">
                        <svg width="29" height="25" viewBox="0 0 29 25" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.68564 17.5686L6.17005 5.84314H27.2648L23.9817 17.5686H7.68564Z"
                                  stroke-width="2"/>
                            <path d="M7.72051 17.4706L5.52443 1H0.583252" stroke-width="2"/>
                            <circle class="_circle" cx="11.0147" cy="21.8627" r="2.19608"/>
                            <circle class="_circle" cx="20.897" cy="21.8627" r="2.19608"/>
                        </svg>
                        <span>2</span>
                    </div>
                    <div class="cart-m-popup">
                        <div class="cart-m-popup-inner">
                            <div class="cart-m-popup-prod">
                                <div class="cart-m-popup-prod-img">
                                    <img loading="lazy" src="/images/cart/1.png" alt="">
                                </div>
                                <div class="cart-m-popup-prod-center">
                                    <a href="#" class="cart-m-popup-prod__name">
                                        Куртка демисезонная
                                        утепляющая "URSUS POWER-FILL"
                                    </a>
                                    <div class="cart-m-popup-prod__price">
                                        ₴ 2100
                                    </div>
                                </div>
                                <div class="cart-m-popup-prod__close"></div>
                            </div>
                            <div class="cart-m-popup-prod">
                                <div class="cart-m-popup-prod-img">
                                    <img loading="lazy" src="/images/cart/1.png" alt="">
                                </div>
                                <div class="cart-m-popup-prod-center">
                                    <a href="#" class="cart-m-popup-prod__name">
                                        Куртка демисезонная
                                        утепляющая "URSUS POWER-FILL"
                                    </a>
                                    <div class="cart-m-popup-prod__price">
                                        ₴ 2100
                                    </div>
                                </div>
                                <div class="cart-m-popup-prod__close"></div>
                            </div>
                            <div class="cart-m-popup-prod">
                                <div class="cart-m-popup-prod-img">
                                    <img loading="lazy" src="/images/cart/1.png" alt="">
                                </div>
                                <div class="cart-m-popup-prod-center">
                                    <a href="#" class="cart-m-popup-prod__name">
                                        Куртка демисезонная
                                        утепляющая "URSUS POWER-FILL"
                                    </a>
                                    <div class="cart-m-popup-prod__price">
                                        ₴ 2100
                                    </div>
                                </div>
                                <div class="cart-m-popup-prod__close"></div>
                            </div>
                            <div class="cart-m-popup-prod">
                                <div class="cart-m-popup-prod-img">
                                    <img loading="lazy" src="/images/cart/1.png" alt="">
                                </div>
                                <div class="cart-m-popup-prod-center">
                                    <a href="#" class="cart-m-popup-prod__name">
                                        Куртка демисезонная
                                        утепляющая "URSUS POWER-FILL"
                                    </a>
                                    <div class="cart-m-popup-prod__price">
                                        ₴ 2100
                                    </div>
                                </div>
                                <div class="cart-m-popup-prod__close"></div>
                            </div>
                        </div>
                        <div class="cart-m-popup-but">
                            <a href="#" class="but but-red"><span><?= Yii::t('app', 'checkout') ?></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header-row mob -->

    <div class="header-row header-row_top mob-hide-x766 _flex clearfix">
        <div class="header-row-col header-row-col_left header-row-col_left-top">
            <ul class="header-menu">
                <li><a href=""><?= Yii::t('app', 'accumulative discount') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'delivery') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'payment') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'wholesale') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'video reviews') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'warranty and return') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'question answer') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'about') ?></a></li>
            </ul>
        </div>
        <div class="header-row-col header-row-col_right header-row-col_left-top mob-hide-x1279 _flex">
            <div class="header-options clearfix">
                <div class="header-options-col header-options-col_tel">
                    <div class="switch">
                        <div class="switch__title s_select_box_value">
                            <span>+38 (050) 555-55-55</span>
                            <div class="material-icons b_arrow">arrow_drop_down</div>
                        </div>
                        <div class="switch-content switch-content_big">
                            <div class="switch-content__title">Отдел продаж</div>
                            <ul>
                                <li>
                                    <a href="tel:+380675557777">+38 (067) 555-77-77</a>
                                </li>
                                <li>
                                    <a href="tel:+380665558888">+38 (066) 555-88-88</a>
                                </li>
                                <li>
                                    <a href="tel:+380505555555">+38 (050) 555-55-55</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-options-col header-options-col_cur">
                    <div class="switch s_select_box">
                        <div class="switch__title _cur s_select_box_value">
                            <span>&#8372;</span>
                            <div class="material-icons b_arrow">arrow_drop_down</div>
                        </div>
                        <div class="switch-content switch-content_select">
                            <ul class="currency_list">
                                <li>€</li>
                                <li>$</li>
                                <li class="selected">₴</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="header-options-col header-options-col_lang">
                    <div class="switch s_select_box">
                        <div class="switch__title _lang s_select_box_value">
                            <span>ru</span>
                            <div class="material-icons b_arrow">arrow_drop_down</div>
                        </div>
                        <div class="switch-content switch-content_select">
                            <ul>
                                <li><a href="<?= LanguageHelper::getLink('en') ?>">en</a></li>
                                <li><a href="<?= LanguageHelper::getLink('ua') ?>">ua</a></li>
                                <li><a href="<?= LanguageHelper::getLink('ru') ?>">ru</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php if (Yii::$app->user->isGuest) { ?>
                    <div class="header-options-col header-options-col_prof">
                        <div class="switch__title _prof">
                            <a href="#" class="js-open-modal-login">ВХОД</a>
                            <div class="material-icons b_arrow">arrow_drop_down</div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="header-options-col header-options-col_prof header-options-col_prof-sigin">
                        <a href="/account/account" class="">
                            <?php echo Yii::$app->user->identity->username ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- ROW -->
    <div class="header-row header-row_bot mob-hide-x766 _flex clearfix">
        <div class="header-row-col header-row-col_left header-row-col_left-bot">
            <div class="search-form search-form_hidden">
                <div class="search-form-inner">
                    <input type="text" placeholder="<?= Yii::t('app', 'Search') ?>" class="search-form__field field_effect">
                    <div class="search-form__close"></div>
                    <button class="search-form__but"></button>
                </div>
            </div>
            <ul class="menu-cat">
                <li><a href=""><?= Yii::t('app', 'shops') ?></a></li>
                <li><a href="/brands"><?= Yii::t('app', 'brands') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'stocks') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'sell-out') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'magazine') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'contacts') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'new items') ?></a></li>
                <li><a href=""><?= Yii::t('app', 'hits') ?></a></li>
            </ul>
        </div>
        <div class="header-row-col header-row-col_right header-row-col_right-bot mob-hide-x1279">
            <div class="header-ordering">
                <div class="header-ordering-col header-ordering-col_call">
                    <a href="" class="link-call js-open-modal-call"><?= Yii::t('app', 'back call') ?></a>
                </div>
                <div class="header-ordering-col header-ordering-col_search">
                    <div class="header-ordering__icon header-ordering__icon_search">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <circle cx="15.8392" cy="15.8392" r="10.2" transform="rotate(-45 15.8392 15.8392)"
                                    stroke-width="2"/>
                            <path d="M27.7185 27.7186L22.7688 22.7688" stroke-width="2"/>
                        </svg>
                    </div>
                </div>
                <div class="header-ordering-col header-ordering-col_fav">
                    <div class="header-ordering__icon header-ordering__icon_fav">
                        <svg width="32" height="21" viewBox="0 0 32 21" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z"
                                  stroke-width="2"/>
                        </svg>

                    </div>
                </div>
                <div class="header-ordering-col header-ordering-col_comp">
                    <div class="header-ordering__icon header-ordering__icon_comp">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="74.333px" height="51.981px" viewBox="23.083 23.843 74.333 51.981" enable-background="new 23.083 23.843 74.333 51.981" xml:space="preserve"><rect x="57.946" y="23.843" width="4.5" height="51.981"/><polygon points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"/><path d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"/><path d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"/></svg>
                    </div>
                </div>
                <div class="header-ordering-col header-ordering-col_cart">
                    <div class="header-ordering__icon header-ordering__icon_cart">
                        <svg width="29" height="25" viewBox="0 0 29 25" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.68564 17.5686L6.17005 5.84314H27.2648L23.9817 17.5686H7.68564Z"
                                  stroke-width="2"/>
                            <path d="M7.72051 17.4706L5.52443 1H0.583252" stroke-width="2"/>
                            <circle class="_circle" cx="11.0147" cy="21.8627" r="2.19608"/>
                            <circle class="_circle" cx="20.897" cy="21.8627" r="2.19608"/>
                        </svg>
                        <span>2</span>
                    </div>
                    <div class="cart-m-popup">
                        <div class="cart-m-popup-inner">
                            <div class="cart-m-popup-prod">
                                <div class="cart-m-popup-prod-img">
                                    <img loading="lazy" src="/images/cart/1.png" alt="">
                                </div>
                                <div class="cart-m-popup-prod-center">
                                    <a href="#" class="cart-m-popup-prod__name">
                                        Куртка демисезонная
                                        утепляющая "URSUS POWER-FILL"
                                    </a>
                                    <div class="cart-m-popup-prod__price">
                                        ₴ 2100
                                    </div>
                                </div>
                                <div class="cart-m-popup-prod__close"></div>
                            </div>
                            <div class="cart-m-popup-prod">
                                <div class="cart-m-popup-prod-img">
                                    <img loading="lazy" src="/images/cart/1.png" alt="">
                                </div>
                                <div class="cart-m-popup-prod-center">
                                    <a href="#" class="cart-m-popup-prod__name">
                                        Куртка демисезонная
                                        утепляющая "URSUS POWER-FILL"
                                    </a>
                                    <div class="cart-m-popup-prod__price">
                                        ₴ 2100
                                    </div>
                                </div>
                                <div class="cart-m-popup-prod__close"></div>
                            </div>
                            <div class="cart-m-popup-prod">
                                <div class="cart-m-popup-prod-img">
                                    <img loading="lazy" src="/images/cart/1.png" alt="">
                                </div>
                                <div class="cart-m-popup-prod-center">
                                    <a href="#" class="cart-m-popup-prod__name">
                                        Куртка демисезонная
                                        утепляющая "URSUS POWER-FILL"
                                    </a>
                                    <div class="cart-m-popup-prod__price">
                                        ₴ 2100
                                    </div>
                                </div>
                                <div class="cart-m-popup-prod__close"></div>
                            </div>
                            <div class="cart-m-popup-prod">
                                <div class="cart-m-popup-prod-img">
                                    <img loading="lazy" src="/images/cart/1.png" alt="">
                                </div>
                                <div class="cart-m-popup-prod-center">
                                    <a href="#" class="cart-m-popup-prod__name">
                                        Куртка демисезонная
                                        утепляющая "URSUS POWER-FILL"
                                    </a>
                                    <div class="cart-m-popup-prod__price">
                                        ₴ 2100
                                    </div>
                                </div>
                                <div class="cart-m-popup-prod__close"></div>
                            </div>
                        </div>
                        <div class="cart-m-popup-but">
                            <a href="<?= LanguageHelper::langUrl('checkout/simplecheckout') ?>"
                               class="but but-red"><span><?= Yii::t('app', 'checkout') ?></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW -->
</div>