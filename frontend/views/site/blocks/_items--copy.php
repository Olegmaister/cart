<?php

use backend\helpers\BackendProductHelper;
use common\helpers\ProductHelper;

?>

<?php if (isset($items['products'][0])): ?>
    <?php foreach ($items['products'] as $item): ?>
        <section data-product-id="<?= $item->product_id ?>" class="product-card-col">
            <article class="product-card">
                <header class="product-card__header">
			        <span class="product-card__label background_<?= $name ?>">
				         <?= Yii::t('app', $name) ?>
			        </span>
                    <section class="product-card__option">
                        <button type="button" class="product-card__option-item js-favorite">
                            <span class="product-card__option-icon product-card__option-icon--fav">
                                <svg width="32" height="21" viewBox="0 0 32 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z" stroke-width="2"></path>
                                </svg>
                            </span>
                        </button>
                        <button class="product-card__option-item">
                            <span class="product-card__option-icon product-card__option-icon--comp">
								<svg width="30" height="21" viewBox="0 0 30 21" fill="none" xmlns="http://www.w3.org/2000/svg">
									<mask id="path-2-outside-1" maskUnits="userSpaceOnUse" x="0" y="11.5" width="13" height="8" fill="black">
										<rect fill="white" y="11.5" width="13" height="8"></rect>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M3 13.5C3.19387 15.2538 4.68077 16.6179 6.48627 16.6179C8.29177 16.6179 9.77866 15.2538 9.97253 13.5H3Z"></path>
									</mask>
									<path class="_path" d="M3 13.5V11.5H0.766729L1.01211 13.7197L3 13.5ZM9.97253 13.5L11.9604 13.7197L12.2058 11.5H9.97253V13.5ZM6.48627 14.6179C5.71157 14.6179 5.07099 14.032 4.98789 13.2803L1.01211 13.7197C1.31676 16.4757 3.64997 18.6179 6.48627 18.6179V14.6179ZM7.98464 13.2803C7.90155 14.032 7.26097 14.6179 6.48627 14.6179V18.6179C9.32257 18.6179 11.6558 16.4757 11.9604 13.7197L7.98464 13.2803ZM9.97253 11.5H3V15.5H9.97253V11.5Z" fill="#EF1B1B" mask="url(#path-2-outside-1)"></path>
									<mask id="path-4-outside-2" maskUnits="userSpaceOnUse" x="16.9727" y="11.5" width="13" height="8" fill="black">
										<rect fill="white" x="16.9727" y="11.5" width="13" height="8"></rect>
										<path fill-rule="evenodd" clip-rule="evenodd" d="M19.9727 13.5C20.1665 15.2538 21.6534 16.6179 23.4589 16.6179C25.2644 16.6179 26.7513 15.2538 26.9452 13.5H19.9727Z"></path>
									</mask>
									<path class="_path" d="M19.9727 13.5V11.5H17.7394L17.9848 13.7197L19.9727 13.5ZM26.9452 13.5L28.9331 13.7197L29.1785 11.5H26.9452V13.5ZM23.4589 14.6179C22.6842 14.6179 22.0436 14.032 21.9605 13.2803L17.9848 13.7197C18.2894 16.4757 20.6226 18.6179 23.4589 18.6179V14.6179ZM24.9573 13.2803C24.8742 14.032 24.2336 14.6179 23.4589 14.6179V18.6179C26.2952 18.6179 28.6284 16.4757 28.9331 13.7197L24.9573 13.2803ZM26.9452 11.5H19.9727V15.5H26.9452V11.5Z" fill="#EF1B1B" mask="url(#path-4-outside-2)"></path>
									<path d="M14.9727 0V21M5.97266 8.5V4.5H23.9727V8.5" stroke="#EF1B1B" stroke-width="2"></path>
								</svg>
                            </span>
                        </button>
                    </section>
                </header>
                <section class="product-card__body">
                    <section class="product-card__img-slider js-product-card-img-slider <?= isset($className) ? $className : ''?>">
                        <?php if (isset($items['relate'][$item->mpn][0])): ?>
                            <?php foreach ($items['relate'][$item->mpn] as $relate): ?>
                                <a class="product-card__img-link" href="<?= $item->url->keyword ?>">
                                    <img loading="lazy" src="<?= BackendProductHelper::getCorrectionImage($relate->image, $relate->date_modified) ?>"
                                         alt="<?= $item->description->name ?>"
                                         class="product-card__img">
                                </a>
                            <?php endforeach ?>
                        <?php endif ?>
                    </section>
                    <section class="product-card__color-slider js-product-card-color-slider <?= isset($className) ? $className . '_c' : ''?>">
                        <?php if (isset($items['relate'][$item->mpn][1])): ?>
                            <?php foreach ($items['relate'][$item->mpn] as $relate): ?>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="<?= $item->product_id ?>"
                                         src="/images/colors/<?= $relate->colorName['image'] ?>"
                                         alt="P1G"
                                         class="product-card__color-img">
                                </article>
                            <?php endforeach ?>
                        <?php endif ?>
                    </section>
                </section>
                <footer class="product-card__footer">
					<h3 class="product-card__name"
						data-category_id="<?= $item->product_id ?>"
						data-product-id="<?= $item->product_id ?>">
                        <a href="<?= $item->url->keyword ?>" class="product-card__name-link">
                            <?= $item->description->name ?>
                        </a>
                    </h3>
                    <div class="product-card-bot-view-2">
                        <section class="product-card__prices">
                            <section class="product-card__price product-card__price--new">
                                <span class="product-card__price-currency--new"><?= $currency->getSimbol() ?></span>
								<span class="js-product-new-price"><?= $currency->getPrice($item->price) ?></span>
                            </section>
                            <section class="product-card__price product-card__price--old">
                                <span class="product-card__price-currency--new"><?= $currency->getSimbol() ?></span>
								<span class="js-product-old-price"><?= $currency->getPrice($item->price * 1.25) ?></span>
                            </section>
                        </section>
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
                    </div>
                </footer>
            </article>
        </section>
    <?php endforeach ?>
<?php endif ?>

