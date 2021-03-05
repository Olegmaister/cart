<?php

use common\helpers\LanguageHelper;
use frontend\assets\AppAsset;
use frontend\services\SEOSarvice;

AppAsset::register($this);
header("Access-Control-Allow-Origin: *");

// Добавляем заголовки LastModified (по умолчаиню -1 день)
SEOSarvice::setHeaderLastModified();

$this->beginPage();

if (Yii::$app->getUser()->id) {
    $user = Yii::$app->user->identity;
}
$url = Yii::$app->request->url;
$link = LanguageHelper::langUrl('/');

?>

<?php /*  ['youtube' => true] загружать script -  https://www.youtube.com/iframe_api */ ?>
<?= $this->render('_header', ['youtube' => true]); ?>

<body class="loader-is-run" data-login="<?= (int)!Yii::$app->user->isGuest ?>">
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
<main class="main-wrapper">

    <header class="header clearfix">
        <div class="header-col header-col_left">
            <div class="header-logo">
                <a href="<?= (!empty($url) && $url != $link) ? $link : ''; ?>">
                    <img src="/images/logo_<?=Yii::$app->language ?>.svg" alt="PROF1Group" title="PROF1Group">
                </a>
            </div>
        </div>

        <?= $this->render('_top-block'); ?>

    </header>

    <?php $this->beginBody() ?>

    <?= $content ?>

    <?= $this->render('_footer'); ?>

</main>
<!--main wrapper-->

<?= $this->render('modal/_back-call') ?>



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
				<?= Yii::t('app', 'Show dimensional grid') ?></div>
            </div>
            <div class="modal-content-col modal-content-col--right">
                <button class="btn btn--trans btn--lx js-product-add-cart-main"
                  onclick="gtag('event', 'category', {'event_category': 'Добавить в корзину выбор размера', 'event_action': 'Нажатие на кнопку'});">
                    <span class="btn__inner"><?= Yii::t('app', 'add to cart') ?></span>
                </button>
            </div>
        </div>
    </div>
    <div class="modal-size-table js-popup-table-sizes">
        <img loading="lazy" src="/images/popup-sizes-template.jpg" alt="" class="modal-size-table__img">
    </div>
</div>

<?php echo $this->render('common/cart/_popup'); ?>

<div class="modal modal--shop">
    <div class="modal-content">
        <span class="modal__close modal__close--shop"></span>
        <div class="modal__title"><?= Yii::t('app', 'shops') ?></div>

        <div class="popup-shop">
            <div class="popup-shop-top">
                <div class="popup-shop-top-col popup-shop-top-col--left">
                    <div class="select-pages">
                        <select class="custom-select custom-select--lg" data-nice-select>
                            <option selected disabled>Украина</option>
                            <option value="1">США</option>
                            <option value="2">Франция</option>
                            <option value="3">Италия</option>
                            <option value="4">Испания</option>
                        </select>
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
                            <div class="b-field"><input class="field-input" type="text" placeholder="*<?= Yii::t('app', 'password') ?>"></div>
                        </div>
                    </div>
                    <div class="popup-shop-bot-row">
                        <div class="popup-shop-bot-row-col popup-shop-bot-row-col--left">
                            <a href="#" class="link-line-dotted link-line-dotted--red"><?= Yii::t('app', 'You forgot your password') ?>?</a>
                            <a href="#" class="link-line-dotted link-line-dotted--red"><?= Yii::t('app', 'registration') ?></a>
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

<?= $this->render('common/customer/_register_auth'); ?>

<?php
// Выводим блок КАТАЛОГ на главной (лидеры, новинки, распродажа и т.д.)
$this->registerJs(
'
function loadMainItems() {
    let prefix = $("html").data("lang");
    $.ajax({
        url: prefix + "/site/get-main-items"
    }).done(function (response) {
        $(".list__items").removeClass("hide");
        $(".main__items").html(response);
    });
}
loadMainItems();
//setTimeout(loadMainItems, 6000);
', \yii\web\View::POS_LOAD
)
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
