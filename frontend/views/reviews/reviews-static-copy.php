<?php
use common\helpers\LanguageHelper;
?>
<div class="page page--white">

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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'reviews') ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">

            <h1 class="title title--page">ВСЕ ОТЗЫВЫ</h1>

            <div class="p-reviews">

                <div class="product-reviews-row product-reviews-row--columns">

                    <div class="product-reviews-col product-reviews-col--left">

                        <div class="product-reviews-user">
                            <img loading="lazy" src="/images/reviews-user-photo.png" alt="" class="product-reviews-user__photo">
                        </div>

                    </div>
                    <!--COLUMN-->

                    <div class="product-reviews-col product-reviews-col--right">

                        <div class="product-reviews-top">
                            <div class="product-reviews-top-col product-reviews-top-col--left">
                                <div class="product-reviews__name-prod">Название товара Название товараНазвание товара Название товара</div>
                                <div class="product-reviews__name">Иван Сёменов</div>
                            </div>
                            <div class="product-reviews-top-col product-reviews-top-col--right">
                                <div class="rating">
                                    <div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div>                                                        </div>
                            </div>
                        </div>

                        <div class="product-reviews__comments">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        </div>

                        <div class="product-reviews-bot">

                            <div class="product-reviews-bot-col product-reviews-bot-col--left">

                                <div class="product-reviews-buttons">

                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                                        <button class="btn btn--trans btn--lxs answer_review">
                                            <span class="btn__inner">ответить</span>
                                        </button>
                                    </div>

                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                                        <div class="product-reviews__link js-answers">
                                            Комментарии <span>6</span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="product-reviews-bot-col product-reviews-bot-col--right">
                                <div class="video-reviews-date">01.02.2020</div>
                            </div>
                        </div>

                        <div class="product-reviews-answers">

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User2
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User3
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User4
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                        </div>
                        <!--ANSWERS-->

                    </div>
                    <!--COLUMN-->

                </div>

                <div class="product-reviews-row product-reviews-row--columns">

                    <div class="product-reviews-col product-reviews-col--left">

                        <div class="product-reviews-user">
                            <img loading="lazy" src="/images/reviews-user-photo.png" alt="" class="product-reviews-user__photo">
                        </div>

                    </div>
                    <!--COLUMN-->

                    <div class="product-reviews-col product-reviews-col--right">

                        <div class="product-reviews-top">
                            <div class="product-reviews-top-col product-reviews-top-col--left">
                                <div class="product-reviews__name-prod">Название товара</div>
                                <div class="product-reviews__name">Иван Сёменов</div>
                            </div>
                            <div class="product-reviews-top-col product-reviews-top-col--right">
                                <div class="rating">
                                    <div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div>                                                        </div>
                            </div>
                        </div>

                        <div class="product-reviews__comments">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        </div>

                        <div class="product-reviews-bot">

                            <div class="product-reviews-bot-col product-reviews-bot-col--left">

                                <div class="product-reviews-buttons">

                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                                        <button class="btn btn--trans btn--lxs answer_review">
                                            <span class="btn__inner">ответить</span>
                                        </button>
                                    </div>

                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                                        <div class="product-reviews__link js-answers">
                                            Комментарии <span>6</span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="product-reviews-bot-col product-reviews-bot-col--right">
                                <div class="video-reviews-date">01.02.2020</div>
                            </div>
                        </div>

                        <div class="product-reviews-answers">

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User2
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User3
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User4
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                        </div>
                        <!--ANSWERS-->

                    </div>
                    <!--COLUMN-->

                </div>

                <div class="product-reviews-row product-reviews-row--columns">

                    <div class="product-reviews-col product-reviews-col--left">

                        <div class="product-reviews-user">
                            <img loading="lazy" src="/images/reviews-user-photo.png" alt="" class="product-reviews-user__photo">
                        </div>

                    </div>
                    <!--COLUMN-->

                    <div class="product-reviews-col product-reviews-col--right">

                        <div class="product-reviews-top">
                            <div class="product-reviews-top-col product-reviews-top-col--left">
                                <div class="product-reviews__name-prod">Название товара</div>
                                <div class="product-reviews__name">Иван Сёменов</div>
                            </div>
                            <div class="product-reviews-top-col product-reviews-top-col--right">
                                <div class="rating">
                                    <div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div>                                                        </div>
                            </div>
                        </div>

                        <div class="product-reviews__comments">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        </div>

                        <div class="product-reviews-bot">

                            <div class="product-reviews-bot-col product-reviews-bot-col--left">

                                <div class="product-reviews-buttons">

                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                                        <button class="btn btn--trans btn--lxs answer_review">
                                            <span class="btn__inner">ответить</span>
                                        </button>
                                    </div>

                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                                        <div class="product-reviews__link js-answers">
                                            Комментарии <span>6</span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="product-reviews-bot-col product-reviews-bot-col--right">
                                <div class="video-reviews-date">01.02.2020</div>
                            </div>
                        </div>

                        <div class="product-reviews-answers">

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User2
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User3
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User4
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                        </div>
                        <!--ANSWERS-->

                    </div>
                    <!--COLUMN-->

                </div>

                <div class="product-reviews-row product-reviews-row--columns">

                    <div class="product-reviews-col product-reviews-col--left">

                        <div class="product-reviews-user">
                            <img loading="lazy" src="/images/reviews-user-photo.png" alt="" class="product-reviews-user__photo">
                        </div>

                    </div>
                    <!--COLUMN-->

                    <div class="product-reviews-col product-reviews-col--right">

                        <div class="product-reviews-top">
                            <div class="product-reviews-top-col product-reviews-top-col--left">
                                <div class="product-reviews__name-prod">Название товара</div>
                                <div class="product-reviews__name">Иван Сёменов</div>
                            </div>
                            <div class="product-reviews-top-col product-reviews-top-col--right">
                                <div class="rating">
                                    <div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div><div class="rating__item rating__item--active"></div>                                                        </div>
                            </div>
                        </div>

                        <div class="product-reviews__comments">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        </div>

                        <div class="product-reviews-bot">

                            <div class="product-reviews-bot-col product-reviews-bot-col--left">

                                <div class="product-reviews-buttons">

                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                                        <button class="btn btn--trans btn--lxs answer_review">
                                            <span class="btn__inner">ответить</span>
                                        </button>
                                    </div>

                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                                        <div class="product-reviews__link js-answers">
                                            Комментарии <span>6</span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="product-reviews-bot-col product-reviews-bot-col--right">
                                <div class="video-reviews-date">01.02.2020</div>
                            </div>
                        </div>

                        <div class="product-reviews-answers">

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User2
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User3
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                            <div class="product-reviews-answers-item">

                                <div class="product-reviews-answers__name">
                                    User4
                                    <div class="video-reviews-date">29.05.2019</div>
                                </div>

                                <div class="product-reviews-answers__comment">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dicta laudantium mollitia quasi. Aliquid consequuntur cum dignissimos dolor earum necessitatibus, odio porro quis quod saepe temporibus veritatis voluptas. Corporis nesciunt, quia.
                                </div>

                            </div>

                        </div>
                        <!--ANSWERS-->

                    </div>
                    <!--COLUMN-->

                </div>

            </div>
            <!--P-REVIEWS-->

            <div class="p-reviews-bot">
                <ul class="paginations">
                    <li class="pagination__item pagination__item--start isDisabled">
                        <a>
                            <svg class="pagination__icon" width="8" height="12" aria-hidden="true">
                                <use xlink:href="#icon-chevron-left"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="pagination__item left_border-hide active">
                        <a href="/odejda" data-page="0">1</a>
                    </li>
                    <li class="pagination__item"><a href="/odejda?page=2" data-page="1">2</a></li>
                    <li class="pagination__item"><a href="/odejda?page=3" data-page="2">3</a></li>
                    <li class="pagination__item"><a href="/odejda?page=4" data-page="3">4</a></li>
                    <li class="pagination__item"><a href="/odejda?page=5" data-page="4">5</a></li>
                    <li class="pagination__item isDisabled"><a>...</a></li>
                    <li class="pagination__item null"><a href="/odejda?page=42" data-page="41">42</a></li>
                    <li class="pagination__item left_border-hide">
                        <a href="/odejda?page=2" data-page="1">
                            <svg class="pagination__icon" width="8" height="12" aria-hidden="true">
                                <use xlink:href="#icon-chevron-right"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
                <button class="btn btn--gray btn--lxx">
                    <span class="btn__inner">показать еще</span>
                </button>
            </div>

        </div>
        <!--PAGE CONTENT-->

    </div>
    <!--WRAPPER-->

    <div class="wrapper wrapper--dark wrapper--slides">
        <div class="content-extra content-extra--product content-extra--product-last">
            <h2 class="content-extra__title">ПОКУПАТЕЛИ ТАК ЖЕ СМОТРЯТ</h2>
            <div class="slider-extra-arrows js-slider-also-watching-arrows">
                <div class="slider-extra-arrows__arrow slider-extra-arrows__arrow_prev js-slider-arrows-prev"></div>
                <div class="slider-extra-arrows__arrow slider-extra-arrows__arrow_next js-slider-arrows-next"></div>
            </div>
            <div class="slider-extra js-slider-also-watching">
                <section class="product-card-col">
                    <article class="product-card">
                        <header class="product-card__header">
            <span class="product-card__label background_hit">
                 лидер			        </span>
                            <section class="product-card__option">
                                <button class="product-card__option-item js-favorite">
                                    <span class="product-card__option-icon product-card__option-icon--fav">
                                        <svg width="32" height="21" viewBox="0 0 32 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button class="product-card__option-item">
                                    <span class="product-card__option-icon product-card__option-icon--comp">
										<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="74.333px" height="51.981px" viewBox="23.083 23.843 74.333 51.981" enable-background="new 23.083 23.843 74.333 51.981" xml:space="preserve"><rect x="57.946" y="23.843" width="4.5" height="51.981"/><polygon points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"/><path d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"/><path d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"/></svg>
                                    </span>
                                </button>
                            </section>
                        </header>
                        <section class="product-card__body">
                            <section class="product-card__img-slider js-product-card-img-slider ">
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" >
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                            </section>

                            <section class="product-card__color-slider js-product-card-color-slider">
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                            </section>
                        </section>

                        <footer class="product-card__footer">
                            <h3 class="product-card__name">
                                <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" class="product-card__name-link">
                                    Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL HEATHER                        </a>
                            </h3>
                            <div class="product-card-bot-view-2">
                                <section class="product-card__prices">
                                    <section class="product-card__price product-card__price--new">
                                        <span>₴</span>
										<span class="js-product-new-price">684</span>
									</section>
                                    <section class="product-card__price product-card__price--old">
                                        <span>₴</span>
										<span class="js-product-old-price">855</span>
									</section>
                                </section>
                                <button class="product-card__cart js-open-modal-size">
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z" stroke="#1D2023" stroke-width="2"></path>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"></path>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                    </svg>
                                </button>
                            </div>
                        </footer>
                    </article>
                </section>
                <section class="product-card-col">
                    <article class="product-card">
                        <header class="product-card__header">
            <span class="product-card__label background_hit">
                 лидер			        </span>
                            <section class="product-card__option">
                                <button class="product-card__option-item js-favorite">
                                    <span class="product-card__option-icon product-card__option-icon--fav">
                                        <svg width="32" height="21" viewBox="0 0 32 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button class="product-card__option-item">
                                    <span class="product-card__option-icon product-card__option-icon--comp">
                                        <svg width="29" height="21" viewBox="0 0 29 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M0 11.5h13v8H0z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M3 13.5a3.508 3.508 0 006.973 0H3z"></path>
                                            </mask>
                                            <path class="_path" d="M3 13.5v-2H.767l.245 2.22L3 13.5zm6.973 0l1.987.22.246-2.22H9.973v2zm-3.487 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.499-1.338a1.508 1.508 0 01-1.499 1.338v4a5.508 5.508 0 005.474-4.898l-3.975-.44zm1.988-1.78H3v4h6.973v-4z" fill="#000" mask="url(#a)"></path>
                                            <mask id="b" maskUnits="userSpaceOnUse" x="16.973" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M16.973 11.5h13v8h-13z"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.973 13.5a3.508 3.508 0 006.972 0h-6.972z"></path>
                                            </mask>
                                            <path class="_path" d="M19.973 13.5v-2h-2.234l.246 2.22 1.988-.22zm6.972 0l1.988.22.245-2.22h-2.233v2zm-3.486 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.498-1.338a1.508 1.508 0 01-1.498 1.338v4a5.508 5.508 0 005.474-4.898l-3.976-.44zm1.988-1.78h-6.972v4h6.972v-4z" fill="#000" mask="url(#b)"></path>
                                            <path d="M14.973 0v21m-9-12.5v-4h18v4" stroke="#1D2023" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                            </section>
                        </header>
                        <section class="product-card__body">
                            <section class="product-card__img-slider js-product-card-img-slider ">
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" >
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                            </section>

                            <section class="product-card__color-slider js-product-card-color-slider">
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                            </section>
                        </section>

                        <footer class="product-card__footer">
                            <h3 class="product-card__name">
                                <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" class="product-card__name-link">
                                    Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL HEATHER                        </a>
                            </h3>
                            <div class="product-card-bot-view-2">
                                <section class="product-card__prices">
                                    <section class="product-card__price product-card__price--new">
                                        <span>₴</span>
										<span class="js-product-new-price">684</span>
									</section>
                                    <section class="product-card__price product-card__price--old">
                                        <span>₴</span>
										<span class="js-product-old-price">855</span>
									</section>
                                </section>
                                <button class="product-card__cart js-open-modal-size">
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z" stroke="#1D2023" stroke-width="2"></path>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"></path>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                    </svg>
                                </button>
                            </div>
                        </footer>
                    </article>
                </section>
                <section class="product-card-col">
                    <article class="product-card">
                        <header class="product-card__header">
            <span class="product-card__label background_hit">
                 лидер			        </span>
                            <section class="product-card__option">
                                <button class="product-card__option-item js-favorite">
                                    <span class="product-card__option-icon product-card__option-icon--fav">
                                        <svg width="32" height="21" viewBox="0 0 32 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button class="product-card__option-item">
                                    <span class="product-card__option-icon product-card__option-icon--comp">
                                        <svg width="29" height="21" viewBox="0 0 29 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M0 11.5h13v8H0z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M3 13.5a3.508 3.508 0 006.973 0H3z"></path>
                                            </mask>
                                            <path class="_path" d="M3 13.5v-2H.767l.245 2.22L3 13.5zm6.973 0l1.987.22.246-2.22H9.973v2zm-3.487 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.499-1.338a1.508 1.508 0 01-1.499 1.338v4a5.508 5.508 0 005.474-4.898l-3.975-.44zm1.988-1.78H3v4h6.973v-4z" fill="#000" mask="url(#a)"></path>
                                            <mask id="b" maskUnits="userSpaceOnUse" x="16.973" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M16.973 11.5h13v8h-13z"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.973 13.5a3.508 3.508 0 006.972 0h-6.972z"></path>
                                            </mask>
                                            <path class="_path" d="M19.973 13.5v-2h-2.234l.246 2.22 1.988-.22zm6.972 0l1.988.22.245-2.22h-2.233v2zm-3.486 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.498-1.338a1.508 1.508 0 01-1.498 1.338v4a5.508 5.508 0 005.474-4.898l-3.976-.44zm1.988-1.78h-6.972v4h6.972v-4z" fill="#000" mask="url(#b)"></path>
                                            <path d="M14.973 0v21m-9-12.5v-4h18v4" stroke="#1D2023" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                            </section>
                        </header>
                        <section class="product-card__body">
                            <section class="product-card__img-slider js-product-card-img-slider ">
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" >
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                            </section>

                            <section class="product-card__color-slider js-product-card-color-slider">
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                            </section>
                        </section>

                        <footer class="product-card__footer">
                            <h3 class="product-card__name">
                                <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" class="product-card__name-link">
                                    Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL HEATHER                        </a>
                            </h3>
                            <div class="product-card-bot-view-2">
                                <section class="product-card__prices">
                                    <section class="product-card__price product-card__price--new">
                                        <span>₴</span>
										<span class="js-product-new-price">684</span>
									</section>
                                    <section class="product-card__price product-card__price--old">
                                        <span>₴</span>
										<span class="js-product-old-price">855</span>
									</section>
                                </section>
                                <button class="product-card__cart js-open-modal-size">
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z" stroke="#1D2023" stroke-width="2"></path>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"></path>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                    </svg>
                                </button>
                            </div>
                        </footer>
                    </article>
                </section>
                <section class="product-card-col">
                    <article class="product-card">
                        <header class="product-card__header">
            <span class="product-card__label background_hit">
                 лидер			        </span>
                            <section class="product-card__option">
                                <button class="product-card__option-item js-favorite">
                                    <span class="product-card__option-icon product-card__option-icon--fav">
                                        <svg width="32" height="21" viewBox="0 0 32 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button class="product-card__option-item">
                                    <span class="product-card__option-icon product-card__option-icon--comp">
                                        <svg width="29" height="21" viewBox="0 0 29 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M0 11.5h13v8H0z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M3 13.5a3.508 3.508 0 006.973 0H3z"></path>
                                            </mask>
                                            <path class="_path" d="M3 13.5v-2H.767l.245 2.22L3 13.5zm6.973 0l1.987.22.246-2.22H9.973v2zm-3.487 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.499-1.338a1.508 1.508 0 01-1.499 1.338v4a5.508 5.508 0 005.474-4.898l-3.975-.44zm1.988-1.78H3v4h6.973v-4z" fill="#000" mask="url(#a)"></path>
                                            <mask id="b" maskUnits="userSpaceOnUse" x="16.973" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M16.973 11.5h13v8h-13z"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.973 13.5a3.508 3.508 0 006.972 0h-6.972z"></path>
                                            </mask>
                                            <path class="_path" d="M19.973 13.5v-2h-2.234l.246 2.22 1.988-.22zm6.972 0l1.988.22.245-2.22h-2.233v2zm-3.486 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.498-1.338a1.508 1.508 0 01-1.498 1.338v4a5.508 5.508 0 005.474-4.898l-3.976-.44zm1.988-1.78h-6.972v4h6.972v-4z" fill="#000" mask="url(#b)"></path>
                                            <path d="M14.973 0v21m-9-12.5v-4h18v4" stroke="#1D2023" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                            </section>
                        </header>
                        <section class="product-card__body">
                            <section class="product-card__img-slider js-product-card-img-slider ">
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" >
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                            </section>

                            <section class="product-card__color-slider js-product-card-color-slider">
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                            </section>
                        </section>

                        <footer class="product-card__footer">
                            <h3 class="product-card__name">
                                <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" class="product-card__name-link">
                                    Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL HEATHER                        </a>
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
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z" stroke="#1D2023" stroke-width="2"></path>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"></path>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                    </svg>
                                </button>
                            </div>
                        </footer>
                    </article>
                </section>
                <section class="product-card-col">
                    <article class="product-card">
                        <header class="product-card__header">
            <span class="product-card__label background_hit">
                 лидер			        </span>
                            <section class="product-card__option">
                                <button class="product-card__option-item js-favorite">
                                    <span class="product-card__option-icon product-card__option-icon--fav">
                                        <svg width="32" height="21" viewBox="0 0 32 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button class="product-card__option-item">
                                    <span class="product-card__option-icon product-card__option-icon--comp">
                                        <svg width="29" height="21" viewBox="0 0 29 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M0 11.5h13v8H0z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M3 13.5a3.508 3.508 0 006.973 0H3z"></path>
                                            </mask>
                                            <path class="_path" d="M3 13.5v-2H.767l.245 2.22L3 13.5zm6.973 0l1.987.22.246-2.22H9.973v2zm-3.487 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.499-1.338a1.508 1.508 0 01-1.499 1.338v4a5.508 5.508 0 005.474-4.898l-3.975-.44zm1.988-1.78H3v4h6.973v-4z" fill="#000" mask="url(#a)"></path>
                                            <mask id="b" maskUnits="userSpaceOnUse" x="16.973" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M16.973 11.5h13v8h-13z"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.973 13.5a3.508 3.508 0 006.972 0h-6.972z"></path>
                                            </mask>
                                            <path class="_path" d="M19.973 13.5v-2h-2.234l.246 2.22 1.988-.22zm6.972 0l1.988.22.245-2.22h-2.233v2zm-3.486 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.498-1.338a1.508 1.508 0 01-1.498 1.338v4a5.508 5.508 0 005.474-4.898l-3.976-.44zm1.988-1.78h-6.972v4h6.972v-4z" fill="#000" mask="url(#b)"></path>
                                            <path d="M14.973 0v21m-9-12.5v-4h18v4" stroke="#1D2023" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                            </section>
                        </header>
                        <section class="product-card__body">
                            <section class="product-card__img-slider js-product-card-img-slider ">
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" >
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                            </section>

                            <section class="product-card__color-slider js-product-card-color-slider">
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                            </section>
                        </section>

                        <footer class="product-card__footer">
                            <h3 class="product-card__name">
                                <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" class="product-card__name-link">
                                    Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL HEATHER                        </a>
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
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z" stroke="#1D2023" stroke-width="2"></path>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"></path>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                    </svg>
                                </button>
                            </div>
                        </footer>
                    </article>
                </section>
                <section class="product-card-col">
                    <article class="product-card">
                        <header class="product-card__header">
            <span class="product-card__label background_hit">
                 лидер			        </span>
                            <section class="product-card__option">
                                <button class="product-card__option-item js-favorite">
                                    <span class="product-card__option-icon product-card__option-icon--fav">
                                        <svg width="32" height="21" viewBox="0 0 32 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                                <button class="product-card__option-item">
                                    <span class="product-card__option-icon product-card__option-icon--comp">
                                        <svg width="29" height="21" viewBox="0 0 29 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="a" maskUnits="userSpaceOnUse" x="0" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M0 11.5h13v8H0z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M3 13.5a3.508 3.508 0 006.973 0H3z"></path>
                                            </mask>
                                            <path class="_path" d="M3 13.5v-2H.767l.245 2.22L3 13.5zm6.973 0l1.987.22.246-2.22H9.973v2zm-3.487 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.499-1.338a1.508 1.508 0 01-1.499 1.338v4a5.508 5.508 0 005.474-4.898l-3.975-.44zm1.988-1.78H3v4h6.973v-4z" fill="#000" mask="url(#a)"></path>
                                            <mask id="b" maskUnits="userSpaceOnUse" x="16.973" y="11.5" width="13" height="8" fill="#000">
                                                <path fill="#fff" d="M16.973 11.5h13v8h-13z"></path>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.973 13.5a3.508 3.508 0 006.972 0h-6.972z"></path>
                                            </mask>
                                            <path class="_path" d="M19.973 13.5v-2h-2.234l.246 2.22 1.988-.22zm6.972 0l1.988.22.245-2.22h-2.233v2zm-3.486 1.118a1.508 1.508 0 01-1.498-1.338l-3.976.44a5.508 5.508 0 005.474 4.898v-4zm1.498-1.338a1.508 1.508 0 01-1.498 1.338v4a5.508 5.508 0 005.474-4.898l-3.976-.44zm1.988-1.78h-6.972v4h6.972v-4z" fill="#000" mask="url(#b)"></path>
                                            <path d="M14.973 0v21m-9-12.5v-4h18v4" stroke="#1D2023" stroke-width="2"></path>
                                        </svg>
                                    </span>
                                </button>
                            </section>
                        </header>
                        <section class="product-card__body">
                            <section class="product-card__img-slider js-product-card-img-slider ">
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" >
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004131/4d11be7f5c1111e980bc005056807e63_4d11be815c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                                <a class="product-card__img-link" href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather">
                                    <img loading="lazy" src="https://dev.p1gtac.com/images/products/import_files/00004132/5313c3845c1111e980bc005056807e63_5313c3895c1111e980bc005056807e63-500x500.jpg" alt="Футболка с рисунком &quot;5.11 Patriot Tee&quot;, [035] CHARCOAL HEATHER" class="product-card__img">
                                </a>
                            </section>

                            <section class="product-card__color-slider js-product-card-color-slider">
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000238.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                                <article class="product-card__color js-product-card-color">
                                    <img data-category_id="4530" src="https://prof1group.ua/image/color/000000307.jpg" alt="P1G" class="product-card__color-img">
                                </article>
                            </section>
                        </section>

                        <footer class="product-card__footer">
                            <h3 class="product-card__name">
                                <a href="futbolka-s-risunkom-quot511-patriot-teequot-035-charcoal-heather" class="product-card__name-link">
                                    Футболка с рисунком "5.11 Patriot Tee", [035] CHARCOAL HEATHER                        </a>
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
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z" stroke="#1D2023" stroke-width="2"></path>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"></path>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                    </svg>
                                </button>
                            </div>
                        </footer>
                    </article>
                </section>
            </div>
        </div>
    </div>

</div>
