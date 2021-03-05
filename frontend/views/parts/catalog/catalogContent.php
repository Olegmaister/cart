<?php

use yii\helpers\Url;
use frontend\widgets\CustomLinkPager;
use common\helpers\ProductHelper;
use common\helpers\LanguageHelper;
use frontend\services\ProductService;


$compare = ProductService::getCompare();
$wishList = ProductService::getWishList();
$email = ProductService::getEmail();
$stockWatch = ProductService::getStockWatchByEmail($email);
$presents = ProductService::getPresents();

$absoluteUrl = Yii::$app->request->absoluteUrl;
$metaCommon = ['url' => $absoluteUrl];
echo $this->render('/seo',
    array_merge($metaData, $metaCommon)
);

?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Product",
        "url": "<?= $absoluteUrl ?>",
        "name": "<?= $title ?>",
        "offers": {
            "@type": "AggregateOffer",
            "highPrice": "<?= $filtersData['maxPrice'] ?>",
            "lowPrice": "<?= $filtersData['lowPrice'] ?>",
            "offerCount": "<?= $provider->getTotalCount() ?>",
            "priceCurrency":"<?= $currency->getCurrencyName() ?>"
        }
    }



    </script>

<?php
/* Определяем тип для подгузки нижних блоков (вы смотрели товары и покупатели так же смотрят) */
if (isset($isBrands)) {
    if ($isBrands === 'brand_categories') {
        $type = 'brand_categories';
        $value = 'brand_' . $get['brandId'] . '-' . 'category_' . $get['categoryId'];
    } else {
        $type = 'brand';
        $value = $get['id'];
    }
} elseif (isset($category)) { // По ид категории
    $type = 'category';
    $value = $get['id'];
} elseif (isset($name)) { // hit, sale,
    $type = 'group';
    $value = $name;
}
?>

    <div class="page" data-type="<?= $type ?>" data-value="<?= $value ?>">
        <div class="cat-head">
            <div class="wrapper">
                <ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">

                    <?php /* Если категория то хлебые крошки такие */ ?>
                    <?php if (isset($category)): ?>

                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                            </a>
                            <meta itemprop="position" content="1"/>
                        </li>
                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="item" href="<?= LanguageHelper::langUrl('catalog') ?>">
                                <span itemprop="name"><?= Yii::t('app', 'catalog') ?></span>
                            </a>
                            <meta itemprop="position" content="2"/>
                        </li>
                        <?php if (isset($breadcrumbs[1])): ?>
                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <a itemprop="item" href="<?= LanguageHelper::langUrl($breadcrumbs[0]->url->keyword) ?>">
                                    <span itemprop="name"><?= $breadcrumbs[0]->description->name ?></span>
                                </a>
                                <meta itemprop="position" content="3"/>
                            </li>
                            <li><span><?= $title ?></span></li>
                        <?php else: ?>
                            <li><span><?= $breadcrumbs[0]->description->name ?></span></li>
                        <?php endif ?>

                        <?php /* Иначе это хиты, распродажа... то хлебые крошки такие */ ?>
                    <?php else: ?>

                        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a itemprop="name" href="<?= LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                            </a>
                            <meta itemprop="position" content="1"/>
                        </li>
                        <?php if (isset($breadcrumbs['name'])): ?>
                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <a itemprop="item" href="<?= LanguageHelper::langUrl($breadcrumbs['link']) ?>">
                                    <span itemprop="name"><?= Yii::t('app', $breadcrumbs['name']) ?></span>
                                </a>
                                <meta itemprop="position" content="2"/>
                            </li>
                        <?php endif ?>

                        <?php if (isset($isBrands)): ?>
                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <a itemprop="item" href="<?= LanguageHelper::langUrl('brands') ?>">
                                    <span itemprop="name"><?= Yii::t('app', 'brands') ?></span>
                                </a>
                                <meta itemprop="position" content="2"/>
                            </li>
                        <?php endif ?>

                        <li><span><?= $title ?></span></li>

                    <?php endif ?>

                </ul>

                <h1 class="title title--page"<?=
                isset($breadcrumbs) ? 'data-category_id="' . end($breadcrumbs)->description->category_id . '"' : ''
                ?>><?= $title ?></h1>

                <?php /* Блок для категорий */ ?>
                <?php if (isset($path)): ?>
                    <div class="cat-slider">
                        <div class="cat-slider-arrows"></div>

                        <?php if ($path == 'categories'): ?>
                            <?= $this->render('/categories/blocks/category-slider', ['categorySlider' => $slider]); ?>
                        <?php else: ?>
                            <?= $this->render('/categories/blocks/brand-slider', ['brandSlider' => $slider]); ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="page-content page-content--min">
            <div class="wrapper">
                <div class="page-content-columns page-content-columns-cat">

                    <?= $this->render('/parts/catalog/left-sidebar', [
                        'get' => $get,
                        'filtersData' => $filtersData
                    ]) ?>

                    <div class="page-content-col page-content-col--right">
                        <div class="page-options">
                            <div class="page-options-col page-options-col--left">
                                <div class="prod-sort mob-hide-x766">
                                    <div class="prod-sort-col prod-sort-col--left">
                                        <div class="prod-sort__title"><?= Yii::t('app', 'sort') ?> <?=
                                            Yii::t('app', 'by') ?>:
                                        </div>
                                    </div>

                                    <div class="prod-sort-col prod-sort-col--right">
                                        <ul class="prod-sort-menu">
                                            <li class="sorting_section sort_all<?= ProductHelper::isSort($get) ?>"
                                                data-sort="all">
                                                <a href=""><?= Yii::t('app', 'all') ?></a>
                                            </li>
                                            <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'price') ?>"
                                                data-sort="price">
                                                <a href="<?= Url::current(['sort' => 'price']) ?>"><?= Yii::t('app', 'price') ?>
                                                    <span class="arrow_up arrow_down"></a>
                                            </li>

                                            <?php if (isset($fullFilters)): ?>
                                                <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'sale') ?>"
                                                    data-sort="-sale">
                                                    <a href=""><?= Yii::t('app', 'sale') ?><span class=""></a>
                                                </li>
                                                <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'new') ?>"
                                                    data-sort="-new">
                                                    <a href=""><?= Yii::t('app', 'new products') ?><span class=""></a>
                                                </li>
                                                <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'rating') ?>"
                                                    data-sort="-rating">
                                                    <a href=""><?= Yii::t('app', 'rating') ?><span class=""></a>
                                                </li>
                                                <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'viewed') ?>"
                                                    data-sort="-viewed">
                                                    <a href=""><?= Yii::t('app', 'popularity') ?><span class=""></a>
                                                </li>
                                                <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'aktsii') ?>"
                                                    data-sort="-shares">
                                                    <a href=""><?= Yii::t('app', 'shares') ?><span class=""></a>
                                                </li>
                                            <?php else: ?>
                                                <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'date_added') ?>"
                                                    data-sort="date_added">
                                                    <a href=""><?= Yii::t('app', 'date') ?><span class=""></a>
                                                </li>
                                            <?php endif ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="prod-sort-mob mob-show-x766">
                                    <img loading="lazy" src="/images/arrows-sort.svg" alt="sort"
                                         class="sorting_section prod-sort-mob__img mr-2" data-sort="price">
                                    <select class="js-nice-select js-select-filter simple-select">
                                        <option value="all"><?= Yii::t('app', 'all') ?></option>
                                        <option value="price"><?= Yii::t('app', 'price') ?></option>

                                        <?php if (isset($fullFilters)): ?>
                                            <option value="-sale"><?= Yii::t('app', 'sale') ?></option>
                                            <option value="-new"><?= Yii::t('app', 'new products') ?></option>
                                            <option value="-rating"><?= Yii::t('app', 'rating') ?></option>
                                            <option value="-viewed"><?= Yii::t('app', 'popularity') ?></option>
                                        <?php else: ?>
                                            <option value="date_added"><?= Yii::t('app', 'date') ?></option>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>

                            <div class="page-options-col page-options-col--right">
                                <div class="views-buttons">
                                    <div class="views-buttons-but views-buttons-but--view-1 views-buttons-but--active js-toggle-view"></div>
                                    <div class="views-buttons-but views-buttons-but--view-2 js-toggle-view"></div>
                                    <div class="views-buttons-but views-buttons-but--view-3 js-toggle-view"></div>
                                </div>
                            </div>
                        </div>

                        <div class="page-content-inner js-catalog-cards">
                            <div class="product-card-wrap product-card-wrap--card-3x js-toggle-views product-card-wrap--view-1">
                                <?= $this->render('/parts/_items-common', [
                                    'items' => $items,
                                    'currency' => $currency,
                                    'productService' => $productService,
                                    'compare' => $compare,
                                    'wishList' => $wishList,
                                    'email' => $email,
                                    'stockWatch' => $stockWatch,
                                    'presents' => $presents
                                ]) ?>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-xl-6 my-2">
                                    <?php if ($provider): ?>
                                        <?= CustomLinkPager::widget([
                                            'pagination' => $provider->getPagination()
                                        ]) ?>
                                    <?php endif ?>
                                </div>
                                <?php if (ProductService::checkExistNextPage($provider)): ?>
                                    <div class="col-xl-auto ml-auto text-center mb-4">
                                        <button data-current_page="<?= isset($get['page']) ? $get['page'] : 1 ?>"
                                                class="btn btn--lg btn--black show__more_catalog d-inline-block"
                                                onclick="gtag('event', 'category', {'event_category': 'Показать еще в каталоге', 'event_action': 'Нажатие на кнопку'});">
                                            <a href="#" class="btn__inner"><?= Yii::t('app', 'show more') ?></a>
                                        </button>
                                    </div>
                                <?php endif ?>
                                <!--CONTENT INNER-->
                            </div>
                            <!--COL RIGHT-->
                        </div>

                        <?php /* if ($viewed): ?>
                <br>
                <div class="wrapper">
                    <div class="content-extra content-extra--product">
                        <h2 class="content-extra__title"><?= Yii::t('app', 'you looked at the goods') ?></h2>
                        <div class="carousel-1 mt-n5">
                            <?= $this->render('/parts/_items-common', [
                                'items' => $viewed,
                                'currency' => $currency,
                                'productService' => $productService,
                                'compare' => $compare,
                                'wishList' => $wishList,
                                'email' => $email,
                                'stockWatch' => $stockWatch,
                                'presents' => $presents
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php if (isset($watching['mpn'])): ?>
                <div class="wrapper">
                    <div class="content-extra content-extra--product content-extra--product-last">
                        <h2 class="content-extra__title"><?= Yii::t('app', 'buyers are also watching') ?></h2>
                        <div class="carousel-1 mt-n5">
                            <?= $this->render('/parts/_items-common', [
                                'items' => $watching,
                                'currency' => $currency,
                                'productService' => $productService,
                                'compare' => $compare,
                                'wishList' => $wishList,
                                'email' => $email,
                                'stockWatch' => $stockWatch,
                                'presents' => $presents
                            ]) ?>
                        </div>
                    </div>
                </div>
            <?php endif */ ?>

                        <div class="wrapper">
                            <div class="content-extra content-extra--product">
                                <h2 class="content-extra__title"><?= Yii::t('app', 'you looked at the goods') ?></h2>
                                <div class="block__viewed"></div>
                            </div>
                        </div>

                        <div class="wrapper">
                            <div class="content-extra content-extra--product content-extra--product-last">
                                <h2 class="content-extra__title"><?= Yii::t('app', 'buyers are also watching') ?></h2>
                                <div class="block__watching"></div>
                            </div>
                        </div>

                        <?php if (isset($seoBlock) && !empty($seoBlock)) : ?>
                            <?= $this->render('/parts/_seo-block', ['seoBlock' => $seoBlock]) ?>
                        <?php endif ?>
                    </div>

                </div>
            </div>

<?php
// Выводим блоки: вы смотрели товары и покупатели так же смотрят
$this->registerJs(
    'function loadBottomItems() {
        let needData = $(".page");
        let data = {type: needData.data("type"), value: needData.data("value")};
        let prefix = $("html").data("lang");
        prefix = (prefix == "") ? "" : "/" + prefix; 

        $.ajax({
            url: prefix + "/categories/get-bottom-items",
            data: data
        }).done(function (response) {
            //$(".list__items").removeClass("hide");
            $(".block__viewed").html(response.blockViewed);
            $(".block__watching").html(response.blockWatching);

            $(".carousel-1").slick({
              slidesToShow: 4,
              sliderToScroll: 1,
              // autoplay: 4000,
              dots: false,
              prevArrow: "<button type=\"button\" class=\"slick_prev\"></button>",
              nextArrow: "<button type=\"button\" class=\"slick_next\"></button>",
              rows: 0,
              responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 2,
                  }
                }
              ]
            });
        });
  }

  loadBottomItems();
  //setTimeout(loadBottomItems, 6000);',

    \yii\web\View::POS_LOAD
)
?>