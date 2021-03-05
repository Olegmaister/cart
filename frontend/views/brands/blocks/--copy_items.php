<?php

use backend\helpers\BackendProductHelper;
use common\helpers\ProductHelper;

?>

<?php if (isset($items['products'][0])): ?>
    <?php foreach ($items['products'] as $item): ?>
        <section class="product-card-col">
            <article class="product-card">
                <header class="product-card__header">
			        <span class="product-card__label background_<?= $name ?>">
				         <?= Yii::t('app', $name) ?>
			        </span>
                    <div class="product-card__option">
                        <button class="product-card__option-item">
                            <i class="product-card__option-icon product-card__option-icon--fav"></i>
                        </button>
                        <button class="product-card__option-item">
                            <i class="product-card__option-icon product-card__option-icon--comp"></i>
                        </button>
                    </div>
                </header>
                <div class="product-card__body">
                    <div class="product-card__img-slider js-product-card-img-slider">
                        <?php if (isset($items['relate'][$item->mpn][0])): ?>
                            <?php foreach ($items['relate'][$item->mpn] as $relate): ?>
                                <a class="product-card__img-link" href="/<?= $item->url->keyword ?>">
                                    <img data-lazy="<?= BackendProductHelper::getCorrectionImage($relate->image, $item->date_modified) ?>"
                                         title="<?= $item->description->name ?> - Prof1group"
                                         alt="<?= $item->description->name ?>"
                                         class="product-card__img">
                                </a>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                    <div class="product-card__color-slider js-product-card-color-slider">
                        <?php if (isset($items['relate'][$item->mpn][0])): ?>
                            <?php foreach ($items['relate'][$item->mpn] as $relate): ?>
                                <article class="product-card__color js-product-card-color">
                                    <img data-lazy="/images/colors/<?= $relate->colorName['image'] ?>"
										 data-product-id="<?= $relate->product_id ?>"
                                         alt="color"
										 title="color - Prof1group"
                                         class="product-card__color-img">
                                </article>
                            <?php endforeach ?>
                        <?php endif ?>
                    </div>
                </div>
                <footer class="product-card__footer">
                    <h3 class="product-card__name">
                        <a href="#" class="product-card__name-link">
                            <?= $item->description->name ?>
                        </a>
                    </h3>
                    <div class="product-card__prices">
                        <div class="product-card__price product-card__price--new">
                            <span class="product-card__price-currency--new">₴</span>
							<span class="js-product-new-price"><?= $item->price ?></span>
                        </div>
                        <div class="product-card__price product-card__price--old">
                            <span class="product-card__price-currency--new">₴</span>
							<span class="js-product-old-price"><?= $item->price + 248 ?></span>
                        </div>
                    </div>
                    <button class="product-card__cart js-open-modal-size">
                        <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z" stroke="#1D2023"
                                  stroke-width="2"/>
                            <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"/>
                            <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"/>
                            <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"/>
                        </svg>
                    </button>
                    <div class="product-card-footer-buttons">
                        <div class="product-card-footer-buttons-col product-card-footer-buttons-col--left">
                            <a href="" class="product-card-footer-buttons-cart">
                                <div class="product-card-footer-buttons-cart__txt"> в корзину</div>
                            </a>
                        </div>
                        <div class="product-card-footer-buttons-col product-card-footer-buttons-col--right">
                            <div class="product-card-footer-buttons__buy">
                                быстрая покупка
                            </div>
                        </div>
                    </div>
                </footer>
            </article>
        </section>
    <?php endforeach ?>
<?php endif ?>