<?php

use backend\entities\Order\Product;
use common\helpers\LanguageHelper;
use frontend\assets\AppAsset;
use frontend\services\SEOSarvice;
use frontend\widgets\LeftMenuWidget;
use yii\web\View;

AppAsset::register($this);
// header("Access-Control-Allow-Origin: *");

if ($id = Yii::$app->request->get('id')) {
    $product = Product::find()->select('date_modified')->where(['product_id' => $id])->asArray()->one();
    // время последнего изменения страницы

    if ($product) {
        SEOSarvice::setHeaderLastModified(strtotime($product['date_modified']));
    }
}

$this->beginPage();

if (Yii::$app->getUser()->id) {
    $user = Yii::$app->user->identity;
}

$url = Yii::$app->request->url;
$link = LanguageHelper::langUrl('/');

?>
<!-- ['youtube' => true] загружать script -  https://www.youtube.com/iframe_api -->
<?= $this->render('_header', ['youtube' => true]); ?>

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
                    <a href="<?= LanguageHelper::langUrl('catalog') ?>" class="">
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

                    /*if(Yii::$app->redis->get('leftMenu_' . Yii::$app->language)) {
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


<!--main wrapper-->
<div class="modal modal--review">
    <div class="modal-content">
        <span class="modal__close modal__close--review"></span>
        <div class="modal__title"><?= Yii::t('app', 'review') ?></div>
        <div class="modal-content-inner">
            <div class="popup-review js-product-review-form"
                 data-empty-fields="<?= Yii::t('app', 'Fills in required fields') ?>!"
                 data-phone-field="<?= Yii::t('app', 'Phone number can only contain numbers') ?>!"
                 data-rating-field="<?= Yii::t('app', 'Rate by clicking on the corresponding star on the account') ?>!">
                <div class="popup-call-row">
                    <div class="popup-call-col">
                        <div class="b-field">
                            <input placeholder="<?= Yii::t('app', 'Name') ?>" type="text" class="field-input"
                                   name="name"
                                   value="<?= isset($user->username) ? $user->username : '' ?>">
                            <span class="field-required js-field-required">*</span>
                        </div>
                    </div>
                    <div class="popup-call-col">
                        <div class="b-field">
                            <input placeholder="E-mail" class="field-input" name="email" autocomplete="off"
                                   value="<?= isset($user->email) ? $user->email : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="popup-call-row">
                    <div class="b-field">
                        <span class="b-field__label js-field-required">*</span>
                        <textarea placeholder="<?= Yii::t('app', 'Your question') ?>" name="comment"
                                  class="field-textarea field-input"></textarea>
                    </div>
                </div>
                <div class="popup-call-row">
                    <div class="popup-review-rating">
                        <div class="rating-interactive js-rating">
                            <input type="hidden" class="js-rating-input" value="0">
                            <span data-vote="5" class="rating-interactive__item js-rating-star"></span>
                            <span data-vote="4" class="rating-interactive__item js-rating-star"></span>
                            <span data-vote="3" class="rating-interactive__item js-rating-star"></span>
                            <span data-vote="2" class="rating-interactive__item js-rating-star"></span>
                            <span data-vote="1" class="rating-interactive__item js-rating-star"></span>
                        </div>
                    </div>
                </div>
                <div class="popup-call-row popup-call-but">
                    <button class="btn btn--red btn--lxx js-send-product-review">
                        <span class="btn__inner"><?= Yii::t('app', 'send') ?></span>
                    </button>
                </div>
                <p class="error-message js-error-message"></p>
            </div>
            <div class="popup-success"><?= Yii::t('app', 'Thank you for your comment') ?>!
                <br/><?= Yii::t('app', 'It will be posted on the site after moderation') ?></div>
        </div>
    </div>
</div>
<div class="modal modal--call">
    <div class="modal-content">
        <span class="modal__close modal__close--call"></span>
        <div class="modal__title"><?= Yii::t('app', 'back call') ?></div>
        <div class="modal-content-inner">

            <form class="popup-call auxiliary_form"
                  data-success="<?= Yii::t('app', 'Thank you for your message') ?>!<br> <?= Yii::t('app', 'We will contact you shortly') ?>"
                  data-error="<?= Yii::t('app', 'Thank you for your comment') ?>!"
                  method="post">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="b-field">
                            <span class="b-field__label js-field-required">*</span>
                            <input class="field-input" value="<?= isset($user->username) ? $user->username : '' ?>"
                                   type="text" name="user_name" placeholder="<?= Yii::t('app', 'Name') ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="b-field">
                            <span class="b-field__label js-field-required">*</span>
                            <input class="field-input" value="<?= isset($user->email) ? $user->email : '' ?>"
                                   type="text" name="user_phone" placeholder="Email">
                        </div>
                    </div>
                </div>

                <div class="account-quest-form-field">
                    <textarea class="account-quest-form-field__textarea" name="message"
                              placeholder="<?= Yii::t('app', 'Your question') ?>"></textarea>
                </div>

                <input type="hidden" name="type" value="call_back">

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
            <div class="sizes-switch js-sizes-switch-present">
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
                <button class="btn btn--trans btn--lx js-product-add-cart-main">
                    <span class="btn__inner"
                          onclick="gtag('event', 'category', {'event_category': 'Добавить в корзину выбор размера', 'event_action': 'Нажатие на кнопку'});">
                    <?= Yii::t('app', 'add to cart') ?></span>
                </button>
            </div>
        </div>
    </div>
    <div class="modal-size-table js-popup-table-sizes">
        <img loading="lazy" src="/images/popup-sizes-template.jpg" alt="sizes" class="modal-size-table__img">
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
                                    <span class="btn__inner"><?= Yii::t('app', 'registration') ?></span>
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
                                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl"
                                                onclick="gtag('event', 'category', {'event_category': 'Вход через Google', 'event_action': 'Нажатие на кнопку'});window.location.href = '/customer/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                                            <span class="btn__inner"><i></i>Вход через google</span>
                                        </button>
                                    </div>
                                    <div class="login-buttons-col">
                                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb"
                                                onclick="gtag('event', 'category', {'event_category': 'Вход через Facebook', 'event_action': 'Нажатие на кнопку'});window.location.href = '/customer/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
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
                                </div>
                                <div class="login-bottom">
                                    <a href="" class="link-line-dotted link-line-dotted--red">Вы забыли пароль?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="s_tabs_content">
                        <div class="login">
                            <div class="login-inner">
                                <div class="login-buttons">
                                    <div class="login-buttons-col">
                                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl"
                                                onclick="window.location.href = '/customer/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                                            <span class="btn__inner"><i></i>Вход через google</span>
                                        </button>
                                    </div>
                                    <div class="login-buttons-col">
                                        <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb"
                                                onclick="window.location.href = '/customer/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
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
                                        <span class="btn__inner"><?= Yii::t('app', 'registration') ?></span>
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

<?= $this->render('common/product/_fast_buy'); ?>


<?= $this->render('common/customer/_register_auth'); ?>

<?php

$this->registerJs('
function activeCarousel_1() {
    $(".carousel-1").slick({
        slidesToShow: 4,
        sliderToScroll: 1,
        // autoplay: 4000,
        dots: false,
        prevArrow: "<button type=\"button\" class=\"slick_prev\"></button>",
        nextArrow: "<button type=\"button\" class=\"slick_next\"></button>",
        rows: 0,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                }
        }]
    });
}

function activeCarousel_1c() {
    $(".carousel-1c:not(.unslick)").slick({
	  slidesToShow: 4,
	  sliderToScroll: 1,
	  dots: false,
      prevArrow: "<button type=\"button\" class=\"slick_prev\"></button>",
      nextArrow: "<button type=\"button\" class=\"slick_next\"></button>",
	  
	  rows: 0,
	  responsive: [{
	      breakpoint: 1024,
	      settings: {
	        slidesToShow: 2,
	      }
	    }
	  ]
	});
}

function loadBottomItemGroups(prefix) {
    $.ajax({
        url: prefix + "/products/get-bottom-item-groups"
    }).done(function (response) {
        $(".block__groups").html(response.blockGroups);
        tabs_initialization();
        activeCarousel_1c();
    });
}

function loadBottomItems() {
    let prefix = $("html").data("lang");
    prefix = (prefix == "") ? "" : "/" + prefix;

    $.ajax({
        url: prefix + "/products/get-bottom-items",
        data: {product_id: $(".page--product").data("product_id")}
    }).done(function (response) {
        $(".block__viewed").html(response.blockViewed);
        $(".block__similar").html(response.blockSimilar);
        $(".block__watching").html(response.blockWatching);
        activeCarousel_1();

        loadBottomItemGroups(prefix);
    });
}

loadBottomItems();
',
    \yii\web\View::POS_LOAD
)
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
