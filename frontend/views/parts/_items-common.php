<?php

use common\helpers\ProductHelper;
use common\helpers\LanguageHelper;
use frontend\widgets\Product\FormationPriceWidget;
use frontend\services\ProductService;
//use frontend\services\present\PresentService;

$wishList = isset($wishList) ? $wishList : ProductService::getWishList();
$compare = isset($compare) ? $compare : ProductService::getCompare();
$presents = isset($presents) ? $presents : ProductService::getPresents();
$email = isset($email) ? $email : ProductService::getEmail();
$stockWatch = isset($stockWatch) ? $stockWatch : ProductService::getStockWatchByEmail($email);

?>

<?php if (isset($items['mpn']) && count($items['mpn']) > 0): ?>

    <?php foreach ($items['mpn'] as $productId => $mpn): ?>

        <?php if (isset($items['relate'][$mpn][$productId]['product_id'])):
            $product = $items['relate'][$mpn][$productId] ?>

            <section data-product-id="<?= $product['product_id'] ?>"
                     class="product-card-col">
                <article class="product-card">
                    <header class="product-card__header">
                        <div class="product-card-labels js-product-card-labels">
                            <?= ProductHelper::checkGroupProductArr($product) ?>
                        </div>
                        <div class="product-card__option">
                            <button type="button"
                                    class="product-card__option-item js-favorite<?= in_array($product['product_id'], $wishList) ? ' is-favorite' : '' ?>"
                                    onclick="gtag('event', 'category', {'event_category': 'Добавить в нравится', 'event_action': 'Нажатие на кнопку'});">
                                <span class="product-card__option-icon product-card__option-icon--fav">
                                    <svg width="32" height="21" viewBox="0 0 32 21" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z"
                                              stroke-width="2"></path>
                                    </svg>
                                </span>
                            </button>
                            <button class="product-card__option-item  js-compare<?= in_array($product['product_id'], $compare) ? ' is-compare' : '' ?>"
                                    onclick="gtag('event', 'category', {'event_category': 'Добавить в сравнение', 'event_action': 'Нажатие на кнопку'});">
                                <span class="product-card__option-icon product-card__option-icon--comp">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="74.333px"
                                         height="51.981px" viewBox="23.083 23.843 74.333 51.981"
                                         enable-background="new 23.083 23.843 74.333 51.981" xml:space="preserve"><rect
                                                x="57.946" y="23.843" width="4.5" height="51.981"/><polygon
                                                points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"/><path
                                                d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"/><path
                                                d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"/></svg>
                                </span>
                            </button>
                        </div>
                    </header>

                    <?php if (isset($items['relate'][$mpn])): ?>
                        <?php $className = isset($className) ? $className : '' ?>
                        <?php $itemsCommon = ProductHelper::rebuildProducts($items['relate'][$mpn], $productId); ?>

                        <div class="product-card__body">

                            <div class="product-card__img-slider js-product-card-img-slider <?= isset($className) ? $className : '' ?>">
                                <?php foreach ($itemsCommon as $key => $relate): ?>
                                    <?php

                                    $discount = null;
                                    $flagDiscount = null;

                                    /*  TODO  ОЛЕГУ пофиксить !!!
                                    $discount = $productService->getStockProduct($relate);

                                    if($relate->inSale()) {
                                        $price = $currency->getPrice($relate->price);
                                        $old_price = $currency->getPrice($relate->price_old);
                                    } else {
                                        if ($discount->isExist()) {
                                            $flagDiscount = true;
                                            $price = $currency->getPrice($discount->getDiscountPrice());
                                            $old_price = $currency->getPrice($discount->getPrice());
                                        } elseif (!$discount->isExist()) {
                                            $price = $currency->getPrice($discount->getPrice());
                                            $old_price = 0;
                                        }
                                    }*/
                                    // TODO Олег!!!
                                    // походу лишнее
                                    //$price = $relate['price'];
                                    //$old_price = $relate['price_old'] + 100;

                                    ?>
                                    <a class="product-card__img-link<?=
                                    in_array($relate['product_id'], $wishList) ? ' is-favorite-selected' : '' ?><?=
                                    in_array($relate['product_id'], $compare) ? ' is-compare-selected' : '' ?>"
                                       data-product-id="<?= $relate['product_id'] ?>"
                                       data-product-name='<?= isset($relate['name']) ? $relate['name'] : '' ?>'
                                       data-product-price="<?php /* echo round($price) */ ?>"
                                       data-product-old-price="<?php /* echo round($old_price) */ ?>"
                                       data-product-label='<?= ProductHelper::checkGroupProductArr($relate, true) ?>'
                                       data-sizes='<?= json_encode($relate['sizes']) ?>'
                                       data-stock-subscribe="<?= in_array($relate['product_id'], $stockWatch) ? 1 : 0 ?>"

                                       href="<?= isset($relate['keyword']) ? LanguageHelper::langUrl($relate['keyword']) : '#' ?>">

                                        <img data-lazy="<?= ProductHelper::correctedImgPath($relate['image']) ?>"
                                             title='<?= isset($relate['name']) ? ProductHelper::clearQuotes($relate['name']) : '' ?> - Prof1group'
                                             alt='<?= isset($relate['name']) ? htmlentities($relate['name']) : '' ?>'
                                             class="product-card__img">
                                        <?php
                                            // TODO Так не пойдет. Слишком громоздко.
                                            // $presents = (new PresentService())->getPresents($relate['product_id']);
                                            // TODO задачу с выводом в каталоге кидайте на Вова или напишите какие данные надо я вытяну одним запросом...
                                        ?>
                                        <?php if (in_array($relate['product_id'], $presents)): ?>
                                            <span class="product-card__gift" data-text="<?= Yii::t('app', 'Gift') ?>">
                                                <img src="/images/gift.png" alt="gift" title="gift - Prof1group">
                                            </span>
                                        <?php endif ?>
                                    </a>
                                <?php endforeach ?>
                            </div>
                            <div class="product-card__color-slider js-product-card-color-slider <?= isset($className) ? $className . '_c' : '' ?>">
                                <?php if (count($itemsCommon) > 1): ?>
                                    <?php foreach ($itemsCommon as $relate): ?>
                                        <div class="product-card__color js-product-card-color">
                                            <img data-product-id="<?= $relate['product_id'] ?>"
                                                 data-lazy="/images/colors/<?= isset($relate['color_image']) ? $relate['color_image'] : '' ?>"
                                                 alt="<?= isset($relate['color_name']) ? $relate['color_name'] : '' ?>"
                                                 title="<?= isset($relate['color_name']) ? $relate['color_name'] : '' ?>"
                                                 class="product-card__color-img">
                                        </div>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <footer class="product-card__footer">
                        <h3 class="product-card__name"
                            data-category_id="<?= $product['product_id'] ?>"
                            data-product-id="<?= $product['product_id'] ?>">

                            <?php /*$itemProduct = $items['relate'][$mpn][$productId]*/ ?>

                            <a href="<?= LanguageHelper::langUrl($relate['keyword']) ?>"
                               class="product-card__name-link">
                                <?= isset($product['name']) ? $product['name'] : 'Нет названия' ?>
                            </a>
                        </h3>
                        <div class="product-card-bot-view-2">

                            <?php
                            echo ($product['price'] != 0) ? FormationPriceWidget::widget(['product' => $product]) : '';
                            ?>

                            <?php $available = $product['stock_status'] > 0 && $product['price'] > 0; ?>
                            <?php if ($available): ?>
                                <button class="product-card__cart js-open-modal-size"
                                        onclick="gtag('event', 'category', {'event_category': 'Добавить в корзину каталог', 'event_action': 'Нажатие на кнопку'});"
                                        data-table_size="<?= isset($product['tablesize_id']) && $itemProduct['tablesize_id'] !== '' ?
                                            '/images/tablesize/' . $product['tablesize_id'] : '' ?>">
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25"
                                         fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z"
                                              stroke="#1D2023"
                                              stroke-width="2"/>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"/>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"/>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"/>
                                    </svg>
                                </button>
                            <?php endif; ?>
                            <button data-product_id="<?= $product['product_id'] ?>"
                                    data-email="<?= $email ?>"
                                    role="tooltip"
                                    data-microtip-position="top"
                                    aria-label="<?= Yii::t('app', 'Inform about availability') ?>"
                                    class="<?= $available ? 'hidden ' : false ?>button-bell js-open-stock-subscribe mt-2<?= in_array($product['product_id'], $stockWatch) ? ' active' : '' ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M405.353 377.987C389.421 354.09 381 326.277 381 297.555V216c0-33.47-13.057-64.915-36.766-88.542-20.117-20.048-45.839-32.399-73.623-35.612V61h-30v30.96C178.951 99.654 131 152.956 131 217.194v80.362c0 28.722-8.421 56.535-24.353 80.432L77.973 421H213.58c6.192 17.458 22.865 30 42.42 30s36.228-12.542 42.42-30h135.607l-28.674-43.013zM133.964 391C151.665 362.989 161 330.775 161 297.555v-80.362c0-52.861 42.466-96.013 94.663-96.193h.338c25.315 0 49.12 9.833 67.058 27.708C341.077 166.664 351 190.562 351 216v81.556c0 33.221 9.333 65.433 27.036 93.444H133.964zM469.53 153.469l-21.213 21.213C470.038 196.403 482 225.282 482 256c0 30.044-11.514 58.467-32.419 80.034l21.541 20.881C497.482 329.72 512 293.881 512 256c0-38.731-15.083-75.144-42.47-102.531z"/>
                                    <path d="M427.104 195.896l-21.213 21.214C416.279 227.497 422 241.308 422 256c0 14.463-5.568 28.12-15.68 38.456l21.445 20.979C443.394 299.459 452 278.351 452 256c0-22.705-8.842-44.05-24.896-60.104zM63.683 174.682L42.47 153.469C15.083 180.856 0 217.269 0 256c0 37.881 14.518 73.72 40.878 100.915l21.541-20.881C41.514 314.467 30 286.044 30 256c0-30.718 11.962-59.597 33.683-81.318z"/>
                                    <path d="M106.109 217.109l-21.213-21.214C68.842 211.949 60 233.295 60 256c0 22.351 8.606 43.459 24.234 59.435l21.445-20.979C95.568 284.12 90 270.463 90 256c0-14.691 5.721-28.503 16.109-38.891z"/>
                                </svg>
                            </button>
                        </div>
                    </footer>
                </article>
            </section>
        <?php endif ?>
    <?php endforeach ?>
<?php else: ?>
    <div>
        <h3 style="margin-left: 20px;font-size: 36px;"><?= Yii::t('app', 'There are no products according to your filtering') ?></h3>
    </div>
<?php endif ?>
