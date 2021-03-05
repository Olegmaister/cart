<?php

use common\helpers\LanguageHelper;
use frontend\assets\CatalogAsset;
use frontend\services\SEOSarvice;
use frontend\widgets\LeftMenuWidget;

CatalogAsset::register($this);
// header("Access-Control-Allow-Origin: *");

// Добавляем заголовки LastModified (по умолчаиню -7 день)
if(isset($this->params['date_modified'])) {
    SEOSarvice::setHeaderLastModified(strtotime($this->params['date_modified']));
} else {
    SEOSarvice::setHeaderLastModified();
}

$this->beginPage();
$url = Yii::$app->request->url;
$link = LanguageHelper::langUrl('/');

?>

<?= $this->render('_header'); ?>

<body class="loaded loader-is-run" data-login="<?= (int)!Yii::$app->user->isGuest ?>">

<div class="loader">
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
    <div class="dot"></div>
</div>

<div id="overlay"></div>

<div class="main-wrapper">

    <header class="header clearfix header--two-variant">

        <div class="header-col header-col_left">

            <div class="header-logo">
                <a href="<?= (!empty($url) && $url != $link) ? $link : ''; ?>">
                    <img src="/images/logo_<?= Yii::$app->language ?>.svg" alt="PROF1Group" title="PROF1Group">
                </a>
            </div>

            <div class="header-cat header-cat--dekstop">

                <div class="header-cat__title">
                    <a href="<?= LanguageHelper::langUrl('categories') ?>" class="">
                        <?= Yii::t('app', 'catalog') ?>
                        <div class="header-cat__title-icons">
                            <div class="header-cat__title-icon header-cat__title-icon--first">
                                <svg width="12" height="12" viewBox="0 0 23 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path class="header-cat__title-icon__path header-cat__title-icon__path--first"
                                          d="M10.1692 2L20.2256 12.0564L10.1692 22.1128" stroke-width="3"/>
                                </svg>
                            </div>
                            <div class="header-cat__title-icon header-cat__title-icon--last">
                                <svg width="12" height="12" viewBox="0 0 23 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path class="header-cat__title-icon__path header-cat__title-icon__path--first"
                                          d="M10.1692 2L20.2256 12.0564L10.1692 22.1128" stroke-width="3"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>

                <ul class="header-cat-menu hidden-content_hidden">
                    <?php
                    //Зависимость кеша от кол-ва категорий
                    /*$dependency = [
                        'class' => 'yii\caching\DbDependency',
                        'sql' => 'SELECT COUNT(*) FROM {{%category_description}}',
                    ];
                    if ($this->beginCache('LcommentsWidget', [
                        'dependency' => $dependency,
                        'variations' => [Yii::$app->language]
                    ])) {
                        echo LeftMenuWidget::widget();
                        $this->endCache();
                    }*/

                    // Redis
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

        </div>

        <?= $this->render('_top-block'); ?>

    </header>

    <?php $this->beginBody() ?>

    <?= $content ?>

    <?= $this->render('_footer'); ?>

</div>
<!--main wrapper-->

<?= $this->render('modal/_back-call') ?>


<div class="modal modal--subscribe">
    <div class="modal-content">
        <span class="modal__close"></span>
        <div class="modal__title"><?= Yii::t('app', 'Inform about availability') ?></div>
        <div class="modal-content-inner">
            <form id="form-stock-watch">
                <div class="b-field">
                    <input required class="field-input" type="email" name="email" placeholder="Email">
                </div>
                <div class="popup-call-row popup-call-but">
                    <button class="btn btn--red btn--lxx" type="submit">
                        <span class="btn__inner"><?= Yii::t('app', 'send') ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal modal--size">
    <div class="modal-content modal-content--size">
        <span class="modal__close modal__close--size" tabindex="0"></span>
        <div class="modal__title"><?= Yii::t('app', 'select size') ?></div>
        <div class="modal-content-row modal-content-row--top">
            <div class="sizes-switch">
                <div class="sizes-switch__item sizes-switch__item--stock sizes-switch__item--active">s</div>
                <div class="sizes-switch__item sizes-switch__item--stock">m</div>
                <div class="sizes-switch__item sizes-switch__item--stock">l</div>
                <div class="sizes-switch__item sizes-switch__item--stock">xl</div>
                <div class="sizes-switch__item sizes-switch__item--stock">xxl</div>
                <div class="sizes-switch__item">xxxl</div>
                <div class="sizes-switch__item">4xl</div>
            </div>
        </div>
        <div class="modal-content-row modal-content-row--bot">
            <div class="modal-content-col modal-content-col--left">
                <div class="link-line-dotted js-popup-table-sizes-open"
				  onclick="gtag('event', 'category', {'event_category': 'Размер сетка в размере', 'event_action': 'Нажатие на кнопку'});">
				<?= Yii::t('app', 'Show dimensional grid') ?>
				</div>
            </div>
            <div class="modal-content-col modal-content-col--right">
                <button class="btn btn--trans btn--lx js-product-add-cart-main">
                    <span class="btn__inner" onclick="gtag('event', 'category', {'event_category': 'Добавить в корзину выбор размера', 'event_action': 'Нажатие на кнопку'});">
                    <?= Yii::t('app', 'add to cart') ?></span>
                </button>
            </div>
        </div>

        <div class="mt-3" id="choose-gift">
            <div class="sidebar-item__title mb-2">ВЫБЕРИТЕ подарок</div>
            <select id="modal-gifts-select"></select>
            <div class="sizes-switch mt-3" id="gift-sizes"></div>
        </div>
    </div>



    <div class="modal-size-table js-popup-table-sizes">
        <img loading="lazy" src="/images/popup-sizes-template.jpg" alt="size table" class="modal-size-table__img">
    </div>
</div>

<div class="modal modal--shop">
    <div class="modal-content">
        <span class="modal__close modal__close--shop"></span>
        <div class="modal__title"><?= Yii::t('app', 'shops') ?></div>

        <div class="popup-shop">
            <div class="popup-shop-top">
                <div class="popup-shop-top-col popup-shop-top-col--left">
                    <div class="select-pages">
                        <select class="custom-select custom-select--red custom-select--lg" data-nice-select=""
                                style="display: none;">
                            <option selected="" disabled="">Поиск по странам</option>
                            <option value="1">Ukraine</option>
                            <option value="2">USA</option>
                            <option value="3">Italy</option>
                            <option value="4">France</option>
                        </select>
                        <div class="nice-select custom-select custom-select--lg" tabindex="0"><span class="current">Поиск по странам</span>
                            <ul class="list">
                                <li data-value="Поиск по странам" class="option selected disabled">Поиск по странам</li>
                                <li data-value="1" class="option">Ukraine</li>
                                <li data-value="2" class="option">USA</li>
                                <li data-value="3" class="option">Italy</li>
                                <li data-value="4" class="option">France</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="popup-shop-top-col popup-shop-top-col--right">
                    <div class="popup-shop-top__info">
                        <span>*</span> Срок бронирования <span>до 24 часов</span>
                    </div>
                </div>
            </div>
            <div class="popup-shop-table">
                <table>
                    <thead>
                    <tr>
                        <td>Размеры товаров</td>
                        <td>Адреса магазинов</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <div class="popup-shop-table-row popup-shop-table-row--top">
                                <div class="popup-shop-table-size">
                                    <div class="sizes-switch">
                                        <div class="sizes-switch__item sizes-switch__item--stock">s</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">m</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">l</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">xl</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">xxl</div>
                                        <div class="sizes-switch__item">xxxl</div>
                                    </div>
                                </div>
                            </div>
                            <div class="popup-shop-table-row popup-shop-table-row--bot">
                                <a href="#" class="link-line-dotted link-line-dotted--red">смотреть еще</a>
                            </div>
                        </td>
                        <td>
                            <div class="popup-shop-table-row popup-shop-table-row--top">
                                <span class="popup-shop-table__txt">г.ивано франковск, ул. Северенко, 12</span>
                            </div>
                            <div class="popup-shop-table-row popup-shop-table-row--bot">
                                <div class="popup-shop-table-row-col popup-shop-table-row-col--left">
                                    <a href="#" class="link-line-dotted link-line-dotted--red _long">Смотерть адрес на
                                        карте</a>
                                </div>
                                <div class="popup-shop-table-row-col popup-shop-table-row-col--right">
                                    <button class="btn btn--red btn--lxs">
                                        <span class="btn__inner">бронировать</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="popup-shop-table-row popup-shop-table-row--top">
                                <div class="popup-shop-table-size">
                                    <div class="sizes-switch">
                                        <div class="sizes-switch__item sizes-switch__item--stock">s</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">m</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">l</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">xl</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">xxl</div>
                                        <div class="sizes-switch__item">xxxl</div>
                                    </div>
                                </div>
                            </div>
                            <div class="popup-shop-table-row popup-shop-table-row--bot">
                                <a href="#" class="link-line-dotted link-line-dotted--red">смотреть еще</a>
                            </div>
                        </td>
                        <td>
                            <div class="popup-shop-table-row popup-shop-table-row--top">
                                <span class="popup-shop-table__txt">г.ивано франковск, ул. Северенко, 12</span>
                            </div>
                            <div class="popup-shop-table-row popup-shop-table-row--bot">
                                <div class="popup-shop-table-row-col popup-shop-table-row-col--left">
                                    <a href="#" class="link-line-dotted link-line-dotted--red _long">Смотерть адрес на
                                        карте</a>
                                </div>
                                <div class="popup-shop-table-row-col popup-shop-table-row-col--right">
                                    <button class="btn btn--red btn--lxs">
                                        <span class="btn__inner">бронировать</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="popup-shop-table-row popup-shop-table-row--top">
                                <div class="popup-shop-table-size">
                                    <div class="sizes-switch">
                                        <div class="sizes-switch__item sizes-switch__item--stock">s</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">m</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">l</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">xl</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">xxl</div>
                                        <div class="sizes-switch__item">xxxl</div>
                                    </div>
                                </div>
                            </div>
                            <div class="popup-shop-table-row popup-shop-table-row--bot">
                                <a href="#" class="link-line-dotted link-line-dotted--red">смотреть еще</a>
                            </div>
                        </td>
                        <td>
                            <div class="popup-shop-table-row popup-shop-table-row--top">
                                <span class="popup-shop-table__txt">г.ивано франковск, ул. Северенко, 12</span>
                            </div>
                            <div class="popup-shop-table-row popup-shop-table-row--bot">
                                <div class="popup-shop-table-row-col popup-shop-table-row-col--left">
                                    <a href="#" class="link-line-dotted link-line-dotted--red _long">Смотерть адрес на
                                        карте</a>
                                </div>
                                <div class="popup-shop-table-row-col popup-shop-table-row-col--right">
                                    <button class="btn btn--red btn--lxs">
                                        <span class="btn__inner">бронировать</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="popup-shop-table-row popup-shop-table-row--top">
                                <div class="popup-shop-table-size">
                                    <div class="sizes-switch">
                                        <div class="sizes-switch__item sizes-switch__item--stock">s</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">m</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">l</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">xl</div>
                                        <div class="sizes-switch__item sizes-switch__item--stock">xxl</div>
                                        <div class="sizes-switch__item">xxxl</div>
                                    </div>
                                </div>
                            </div>
                            <div class="popup-shop-table-row popup-shop-table-row--bot">
                                <a href="#" class="link-line-dotted link-line-dotted--red">смотреть еще</a>
                            </div>
                        </td>
                        <td>
                            <div class="popup-shop-table-row popup-shop-table-row--top">
                                <span class="popup-shop-table__txt">г.ивано франковск, ул. Северенко, 12</span>
                            </div>
                            <div class="popup-shop-table-row popup-shop-table-row--bot">
                                <div class="popup-shop-table-row-col popup-shop-table-row-col--left">
                                    <a href="#" class="link-line-dotted link-line-dotted--red _long">Смотерть адрес на
                                        карте</a>
                                </div>
                                <div class="popup-shop-table-row-col popup-shop-table-row-col--right">
                                    <button class="btn btn--red btn--lxs">
                                        <span class="btn__inner">бронировать</span>
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="popup-shop-bot">
                <div class="popup-shop-bot__title">
                    Забронировать товары может только авторизированный пользователь!
                </div>
                <div class="popup-shop-bot-inner">
                    <div class="popup-shop-bot-row">
                        <div class="popup-shop-bot-row-col popup-shop-bot-row-col--left">
                            <div class="b-field"><input class="field-input" type="text" placeholder="E-mail"></div>
                        </div>
                        <div class="popup-shop-bot-row-col popup-shop-bot-row-col--right">
                            <div class="b-field"><input class="field-input" type="text" placeholder="*Пароль"></div>
                        </div>
                    </div>
                    <div class="popup-shop-bot-row">
                        <div class="popup-shop-bot-row-col popup-shop-bot-row-col--left">
                            <a href="#" class="link-line-dotted link-line-dotted--red">Вы забыли пароль?</a>
                            <a href="#" class="link-line-dotted link-line-dotted--red">регистрация</a>
                        </div>
                        <div class="popup-shop-bot-row-col popup-shop-bot-row-col--right">
                            <button class="btn btn--red btn--full btn--lg-x">
                                <span class="btn__inner"><?= Yii::t('app', 'entrance') ?></span>
                            </button>
                        </div>
                    </div>
                    <div class="popup-shop-bot-row">
                        <div class="popup-shop-bot-row-col popup-shop-bot-row-col--left">
                            <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl" onclick="window.location.href = '/customer/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                                <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with google') ?></span>
                            </button>
                        </div>
                        <div class="popup-shop-bot-row-col popup-shop-bot-row-col--right">
                            <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb" onclick="window.location.href = '/customer/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
                                <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with facebook') ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--popup-shop-->
    </div>
</div>

<?php echo $this->render('common/cart/_popup'); ?>


<?php if (false): ?>
    <div class="modal modal--login">
        <div class="modal-content">
            <section class="login s_tabs _flex">
                <div class="login-top">
                    <ul class="s_tabs_list">
                        <li class="active">
                            <div class="login-top-col login-top-col--but">
                                <button class="btn btn--full btn--trans btn--trans--v2">
                                    <span class="btn__inner"><?= Yii::t('app', 'entrance') ?></span>
                                </button>
                            </div>
                        </li>
                        <li>
                            <div class="login-top-col login-top-col--but">
                                <button class="btn btn--full btn--trans btn--trans--v2">
                                    <span class="btn__inner">Регистрация</span>
                                </button>
                            </div>
                        </li>
                    </ul>
                    <div class="login-top-col login-top-col--close modal__close--login">
                        <i class="login__close"></i>
                    </div>
                </div>
                <div class="login-inner">
                    <div class="s_tabs_content active">
                        <div class="login">
                            <div class="login-inner">
                                <div class="login-buttons">
                                    <div class="login-buttons-col">
                                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl" onclick="window.location.href = '/customer/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                                            <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with google') ?></span>
                                        </button>
                                    </div>
                                    <div class="login-buttons-col">
                                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb" onclick="window.location.href = '/customer/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
                                            <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with facebook') ?></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="login-fields">
                                    <div class="login-fields-row">
                                        <div class="login-fields-col">
                                            <div class="b-field">
                                                <i>*</i>
                                                <input type="text" placeholder="Имя">
                                            </div>
                                        </div>
                                        <div class="login-fields-col">
                                            <div class="b-field">
                                                <i>*</i>
                                                <input type="text" placeholder="Фамилия">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="login-bottom">
                                    <a href="" class="link-line-dotted link-line-dotted--red"><?= Yii::t('app', 'You forgot your password') ?>?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="s_tabs_content">
                        <div class="login">
                            <div class="login-inner">
                                <div class="login-buttons">
                                    <div class="login-buttons-col">
                                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl" onclick="window.location.href = '/customer/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                                            <span class="btn__inner"><i></i>Вход через google</span>
                                        </button>
                                    </div>
                                    <div class="login-buttons-col">
                                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb" onclick="window.location.href = '/customer/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
                                            <span class="btn__inner"><i></i>Вход через facebook</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="login-fields">
                                    <div class="login-fields-row">
                                        <div class="login-fields-col">
                                            <div class="b-field">
                                                <i>*</i>
                                                <input type="text" placeholder="Имя">
                                            </div>
                                        </div>
                                        <div class="login-fields-col">
                                            <div class="b-field">
                                                <i>*</i>
                                                <input type="text" placeholder="Фамилия">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="login-fields-row">
                                        <div class="login-fields-col">
                                            <div class="b-field">
                                                <i>*</i>
                                                <input type="text" placeholder="Телефон">
                                            </div>
                                        </div>
                                        <div class="login-fields-col">
                                            <div class="b-field">
                                                <i>*</i>
                                                <input type="text" placeholder="E-mail">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="login-fields-row">
                                        <div class="login-fields-col">
                                            <div class="b-field">
                                                <i>*</i>
                                                <input type="text" placeholder="Пароль">
                                            </div>
                                        </div>
                                        <div class="login-fields-col">
                                            <div class="b-field">
                                                <i>*</i>
                                                <input type="text" placeholder="Повторить пароль">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="login-bottom">
                                    <button class="btn btn--red btn--lxx">
                                        <span class="btn__inner">регистрация</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--INNER-->
            </section>
        </div>
    </div>
<?php endif; ?>

<?= $this->render('common/customer/_register_auth'); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
