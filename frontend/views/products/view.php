<?php

/**
 * @var \common\entities\Products\Product $product
 */

use backend\services\PriceWatchesService;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\helpers\WishListHelper;
use frontend\services\ProductService;
use frontend\widgets\Product\FormationPriceWidget;

/**@var \frontend\services\product\ProductDiscount $discount */
/* @var \frontend\entities\Present\ProductPresent [] $presents**/

$storeList = $product->getStoreList();
$cityStoreUniqList = $product->getUniqStoreList();
$altImg = htmlentities($product->description->name);
$titleImg = ProductHelper::clearQuotes($product->description->name) . ' - Prof1grou';
$compare = ProductService::getCompare();
$wishList = ProductService::getWishList();
$email = ProductService::getEmail();
$stockWatch = ProductService::getStockWatchByEmail($email);
$presentsArr = ProductService::getPresents();
$absoluteUrl = Yii::$app->request->absoluteUrl;


echo $this->render('/seo', [
    'title' => html_entity_decode($product->description->meta_title),
    'description' => html_entity_decode($product->description->meta_description),
    'keywords' => html_entity_decode($product->description->meta_keyword),
    'url' => $absoluteUrl, //'https://prof1group.ua' . LanguageHelper::langUrl($product->url->keyword),
    'image' => ProductHelper::correctedImgPath_500p($product->image),
    'width' => 500,
    'height' => 500,
    'price' => $product->price,
    'type' => 'product',
]);

$isUserHasPriceWatch = (new PriceWatchesService())->isUserHasPriceWatch($product->product_id);
?>

<?= $this->render('_schema_org', ['product' => $product, 'currency' => $currency, 'reviews' => $reviews, 'absoluteUrl' => $absoluteUrl]) ?>

<div class="page page--product" data-product_id="<?= $product->product_id ?>">
    <div class="wrapper">
        <ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                    <span itemprop="name" content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                </a>
                <meta itemprop="position" content="1"/>
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="<?= LanguageHelper::langUrl('catalog') ?>">
                    <span itemprop="name"><?= Yii::t('app', 'catalog') ?></span>
                </a>
                <meta itemprop="position" content="2"/>
            </li>
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="<?= LanguageHelper::langUrl($inCategory[0]['keyword']) ?>">
                    <span itemprop="name"><?= $inCategory[0]['name'] ?></span>
                </a>
                <meta itemprop="position" content="3"/>
            </li>
            <?php if (isset($inCategory[1])): ?>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl(end($inCategory)['keyword']) ?>">
                        <span itemprop="name"><?= end($inCategory)['name'] ?></span>
                    </a>
                    <meta itemprop="position" content="4"/>
                </li>
            <?php endif ?>
            <li>
                <span><?= $product->description->name ?></span>
            </li>
        </ul>
        <div class="page-content product">
            <div class="product-col product-col--left">
                <div class="product-top mob-show-x1279">
                    <div class="product-top-col product-top-col--left">
                        <div class="product__article"><?= Yii::t('app', 'sku') ?>: <?= $product->sku ?></div>
                    </div>
                    <div class="product-top-col product-top-col--right">
                        <div class="product__availability <?= (!$product->stock_status) ? 'not__availability' : '' ?>">
                            <?= ($product->stock_status) ? Yii::t('app', 'available') : Yii::t('app', 'not_available') ?>
                        </div>
                    </div>
                </div>
                <h1 class="product__name mob-show-x1279">
                    <?= $product->description->name ?>
                </h1>
                <div class="product-slider">
                    <div class="product-card-labels" id="product-card-labels">
                        <?php if ($reviews): ?>
                            <div class="rating mb-2">
                                <?= ProductHelper::getRatingStars($reviews) ?>
                            </div>
                        <?php endif ?>
                        <?php if ($product['only_ua']): ?>
                            <div class="country-only mb-3 mob-hide-x1279">
                                <div class="country-only__icon"></div>
                                <div class="country-only__txt">ukraine only</div>
                            </div>
                        <?php endif ?>
                        <?php if ($product->hit): ?>
                            <span class="product-card__label background_hit"><?= Yii::t('app', 'hit') ?></span>
                        <?php endif ?>
                        <?php if ($product->new): ?>
                            <span class="product-card__label background_new"><?= Yii::t('app', 'new') ?></span>
                        <?php endif ?>
                        <?php if ($product->recommend): ?>
                            <span class="product-card__label background_recommend"><?= Yii::t('app', 'recommend') ?></span>
                        <?php endif ?>
                        <?php if ($product->sale == 1): ?>
                            <span role="tooltip"
                                  data-microtip-position="top"
                                  aria-label="<?= Yii::t('app', 'Other discounts do not apply to sale items') ?>"
                                  class="product-card__label background_sale"><?= Yii::t('app', 'sell-out') ?></span>
                        <?php elseif ($product->shares == 1): ?>
                            <span class="product-card__label background_stock_shares"><?= Yii::t('app', 'stock_shares') ?></span>
                        <?php endif ?>
                    </div>
                    <div class="product-slider-modal product-slider-modal--video">
                        <?php if (isset($videos['main'])): ?>
                            <div class="product-slider-images-media">
                                <?= $videos['main']['content'] ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="product-slider-modal product-slider-modal--video-3d">
                        <div class="product-slider-images-media">
                            <img class="product-slider-images-media__img" src="/images/slider/slider_icon_3d.svg"
                                 alt="slider">
                        </div>
                    </div>
                    <!--                    <div class="product-slider-arrows-wrap">-->
                    <!---->
                    <!--                        <button class="product-slider-arrows-arrow product-slider-arrows-arrow--prev"></button>-->
                    <!--                        <button class="product-slider-arrows-arrow product-slider-arrows-arrow--next"></button>-->
                    <!---->
                    <!--                    </div>-->
                    <div class="product-slider__buttons">
                        <?php if (isset($images['additional'])): ?>
                            <button class="button-1 js-switch-product-images"><?= Yii::t('app', 'model photos') ?> <?= count($images['additional']) ?></button>
                        <?php endif ?>
                        <div class="product-slider__compare<?php

                        if(Yii::$app->user->isGuest) {
                            // Проверяем куку на продуку ид
                            echo \frontend\helpers\CompareHelper::checkCookiesInProductId($product['product_id']) ? ' is-compare_img' : '';
                        } else {
                            echo $product->compare ? ' is-compare_img' : '';
                        }

                        ?>" onclick="gtag('event', 'category', {'event_category': 'Добавить в сравнение', 'event_action': 'Нажатие на кнопку'});"
                        ></div>
                    </div>

                    <?php if (isset($images['additional'])): ?>
                        <div class="product-slider-images product-alt-image">
                            <?php foreach ($images['additional'] as $image): ?>
                                <div class="product-slider-images-media">

                                    <img class="product-slider-images-media__img"
                                         src="<?= ProductHelper::correctedImgPath_500p($image) ?>"
                                         title="<?= $titleImg ?>"
                                         alt="<?= $altImg ?>">
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

                    <div class="product-slider-images active">
                        <?php if (isset($images['main'])): ?>
                            <?php foreach ($images['main'] as $image): ?>
                                <div class="product-slider-images-media">
                                    <svg class="preview-icon" fill="currentColor" viewBox="0 0 28.932 28.932"
                                         width="1em" height="1em">
                                        <path d="M28.345,25.517L22.229,19.4c3.43-4.791,3.01-11.508-1.289-15.809C18.624,1.276,15.544,0,12.267,0   C8.991,0,5.911,1.275,3.595,3.592c-2.317,2.317-3.593,5.397-3.593,8.674c0,3.275,1.276,6.356,3.593,8.674   c2.316,2.315,5.396,3.592,8.672,3.592c2.599,0,5.066-0.812,7.136-2.301l6.115,6.114c0.391,0.392,0.901,0.587,1.414,0.587   c0.512,0,1.023-0.195,1.414-0.587C29.125,27.564,29.125,26.296,28.345,25.517z M6.422,18.111c-1.562-1.562-2.421-3.64-2.421-5.847   c0-2.208,0.86-4.283,2.422-5.846c1.561-1.561,3.636-2.42,5.844-2.42s4.284,0.859,5.845,2.42c3.223,3.224,3.223,8.467,0,11.69   c-1.561,1.561-3.637,2.42-5.845,2.42C10.058,20.529,7.982,19.671,6.422,18.111z M18.466,12.381c0,1.104-0.896,2-2,2h-2.25v2.25   c0,1.104-0.896,2-2,2s-2-0.896-2-2v-2.25h-2.25c-1.104,0-2-0.896-2-2s0.896-2,2-2h2.25v-2.25c0-1.104,0.896-2,2-2s2,0.896,2,2v2.25   h2.25C17.57,10.381,18.466,11.278,18.466,12.381z"/>
                                    </svg>
                                    <img class="product-slider-images-media__img"
                                         src="<?= ProductHelper::correctedImgPath_500p($image) ?>"
                                         title="<?= $titleImg ?>"
                                         alt="<?= $altImg ?>">
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <div class="product-slider-images-media">
                                <img class="product-slider-images-media__img"
                                     src="<?= ProductHelper::correctedImgPath_500p($product->image) ?>"
                                     title="<?= $titleImg ?>"
                                     alt="<?= $altImg ?>">
                            </div>
                        <?php endif ?>
                    </div>

                <?php if (isset($videos['main']) || isset($images['main'])): ?>
                    <!--IMAGES-->
                    <div class="product-slider-thumbs">
                        <div class="product-slider-thumbs-col product-slider-thumbs-col--left">

                            <?php if (isset($images['additional'])): ?>
                                <div class="product-slider-thumbs-items product-alt-thumbs">
                                    <?php foreach ($images['additional'] as $image): ?>
                                        <div class="product-slider-thumbs-media product-slider-thumbs-media--item">
                                            <div class="product-slider-thumbs-inner">
                                                <img class="product-slider-thumbs__img"
                                                     src="<?= ProductHelper::correctedImgPath_500p($image) ?>"
                                                     title="<?= $titleImg ?>"
                                                     alt="<?= $altImg ?>">
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>

                            <div class="product-slider-thumbs-items">
                                <?php if (isset($images['main'])): ?>
                                    <?php foreach ($images['main'] as $image): ?>
                                        <div class="product-slider-thumbs-media product-slider-thumbs-media--item">
                                            <div class="product-slider-thumbs-inner">
                                                <img class="product-slider-thumbs__img"
                                                     src="<?= ProductHelper::correctedImgPath_500p($image) ?>"
                                                     title="<?= $titleImg ?>"
                                                     alt="<?= $altImg ?>">
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <div class="product-slider-thumbs-media product-slider-thumbs-media--item">
                                        <div class="product-slider-thumbs-inner">
                                            <img class="product-slider-thumbs__img" src="<?= $product->getImage() ?>"
                                                 title="<?= $titleImg ?>"
                                                 alt="<?= $altImg ?>">
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="product-slider-thumbs-col product-slider-thumbs-col--right">

                            <?php if (isset($videos['main'])): ?>
                                <div class="product-slider-thumbs-media product-slider-thumbs-media--autonom  js-video">
                                    <div class="product-slider-thumbs-inner">
                                        <div class="product-slider-thumbs__img">
                                            <svg width="42" height="42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path class="_path" d="M31 21l-15 8.66V12.34L31 21z"/>
                                                <circle class="_circle" cx="21" cy="21" r="20" stroke-width="2"/>
                                            </svg>
                                            <!-- 3D фотка -->
                                            <!--svg width="36" height="38" fill="none" xmlns="http://www.w3.org/2000/svg"><path class="_path" d="M8.352 33.48c-2.581 0-4.416-.704-5.504-2.112-1.088-1.408-1.632-3.413-1.632-6.016v-.928H6.56v.928c0 1.323.128 2.261.384 2.816.277.533.779.8 1.504.8.683 0 1.141-.267 1.376-.8.235-.533.352-1.419.352-2.656 0-1.365-.192-2.357-.576-2.976-.384-.64-1.099-.97-2.144-.992h-.992v-3.68h.864c1.088 0 1.835-.288 2.24-.864.405-.597.608-1.579.608-2.944 0-1.045-.139-1.824-.416-2.336-.277-.512-.768-.768-1.472-.768-.661 0-1.12.277-1.376.832-.235.533-.352 1.323-.352 2.368v1.344H1.216v-1.568c0-2.325.619-4.107 1.856-5.344 1.259-1.259 2.997-1.888 5.216-1.888 2.261 0 4.021.597 5.28 1.792 1.259 1.195 1.888 2.933 1.888 5.216 0 1.472-.299 2.73-.896 3.776-.597 1.024-1.355 1.664-2.272 1.92.981.363 1.75 1.013 2.304 1.952.576.939.864 2.283.864 4.032 0 2.517-.565 4.501-1.696 5.952-1.13 1.43-2.933 2.144-5.408 2.144zm10.006-26.4h6.56c2.24 0 3.989.277 5.248.832 1.258.555 2.143 1.43 2.655 2.624.534 1.173.8 2.752.8 4.736v9.408c0 2.005-.266 3.605-.8 4.8-.511 1.195-1.397 2.08-2.655 2.656-1.238.576-2.966.864-5.184.864h-6.624V7.08zm6.623 21.952c.832 0 1.44-.117 1.824-.352a1.67 1.67 0 00.768-1.056c.107-.47.16-1.152.16-2.048V14.28c0-.832-.064-1.461-.192-1.888a1.453 1.453 0 00-.768-.992c-.383-.213-.991-.32-1.823-.32h-.864v17.952h.896z"/></svg-->
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!--                                    <div class="product-slider-thumbs-inner">-->
                                <!--                                        <div class="product-slider-thumbs__img">-->
                                <!--                                       </div>-->
                                <!--                                    </div>-->
                            <?php endif ?>

                            <!--div class="product-slider-thumbs-media product-slider-thumbs-media--autonom js-video-3d">
                                <div class="product-slider-thumbs-inner">
                                    <div class="product-slider-thumbs__img">
                                        <svg width="42" height="42" fill="none" xmlns="http://www.w3.org/2000/svg"><path class="_path" d="M31 21l-15 8.66V12.34L31 21z"/><circle class="_circle" cx="21" cy="21" r="20" stroke-width="2"/></svg>
                                    </div>
                                </div>
                            </div -->
                        </div>
                        <!--THUMBS ICONS-->
                    </div>
                    <!--THUMBS-->
                <?php endif ?>

                </div>
                <!--SLIDER-->


                <section class="product-tabs s_tabs mob-hide-x1279">
                    <ul class="product-tabs-nav s_tabs_list">
                        <li class="product-tabs-nav__item active">
                            <div class="product-tabs-nav__inner"><h2><?= Yii::t('app', 'description') ?></h2></div>
                        </li>
                        <li class="product-tabs-nav__item">
                            <div class="product-tabs-nav__inner"><h2><?= Yii::t('app', 'characteristics') ?></h2>
                            </div>
                        </li>
                        <li class="product-tabs-nav__item">
                            <div class="product-tabs-nav__inner"><h2><?= Yii::t('app', 'reviews') ?></h2></div>
                        </li>

                        <?php if (isset($videos['other']) && count($videos['other']) > 0): ?>
                            <li class="product-tabs-nav__item js-init-product-media-slider">
                                <div class="product-tabs-nav__inner"><h2><?= Yii::t('app', 'Other videos') ?></h2>
                                </div>
                            </li>
                        <?php endif ?>
                    </ul>
                    <div class="product-tabs-content">
                        <div class="product-tabs-row s_tabs_content active">
                            <section class="product-desc">
                                <h3 class="product-tabs__title">
                                    <?= $product->description->name ?>
                                </h3>
                                <div id="desc" class="product-tabs-inner">
                                    <div id="js-height" class="product-desc-content">
                                        <?php if ($product->show_excerpt == 1 && $product->description->excerpt): ?>
                                            <?= html_entity_decode($product->description->excerpt) ?><br>
                                        <?php endif ?>
                                        <?= html_entity_decode($product->description->description) ?>

                                    </div>
                                </div>
                                <div class="product-desc-but product-desc-but--show">
                                    <button class="btn-link btn-link--red">
                                        <span class="btn-link__inner"><?= Yii::t('app', 'read more') ?></span>
                                    </button>
                                </div>
                                <div class="product-desc-but product-desc-but--hidden">
                                    <button class="btn-link btn-link--red">
                                        <a href="#desc" class="btn-link__inner"><?= Yii::t('app', 'hide') ?></a>
                                    </button>
                                </div>
                            </section>
                        </div>
                        <div class="product-tabs-row s_tabs_content">
                            <div class="product-feature">
                                <h3 class="product-tabs__title"><?= Yii::t('app', 'characteristics') ?></h3>
                                <div class="product-tabs-inner">
                                    <div class="product-feature-row">
                                        <div class="product-feature-row-col product-feature-row-col--left">
                                            <div class="product-feature__name"><?= Yii::t('app', 'manufacturer') ?>:
                                            </div>
                                        </div>
                                        <div class="product-feature-row-col product-feature-row-col--right">
                                            <div class="product-feature__option"><?= $product->brand->name ?></div>
                                        </div>
                                    </div>
                                    <!-- div class="product-feature-row">
                                        <div class="product-feature-row-col product-feature-row-col--left">
                                            <div class="product-feature__name"><?= Yii::t('app', 'Model') ?>:</div>
                                        </div>
                                        <div class="product-feature-row-col product-feature-row-col--right">
                                            <div class="product-feature__option">< ?= $product->model ?></div>
                                        </div>
                                    </div-->

                                    <?php if (isset($attrGroups[0])): ?>
                                        <?php foreach (ProductService::prepareAttributes($attrGroups) as $attribute): ?>
                                            <div class="product-feature-row">
                                                <div class="product-feature-row-col product-feature-row-col--left">
                                                    <div class="product-feature__name"><?= $attribute['group_name'] ?></div>
                                                </div>
                                                <div class="product-feature-row-col product-feature-row-col--right">
                                                    <div class="product-feature__option"><?= $attribute['values'] ?></div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>

                                </div>
                            </div>
                        </div>
                        <div class="product-tabs-row s_tabs_content">

                            <section class="product-reviews">

                                <h3 class="product-tabs__title"><?= Yii::t('app', 'reviews') ?></h3>

                                <div class="product-tabs-inner">

                                    <?php if (isset($reviews[0])): ?>
                                        <div class="container-reviews reviews-short">
                                            <?php foreach ($reviews as $review): ?>
                                                <div class="product-reviews-row">

                                                    <div class="product-reviews-top">
                                                        <div class="product-reviews-top-col product-reviews-top-col--left">
                                                            <div class="product-reviews__name"><?= $review['author'] ?></div>
                                                        </div>
                                                        <div class="product-reviews-top-col product-reviews-top-col--right">
                                                            <div class="rating">
                                                                <?= ProductHelper::getRatingStars($review) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="product-reviews__comments">
                                                        <?= $review['text'] ?>
                                                    </div>

                                                    <div class="product-reviews-bot">
                                                        <div class="product-reviews-bot-col product-reviews-bot-col--left">
                                                            <div class="product-reviews-buttons">
                                                                <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                                                                    <button class="js-open-modal-review btn btn--trans btn--lxs answer_review"
                                                                            data-review_id="<?= $review['review_id'] ?>">
                                                                        <span class="btn__inner"><?= Yii::t('app', 'answer') ?></span>
                                                                    </button>
                                                                </div>
                                                                <?php if (isset($review['re'][0])): ?>
                                                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                                                                        <div class="product-reviews__link js-answers">
                                                                            <?= Yii::t('app', 'comments') ?>
                                                                            <span>(<?= count($review['re']) ?>)</span>
                                                                        </div>
                                                                    </div>
                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                        <div class="product-reviews-bot-col product-reviews-bot-col--right">
                                                            <div class="video-reviews-date"><?= Yii::$app->formatter->asDate($review['date_added'], 'dd.MM.yyyy') ?></div>
                                                        </div>
                                                    </div>

                                                    <?php if (isset($review['re'][0])): ?>
                                                        <div class="product-reviews-answers">
                                                            <?php foreach ($review['re'] as $re): ?>
                                                                <div class="product-reviews-answers-item">
                                                                    <div class="product-reviews-answers__name">
                                                                        <?= $re['author'] ?>
                                                                        <div class="video-reviews-date"><?= $re['date_added'] ?></div>
                                                                    </div>
                                                                    <div class="product-reviews-answers__comment">
                                                                        <?= $re['text'] ?>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach ?>
                                                        </div>
                                                    <?php endif ?>
                                                    <!--ANSWERS-->
                                                </div>
                                            <?php endforeach ?>

                                        </div>
                                        <div class="product-buttons">
                                            <div class="product-buttons-col product-buttons-col--left">
                                                <button class="js-open-modal-review btn btn--red btn--full btn--lg-h send__review">
                                                    <span class="btn__inner">
                                                        <?= Yii::t('app', 'Give feedback') ?>
                                                    </span>
                                                </button>
                                            </div>

                                            <?php if (isset($reviews[3])): ?>
                                                <div class="product-buttons-col product-buttons-col--right js-show-more-reviews">
                                                    <button class="btn btn--black btn--full btn--lg-h">
                                                        <span class="btn__inner">
                                                             <?= Yii::t('app', 'Show more reviews') ?>
                                                        </span>
                                                    </button>
                                                </div>
                                            <?php endif ?>
                                        </div>

                                    <?php else: ?>
                                        <div>
                                            <h3 class="product-tabs__title">
                                                <?= Yii::t('app', 'THIS PRODUCT HAS NO REVIEWS, YOU CAN LEAVE THE FIRST REVIEW') ?>
                                            </h3>
                                            <br>
                                            <button class="js-open-modal-review btn btn--red btn--full btn--lg-h send__review"
                                                    style="width: 300px; margin-top: 20px;">
                                                <span class="btn__inner">
                                                    <?= Yii::t('app', 'Give feedback') ?>
                                                </span>
                                            </button>
                                        </div>
                                    <?php endif ?>

                                </div>

                            </section>
                        </div>
                        <div class="product-tabs-row s_tabs_content">
                            <div class="product-tabs-wrap">
                                <h2 class="product-tabs__title" tabindex="0"><?= Yii::t('app', 'Other videos') ?></h2>
                                <div class="product-tabs-inner">

                                    <?php if (isset($videos['other']) && count($videos['other']) > 0): ?>
                                        <div class="row">
                                            <?php foreach ($videos['other'] as $video): ?>
                                                <div class="col-md-6 mb-4">
                                                    <?= isset($video['content']) ? $video['content'] : '' ?>
                                                </div>
                                            <?php endforeach ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div><div class="product-col product-col--right">
                <div class="product-top mob-hide-x1279">
                    <div class="product-top-col product-top-col--left">
                        <div class="product__article"><?= Yii::t('app', 'sku') ?>: <?= $product->sku ?></div>
                    </div>
                    <div class="product-top-col product-top-col--right">
                        <div class="product__availability <?= (!$product->stock_status) ? 'not__availability' : '' ?>">
                            <?= ($product->stock_status) ? Yii::t('app', 'available') : Yii::t('app', 'not_available') ?>
                        </div>
                    </div>
                </div>
                <h1 class="product__name mob-hide-x1279">
                    <?= $product->description->name ?>
                </h1>
                <div class="product-prices justify-content-end">

                <!--формирование цен-->
                <?php if($product->price !== 0): ?>
                    <?= FormationPriceWidget::widget(['product' => $product]) ?>
                <?php endif ?>

                    <div class="product-prices-col product-prices-col--right">
                        <div class="pay-icons">
                            <div class="pay-icons__item"
                                 role="tooltip"
                                 data-microtip-position="top"
                                 aria-label="<?= $settings['payment_systems_installments'] ?>">
                                <img loading="lazy" src="/images/icon_pay0.svg"
                                     alt="<?= $settings['payment_systems_installments'] ?>" class="pay-icons__img">
                            </div>
                            <div class="pay-icons__item"
                                 role="tooltip"
                                 data-microtip-position="top"
                                 aria-label="<?= $settings['payment_systems_visa'] ?>">
                                <img loading="lazy" src="/images/icon_pay2.svg"
                                     alt="<?= $settings['payment_systems_visa'] ?>" class="pay-icons__img">
                            </div>
                            <div class="pay-icons__item"
                                 role="tooltip"
                                 data-microtip-position="top"
                                 aria-label="<?= $settings['payment_systems_mastercard'] ?>">
                                <img loading="lazy" src="/images/icon_pay3.svg"
                                     alt="<?= $settings['payment_systems_mastercard'] ?>" class="pay-icons__img">
                            </div>
                            <?php if (defined('IS_DEV')): ?>
                                <div class="pay-icons__item"
                                     role="tooltip"
                                     data-microtip-position="top"
                                     aria-label="<?= $settings['payment_systems_apple_pay'] ?>">
                                    <img loading="lazy" src="/images/icon_pay4.svg"
                                         alt="<?= $settings['payment_systems_apple_pay'] ?>" class="pay-icons__img">
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="product__compare">
                        <span></span>
                    </div>

                </div>
                <!--PRICES-->
                <div class="product-sizes">
                    <div class="product-sizes-head">
                        <h2 class="product-sizes__title"><?= Yii::t('app', 'choose size') ?>:</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">

                            <div class="product-sizes-content-row product-sizes-content-row--sizes js-sizes-height">
                                <div id="js-product-size" class="sizes-switch sizes-switch--product">

                                    <?php if (is_array($options) && count($options)): ?>
                                        <?php foreach ($options as $option): ?>
                                            <?php if ($product->stock_status): ?>
                                                <div class="sizes-switch__item<?php
                                                    if ($option['quantity_sum'] > 0){
                                                        echo ' js-product-size sizes-switch__item--stock';
                                                        echo reset($options) == $option ? ' sizes-switch__item--active' : '';
                                                    }
                                                ?>"  data-product_id="<?= $option['product_id'] ?>"
                                                     data-option_id="<?= $option['option_id'] ?>">
                                                    <?= $option['name'] ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="sizes-switch__item"
                                                     role="tooltip"
                                                     aria-label="<?= $option['name'] ?>"
                                                     data-microtip-position="top"><?= $option['name'] ?></div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <div class="js-product-size sizes-switch__item sizes-switch__item--stock sizes-switch__item--active"
                                             data-product_id=""
                                             data-option_id=""><?= Yii::t('app', 'no sizes') ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>

                            <div class="product-sizes-content-row product-sizes-content-row--bot js-sizes-link-show">
                                <div class="link-line-dotted js-sizes-link-inner"><?= Yii::t('app', 'show') ?> <?= Yii::t('app', 'dimensions') ?></div>
                            </div>
                            <div class="product-sizes-content-row product-sizes-content-row--bot  product-sizes-content-row--bot-hidden js-sizes-hidden">
                                <div class="link-line-dotted js-sizes-link-inner"><?= Yii::t('app', 'hide') ?> <?= Yii::t('app', 'dimensions') ?></div>
                            </div>
                        </div>
                        <?php if (!empty($product->tablesize_id)): ?>
                            <section class="video-modal">
                                <section class="video-modal-window">
                                    <svg class="video-modal-close js-modal-video-close" width="18" height="18"
                                         viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.75 0L18 2.24999L2.25006 17.9999L6.58121e-05 15.7499L15.75 0Z"></path>
                                        <path d="M0 2.24999L2.24999 2.46558e-06L17.9999 15.7499L15.7499 17.9999L0 2.24999Z"></path>
                                    </svg>
                                    <iframe class="video-modal-youtube js-modal-video-youtube" frameborder="0"
                                            allow="autoplay;" allowfullscreen="" src=""></iframe>
                                </section>
                            </section>
                            <div class="col-md-6 mb-2 text-center">
                                <div class="row no-gutters justify-content-center">
                                    <div class="col-sm-6 pb-3 pr-sm-2<?= $product->video ? '' : ' d-none' ?>">
                                        <button class="button-4 w-100 text-nowrap js-video-modal-open"
                                                data-video-src="<?= $product->video ? $product->video : '' ?>"
                                                onclick="gtag('event', 'category', {'event_category': 'Размер видео', 'event_action': 'Нажатие на кнопку'});"><i
                                                    class="play-icon"></i><?= Yii::t('app', 'video instruction') ?>
                                        </button>
                                    </div>
                                    <div class="col-sm-6 pb-3">
                                        <button class="button-5 w-100 js-open-modal-img-size" onclick="gtag('event', 'category', {'event_category': 'Размер сетка в карточке', 'event_action': 'Нажатие на кнопку'});"><i
                                                    class="grid-icon">
                                                <span></span><span></span><span></span><span></span>
                                            </i><?= Yii::t('app', 'size chart') ?>
                                        </button>
                                        <div class="modal modal--img-size">
                                            <div class="modal-content">
                                                <span class="modal__close modal__close--img-size"></span>
                                                <div class="modal-content-inner">
                                                    <img loading="lazy"
                                                         src="/images/tablesize/<?= $product->tablesize_id ?>"
                                                         alt="<?= $product->tablesize_id ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="size-text" role="tooltip" data-microtip-size="large" data-microtip-position="top"
                                      aria-label="<?= isset($settings['how_to_choose_size']) ? $settings['how_to_choose_size'] : '' ?>">
                                    <span class="mr-2">
                                        <svg width="1em" height="1em" fill="currentColor" viewBox="0 0 330 330">
	<path d="M165,0C74.019,0,0,74.02,0,165.001C0,255.982,74.019,330,165,330s165-74.018,165-164.999C330,74.02,255.981,0,165,0z    M165,300c-74.44,0-135-60.56-135-134.999C30,90.562,90.56,30,165,30s135,60.562,135,135.001C300,239.44,239.439,300,165,300z"/>
	<path d="M164.998,70c-11.026,0-19.996,8.976-19.996,20.009c0,11.023,8.97,19.991,19.996,19.991   c11.026,0,19.996-8.968,19.996-19.991C184.994,78.976,176.024,70,164.998,70z"/>
	<path d="M165,140c-8.284,0-15,6.716-15,15v90c0,8.284,6.716,15,15,15c8.284,0,15-6.716,15-15v-90C180,146.716,173.284,140,165,140z   "/>
</svg>
                                    </span>
                                    <?= Yii::t('app', 'How to choose the size') ?>?
                                </span>
                            </div>
                        <?php endif ?>
                    </div>
                    <!--SIZES CONTENT-->
                </div>
                <!--PRODUCT SIZES-->
                <div class="product-colors">
                    <div class="product-sizes-head">
                        <h2 class="product-sizes__title"><?= Yii::t('app', 'choose color') ?>:</h2>
                    </div>
                    <div class="product-colors-items">
                        <?php foreach ($colors as $color): ?>
                            <div role="tooltip"
                                    aria-label="<?= isset($color['name']) ? $color['name'] . ' [' . $color['code_1c'] . ']' : 'Цвет' ?>"
                                    data-microtip-position="top"
                                    class="product-colors__item<?= $product['color'] == $color['color_id'] ? ' _active' : '' ?>">
                                <div>
                                    <a href="<?= isset($color['keyword']) ? LanguageHelper::langUrl($color['keyword']) : '#' ?>">
                                        <img loading="lazy" src="/images/colors/<?= $color['image'] ?>"
                                             data-product_id="<?= $color['prod_id'] ?>"
                                             alt="<?= $color['name'] ?>"
                                             title="<?= $color['name'] ?>">
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <hr class="hr-1 my-4">

                <?php if(!empty($presents)) : ?>
                    <div class="product-gifts mb-4">
                        <div class="product-sizes__title mb-3" data-error="Пожалуйста выберите подарок">Выбрать товар в продарок:</div>
                        <div class="row">
                            <?php foreach ($presents as $present): ?>
                                <div class="col-4 col-sm-2 mb-3">
                                    <a class="product-gifts__item" href="#" onclick="gtag('event', 'category', {'event_category': 'Выбор подарка', 'event_action': 'Нажатие на кнопку'});"
                                       data-id=<?=$present->getProductId()?>
                                       data-sizes='<?= json_encode($present->getOptions()) ?>'>
                                        <img src="<?= ProductHelper::correctedImgPath_500p($present->getImage())  ?>" alt="ddd" title="title">
                                        <span><?=$present->getName()?></span>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif;?>

                <!--PRODUCT COLORS-->
                <?php if ($product->stock_status && $product->price !== 0): ?>
                    <div class="product-buttons">
                        <div class="product-buttons-col  product-buttons-col--left">
                            <button class="btn btn--red btn--full btn--lg-h js-product-add-cart"
                                    onclick="gtag('event', 'category', {'event_category': 'Добавить в корзину карточка', 'event_action': 'Нажатие на кнопку'});">
                                <span class="btn__inner"><?= Yii::t('app', 'add to cart') ?></span>
                            </button>
                        </div>
                        <div class="product-buttons-col product-buttons-col--right">
                            <button class="js-btn-fast-modal btn btn--black btn--full btn--lg-h js-open-modal-quik-buy"
                                    onclick="gtag('event', 'category', {'event_category': 'Быстрая покупка', 'event_action': 'Нажатие на кнопку'});">
                                <span class="btn__inner"><?= Yii::t('app', 'fast buy') ?></span>
                            </button>
                        </div>
                    </div>

                <?php else: ?>

                    <?php $email = isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : '' ?>

                    <div class="product-buttons">
                        <div class="product-buttons-col  product-buttons-col--left">
                            <button class="btn btn--black btn--full btn--lg-h js-open-stock-subscribe"
                                    data-email="<?= $email ?>" data-product_id="<?= $product->product_id ?>">
                                <span class="btn__inner"><?= Yii::t('app', 'Inform about availability') ?></span>
                            </button>
                        </div>

                        <?php $analogLink = LanguageHelper::langUrl(end($inCategory)['keyword']) ?>
                        <div class="product-buttons-col product-buttons-col--right">
                            <a class="btn btn--black btn--full btn--lg-h" target="_blank" href="<?=
                                $analogLink . ProductHelper::getUrlParams($product) ?>">
                                <span class="btn__inner"><?= Yii::t('app', 'Watch analogs') ?></span>
                            </a>
                        </div>
                    </div>

                <?php endif ?>
                <section class="product-watches">
                    <div class="product-watches-col product-watches-col--left js-product-favorite <?= isset($product->favorite) ? 'is-favorite' : '' ?>"
                         data-product-id="<?= $product->product_id ?>">
                        <i class="product-watches__icon product-watches__icon--heart"></i>
                        <div class="product-watches-content" onclick="gtag('event', 'category', {'event_category': 'Добавить в нравится', 'event_action': 'Нажатие на кнопку'});">
                            <div class="product-watches__txt product-watches__txt--big">
                                <?= isset($product->favorite) ? Yii::t('app', 'Added') : Yii::t('app', 'Add to') ?> <?= Yii::t('app', ' wishlist') ?>
                            </div>
                            <div class="product-watches__txt product-watches__txt--min">
                                <?= Yii::t('app', 'Total added people') ?>:
                                <span class="js-favorite-added-all">
									<?= (new WishListHelper)->getTotalCountForProduct($product->product_id) ?>
								</span>
                            </div>
                        </div>
                    </div>
                    <div class="product-watches-col product-watches-col--right js-modal-watch <?= $isUserHasPriceWatch ? 'watch-active' : '' ?>"
                         onclick="gtag('event', 'category', {'event_category': 'Следить за ценой', 'event_action': 'Нажатие на кнопку'});">
                        <i class="product-watches__icon product-watches__icon--glasses"></i>
                        <div class="product-watches-content">
                            <div class="product-watches__txt product-watches__txt--big"
                                 data-set-text="<?= Yii::t('app', 'Track price and discounts') ?>"
                                 data-unset-text="<?= Yii::t('app', 'You follow the price of the goods') ?>"
                            >
                                <?= $isUserHasPriceWatch
                                    ? Yii::t('app', 'You follow the price of the goods')
                                    : Yii::t('app', 'Track price and discounts')
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal modal--watch">
                        <div class="modal-content">
                            <span class="modal__close modal__close--watch"></span>
                            <div class="modal__title"><?= Yii::t('app', 'Track price') ?></div>
                            <form id="follow-price">
                                <p><?= Yii::t('app', 'As soon as the price of the product goes down, we will send you an e-mail') ?></p>
                                <input required type="email" class="input-1" placeholder="<?= Yii::t('app', 'Enter your E-mail') ?>">
                                <button class="button-3 w-100" onclick="gtag('event', 'category', {'event_category': 'Следить за ценой', 'event_action': 'Нажатие на кнопку'});"
                                ><?= Yii::t('app', 'Track price') ?></button>
                            </form>
                        </div>
                    </div>
                </section>
                <?php if (false): ?>
                    <section class="product-choice">
                        <div class="product-choice-col product-choice-col--left">
                            <i class="product-choice__icon"></i>
                            <div class="product-choice__txt">
                                <?= Yii::t('app', 'How to choose the size') ?>?
                            </div>
                        </div>
                        <div class="product-choice-col product-choice-col--right">
                            <button class="btn btn--red btn--full btn--lg-x">
                                <a href="<?= LanguageHelper::langUrl($settings['sizing_video']) ?>">
                                    <span class="btn__inner"><?= Yii::t('app', 'Watch the video') ?></span>
                                </a>
                            </button>
                        </div>
                    </section>
                <?php endif ?>

                <?php if ($product->stock_status): ?>
                    <div class="reserve-block">
                        <div class="row align-items-center">
                            <div class="col-md-6 py-3">
                                <div class="row align-items-center cursor-pointer" role="tooltip"
                                     data-microtip-position="top"
                                     data-microtip-size="large"
                                     aria-label="<?= isset($settings['pickup_from_our_stores']) ? $settings['pickup_from_our_stores'] : '' ?>">
                                    <div class="col-auto">
                                        <svg width="50" height="50" viewBox="0 0 15 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <rect x="8.18164" y="10.7308" width="1.63636" height="4.90167"
                                                  transform="rotate(180 8.18164 10.7308)" fill="#5B5A5A"/>
                                            <rect x="8.18164" y="4.31287" width="1.63636" height="1.75139"
                                                  transform="rotate(180 8.18164 4.31287)" fill="#5B5A5A"/>
                                            <circle cx="7.5" cy="7.5" r="7" stroke="#5B5A5A"/>
                                        </svg>
                                    </div>
                                    <div class="col"><?= Yii::t('app', 'SELECTION FROM OUR STORES') ?></div>
                                </div>
                            </div>
                            <div class="col-md-6 py-3">
                                <a href="" class="btn btn--lg-lx btn--trans btn--trans-red js-open-modal-shop w-100"
                                   onclick="gtag('event', 'category', {'event_category': 'Резервировать в магазинах', 'event_action': 'Нажатие на кнопку'});">
                                    <span class="btn__inner"><?= Yii::t('app', 'reserve in stores') ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <div class="product-accordion mob-show-x1279">
                    <section class="product-accord">
                        <article class="product-accord-item">
                            <header class="product-accord-head js-toggle-slide">
                                <div class="product-accord-head__title"><?= Yii::t('app', 'description') ?></div>
                            </header>
                            <article class="product-accord-cont js-toggle-cont">
                                <section class="product-desc">
                                    <div class="product-desc-content">
                                        <?php if ($product->show_excerpt == 1 && $product->description->excerpt): ?>
                                            <?= html_entity_decode($product->description->excerpt) ?><br>
                                        <?php endif ?>
                                        <?= html_entity_decode($product->description->description) ?>
                                    </div>
                                </section>
                            </article>
                        </article>
                        <article class="product-accord-item">
                            <header class="product-accord-head js-toggle-slide">
                                <div class="product-accord-head__title"><?= Yii::t('app', 'characteristics') ?></div>
                            </header>
                            <article class="product-accord-cont js-toggle-cont">
                                <div class="product-feature">
                                    <div class="product-feature-row">
                                        <div class="product-feature-row-col product-feature-row-col--left">
                                            <div class="product-feature__name"><?= Yii::t('app', 'manufacturer') ?>:
                                            </div>
                                        </div>
                                        <div class="product-feature-row-col product-feature-row-col--right">
                                            <div class="product-feature__option"><?= $product->brand->name ?></div>
                                        </div>
                                    </div>
                                    <?php if (isset($attrGroups[0])): ?>
                                        <?php foreach (ProductService::prepareAttributes($attrGroups) as $attribute): ?>
                                            <div class="product-feature-row">
                                                <div class="product-feature-row-col product-feature-row-col--left">
                                                    <div class="product-feature__name"><?= $attribute['group_name'] ?></div>
                                                </div>
                                                <div class="product-feature-row-col product-feature-row-col--right">
                                                    <div class="product-feature__option"><?= $attribute['values'] ?></div>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                            </article>
                        </article>

                        <article class="product-accord-item ">

                            <?php if (isset($reviews[0])): ?>
                                <header class="product-accord-head js-toggle-slide">
                                    <div class="product-accord-head__title"><?= Yii::t('app', 'reviews') ?>
                                        (<?= count($reviews) ?>)
                                    </div>
                                </header>

                                <article class="product-accord-cont js-toggle-cont">

                                    <?php foreach ($reviews as $review): ?>
                                        <div class="product-reviews-row">
                                            <div class="product-reviews-top">
                                                <div class="product-reviews-top-col product-reviews-top-col--left">
                                                    <div class="product-reviews__name"><?= $review['author'] ?></div>
                                                </div>
                                                <div class="product-reviews-top-col product-reviews-top-col--right">
                                                    <div class="rating">
                                                        <?= ProductHelper::getRatingStars($review) ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="product-reviews__comments">
                                                <?= $review['text'] ?>
                                            </div>

                                            <div class="product-reviews-bot">

                                                <div class="product-reviews-bot-col product-reviews-bot-col--left">

                                                    <div class="product-reviews-buttons">

                                                        <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                                                            <button class="js-open-modal-review btn btn--trans btn--lxs answer_review"
                                                                    data-review_id="<?= $review['review_id'] ?>">
                                                                <span class="btn__inner"><?= Yii::t('app', 'answer') ?></span>
                                                            </button>
                                                        </div>

                                                        <?php if (isset($review['re'][0])): ?>
                                                            <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                                                                <div class="product-reviews__link js-answers">
                                                                    <?= Yii::t('app', 'comments') ?>
                                                                    <span>(<?= count($review['re']) ?>)</span>
                                                                </div>
                                                            </div>
                                                        <?php endif ?>
                                                    </div>

                                                </div>

                                                <div class="product-reviews-bot-col product-reviews-bot-col--right">
                                                    <div class="video-reviews-date"><?= Yii::$app->formatter->asDate($review['date_added'], 'dd.MM.yyyy') ?></div>
                                                </div>
                                            </div>

                                            <?php if (isset($review['re'][0])): ?>
                                                <div class="product-reviews-answers">
                                                    <?php foreach ($review['re'] as $re): ?>
                                                        <div class="product-reviews-answers-item">
                                                            <div class="product-reviews-answers__name">
                                                                <?= $re['author'] ?>
                                                                <div class="video-reviews-date"><?= $re['date_added'] ?></div>
                                                            </div>
                                                            <div class="product-reviews-answers__comment">
                                                                <?= $re['text'] ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach ?>
                                                </div>
                                            <?php endif ?>
                                            <!--ANSWERS-->

                                        </div>
                                    <?php endforeach ?>

                                </article>

                            <?php else: ?>

                                <header class="product-accord-head js-toggle-slide">
                                    <div class="product-accord-head__title"><?= Yii::t('app', 'No reviews, leave') ?>?
                                    </div>
                                </header>

                                <article class="product-accord-cont product-accord-cont--empty-rev js-toggle-cont">

                                    <h3 class="product-tabs__title">
                                        <?= Yii::t('app', 'THIS PRODUCT HAS NO REVIEWS, YOU CAN LEAVE THE FIRST REVIEW') ?>
                                    </h3>
                                    <br>
                                    <button class="js-open-modal-review btn btn--red btn--full btn--lg-h send__review"
                                            style="width: 300px; margin-top: 20px;">
                                                <span class="btn__inner">
                                                    <?= Yii::t('app', 'Give feedback') ?>
                                                </span>
                                    </button>

                                </article>
                            <?php endif ?>

                        </article>


                        <?php if (isset($videos['other']) && count($videos['other']) > 0): ?>
                            <article class="product-accord-item">
                                <header class="product-accord-head js-toggle-slide">
                                    <div class="product-accord-head__title"><?= Yii::t('app', 'video') ?></div>
                                </header>
                                <article class="product-accord-cont js-toggle-cont">
                                    <?php /*if (isset($images['main'])):*/ ?>
                                    <section class="product-media js-product-media-slider">

                                        <?php foreach ($videos['other'] as $video): ?>
                                            <figure class="product-media-col product-media__video">
                                                <img loading="lazy" src=https://img.youtube.com/vi/"<?=
                                                  $video['id_video'] ?>/0.jpg"
                                                     alt="<?= $video['name'] ?>"
                                                     title="<?= $video['name'] . ' - Prof1group' ?>"
                                                     data-video-src="<?= $video['id_video']
                                                        //ProductService::checkoVideo($video)
                                                     ?>"
                                                     class="product-media__video-img">
                                                <button class="product-media__video-button" type="button"
                                                        aria-label="Запустить видео"
                                                        title="Запустить видео">
                                                    <svg width="68" height="48" viewBox="0 0 68 48">
                                                        <path class="product-media__video-button-shape"
                                                              d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                                                        <path class="product-media__video-button-icon"
                                                              d="M 45,24 27,14 27,34"></path>
                                                    </svg>
                                                </button>
                                            </figure>
                                        <?php endforeach ?>
                                        <?php /* endif*/ ?>
                                    </section>
                                </article>
                            </article>
                        <?php endif ?>

                    </section>

                </div>

                <section class="product-delivery">
                    <div class="product-delivery-col product-delivery-col--left">
                        <h3 class="product-delivery__title"><?= $settings['delivery_in_Ukraine_title'] ?>:</h3>
                        <ul class="product-delivery-list">
                            <?= ProductHelper::wrapToList($settings['delivery_in_Ukraine'], 'product-delivery-list__item') ?>
                        </ul>
                        <a rel="nofollow" target="_blank" href="<?= $settings['link_delivery_in_ua'] ?>"
                           class="product-delivery__link" onclick="gtag('event', 'category', {'event_category': 'Рассчитать доставку Украина', 'event_action': 'Нажатие на кнопку'});"
                        ><?= Yii::t('app', 'calculate shipping cost') ?></a>
                    </div>
                    <div class="product-delivery-col product-delivery-col--right">
                        <h3 class="product-delivery__title"><?= $settings['delivery_other_countries_title'] ?>:</h3>
                        <ul class="product-delivery-list">
                            <?= ProductHelper::wrapToList($settings['delivery_to_other_countries'], 'product-delivery-list__item') ?>
                        </ul>
                        <a rel="nofollow" target="_blank" href="<?= $settings['link_delivery_2'] ?>"
                           class="product-delivery__link" onclick="gtag('event', 'category', {'event_category': 'Расчитать доставку Страны', 'event_action': 'Нажатие на кнопку'});"
                        ><?= Yii::t('app', 'calculate shipping cost') ?></a>
                    </div>
                </section>
                <section class="product-garanties">
                    <h3 class="product-garanties__title"><?= $settings['quality_assurance_title'] ?></h3>
                    <div class="product-garanties__desc">
                        <?= $settings['warranty_information'] ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="content-extra-wrap">

        <?php if (defined('IS_DEV')): ?>
            <div class="wrapper mb-5 mt-4">
                <h2 class="content-extra__title">ВМЕСТЕ ДЕШЕВЛЕ</h2>

                <div class="slider-2 mt-n5">
                    <?php for ($item = 0; $item < 4; $item++): ?>
                        <div class="slider-2__item">
                            <div class="row align-items-center bundle-1">
                                <?php for ($i = 0; $i < 2; $i++): ?>
                                    <div class="col-lg-6 col-xl mb-4">
                                        <div class="product-item-1">
                                            <div class="row align-items-center">
                                                <div class="col-auto text-center">
                                                    <a href="#">
                                                        <img class="product-item-1__image"
                                                             src="https://dev.p1gtac.com/images/products/import_files/00005436/cd35d9575c2511e980bc005056807e63_cd35d9585c2511e980bc005056807e63-228x228.jpg"
                                                             alt="">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <div class="row product-item-1__buttons">
                                                        <div class="col-auto">
                                                            <button class="js-favorite">
                                                                <svg width="1em" height="1em" viewBox="0 0 32 21"
                                                                     fill="none">
                                                                    <path d="M2 4.85714L16 19L30 4.85714L26.1818 1H19.8182L16 4.85714L12.1818 1H5.81818L2 4.85714Z"
                                                                          stroke="currentColor" stroke-width="2"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button class="js-compare">
                                                                <svg width="1em" height="1em"
                                                                     viewBox="23.083 23.843 74.333 51.981">
                                                                    <rect x="57.946" y="23.843" width="4.5"
                                                                          height="51.981"></rect>
                                                                    <polygon
                                                                            points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"></polygon>
                                                                    <path d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"></path>
                                                                    <path d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div class="col-auto"><span class="badge-1">-15 %</span></div>
                                                    </div>
                                                    <a href="#" class="product-item-1__title">Куртка демисезонная утепляющая
                                                        "URSUS
                                                        POWER-FILL"</a>
                                                    <span class="price-1 mr-2"><small>₴</small> 2100</span>
                                                    <span class="price-2 line-through"><small>₴</small> 3000</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                <div class="col-xl-20 mb-4">
                                    <a href="#" class="button-2 w-100 mt-2" onclick="gtag('event', 'category', {'event_category': 'В корзину вместе дешевле', 'event_action': 'Нажатие на кнопку'});">Добавить в корзину</a>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>



            </div>
        <?php endif ?>

        <?php if (defined('IS_DEV')): ?>
            <div class="wrapper mb-3">
                <h2 class="content-extra__title">КУПИТЬ БОЛЬШИМ НАБОРОМ</h2>
                <div class="slider-2 mt-n5">
                    <?php for ($slides = 0; $slides < 4; $slides++): ?>
                        <div class="slider-2__item">
                            <div class="row row-20 align-items-center bundle-2">
                                <?php for ($i = 0; $i < 4; $i++): ?>
                                    <div class="col-6 col-xl-20 mb-4">
                                        <article class="product-card">
                                            <header class="product-card__header">
        <span class="product-card__label background_hit">
             лидер			        </span>
                                                <section class="product-card__option">
                                                    <button class="product-card__option-item js-favorite">
                                <span class="product-card__option-icon product-card__option-icon--fav">
                                    <svg width="32" height="21" viewBox="0 0 32 21" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z"
                                              stroke-width="2"></path>
                                    </svg>
                                </span>
                                                    </button>
                                                    <button class="product-card__option-item">
                                <span class="product-card__option-icon product-card__option-icon--comp">
                                    <svg width="29" height="21" viewBox="0 0 29 21" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <mask id="a" maskUnits="userSpaceOnUse" x="0" y="11.5" width="13" height="8"
                                              fill="#000">
                                            <path fill="#fff" d="M0 11.5h13v8H0z"></path><path fill-rule="evenodd"
                                                                                               clip-rule="evenodd"
                                                                                               d="M3 13.5a3.508 3.508 0 006.973 0H3z"></path>
                                        </mask>
                                        <path class="_path"
                                              d="M3 13.5v-2H.767l.245 2.22L3 13.5zm6.973 0l1.987.22.246-2.22H9.973v2zm-3.487 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.499-1.338a1.508 1.508 0 01-1.499 1.338v4a5.508 5.508 0 005.474-4.898l-3.975-.44zm1.988-1.78H3v4h6.973v-4z"
                                              fill="#000" mask="url(#a)"></path>
                                        <mask id="b" maskUnits="userSpaceOnUse" x="16.973" y="11.5" width="13"
                                              height="8" fill="#000">
                                            <path fill="#fff" d="M16.973 11.5h13v8h-13z"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M19.973 13.5a3.508 3.508 0 006.972 0h-6.972z"></path>
                                        </mask>
                                        <path class="_path"
                                              d="M19.973 13.5v-2h-2.234l.246 2.22 1.988-.22zm6.972 0l1.988.22.245-2.22h-2.233v2zm-3.486 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.498-1.338a1.508 1.508 0 01-1.498 1.338v4a5.508 5.508 0 005.474-4.898l-3.976-.44zm1.988-1.78h-6.972v4h6.972v-4z"
                                              fill="#000" mask="url(#b)"></path>
                                        <path d="M14.973 0v21m-9-12.5v-4h18v4" stroke="#1D2023"
                                              stroke-width="2"></path>
                                    </svg>
                                </span>
                                                    </button>
                                                </section>
                                            </header>
                                            <section class="product-card__body">
                                                <section class="product-card__img-slider js-product-card-img-slider">
                                                    <a class="product-card__img-link"
                                                       href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                                        <img loading="lazy"
                                                             src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg"
                                                             alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER"
                                                             class="product-card__img">
                                                    </a>
                                                    <a class="product-card__img-link"
                                                       href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                                        <img loading="lazy"
                                                             src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg"
                                                             alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER"
                                                             class="product-card__img">
                                                    </a>
                                                </section>

                                                <section
                                                        class="product-card__color-slider js-product-card-color-slider">
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000238.jpg"
                                                             alt="P1G" class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000307.jpg"
                                                             alt="P1G" class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000238.jpg"
                                                             alt="P1G" class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000307.jpg"
                                                             alt="P1G" class="product-card__color-img">
                                                    </article>
                                                </section>
                                            </section>

                                            <footer class="product-card__footer">
                                                <h3 class="product-card__name">
                                                    <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather"
                                                       class="product-card__name-link">
                                                        Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL
                                                        HEATHER </a>
                                                </h3>
                                                <div class="product-card-bot-view-2">
                                                    <section class="product-card__prices">
                                                        <section class="product-card__price product-card__price--new">
                                                            <span>₴</span>
                                                            <span class="js-product-new-price"> 684</span>
                                                        </section>
                                                        <section class="product-card__price product-card__price--old">
                                                            <span>₴</span>
                                                            <span class="js-product-old-price"> 855</span>
                                                        </section>
                                                    </section>
                                                    <button class="product-card__cart js-open-modal-size">
                                                        <svg class="product-card__cart-svg" width="28" height="25"
                                                             viewBox="0 0 28 25" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z"
                                                                  stroke="#1D2023" stroke-width="2"></path>
                                                            <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023"
                                                                  stroke-width="2"></path>
                                                            <circle cx="10.4314" cy="21.8627" r="2.19608"
                                                                    fill="#1D2023"></circle>
                                                            <circle cx="20.3138" cy="21.8627" r="2.19608"
                                                                    fill="#1D2023"></circle>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </footer>
                                        </article>
                                    </div>
                                <?php endfor; ?>
                                <div class="col-xl-20">
                                    <span class="text-uppercase mr-1">Набором:</span>
                                    <span class="price-1 mr-2"><small>₴</small> 2100</span>
                                    <span class="price-2 line-through"><small>₴</small> 3000</span>
                                    <br>
                                    <a href="#" class="button-2 w-100 mt-2">Добавить в корзину</a>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif ?>

        <br>
        <div class="wrapper block__viewed"></div>
        <?php /* ?>
            <?php if ($viewed): ?>
                <br>
                <div class="wrapper">
                    <div class="content-extra content-extra--product">
                        <h2 class="content-extra__title"><?= Yii::t('app', 'you looked at the goods') ?></h2>
                        <div class="carousel-1 mt-n5">
                            <?= $this->render('/parts/_items-common', [
                                'items' => $viewed,
                                'currency' => $currency,
                                'productService' => $productService,
                                'wishList' => $wishList,
                                'compare' => $compare,
                                'email' => $email,
                                'stockWatch' => $stockWatch,
                                'presents' => $presentsArr
                            ])
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php */ ?>

        <div class="wrapper block__similar"></div>
        <?php /* ?>
            <?php if (isset($similars['mpn']) && count($similars['mpn'])): ?>
                <br>
                <div class="wrapper">
                    <div class="content-extra content-extra--product">
                        <h2 class="content-extra__title"><?= Yii::t('app', 'similar products') ?></h2>
                        <div class="carousel-1 mt-n5">
                            <?= $this->render('/parts/_items-common', [
                                'items' => $similars,
                                'currency' => $currency,
                                'productService' => $productService,
                                'wishList' => $wishList,
                                'compare' => $compare,
                                'email' => $email,
                                'stockWatch' => $stockWatch,
                                'presents' => $presentsArr
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php */ ?>

        <div class="wrapper block__watching"></div>
        <?php /* ?>
            <?php if (isset($watching['mpn'])): ?>
                <div class="wrapper">
                    <div class="content-extra content-extra--product content-extra--product-last">
                        <h2 class="content-extra__title"><?= Yii::t('app', 'buyers are also watching') ?></h2>
                        <div class="carousel-1 mt-n5">
                                <?= $this->render('/parts/_items-common', [
                                    'items' => $watching,
                                    'currency' => $currency,
                                    'productService' => $productService,
                                    'wishList' => $wishList,
                                    'compare' => $compare,
                                    'email' => $email,
                                    'stockWatch' => $stockWatch,
                                    'presents' => $presentsArr
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        <?php */ ?>

        <div class="wrapper block__groups"></div>
        <?php /* ?>
            <div class="wrapper block__groups">
                <div class="s_tabs product-card-tabs">
                    <ul class="content-nav s_tabs_list">
                        <li class="content-nav__item active" data-link="hits"
                            data-title="<?= Yii::t('app', 'leaders') ?>"><?= Yii::t('app', 'leaders') ?></li>
                        <li class="content-nav__item" data-link="novelty"
                            data-title="<?= Yii::t('app', 'new items') ?>"><?= Yii::t('app', 'new items') ?></li>
                        <li class="content-nav__item" data-link="sales"
                            data-title="<?= Yii::t('app', 'sale') ?>"><?= Yii::t('app', 'sale') ?></li>
                        <li class="content-nav__item" data-link="recommend"
                            data-title="<?= Yii::t('app', 'recommend') ?>"><?= Yii::t('app', 'recommend') ?></li>
                        <li class="content-nav__item" data-link="shares"
                            data-title="<?= Yii::t('app', 'aktsii') ?>"><?= Yii::t('app', 'aktsii') ?></li>
                    </ul>
                    <?php foreach ($productGroup as $key => $group): ?>
                        <div class="product-card-wrap s_tabs_content <?= $key === 0 ? 'active' : '' ?>">
                            <div class="carousel-1c <?= $key !== 0 ? 'unslick' : '' ?>">
                                <?= $this->render('/parts/_items-common', [
                                        'items' => $items[$group],
                                        'name' => $group,
                                        'currency' => $currency,
                                        'productService' => $productService,
                                        'wishList' => $wishList,
                                        'compare' => $compare,
                                        'email' => $email,
                                        'stockWatch' => $stockWatch,
                                        'presents' => $presentsArr
                                    ]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php */ ?>
    </div>
</div>

<div class="modal modal--shop">
    <div class="modal-content">
        <span class="modal__close modal__close--shop"></span>
        <div class="modal__title"><?= Yii::t('app', 'RESERVATION IN STORES') ?></div>

        <?php if ($storeList): ?>
            <div class="popup-shop">

                <div class="popup-shop-top">
                    <div class="popup-shop-top-col popup-shop-top-col--left">
                        <select class="select-popup js-reserve-filter" <?= count($cityStoreUniqList) === 1 ? 'disabled' : false ?>>
                            <?php if (count($cityStoreUniqList) > 1): ?>
                                <option value="all"><?= Yii::t('app', 'all cities') ?></option>
                            <?php endif ?>
                            <?php foreach ($cityStoreUniqList as $store): ?>
                                <option value="<?= $store['store_city'] ?>"><?= $store['store_city'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="popup-shop-top-col popup-shop-top-col--right">
                        <div class="popup-shop-top__info">
                            <span>*</span> <?= Yii::t('big', 'You can reserve goods in our stores before the end of the working day.') ?>
                        </div>
                    </div>
                </div>


                <div class="popup-shop-table">
                    <table>
                        <thead>
                        <tr>
                            <td><?= Yii::t('app', 'Product dimensions') ?></td>
                            <td><?= Yii::t('app', 'Store addresses') ?></td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="popup-shop-table">

                    <table>

                        <tbody>

                        <?php foreach ($storeList as $store): ?>
                            <?php
                            $storeOption = $product->getStoreProductSizesList($store['store_id']);
                            ?>
                            <tr data-city="<?= $store['store_city'] ?>" class="reserve-store">
                                <td aria-label="Размеры">
                                    <div class="popup-shop-table-row popup-shop-table-row--top">
                                        <div class="popup-shop-table-size">
                                            <div class="sizes-switch js-popup-shop-size-height">
                                                <?php foreach ($storeOption as $option): ?>
                                                    <div
                                                        class="sizes-switch__item <?= (int)$option['option_quantity'] > 0 ? 'sizes-switch__item--stock' : '' ?>"
                                                        data-option-id="<?= $option['option_id'] ?>"
                                                    ><?= $option['option_name'] ?></div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (count($storeOption) > 5): ?>
                                        <div class="popup-shop-table-row popup-shop-table-row--bot">
                                            <a href="#"
                                               data-show="<?= Yii::t('app', 'show more') ?>"
                                               data-hide="<?= Yii::t('app', 'hide') ?>"
                                               class="link-line-dotted link-line-dotted--red js-popup-shop-size-but">
                                                <?= Yii::t('app', 'show more') ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td aria-label="Адреса магазинов">
                                    <div class="popup-shop-table-row popup-shop-table-row--top">
                                        <span class="popup-shop-table__txt"><?= $store['store'] ?></span>
                                    </div>
                                    <div class="popup-shop-table-row popup-shop-table-row--bot">
                                        <div class="popup-shop-table-row-col popup-shop-table-row-col--left">
                                            <a target="_blank" href=" <?= LanguageHelper::langUrl('our-stores#' . $store['store_id']) ?>"
                                               class="link-line-dotted _long">
                                                <?= Yii::t('app', 'See address on the map') ?>
                                            </a>
                                        </div>
                                        <div class="popup-shop-table-row-col popup-shop-table-row-col--right">
                                            <button class="btn btn--red btn--lxs js-reserve-product-btn"
                                                    onclick="gtag('event', 'category', {'event_category': 'Резервировать в попапе', 'event_action': 'Нажатие на кнопку'});"
                                                    data-product-id="<?= $product->product_id ?>"
                                                    data-store-id="<?= $store['store_id'] ?>">
                                                <span class="btn__inner"><?= Yii::t('app', 'reserve') ?></span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (Yii::$app->user->isGuest): ?>
                    <div class="auth-warning">
                        <div class="row">
                            <div class="col-12">
                                <div class="popup-shop-table__txt mb-3">
                                    <?= Yii::t('app', 'To reserve a product, you need to go through authorization') ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="#" class="button-2 w-100 js-warning-register"><?= Yii::t('app', 'registration') ?></a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="button-2 w-100 js-warning-login"><?= Yii::t('app', 'login') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="popup-shop-bot">
                        <div class="popup-shop-bot__title">
                            <?= Yii::t('app', 'Only an authorized user can book products!') ?>
                        </div>
                        <div class="popup-shop-bot-inner">
                            <div class="popup-shop-bot-row">
                                <div class="popup-shop-bot-row-col popup-shop-bot-row-col--left">
                                    <div class="b-field"><input class="field-input" type="text" placeholder="E-mail">
                                    </div>
                                </div>
                                <div class="popup-shop-bot-row-col popup-shop-bot-row-col--right">
                                    <div class="b-field"><input class="field-input" type="text"
                                                                placeholder="*<?= Yii::t('app', 'password') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="popup-shop-bot-row">
                                <div class="popup-shop-bot-row-col popup-shop-bot-row-col--left">
                                    <a href="#"
                                       class="link-line-dotted link-line-dotted--red"><?= Yii::t('app', 'You forgot your password') ?>
                                        ?</a>
                                    <a href="#"
                                       class="link-line-dotted link-line-dotted--red"><?= Yii::t('app', 'registration') ?></a>
                                </div>
                                <div class="popup-shop-bot-row-col popup-shop-bot-row-col--right">
                                    <button class="btn btn--red btn--full btn--lg-x">
                                        <span class="btn__inner"><?= Yii::t('app', 'entrance') ?></span>
                                    </button>
                                </div>
                            </div>
                            <div class="popup-shop-bot-row">
                                <div class="popup-shop-bot-row-col popup-shop-bot-row-col--left">
                                    <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl"
                                            onclick="window.location.href = '/customer/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                                        <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with google') ?></span>
                                    </button>
                                </div>
                                <div class="popup-shop-bot-row-col popup-shop-bot-row-col--right">
                                    <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb"
                                            onclick="window.location.href = '/customer/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
                                        <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with facebook') ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="reserve-empty"><?= Yii::t('app', 'This product is not available in stores, the product is only in stock') ?></div>
        <?php endif ?>
        <!--popup-shop-->
    </div>
</div>
