<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;

?>

<?php foreach ($idMpn as $productId => $mpn): ?>
    <?php $itemCommon = ProductHelper::rebuildProducts($items[$mpn], $productId) ?>
    <?php $item = reset($itemCommon) ?>

    <div class="p-compare-slider-col">
        <div class="p-compare-slider-head">
            <div class="p-compare-slider-head__close" data-product_id="<?= $item['product_id'] ?>">
                <svg class="_patch" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.75 0L18 2.25 2.25 18 0 15.75 15.75 0z"/>
                    <path d="M0 2.25L2.25 0 18 15.75 15.75 18 0 2.25z"/>
                </svg>
            </div>
        </div>

        <div class="p-compare-slider-col-inner js-parent">

            <article class="product-card">
                <section class="product-card__body">
                    <section class="product-card__img-slider js-product-card-img-slider <?= isset($className) ? $className : '' ?>">
                        <?php foreach ($itemCommon as $relate): ?>
                            <a class="product-card__img-link <?= isset($relate['favorite']) ? 'is-favorite-selected' : '' ?>"
                               data-product-id="<?= $relate['product_id'] ?>"
                               data-product-name='<?= $relate['name'] ?>'
                               data-product-price="<?= $currency->getPrice($relate['price']) ?>"
                               data-product-old-price="<?= $currency->getPrice($relate['price_old']) ?>"
                               data-sizes='<?= json_encode($relate['sizes']) ?>'
                               href="<?= LanguageHelper::langUrl($relate['keyword']) ?>">
                                <img data-lazy="<?= ProductHelper::correctedImgPath($relate['image']) ?>"
                                     title="<?= $relate['name'] ?>"
                                     alt="<?= $relate['name'] ?>"
                                     class="product-card__img">
                            </a>
                        <?php endforeach ?>
                    </section>

                    <section class="product-card__color-slider js-product-card-color-slider <?= isset($className) ? $className . '_c' : '' ?>">
                        <?php foreach ($itemCommon as $relate): ?>
                            <article class="product-card__color js-product-card-color">
                                <img data-product-id="<?= $relate['product_id'] ?>"
                                     data-lazy="/images/colors/<?= $relate['color_image'] ?>"
                                     title="<?= $relate['color_name'] ?>"
                                     alt="<?= $relate['color_name'] ?>"
                                >
                            </article>
                        <?php endforeach ?>
                    </section>
                </section>

                <footer class="product-card__footer">
                    <h3 class="product-card__name"
                        data-category_id="<?= $relate['product_id'] ?>"
                        data-product-id="<?= $relate['product_id'] ?>">
                        <a target="_blank" href="<?= LanguageHelper::langUrl($relate['keyword']) ?>"
                           class="product-card__name-link">
                            <?= $relate['name'] ?>
                        </a>
                    </h3>

                    <?php
                        //$discount = $productService->getStockProduct($item);
                        echo  \frontend\widgets\Product\FormationPriceWidget::widget(['product' => $item]) ;
                    ?>
                    <?php /* ?>
                    <div class="product-card-bot-view-2">
                        <section class="mt-1 mr-auto">
                            <?php if ($discount->isExist()) : ?>
                                <span class="product-card__price product-card__price--new<?= (!$item['stock_status']) ? ' gray' : '' ?>">
                                        <small class="product-card__price-currency--new"><?= $currency->getSimbol() ?></small>
                                        <span class="js-product-new-price"><?= $currency->getPrice($discount->getDiscountPrice()) ?></span>
                                </span>
                                <!--old-->
                                <span class="product-card__price product-card__price--old">
                                        <small><?= $currency->getSimbol() ?></small>
                                        <span class="js-product-old-price"><?= $currency->getPrice($discount->getPrice()) ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if (!$discount->isExist()) : ?>
                                <section class="product-card__price product-card__price--new<?= (!$item['stock_status']) ? ' gray' : '' ?>">
                                    <span class="product-card__price-currency--new"><?= $currency->getSimbol() ?></span>
                                    <span class="js-product-new-price"><?= $currency->getPrice($discount->getPrice()) ?></span>
                                </section>
                            <?php endif ?>
                        </section>

                        <?php if (isset($otherData['reviews'][$item['product_id']])): ?>
                            <div class="product-card-rating">
                                <div class="rating rating--small">
                                    <?= ProductHelper::getRatingStars($otherData['reviews'][$item['product_id']]) ?>
                                </div>
                            </div>
                        <?php endif ?>

                    </div>
                    <?php */ ?>


                </footer>
            </article>

            <div class="p-compare-param p-compare-param--sizes">
                <div class="p-compare-param__title"><?= Yii::t('app', 'choose size') ?>:</div>

                <div class="p-compare-param-inner p-compare-param-inner--sizes">
                    <div class="js-compare-height-sizes sizes-switch sizes-switch--big">
                        <?php foreach ($item['sizes'] as $key => $size): ?>
                            <div class="js-product-size sizes-switch__item<?php
                                echo ($size['quantity'] > 0) ? ' sizes-switch__item--stock' : '';
                                echo ($key == 0 && $size['quantity'] > 0) ? ' sizes-switch__item--active' : '';?>"

                                 data-product_id="<?= $item['product_id'] ?>"
                                 data-option_id="<?= $size['option_id'] ?>"><?= $size['name'] ?></div>
                        <?php endforeach ?>
                    </div>
                </div>

                <div class="p-compare-param__link js-compare-view-size-but">
                    <?= Yii::t('app', 'Show all sizes') ?>
                </div>
            </div>

            <div class="p-compare-param p-compare-param--colors">
                <div class="p-compare-param__title"><?= Yii::t('app', 'choose color') ?>:</div>

                <div class="p-compare-param-inner p-compare-param-inner--colors">
                    <div class="js-compare-height-colors switch-color">
                        <?php foreach ($itemCommon as $key => $relate): ?>
                            <div class="product-colors__item<?= $key == $item['product_id'] ? ' _active' : '' ?>">
                                <button class="product-card__color js-product-card-color">
                                    <img data-product-id="<?= $item['product_id'] ?>"
                                         src="/images/colors/<?= $relate['color_image'] ?>"
                                         alt="<?= $relate['color_name'] ?>">
                                </button>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>

                <div class="p-compare-param__link js-compare-view-color-but d-none">
                    <?= Yii::t('app', 'Show all colors') ?>
                </div>
            </div>

            <?php if ($item['price'] > 0 && $item['stock_status'] == 1): ?>
                <div class="p-compare-buttons">
                    <button class="btn btn--red btn--full btn--lg-xs-l js-compare-add-cart">
                        <span class="btn__inner"><?= Yii::t('app', 'add to cart') ?></span>
                    </button>
                    <button class="js-btn-fast-modal btn btn--black btn--full btn--lg-h btn--lg-xs-l js-open-modal-quik-buy">
                        <span class="btn__inner"><?= Yii::t('app', 'fast buy') ?></span>
                    </button>
                </div>
            <?php endif ?>

            <?php if (isset($item['description'])): ?>
                <div id="js-compare-option-desc-height" class="p-compare-options">
                    <div class="p-compare-options__title"><?= Yii::t('app', 'description') ?></div>

                    <div class="p-compare-options-inner p-compare-options-inner--desc">
                        <div class="js-compare-height-desc">
                            <?= html_entity_decode($item['description']) ?>
                        </div>

                        <div class="p-compare-options-bot">
                            <i class="p-compare-options__arrow js-compare-view-desc-but">
                                <svg class="_patch" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.97 9.314l-8.485 8.485L2 9.314" stroke-width="3"/>
                                </svg>
                            </i>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <div class="p-compare-options p-compare-options--character">
                <div class="p-compare-options__title">
                    <span><?= Yii::t('app', 'characteristics') ?></span>
                </div>

                <div class="p-compare-options-inner p-compare-options-inner--character">
                    <div class="js-compare-height-character">
                        <div class="product-feature-row">
                            <div class="product-feature-row-col product-feature-row-col--left">
                                <div class="product-feature__name"><?= Yii::t('app', 'manufacturer') ?>:</div>
                            </div>
                            <div class="product-feature-row-col product-feature-row-col--right">
                                <div class="product-feature__option"><?= $otherData['brands'][$item['manufacturer_id']] ?></div>
                            </div>
                        </div>
                        <div class="product-feature-row">
                            <div class="product-feature-row-col product-feature-row-col--left">
                                <div class="product-feature__name"><?= Yii::t('app', 'Model') ?>:</div>
                            </div>
                            <div class="product-feature-row-col product-feature-row-col--right">
                                <div class="product-feature__option"><?= $item['model'] ?></div>
                            </div>
                        </div>

                        <?php if (isset($otherData['attributes'][$item['mpn']])): ?>
                            <?php foreach ($otherData['attributes'][$item['mpn']] as $attribute): ?>
                                <div class="product-feature-row">
                                    <div class="product-feature-row-col product-feature-row-col--left">
                                        <div class="product-feature__name"><?= $attribute['group_name'] ?>:</div>
                                    </div>
                                    <div class="product-feature-row-col product-feature-row-col--right">
                                        <div class="product-feature__option"><?= $attribute['attr_name'] ?></div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>

                    <div class="p-compare-options-bot">
                        <i class="p-compare-options__arrow js-compare-view-char-but">
                            <svg class="_patch" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.97 9.314l-8.485 8.485L2 9.314" stroke-width="3"/>
                            </svg>
                        </i>
                    </div>

                </div>
            </div>

            <div id="js-parent" class="p-compare-options p-compare-options--last">
                <?php if (isset($otherData['video'][$item['product_id']][0])): ?>
                    <div class="p-compare-options__title">
                        <?= Yii::t('app', 'video') ?>:
                    </div>

                    <div class="p-compare-options-inner p-compare-options-inner--extra">
                        <div class="js-compare-height-extra">
                            <?= $otherData['video'][$item['product_id']][0] ?>
                        </div>
                    </div>
                <?php endif ?>
            </div>

        </div>
    </div>
<?php endforeach ?>
