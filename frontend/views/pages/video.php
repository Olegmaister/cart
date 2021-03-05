<?php
use common\helpers\LanguageHelper;
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'video reviews') ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">

            <div class="page-content-columns p-videos-options">

                <div class="page-content-col page-content-col--left p-videos-options-col">
                    <h1 class="title"><?= Yii::t('app', 'video reviews') ?></h1>
                </div>

                <div class="page-content-col page-content-col--right p-videos-options-col p-videos-options-col--right">

                    <div class="prod-sort p-videos-sort">

                        <div class="prod-sort-col prod-sort-col--left">
                            <div class="prod-sort__title">Сортировать по:</div>
                        </div>

                        <div class="prod-sort-col prod-sort-col--right">
                            <ul class="prod-sort-menu">
                                <li><a href="">распродаже</a></li>
                                <li><a href="">новинкам</a></li>
                                <li><a href="">рейтингу</a></li>
                                <li><a href="">популярности</a></li>
                                <li><a href="">акциям</a></li>
                            </ul>
                        </div>

                    </div>

                </div>
                <!--COLUMN RIGHT-->

            </div>
            <!--OPTIONS-->

            <div class="page-content-columns p-videos-colums">

                <div class="page-content-col page-content-col--left">

                    <button class="btn btn--red btn--full btn--lg-h mob-show-x766 js-toggle-sidebar">
                        <span class="btn__inner">фильтр</span>
                    </button>

                    <div class="sidebar">

                        <div class="filter-cat">

                            <div class="filter-cat-head">

                                <i class="filter-cat-head__icon">
                                    <svg class="_path" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-width="2" d="M1 1h8v8H1zM1 12h8v8H1zM13 1h8v8h-8zM13 12h8v8h-8z"/>
                                    </svg>
                                </i>
                                <div class="filter-cat-head__txt">
                                    все товары
                                </div>

                            </div>

                            <div class="filter-cat-items">

                                <div id="js-height-filter-cat-items">

                                    <div class="filter-cat-item">

                                        <div class="filter-cat-item__icon">
                                            <img loading="lazy" src="/images/slider-content/odejda.svg" alt="">
                                        </div>

                                        <div class="filter-cat-item__txt">
                                            Одежда
                                        </div>

                                    </div>
                                    <div class="filter-cat-item">

                                        <div class="filter-cat-item__icon">
                                            <img loading="lazy" src="/images/slider-content/obuv.svg" alt="">
                                        </div>

                                        <div class="filter-cat-item__txt">
                                            Обувь
                                        </div>

                                    </div>
                                    <div class="filter-cat-item">

                                        <div class="filter-cat-item__icon">
                                            <img loading="lazy" src="/images/slider-content/snaryajenie.svg" alt="">
                                        </div>

                                        <div class="filter-cat-item__txt">
                                            Тактическое снаряжение
                                        </div>

                                    </div>
                                    <div class="filter-cat-item">

                                        <div class="filter-cat-item__icon">
                                            <img loading="lazy" src="/images/slider-content/snaryajenie.svg" alt="">
                                        </div>

                                        <div class="filter-cat-item__txt">
                                            Тактическое снаряжение
                                        </div>

                                    </div>
                                    <div class="filter-cat-item">

                                        <div class="filter-cat-item__icon">
                                            <img loading="lazy" src="/images/slider-content/snaryajenie.svg" alt="">
                                        </div>

                                        <div class="filter-cat-item__txt">
                                            Тактическое снаряжение
                                        </div>

                                    </div>
                                    <div class="filter-cat-item">

                                        <div class="filter-cat-item__icon">
                                            <img loading="lazy" src="/images/slider-content/snaryajenie.svg" alt="">
                                        </div>

                                        <div class="filter-cat-item__txt">
                                            Тактическое снаряжение
                                        </div>

                                    </div>
                                    <div class="filter-cat-item">

                                        <div class="filter-cat-item__icon">
                                            <img loading="lazy" src="/images/slider-content/snaryajenie.svg" alt="">
                                        </div>

                                        <div class="filter-cat-item__txt">
                                            Тактическое снаряжение
                                        </div>

                                    </div>
                                    <div class="filter-cat-item">

                                        <div class="filter-cat-item__icon">
                                            <img loading="lazy" src="/images/slider-content/snaryajenie.svg" alt="">
                                        </div>

                                        <div class="filter-cat-item__txt">
                                            Тактическое снаряжение
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <!--ITEMS-->

                            <div class="filter-cat__arrow js-filter-cat-but">

                                <svg class="_path" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.113 10.056L12.056 20.113 2 10.056" stroke-width="3"/>
                                </svg>

                            </div>

                        </div>
                        <!--FILTER CAT-->

                    </div>
                    <!--SIDEBAR-->

                </div>
                <!--COLUMN LEFT-->

                <div class="page-content-col page-content-col--right">

                    <div class="p-videos-items">

                        <?php

                        //ТУТ ОЖИДАЮ ДАННЫЕ ИЗ БЭКА...


                        //$video_frame_small_2 = $video[5]->content;

                        // ищем ВСЕ совпадения
                        //preg_match_all("/embed\/([aA-zZ_\-\d]+)/", $video_frame_small_2, $matches);
                        // выведем все совпадения в цикле foreach
//                        foreach ($matches[1] as $value) {
//                            $id_video_small_2 = $value;
//                        }
                        $id_video_small_2 = '_1j2KEifZoc';
                        $preview_video_small_2 = 'https://img.youtube.com/vi/_1j2KEifZoc/sddefault.jpg';
                        ?>

                        <div class="p-videos-items-col">

                            <article class="journal-card">

                                <div class="journal-card__mini-img">
                                    <img loading="lazy" src="/images/videos-img.png" alt="">
                                </div>

                                <div class="journal-card__img-link js-video-modal-open" data-video-src="<?= $id_video_small_2; ?>">

                                    <div class="journal-card__play-icon">
                                    <svg width="42" height="42" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M31 21l-15 8.66V12.34L31 21z" fill="#EF1B1B"/><circle cx="21" cy="21" r="20" stroke="#EF1B1B" stroke-width="2"/></svg>
                                </div>
                                    <img loading="lazy" class="journal-card__img" src="<?= $preview_video_small_2; ?>" alt="">
                                </div>
                                <div class="journal-card__info">
                                    <div class="journal-card__info-header">
                                        <a href="/krupnyj-karas" class="journal-card__title title-h4">крупный карась</a>
                                    </div>
                                    <div class="journal-card__info-footer">
                                        <div class="journal-card__date">2020-06-22</div>
                                        <button data-id="13" class="journal-card__like like js-blog-add-like">
                                            <svg class="like__icon" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" tabindex="0">
                                                <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"></path>
                                            </svg>
                                            <span class="js-blog-like-13 like__count">1</span>
                                        </button>
                                    </div>
                                </div>
                            </article>

                        </div>

                        <div class="p-videos-items-col">

                            <article class="journal-card">

                                <div class="journal-card__mini-img">
                                    <img loading="lazy" src="/images/videos-img.png" alt="">
                                </div>

                                <div class="journal-card__img-link js-video-modal-open" data-video-src="<?= $id_video_small_2; ?>">

                                    <div class="journal-card__play-icon">
                                        <svg width="42" height="42" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M31 21l-15 8.66V12.34L31 21z" fill="#EF1B1B"/><circle cx="21" cy="21" r="20" stroke="#EF1B1B" stroke-width="2"/></svg>
                                    </div>
                                    <img loading="lazy" class="journal-card__img" src="<?= $preview_video_small_2; ?>" alt="">
                                </div>
                                <div class="journal-card__info">
                                    <div class="journal-card__info-header">
                                        <a href="/krupnyj-karas" class="journal-card__title title-h4">крупный карась</a>
                                    </div>
                                    <div class="journal-card__info-footer">
                                        <div class="journal-card__date">2020-06-22</div>
                                        <button data-id="13" class="journal-card__like like js-blog-add-like">
                                            <svg class="like__icon" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" tabindex="0">
                                                <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"></path>
                                            </svg>
                                            <span class="js-blog-like-13 like__count">1</span>
                                        </button>
                                    </div>
                                </div>
                            </article>

                        </div>

                        <div class="p-videos-items-col">

                            <article class="journal-card">

                                <div class="journal-card__mini-img">
                                    <img loading="lazy" src="/images/videos-img.png" alt="">
                                </div>

                                <div class="journal-card__img-link js-video-modal-open" data-video-src="<?= $id_video_small_2; ?>">

                                    <div class="journal-card__play-icon">
                                        <svg width="42" height="42" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M31 21l-15 8.66V12.34L31 21z" fill="#EF1B1B"/><circle cx="21" cy="21" r="20" stroke="#EF1B1B" stroke-width="2"/></svg>
                                    </div>
                                    <img loading="lazy" class="journal-card__img" src="<?= $preview_video_small_2; ?>" alt="">
                                </div>
                                <div class="journal-card__info">
                                    <div class="journal-card__info-header">
                                        <a href="/krupnyj-karas" class="journal-card__title title-h4">крупный карась</a>
                                    </div>
                                    <div class="journal-card__info-footer">
                                        <div class="journal-card__date">2020-06-22</div>
                                        <button data-id="13" class="journal-card__like like js-blog-add-like">
                                            <svg class="like__icon" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" tabindex="0">
                                                <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"></path>
                                            </svg>
                                            <span class="js-blog-like-13 like__count">1</span>
                                        </button>
                                    </div>
                                </div>
                            </article>

                        </div>

                    </div>
                    <!--VIDEOS ITEMS-->

                    <div class="p-reviews-bot p-videos-bot">
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
                <!--COLUMN RIGHT-->

            </div>
            <!--P-VIDEOS-->

            <?php if(isset($seoBlock) && !empty($seoBlock)) : ?>
                <?= $this->render('/parts/_seo-block', ['seoBlock' => $seoBlock]) ?>
            <?php endif ?>

        </div>
        <!--PAGE-CONTENT-->

    </div>
    <!--WRAPPER-->

</div>
<!--PAGE-->

<!-- PopUp for video -->
<section class="video-modal">
    <section class="video-modal-window">
        <svg class="video-modal-close js-modal-video-close" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.75 0L18 2.24999L2.25006 17.9999L6.58121e-05 15.7499L15.75 0Z"></path>
            <path d="M0 2.24999L2.24999 2.46558e-06L17.9999 15.7499L15.7499 17.9999L0 2.24999Z"></path>
        </svg>
        <div class="video-modal-youtube js-modal-video-youtube" frameborder="0" allow="autoplay;" allowfullscreen=""></div>
    </section>
</section>
<!-- END PopUp for video -->