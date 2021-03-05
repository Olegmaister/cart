<?php

use yii\helpers\Url;
use common\helpers\LanguageHelper;

/**@var \common\entities\Customer $customer * */
?>
<div class="page">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="breadcrumbs__item">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('account/account') ?>">
                        <?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?>
                    </a>
                    <meta itemprop="position" content="2"/>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'only for you') ?></span>
                </li>
            </ul>
        </nav>
        <div class="page-content">
            <h1 class="title title--page-lg"><?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?>: <?=
                Yii::t('app', 'general') ?> <?= Yii::t('app', 'data') ?></h1>
            <section class="account-body">

                <div class="account-col account-col--left">
                    <div class="account-menu">
                        <?= $this->render('common/_menu', [
                            'customer' => $customer,
                            'active' => $active
                        ]) ?>
                    </div>
                </div>
                <div class="account-col account-col--right">
                    <div class="wrapper">
                        <div class="content-extra content-extra--account">
                            <h2 class="content-extra__title"><?= Yii::t('app', 'GOODS ONLY FOR YOU') ?></h2>
                            <div class="carousel-1b mt-n5">
                                <?php for ($i = 0; $i < 8; $i++): // TODO: вывести товары для вас ?>
                                <section class="product-card-col">
                                    <article class="product-card">
                                        <header class="product-card__header">
            <span class="product-card__label background_hit">
                 <?= Yii::t('app', 'hit') ?>			        </span>
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
                                                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="11.5"
                                                                  width="13" height="8" fill="#000">
                                                                <path fill="#fff" d="M0 11.5h13v8H0z"></path><path
                                                                        fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M3 13.5a3.508 3.508 0 006.973 0H3z"></path>
                                                            </mask>
                                                            <path class="_path"
                                                                  d="M3 13.5v-2H.767l.245 2.22L3 13.5zm6.973 0l1.987.22.246-2.22H9.973v2zm-3.487 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.499-1.338a1.508 1.508 0 01-1.499 1.338v4a5.508 5.508 0 005.474-4.898l-3.975-.44zm1.988-1.78H3v4h6.973v-4z"
                                                                  fill="#000" mask="url(#a)"></path>
                                                            <mask id="b" maskUnits="userSpaceOnUse" x="16.973" y="11.5"
                                                                  width="13" height="8" fill="#000">
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
                                            <section class="product-card__img-slider js-product-card-img-slider ">
                                                <a class="product-card__img-link"
                                                   href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg"
                                                         alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER"
                                                         class="product-card__img">
                                                </a>
                                                <a class="product-card__img-link"
                                                   href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg"
                                                         alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER"
                                                         class="product-card__img">
                                                </a>
                                            </section>

                                            <section class="product-card__color-slider js-product-card-color-slider">
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                                <article class="product-card__color js-product-card-color">
                                                    <img data-category_id="4530"
                                                         src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                         class="product-card__color-img">
                                                </article>
                                            </section>
                                        </section>

                                        <footer class="product-card__footer">
                                            <h3 class="product-card__name">
                                                <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather"
                                                   class="product-card__name-link">
                                                    Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL HEATHER </a>
                                            </h3>
                                            <div class="product-card-bot-view-2">
                                                <section class="product-card__prices">
                                                    <section class="product-card__price product-card__price--new">
                                                        <span>₴</span> 684
                                                    </section>
                                                    <section class="product-card__price product-card__price--old">
                                                        <span>₴</span> 855
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
                                </section>
                                <?php endfor;  ?>
                            </div>
                        </div>

                        <div class="content-extra content-extra--account">
                            <h2 class="content-extra__title"><?= Yii::t('app', 'you looked at the goods') ?></h2>
                            <div class="carousel-1b mt-n5">
                                <?php for ($i = 0; $i < 8; $i++): // TODO: вывести вы смотрели ?>
                                    <section class="product-card-col">
                                        <article class="product-card">
                                            <header class="product-card__header">
            <span class="product-card__label background_hit">
                 <?= Yii::t('app', 'hit') ?>			        </span>
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
                                                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="11.5"
                                                                  width="13" height="8" fill="#000">
                                                                <path fill="#fff" d="M0 11.5h13v8H0z"></path><path
                                                                        fill-rule="evenodd" clip-rule="evenodd"
                                                                        d="M3 13.5a3.508 3.508 0 006.973 0H3z"></path>
                                                            </mask>
                                                            <path class="_path"
                                                                  d="M3 13.5v-2H.767l.245 2.22L3 13.5zm6.973 0l1.987.22.246-2.22H9.973v2zm-3.487 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.499-1.338a1.508 1.508 0 01-1.499 1.338v4a5.508 5.508 0 005.474-4.898l-3.975-.44zm1.988-1.78H3v4h6.973v-4z"
                                                                  fill="#000" mask="url(#a)"></path>
                                                            <mask id="b" maskUnits="userSpaceOnUse" x="16.973" y="11.5"
                                                                  width="13" height="8" fill="#000">
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
                                                <section class="product-card__img-slider js-product-card-img-slider ">
                                                    <a class="product-card__img-link"
                                                       href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                                        <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg"
                                                             alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER"
                                                             class="product-card__img">
                                                    </a>
                                                    <a class="product-card__img-link"
                                                       href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                                        <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg"
                                                             alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER"
                                                             class="product-card__img">
                                                    </a>
                                                </section>

                                                <section class="product-card__color-slider js-product-card-color-slider">
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                    <article class="product-card__color js-product-card-color">
                                                        <img data-category_id="4530"
                                                             src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G"
                                                             class="product-card__color-img">
                                                    </article>
                                                </section>
                                            </section>

                                            <footer class="product-card__footer">
                                                <h3 class="product-card__name">
                                                    <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather"
                                                       class="product-card__name-link">
                                                        Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL HEATHER </a>
                                                </h3>
                                                <div class="product-card-bot-view-2">
                                                    <section class="product-card__prices">
                                                        <section class="product-card__price product-card__price--new">
                                                            <span>₴</span> 684
                                                        </section>
                                                        <section class="product-card__price product-card__price--old">
                                                            <span>₴</span> 855
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
                                    </section>
                                <?php endfor;  ?>
                            </div>
                        </div>
                    </div>
                    <!--wrapper-->
                </div>
            </section>
        </div>
        <!--page-content-->
    </div>
    <!--wrapper-->
</div>
<!--page-->