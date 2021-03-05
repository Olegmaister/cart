<?php

use common\helpers\ProductHelper;


/**@var \frontend\services\ProductService $productService*/
?>

<?php if (isset($items['products'][0])): ?>
    <?php foreach ($items['products'] as $item): ?>
        <?php $name = ProductHelper::getGroup($item) ?>
        <section data-product-id="<?= $item->product_id ?>" class="product-card-col">
            <article class="product-card">
                <header class="product-card__header">
                    <div class="product-card__check">
                        <div class="check-card">
                            <input id="<?= $item->product_id ?>" type="checkbox" value="">
                            <label for="<?= $item->product_id ?>"></label>
                        </div>
                    </div>
                    <div class="product-card__option">
                        <button type="button" class="product-card__option-item js-favorite">
                            <span class="product-card__option-icon product-card__option-icon--fav">
                                <svg width="32" height="21" viewBox="0 0 32 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z" stroke-width="2"></path>
                                </svg>
                            </span>
                        </button>
                        <button class="product-card__option-item js-compare<?= $item->compare ? ' is-compare' : '' ?>">
                            <span class="product-card__option-icon product-card__option-icon--comp">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="74.333px"
                                     height="51.981px" viewBox="23.083 23.843 74.333 51.981"
                                     enable-background="new 23.083 23.843 74.333 51.981" xml:space="preserve"><rect x="57.946" y="23.843" width="4.5" height="51.981"/><polygon points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"/><path d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"/><path d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"/></svg>
                            </span>
                        </button>
                    </div>
                </header>
                <div class="product-card__body">
                    <div class="product-card__img-slider js-product-card-img-slider">
                        <?php if (isset($items['relate'][$item->mpn][0])): ?>
                            <?php foreach ($items['relate'][$item->mpn] as $relate): ?>
                                <a class="product-card__img-link<?= $item->compare ? ' is-compare-selected' : '' ?>" href="<?= $item->url->keyword ?>">
                                    <img data-lazy="<?= ProductHelper::correctedImgPath($relate->image) ?>"
                                         title="<?= $item->description->name ?>"
                                         alt="<?= $item->description->name ?>"
                                         class="product-card__img">
                                </a>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                    <div class="product-card__color-slider js-product-card-color-slider">
                        <?php if (isset($items['relate'][$item->mpn][1])): ?>
                            <?php foreach ($items['relate'][$item->mpn] as $relate): ?>
                                <div class="product-card__color js-product-card-color">
                                    <img data-category_id="<?= $item->product_id ?>"
										 data-product-id="<?= $relate->product_id ?>"
                                         data-lazy="/images/colors/<?= $relate->colorName['image'] ?>"
                                         title="P1G"
                                         alt="P1G"
                                         class="product-card__color-img">
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
                <footer class="product-card__footer">
                    <h3 class="product-card__name"
						data-category_id="<?= $item->product_id ?>"
						data-product-id="<?= $item->product_id ?>">
                        <a href="<?= isset($item->url->keyword) ? $item->url->keyword : '#' ?>" class="product-card__name-link">
                            <?= $item->description->name ?>
                        </a>
                    </h3>

                    <?php
                    /** @var  \common\entities\Products\Product $item**/
                    /** @var  \frontend\services\product\ProductDiscount $discount**/
                    $discount = $productService->getStockProduct($item);

                    ?>


                    <div class="product-card-bot-view-2">
                        <div class="product-card__prices">
                            <div class="product-card__price product-card__price--new">
                                <span class="product-card__price-currency--new"><?= $currency->getSimbol() ?></span>
								<span class="js-product-new-price"><?= $currency->getPrice($item->price) ?></span>
                            </div>
                            <?php if($discount->isExist()) :?>
                                <div class="product-card__price product-card__price--old">
                                    <span><?= $currency->getSimbol() ?></span>
									<span class="js-product-old-price"><?= $discount->getDiscountPrice() ?></span>
                                </div>
                            <?php endif;?>
                        </div>
                        <button class="product-card__cart js-open-modal-size">
                            <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z"
                                      stroke="#1D2023"
                                      stroke-width="2"/>
                                <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"/>
                                <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"/>
                                <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"/>
                            </svg>
                        </button>
                    </div>
                </footer>
            </article>
        </section>
    <?php endforeach ?>
<?php endif ?>

