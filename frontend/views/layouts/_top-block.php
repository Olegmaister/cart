<?php

/**
 * @var \yii\web\View $this
 */

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;
use frontend\helpers\CompareHelper;
use frontend\helpers\WishListHelper;
use common\services\RedisService;
use frontend\widgets\HeaderCartWidget;
use frontend\widgets\HeaderCompareWidget;
use frontend\widgets\LeftMenuWidget;
use yii\web\View;

$currency = new ApiCurrency();
$user = Yii::$app->user->id;
$favoriteCount = $user ? (new WishListHelper())->getProductCount($user) : 0;
$favoriteCount = $favoriteCount > 0 ? $favoriteCount : '';
$compareCount = (new CompareHelper())->getProductCount($user);
$phones = (new RedisService())->getPhones();
$url = Yii::$app->request->url;

?>
<div class="header-col header-col_right">

    <div class="header-row header-row_top d-none d-lg-flex">

        <div class="header-row-col header-row-col_left header-row-col_left-top">

            <ul class="header-menu">
                <?= $this->render('_header_first-menu', ['url' => $url]) ?>
            </ul>

        </div>

        <div class="header-row-col header-row-col_right header-row-col_left-top">

            <div class="header-options clearfix">

                <div class="header-options-col header-options-col_tel">
                    <div class="switch">
                        <div class="switch__title s_select_box_value">
                            <span onclick="gtag('event', 'category', {'event_category': 'Список телефонов', 'event_action': 'Нажатие на кнопку'});">
                                <?= $phones[0]['value'] ?>
                                <div class="b_arrow">
                                <svg class="_patch" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                                            d="M4 3.572L.536.143h6.928L4 3.572z"/></svg>
                            </div>
                            </span>
                        </div>
                        <div class="switch-content switch-content_big">
                            <div class="switch-content__title"><?= Yii::t('app', 'Sales department') ?></div>
                            <ul>
                                <?php foreach ($phones as $key => $phone): ?>
                                    <li>
                                        <a href="tel:<?= ProductHelper::clearPhone($phone['value']) ?>" onclick="gtag('event', 'category', {'event_category': 'Телефон <?= $key+1 ?>', 'event_action': 'Нажатие на кнопку'});"><?= $phone['value'] ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="header-options-col header-options-col_cur overflow-visible">
                    <div class="dd-1">
                        <button class="dd-1__current">
                            <?= $currency->getSimbol() ?>
                        </button>
                        <div class="switch-content switch-content_select">
                            <ul class="currency_list">
                                <li class="<?= $currency->checkSelected(3) ?>"><a
                                            href="#"><?= $currency::UAH_SYMBOL ?></a></li>
                                <li class="<?= $currency->checkSelected(2) ?>"><a
                                            href="#"><?= $currency::USD_SYMBOL ?></a></li>
                                <li class="<?= $currency->checkSelected(1) ?>"><a
                                            href="#"><?= $currency::EUR_SYMBOL ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="header-options-col header-options-col_lang overflow-visible">
                    <div class="dd-1">
                        <button class="dd-1__current"><?= LanguageHelper::getCurrent() ?></button>
                        <div class="switch-content switch-content_select">
                            <ul>
                                <li><a onclick="updateLanguage(this); return false" data-language="en-EN" href="<?= LanguageHelper::getLink('en') ?>">en</a></li>
                                <li><a onclick="updateLanguage(this); return false" data-language="ua-UA" href="<?= LanguageHelper::getLink('ua') ?>">ua</a></li>
                                <li><a onclick="updateLanguage(this); return false" data-language="ru-RU" href="<?= LanguageHelper::getLink('ru') ?>">ru</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <?php if (Yii::$app->user->isGuest) { ?>
                    <div class="header-options-col header-options-col_prof">
                        <div class="switch__title _prof">
                            <a href="#" class="js-open-modal-login">
                                <?= Yii::t('app', 'entrance') ?>
                                <div class="b_arrow">
                                    <svg class="_patch" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 3.572L.536.143h6.928L4 3.572z"/>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="header-options-col header-options-col_prof header-options-col_prof-sigin">
                        <a href="<?= LanguageHelper::langUrl('account/account') ?>" class="">
                            <?= Yii::$app->user->identity->getProfileName() ?>
                        </a>
                    </div>
                <?php } ?>

            </div>

        </div>

    </div>
    <!-- ROW -->

    <div class="nav-container">
        <div class="row header-nav">

            <a class="col-auto d-lg-none mobile-logo" href="<?= LanguageHelper::langUrl('/') ?>">
                <img class="w-100" src="/images/header/logo-mob.svg" alt="PROF1Group" title="PROF1Group">
            </a>

            <div class="col d-none d-lg-block">
                <div class="row h-100 align-items-center nav-with-search">
                    <form class="main-search" action="<?= LanguageHelper::langUrl('search') ?>" autocomplete="off">
                        <span class="loader-1"><span></span></span>
                        <input type="text" placeholder="<?= Yii::t('app', 'Search') ?>" class="main-search__input" name="text">
                        <div class="search-autocomplete"></div>
                        <i class="main-search__close js-close-main-search"></i>
                        <button class="main-search__submit" type="submit">
                            <svg id="h-icon-search" width="36" height="36" viewBox="0 0 36 36" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle cx="15.8392" cy="15.8392" r="10.2" transform="rotate(-45 15.8392 15.8392)"
                                        stroke-width="2"/>
                                <path d="M27.7185 27.7186L22.7688 22.7688" stroke-width="2"/>
                            </svg>
                        </button>
                    </form>
                    <div class="col">
                        <ul class="menu-cat">
                            <?= $this->render('_header_second-menu', ['url' => $url]) ?>
                        </ul>
                    </div>
                    <div class="col-auto">
                        <a href="" class="link-call text-nowrap js-open-modal-call" onclick="gtag('event', 'category', {'event_category': 'Обратный звонок', 'event_action': 'Нажатие на кнопку'});">
                            <?= Yii::t('app', 'back call') ?>
                        </a>
                    </div>
                    <div class="col-auto pr-2">
                        <div class="h-icon-button">
                            <div class="h-icon-button__icon js-open-main-search">
                                <svg id="h-icon-search" width="36" height="36" viewBox="0 0 36 36" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="15.8392" cy="15.8392" r="10.2" transform="rotate(-45 15.8392 15.8392)"
                                            stroke-width="2"/>
                                    <path d="M27.7185 27.7186L22.7688 22.7688" stroke-width="2"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="search-form search-form_hidden">

                    <div class="search-form-inner">
                        <input type="text" placeholder="<?= Yii::t('app', 'Search') ?>" class="search-form__field field_effect">
                        <div class="search-form__close"></div>
                        <button class="search-form__but"></button>
                    </div>

                </div>


            </div>

            <div class="col-auto ml-auto pl-0">

                <div class="row no-gutters h-100 align-items-center">
                    <div class="col-auto">
                        <div class="h-icon-button">
                            <a href="<?= Yii::$app->user->isGuest ? '#' : LanguageHelper::langUrl('account/wishlist') ?>" class=" <?= Yii::$app->user->isGuest ? 'js-open-modal-login' : '' ?> h-icon-button__icon">
                                <svg id="js-header-fav-distance" width="32" height="21" viewBox="0 0 32 21"
                                     fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z"
                                          stroke-width="2"/>
                                </svg>
                                <span class="js-favorite-counter"><?= $favoriteCount ?></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="h-icon-button">
                            <div class="js-open-comp-list h-icon-button__icon">
                                <svg width="32" height="21"
                                     style="stroke: none"
                                     viewBox="23.083 23.843 74.333 51.981">
                                    <rect x="57.946" y="23.843" width="4.5"
                                          height="51.981"></rect>
                                    <polygon
                                            points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"></polygon>
                                    <path d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"></path>
                                    <path d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"></path>
                                </svg>
                                <span class="compare-counter js-compare-counter"><?= $compareCount ?></span>
                            </div>

                            <div class="header-comp-list">
                                <?= HeaderCompareWidget::widget() ?>
                            </div>

                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="h-icon-button header-cart">
                            <!--include header widget cart-->
                            <?= HeaderCartWidget::widget() ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- ROW -->

    <div class="header-burgers d-lg-none">

        <div class="header-burgers-col header-burgers-col--cat">

            <div class="header-burgers__txt js-toggle-show js-toggle-show_cat">
                <?= Yii::t('app', 'catalog') ?>
                <span class="material-icons b_arrow"></span>
            </div>

        </div>

        <div class="header-burgers-col header-burgers-col--middle">
            <div class="header-burger header-burger_search js-toggle-show js-open-main-search">
                <div class="header-ordering__icon header-ordering__icon_search header-ordering__icon_search-icon"></div>
            </div>
        </div>

        <div class="header-burgers-col header-burgers-col--right">

            <div class="header-burger header-burger_menu js-toggle-show js-toggle-show_menu">
                <div class="header-ordering__icon header-ordering__icon_menu"></div>
            </div>

            <div class="header-burger-content hidden-content_hidden d-flex flex-column">
                <div class="flex-fill overflow-auto">
                    <div class="header-burger-content-row">

                        <div class="burger-header-options clearfix">

                            <div class="burger-header-options-col burger-header-options-col--cur">
                                <div class="dd-1">
                                    <button class="dd-1__current">
                                        <?= $currency->getSimbol() ?>
                                    </button>
                                    <div class="switch-content switch-content_select">
                                        <ul class="currency_list">
                                            <li class="<?= $currency->checkSelected(3) ?>"><a
                                                        href="#"><?= $currency::UAH_SYMBOL ?></a></li>
                                            <li class="<?= $currency->checkSelected(2) ?>"><a
                                                        href="#"><?= $currency::USD_SYMBOL ?></a></li>
                                            <li class="<?= $currency->checkSelected(1) ?>"><a
                                                        href="#"><?= $currency::EUR_SYMBOL ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="burger-header-options-col burger-header-options-col--lang">
                                <div class="dd-1">
                                    <button class="dd-1__current"><?= LanguageHelper::getCurrent() ?></button>
                                    <div class="switch-content switch-content_select">
                                        <ul>
                                            <li><a onclick="updateLanguage(this); return false" data-language="en-EN" href="<?= LanguageHelper::getLink('en') ?>">en</a></li>
                                            <li><a onclick="updateLanguage(this); return false" data-language="ua-UA" href="<?= LanguageHelper::getLink('ua') ?>">ua</a></li>
                                            <li><a onclick="updateLanguage(this); return false" data-language="ru-RU" href="<?= LanguageHelper::getLink('ru') ?>">ru</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="burger-header-options-col burger-header-options-col--prof">
                                <div class="switch__title _prof">
                                    <?php if (Yii::$app->user->isGuest) { ?>
                                        <a href="#" class="js-open-modal-login"><?= Yii::t('app', 'entrance') ?></a>
                                        <div class="material-icons b_arrow b_arrow_dark">arrow_drop_down</div>
                                    <?php } else { ?>
                                        <a href="<?= LanguageHelper::langUrl('account/account') ?>" class="">
                                            <?= Yii::$app->user->identity->getProfileName() ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="menu-shop-mobile">
                        <?= $this->render('_header_second-menu', ['url' => $url]) ?>
                    </ul>
                    <hr class="hr-1">
                    <ul class="menu-shop-mobile menu-shop-mobile--secondary">
                        <?= $this->render('_header_first-menu', ['url' => $url]) ?>
                    </ul>
                </div>
                <div class="header-burger-content-buttons">
                    <div class="header-burger-content-buttons-col">
                        <a href=""
                           class="js-open-modal-call but but-red but_call-mob"><span><?= Yii::t('app', 'back call') ?></span></a>
                    </div>
                    <div class="header-burger-content-buttons-col phones-dropdown js-phones-dropdown">
                        <div class="but but_phone-mob phones-dropdown__label">
                            <span>+38 (050) 555-55-55</span>
                        </div>
                        <div class="phones-dropdown__box">
                            <ul class="phones-dropdown__list">
                                <?php foreach ($phones as $phone): ?>
                                    <li class="phones-dropdown__item">
                                        <a class="phones-dropdown__phone"
                                           href="tel:<?= ProductHelper::clearPhone($phone['value']) ?>"><?= $phone['value'] ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--CONTENT-->

        </div>

    </div>
    <!--BURGERS-->

</div>

<div class="header-cat-mobile <?=
(Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'index') ?
    'header-cat-menu_main' : 'hidden-content_hidden' ?>">

    <ul class="header-cat-menu hidden-content_hidden">
        <?php
        /*if (Yii::$app->redis->get('leftMenu_' . Yii::$app->language)) {
            echo Yii::$app->redis->get('leftMenu_' . Yii::$app->language);
        } else {
            $leftMemu = LeftMenuWidget::widget();
            echo $leftMemu;
            Yii::$app->redis->set('leftMenu_' . Yii::$app->language, $leftMemu);
        }*/
        echo LeftMenuWidget::widget();
        ?>
    </ul>
</div>

<?php
$js = <<<JS
    function updateLanguage(element) {
        $.ajax({
            type: 'POST',
            url: "/update-language",
            data: {
                language: $(element).data('language')
            }
        }).done(function () {
            location.href = $(element).attr('href')
        });
    }
JS;

$this->registerJs($js, View::POS_END);
?>
