<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\widgets\Product\FormationPriceWidget;

?>

<?php if (isset($items['products'][0])): ?>
    <?php foreach ($items['products'] as $item): ?>
        <?php $name = ProductHelper::getGroup($item) ?>
        <section data-product-id="<?= $items['relate'][$item->mpn][0]->product_id ?>" class="product-card-col">
            <article class="product-card">
                <header class="product-card__header">
                    <div class="product-card__check">
                        <div class="check-card">
                            <input id="<?= $item->product_id ?>" class="js-check-favorite" type="checkbox" value="">
                            <label for="<?= $item->product_id ?>"></label>
                        </div>
                    </div>
                    <section class="product-card__option">
                        <button type="button"
                                class="product-card__option-item js-favorite <?= isset($items['relate'][$item->mpn][0]->favorite) ? 'is-favorite' : '' ?>">
                            <span class="product-card__option-icon product-card__option-icon--fav">
                                <svg class="heart-delete" viewBox="0 0 14.86 10.63">
                                    <path d="M7.43,10.48.59,3.39a1.38,1.38,0,0,1,0-1.87l.8-.9a1.35,1.35,0,0,1,1-.47H5.27a1.39,1.39,0,0,1,1,.43L7.43,1.8,8.59.58a1.39,1.39,0,0,1,1-.43h2.89a1.35,1.35,0,0,1,1,.47l.8.9a1.39,1.39,0,0,1,0,1.87Zm-5-9.41A.45.45,0,0,0,2,1.22l-.8.91a.46.46,0,0,0,0,.62L7.43,9.16l6.18-6.41a.45.45,0,0,0,0-.62h0l-.8-.91a.47.47,0,0,0-.35-.15H9.59a.48.48,0,0,0-.34.14L7.43,3.12,5.61,1.21a.48.48,0,0,0-.34-.14Z"/>
                                    <polygon
                                            points="9.42 3.89 8.83 3.19 7.43 4.36 6.03 3.19 5.44 3.89 6.72 4.96 5.44 6.02 6.03 6.72 7.43 5.55 8.83 6.72 9.42 6.02 8.14 4.96 9.42 3.89"/>
                                </svg>
                            </span>
                        </button>
                        <button class="product-card__option-item js-compare <?= isset($items['relate'][$item->mpn][0]->compare) ? 'is-compare' : '' ?>">
                            <span class="product-card__option-icon product-card__option-icon--comp">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                     x="0px" y="0px" width="74.333px"
                                     height="51.981px" viewBox="23.083 23.843 74.333 51.981"
                                     enable-background="new 23.083 23.843 74.333 51.981" xml:space="preserve"><rect
                                            x="57.946" y="23.843" width="4.5" height="51.981"/><polygon
                                            points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"/><path
                                            d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"/><path
                                            d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"/></svg>
                            </span>
                        </button>
                    </section>
                </header>
                <?php if (isset($items['relate'][$item->mpn][0])): ?>
                    <?php $className = isset($className) ? $className : '' ?>
                    <?= $this->render('/parts/_items-common-section', ['itemsCommon' => $items['relate'][$item->mpn], 'productService' => $productService, 'currency' => $currency, 'className' => $className]); ?>
                <?php endif ?>
                <footer class="product-card__footer">
                    <h3 class="product-card__name"
                        data-category_id="<?= $item->product_id ?>"
                        data-product-id="<?= $item->product_id ?>">
                        <a href="<?= LanguageHelper::langUrl(isset($item->url->keyword) ? $item->url->keyword : '#') ?>"
                           class="product-card__name-link">
                            <?= $item->description->name ?>
                        </a>
                    </h3>
                    <div class="product-card-bot-view-2">
                        <?= FormationPriceWidget::widget(['product' => $items['relate'][$item->mpn][0]]) ?>
                        <?php if ($item->stock_status): ?>
                            <button class="product-card__cart js-open-modal-size">
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
                        <?php endif ?>
                    </div>
                </footer>
            </article>
        </section>
    <?php endforeach ?>
<?php endif ?>

