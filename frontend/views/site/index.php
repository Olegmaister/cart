<?php

use backend\models\Subscribe;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\widgets\LeftMenuWidget;

/**@var \common\entities\Blog\BlogCategory[] $blogsMenu */

echo $this->render('/seo', [
    'title' => 'PROF1 Group® | Сеть магазинов военной, тактической и полевой одежды, обуви и снаряжения.',
    'description' => 'Сеть военных магазинов тактической, полевой одежды и снаряжения ☛ Купить военную одежду, обувь, снаряжение и аксессуары по низкой цене с БЕСПЛАТНОЙ доставкой по всей Украине ➤ официальный дистрибьютор ➤ работаем с 2001 года ➤  Лучший военторг в Украине! | Prof1Group.ua',
    //'keywords' => 'PROF1 Group®',
    'url' => 'https://prof1group.ua/',
    'image' => 'https://prof1group.ua/image/cache/catalog/prof1group-300x300.png',
    'width' => 300,
    'height' => 300,
]);
?>


<section class="slider-content clearfix">
    <div class="slider-content-col slider-content-col_left">
        <div class="header-cat">

            <div class="header-cat__title">
                <a href="<?= LanguageHelper::langUrl('catalog') ?>" class="">
                    <?= Yii::t('app', 'catalog') ?>
                    <div class="header-cat__title-icons">
                        <div class="header-cat__title-icon header-cat__title-icon--first">
                            <svg width="12" height="12" viewBox="0 0 23 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path class="header-cat__title-icon__path header-cat__title-icon__path--first"
                                      d="M10.1692 2L20.2256 12.0564L10.1692 22.1128" stroke-width="3"/>
                            </svg>
                        </div>
                        <div class="header-cat__title-icon header-cat__title-icon--last">
                            <svg width="12" height="12" viewBox="0 0 23 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path class="header-cat__title-icon__path header-cat__title-icon__path--first"
                                      d="M10.1692 2L20.2256 12.0564L10.1692 22.1128" stroke-width="3"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
            <ul class="header-cat-menu header-cat-menu_main">
			    <?= LeftMenuWidget::widget() ?>
            </ul>
        </div>
    </div>
    <div class="slider-content-col slider-content-col_right">
        <div class="slider-main">
            <div class="slider-arrows">
                <div class="slider-arrow slider-arrow__prev"></div>
                <div class="slider-arrow slider-arrow__next"></div>
            </div>
            <div class="slider-main-nums">
                <div class="slider-main-num__item slider-main-num__item_static js-hero-slider-total">03</div>
                <div class="slider-main-num__item slider-main-num__item_dunamic">
                    <span>0</span><span class="s-num-counter js-hero-slider-current">1</span>
                </div>
            </div>

            <div class="slider-main-wrap">
                <?php foreach ($slider as $slide): ?>
                    <div class="slider-main__item">
                        <div class="slider-main__content">
                            <h2 class="slider-main__content-title slide-up">
                                <?= ProductHelper::splitText($slide['text']) ?>
                            </h2>
                            <button class="btn-link">
                                <a href="<?= LanguageHelper::langUrl($slide['link']) ?>"
                                onclick="gtag('event', 'category', {'event_category': 'Кнопка на слайдере', 'event_action': 'Нажатие на кнопку'});" 
                                   class="btn-link__inner"><?= $slide['button_name'] ?></a>
                            </button>
                        </div>
                        <figure class="slider-main__img-wrap">
                            <?php $text = strip_tags($slide['name']) ?>
                            <img data-lazy="/images/slider/<?= $slide['image'] ?>" alt="<?= $text ?>" title="<?= $text ?> - PROF1Group" class="slider-main__img">
                        </figure>
                    </div>
                <?php endforeach ?>

                <?php /*
                    <div class="slider-main__item">
                        <div class="slider-main__content">
                            <h2 class="slider-main__content-title">
                                <span class="slide-up">
                                    <span class="slide-up__content">P1G</span>
                                </span>
                                <span class="slide-up">
                                    <span class="slide-up__content">первый украинский</span>
                                </span>
                                <span class="slide-up">
                                    <span class="slide-up__content">военный бренд</span>
                                </span>
                            </h2>
                            <button class="btn-link">
                                <a href="#" class="btn-link__inner"><?= Yii::t('app', 'read more') ?></a>
                            </button>
                        </div>
                        <figure class="slider-main__img-wrap">
                            <img loading="lazy" src="/images/slider-content/hero_slide_1.jpg" alt="" class="slider-main__img">
                        </figure>
                    </div>
                    <div class="slider-main__item">
                        <div class="slider-main__content">
                            <h2 class="slider-main__content-title">
                                <span class="slide-up">
                                    <span class="slide-up__content">P1G</span>
                                </span>
                                <span class="slide-up">
                                    <span class="slide-up__content">лучший украинский</span>
                                </span>
                                <span class="slide-up">
                                    <span class="slide-up__content">военный бренд</span>
                                </span>
                            </h2>
                            <button class="btn-link">
                                <a href="#" class="btn-link__inner"><?= Yii::t('app', 'read more') ?></a>
                            </button>
                        </div>
                        <figure class="slider-main__img-wrap">
                            <img loading="lazy" src="/images/slider-content/hero_slide_2.jpg" alt="" class="slider-main__img">
                        </figure>
                    </div>
                    <div class="slider-main__item">
                        <div class="slider-main__content">
                            <h2 class="slider-main__content-title">
                                <span class="slide-up">
                                    <span class="slide-up__content">P1G</span>
                                </span>
                                <span class="slide-up">
                                    <span class="slide-up__content">первый украинский</span>
                                </span>
                                <span class="slide-up">
                                    <span class="slide-up__content">военный бренд</span>
                                </span>
                            </h2>
                            <button class="btn-link">
                                <a href="#" class="btn-link__inner"><?= Yii::t('app', 'read more') ?></a>
                            </button>
                        </div>
                        <figure class="slider-main__img-wrap">
                            <img loading="lazy" src="/images/slider-content/hero_slide_3.jpg" alt="" class="slider-main__img">
                        </figure>
                    </div>
                    <div class="slider-main__item">
                        <div class="slider-main__content">
                            <h2 class="slider-main__content-title">
                                <span class="slide-up">
                                    <span class="slide-up__content">P1G</span>
                                </span>
                                <span class="slide-up">
                                    <span class="slide-up__content">премиум</span>
                                </span>
                                <span class="slide-up">
                                    <span class="slide-up__content">военный бренд</span>
                                </span>
                            </h2>
                            <button class="btn-link">
                                <a href="#" class="btn-link__inner"><?= Yii::t('app', 'read more') ?></a>
                            </button>
                        </div>
                        <figure class="slider-main__img-wrap">
                            <img loading="lazy" src="/images/slider-content/hero_slide_4.jpg" alt="" class="slider-main__img">
                        </figure>
                    </div>
                */ ?>
            </div>


        </div>
    </div>
</section>

<section class="brands">
    <?= $this->render('blocks/_brands', ['brands' => $brands]) ?>
</section>


<section class="content s_tabs _flex catalog-cards">

    <div class="wrapper">
        <h2 class="title"><?= Yii::t('app', 'catalog') ?></h2>
        <div class="row mt-4 align-items-center    list__items hide">
            <div class="col-lg mb-4">
                <ul class="content-nav s_tabs_list list_by-params">
                    <li class="content-nav__item active" data-link="<?= LanguageHelper::langUrl('hits') ?>"
                        data-title="<?= Yii::t('app', 'leaders') ?>"><?= Yii::t('app', 'leaders') ?></li>
                    <li class="content-nav__item" data-link="<?= LanguageHelper::langUrl('novelty') ?>"
                        data-title="<?= Yii::t('app', 'new items') ?>"><?= Yii::t('app', 'new items') ?></li>
                    <li class="content-nav__item" data-link="<?= LanguageHelper::langUrl('sales') ?>"
                        data-title="<?= Yii::t('app', 'sales') ?>"><?= Yii::t('app', 'sale') ?></li>
                    <li class="content-nav__item" data-link="<?= LanguageHelper::langUrl('recommend') ?>"
                        data-title="<?= Yii::t('app', 'recommended') ?>"><?= Yii::t('app', 'recommend') ?></li>
                    <li class="content-nav__item" data-link="<?= LanguageHelper::langUrl('aktsii') ?>"
                            data-title="<?= Yii::t('app', 'aktsii') ?>"><?= Yii::t('app', 'aktsii') ?></li>
                </ul>
            </div>
            <div class="col-lg-auto d-none d-lg-block mb-4">
                <a href="<?= LanguageHelper::langUrl('hits') ?>" class="button-6" id="all-hits-btn"><?= Yii::t('app', 'all') ?> <?= Yii::t('app', 'leaders') ?></a>
                <button class="btn btn--lg btn--red d-none">
                    <a class="_full-page" href="<?= LanguageHelper::langUrl('hits') ?>">
                    <span class="btn__inner"><?= Yii::t('app', 'all') ?>
                        <span class="inner_text-label"><?= Yii::t('app', 'leaders') ?></span></span>
                    </a>
                </button>
            </div>
        </div>

        <div class=" main__items">
        <?php /* ?>
        <?php if (count($items) > 0): ?>
            <?php foreach ($productGroup as $group): ?>
                <div class="product-card-wrap s_tabs_content <?= $group == 'hit' ? 'active' : '' ?>">
                    <div class="block_product-list__<?= $group ?>" style="display: contents;">
                        <?= $this->render('/parts/_items-common', [
                            'items' => $items[$group],
                            'name' => $group,
                            'currency' => $currency,
                            'productService' => $productService,
                            'compare' => $compare,
                            'wishList' => $wishList
                        ]) ?>
                    </div>
                    <div class="card-more-but">
                        <button class="btn btn--lg btn--black view-more_by-field btn-list__<?= $group ?>"
                                onclick="gtag('event', 'category', {'event_category': 'Показать еще в каталоге', 'event_action': 'Нажатие на кнопку'});"
                                data-field="<?= $group ?>" data-page="2">
                            <a href="#" class="btn__inner"><?= Yii::t('app', 'show more') ?></a>
                        </button>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
        <?php */ ?>
        </div>
    </div>

</section>



<section class="video-reviews">
    <section class="wrapper">
        <section class="video-reviews-head">
            <section class="video-reviews-head-col video-reviews-head-col_left">
                <h2 class="title title_reviews"><?= Yii::t('app', 'new product reviews') ?></h2>
            </section>
            <section class="video-reviews-head-col video-reviews-head-col_right">
                <a rel="nofollow" target="_blank" href="https://www.youtube.com/user/prof1media" class="btn btn--lg btn--red">
                    <span class="btn__inner"><?= Yii::t('app', 'more reviews') ?></span>
                </a>
            </section>
        </section>
        <section class="video-reviews-content">
            <section class="video-reviews-content-col video-reviews-content-col_left">
                <article class="video-reviews-player">
                    <figure class="video-reviews-player__vid video-reviews-player__vid--main js-video-modal-open"
                            tabindex="0"
                            data-video-src="<?= $video[0]['image_name'] ?>">
                        <img loading="lazy" src="<?= $video[0]['preview_video'] ?>" alt="<?= $video[0]['name'] ?>"
                             class="video-reviews-player__img">
                        <button class="video-reviews-player__button" type="button" aria-label="Запустить видео"
                                title="Запустить видео">
                            <svg width="68" height="48" viewBox="0 0 68 48">
                                <path class="video-reviews-player__button-shape"
                                      d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                                <path class="video-reviews-player__button-icon" d="M 45,24 27,14 27,34"></path>
                            </svg>
                        </button>
                    </figure>
                    <section class="video-reviews-player-bot">
                        <a href="<?= LanguageHelper::langUrl($video[0]['keyword']) ?>" class="video-reviews-player__name"><?= $video[0]['name'] ?></a>
                        <section class="video-reviews-player-serv">
                            <section class="video-reviews-player-serv-col video-reviews-player-serv-col_left">
                                <p class="video-reviews-date"><?= $video[0]['date_modified'] ?></p>
                            </section>
                            <?php if(isset($video[0]['tags'][0])): ?>
                                <section class="video-reviews-player-serv-col video-reviews-player-serv-col_right">
                                    <a href="<?=$video[0]['tags'][0]['link'] ?>" class="video-reviews-tags"><?= $video[0]['tags'][0]['name'] ?></a>
                                </section>
                            <?php endif ?>
                        </section>
                    </section>
                </article>
            </section>
            <!-- LEFT -->
            <section class="video-reviews-content-col video-reviews-content-col_right">
                <article class="video-reviews-prev">
                    <article class="video-reviews-prev-row">
                        <section class="video-reviews-prev-wrap">
                            <section class="video-reviews-prev-col video-reviews-prev-col_left">
                                <figure class="video-reviews-prev-img js-video-modal-open"
                                        tabindex="0"
                                        data-video-src="<?= $video[1]['image_name'] ?>">
                                    <img loading="lazy" src="<?= $video[1]['preview_video'] ?>" alt="<?= $video[1]['image_name'] ?>"
                                         class="video-reviews-prev-img__img">
                                    <button class="video-reviews-prev-img__button" type="button"
                                            aria-label="Запустить видео" title="Запустить видео">
                                        <svg width="68" height="48" viewBox="0 0 68 48">
                                            <path class="video-reviews-prev-img__button-shape"
                                                  d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                                            <path class="video-reviews-prev-img__button-icon"
                                                  d="M 45,24 27,14 27,34"></path>
                                        </svg>
                                    </button>
                                </figure>
                            </section>
                            <!-- COLUMN -->
                            <div class="video-reviews-prev-col video-reviews-prev-col_right">
                                <a href="<?= LanguageHelper::langUrl($video[1]['keyword']) ?>" class="video-reviews-prev__title">
                                    <?= $video[1]['name'] ?>
                                </a>
                                <div class="video-reviews-prev-bot">
                                    <div class="video-reviews-prev-bot-col video-reviews-prev-bot-col_left">
                                        <div class="video-reviews-date">
                                            <?= $video[1]['date_modified'] ?>
                                        </div>
                                    </div>
                                    <div class="video-reviews-prev-bot-col video-reviews-prev-bot-col_right mob-hide-x766 _flex">
                                        <?php if(isset($video[1]['tags'][0]['name'])): ?>
                                            <?php foreach($video[1]['tags'] as $tag): ?>
                                                <a href="<?= $tag['link'] ?>" class="video-reviews-tags"><?= $tag['name'] ?></a>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <!-- COLUMN -->
                        </section>
                        <!-- WRAPPER -->
                        <div class="video-reviews-prev-row-mob mob-show-x766 _flex">
                            <?php if(isset($video[1]['tags'][0]['name'])): ?>
                                <?php foreach($video[1]['tags'] as $tag): ?>
                                    <a href="<?= $tag['link'] ?>" class="video-reviews-tags"><?= $tag['name'] ?></a>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </article>
                    <!-- ROW -->
                    <article class="video-reviews-prev-row">
                        <section class="video-reviews-prev-wrap">
                            <section class="video-reviews-prev-col video-reviews-prev-col_left">
                                <figure class="video-reviews-prev-img js-video-modal-open"
                                        tabindex="0"
                                        data-video-src="<?= $video[2]['image_name'] ?>">
                                    <img loading="lazy" src="<?= $video[2]['preview_video'] ?>" alt="<?= $video[2]['name'] ?>"
                                         class="video-reviews-prev-img__img">
                                    <button class="video-reviews-prev-img__button" type="button"
                                            aria-label="Запустить видео" title="Запустить видео">
                                        <svg width="68" height="48" viewBox="0 0 68 48">
                                            <path class="video-reviews-prev-img__button-shape"
                                                  d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                                            <path class="video-reviews-prev-img__button-icon"
                                                  d="M 45,24 27,14 27,34"></path>
                                        </svg>
                                    </button>
                                </figure>
                            </section>
                            <!-- COLUMN -->
                            <div class="video-reviews-prev-col video-reviews-prev-col_right">
                                <a href="<?= LanguageHelper::langUrl($video[2]['keyword']) ?>" class="video-reviews-prev__title">
                                    <?= $video[2]['name'] ?>
                                </a>
                                <div class="video-reviews-prev-bot">
                                    <div class="video-reviews-prev-bot-col video-reviews-prev-bot-col_left">
                                        <div class="video-reviews-date">
                                            <?= $video[2]['date_modified'] ?>
                                        </div>
                                    </div>
                                    <div class="video-reviews-prev-bot-col video-reviews-prev-bot-col_right mob-hide-x766 _flex">
                                        <?php if(isset($video[2]['tags'][0]['name'])): ?>
                                            <?php foreach($video[2]['tags'] as $tag): ?>
                                                <a href="<?= $tag['link'] ?>" class="video-reviews-tags"><?= $tag['name'] ?></a>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <!-- COLUMN -->
                        </section>
                        <!-- WRAPPER -->

                        <div class="video-reviews-prev-row-mob mob-show-x766">
                            <?php if(isset($video[2]['tags'][0]['name'])): ?>
                                <?php foreach($video[2]['tags'] as $key => $tag): ?>
                                    <a href="<?= $tag['link'] ?>" class="video-reviews-tags"><?= $tag['name'] ?></a>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </article>
                    <!-- ROW -->
                    <article class="video-reviews-prev-row">
                        <section class="video-reviews-prev-wrap">
                            <section class="video-reviews-prev-col video-reviews-prev-col_left">
                                <figure class="video-reviews-prev-img js-video-modal-open"
                                        tabindex="0"
                                        data-video-src="<?= $video[3]['image_name'] ?>">
                                    <img loading="lazy" src="<?= $video[3]['preview_video'] ?>" alt="<?= $video[3]['name'] ?>"
                                         class="video-reviews-prev-img__img">
                                    <button class="video-reviews-prev-img__button" type="button"
                                            aria-label="Запустить видео" title="Запустить видео">
                                        <svg width="68" height="48" viewBox="0 0 68 48">
                                            <path class="video-reviews-prev-img__button-shape"
                                                  d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path>
                                            <path class="video-reviews-prev-img__button-icon"
                                                  d="M 45,24 27,14 27,34"></path>
                                        </svg>
                                    </button>
                                </figure>
                            </section>
                            <!-- COLUMN -->
                            <div class="video-reviews-prev-col video-reviews-prev-col_right">
                                <a href="<?= LanguageHelper::langUrl($video[3]['keyword']) ?>" class="video-reviews-prev__title">
                                    <?= $video[3]['name'] ?>
                                </a>
                                <div class="video-reviews-prev-bot">
                                    <div class="video-reviews-prev-bot-col video-reviews-prev-bot-col_left">
                                        <div class="video-reviews-date">
                                            <?= $video[3]['date_modified'] ?>
                                        </div>
                                    </div>
                                    <div class="video-reviews-prev-bot-col video-reviews-prev-bot-col_right mob-hide-x766 _flex">
                                        <?php if(isset($video[3]['tags'][0]['name'])): ?>
                                            <?php foreach($video[3]['tags'] as $tag): ?>
                                                <a href="<?= $tag['link'] ?>" class="video-reviews-tags"><?= $tag['name'] ?></a>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                            <!-- COLUMN -->
                        </section>
                        <!-- WRAPPER -->
                        <div class="video-reviews-prev-row-mob mob-show-x766 _flex">
                            <?php if(isset($video[3]['tags'][0]['name'])): ?>
                                <?php foreach($video[3]['tags'] as $tag): ?>
                                    <a href="<?= $tag['link'] ?>" class="video-reviews-tags"><?= $tag['name'] ?></a>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </article>
                    <!-- ROW -->
                </article>
            </section>
            <!-- RIGHT -->
        </section>
        <button class="btn btn--lg-h btn--full btn--red mob-show-x766 _flex">
            <span class="btn__inner"><?= Yii::t('app', 'more reviews') ?></span>
        </button>
    </section>
    <!-- WRAPPER -->
</section>

<!-- PopUp for video -->
<section class="video-modal">
    <section class="video-modal-window">
        <svg class="video-modal-close js-modal-video-close" width="18" height="18" viewBox="0 0 18 18"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M15.75 0L18 2.24999L2.25006 17.9999L6.58121e-05 15.7499L15.75 0Z"></path>
            <path d="M0 2.24999L2.24999 2.46558e-06L17.9999 15.7499L15.7499 17.9999L0 2.24999Z"></path>
        </svg>
        <div class="video-modal-youtube js-modal-video-youtube" frameborder="0" allow="autoplay;"
             allowfullscreen=""></div>
    </section>
</section>
<!-- END PopUp for video -->

<section class="subscribe-yt">
    <div class="wrapper">
        <div class="subscribe-yt-col subscribe-yt-col_left">
            <div class="subscribe-yt__icon">
                <img loading="lazy" src="/images/subscribe-yt/youtube.svg" alt="Youtube">
            </div>
            <div class="subscribe-yt__txt">
                <?= Yii::t('app', 'Subscribe to our YouTube channel and be the first to know about new reviews') ?>
            </div>
        </div>
		
        <div class="subscribe-yt-col subscribe-yt-col_right">
            <a rel="nofollow" target="_blank" href="https://www.youtube.com/channel/UCpCWHrMZ1INYZcmh--ygCSQ?sub_confirmation=1" class="btn btn--lg btn--red"
               onclick="gtag('event', 'category', {'event_category': 'Подписаться на YouTube', 'event_action': 'Нажатие на кнопку'});">
                <span class="btn__inner"><?= Yii::t('app', 'subscribe') ?></span>
            </a>
        </div>
    </div>
</section>


<!--blog-->
<?php if(isset($blogsData['menus'][0]) && isset($blogsData['mainData'][0])): ?>
    <?= $this->render('blocks/_blog-arr', [
        'blogsData' => $blogsData
    ]) ?>
<?php endif ?>
<?php /* ?>
<?= $this->render('common/_blog', [
    'blogsMenu' => $blogsMenu
]); ?>
<?php */ ?>
<!--/blog-->


<section class="subscribe-mail">
    <div class="wrapper">
        <div class="subscribe-mail-col subscribe-mail-col_left">
            <div class="subscribe-mail-icon">
                <img loading="lazy" src="/images/subscribe-mail/icon.svg" alt="subscribe-mail">
            </div>
            <div class="subscribe-mail__txt">
                <?= Yii::t('app', 'Subscribe to the mailing list') ?><br>
                <?= Yii::t('app', 'articles of our military magazine') ?>
            </div>
        </div>
        <div class="subscribe-mail-col subscribe-mail-col_right">
            <div class="subscribe-form subscribe-form_mob subscribe-wrapper_js">
                <div class="subscribe-form-field">
                    <input type="text" value="" placeholder="E-mail " class="subscribe-form-input field_effect">
                </div>
                <div class="subscribe-form-but">
                    <button class="btn btn--full btn--red subscribe-btn_js" data-type="<?= Subscribe::ARTICLE_TYPE ?>"
                            onclick="gtag('event', 'category', {'event_category': 'Открыть угловой баннер', 'event_action': 'Подписаться на Email'});">
                        <span class="btn__inner"><?= Yii::t('app', 'subscribe') ?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (isset($seoBlock) && !empty($seoBlock)) : ?>
    <section class="post-prev post-prev--main">
        <div class="wrapper">
            <?= $this->render('/parts/_seo-block_arr', ['seoBlock' => $seoBlock]) ?>
        </div>
    </section>
<?php endif ?>

<?php if (Yii::$app->request->get('email-invoice')): ?>
    <?php
    $js = <<<JS
    $(function() {
        let url = new URL(document.location.href);
        let invoice = url.searchParams.get("email-invoice");
        download('/download-invoice?id=' + invoice, 'invoice.pdf')
    })

    function download(url, filename) {
        fetch(url).then(function(t) {
            if (t.status !== 200) {
                notify('Ошибка формирования счет фактуры');
                
                return;
            }
            
            return t.blob().then((b)=>{
                let a = document.createElement("a");
                a.href = URL.createObjectURL(b);
                a.setAttribute("download", filename);
                a.click();
                
                location.href = '/';
             });
        });
    }
JS;

    $this->registerJs($js);
    ?>
<?php endif ?>