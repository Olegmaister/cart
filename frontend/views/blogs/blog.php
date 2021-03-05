<?php

use common\helpers\LanguageHelper;
use common\widgets\Blog\RightWidget;
use common\widgets\Blog\TagNameWidget;
use yii\helpers\Html;
use yii\helpers\Url;

/**@var \frontend\entities\Blog\Review $providers */
/**@var \common\entities\Blog\review\BlogReview $provider */


$currUrl = Url::home(true) . substr(Url::to(), 1);

echo $this->render('/seo', [
    'title' => $blog->childrenDescription->name,
    'description' => $blog->childrenDescription->name,
    'keywords' => $blog->childrenDescription->name,
    'image' => isset($blog->photos[0]) ? ( $blog->photos[0])->getThumbFileUrl('file', 'slider') : null,
]);
?>
<div class="page">
    <div class="wrapper">

        <ul class="breadcrumbs">
            <li><a href="<?= LanguageHelper::langUrl('/') ?>"><?= Yii::t('app', 'home') ?></a></li>
            <li><a href="<?= LanguageHelper::langUrl('novosti') ?>"><?= Yii::t('app', 'magazine') ?></a></li>
            <li><span><?= $blog->childrenDescription->name ?></span></li>
        </ul>

        <div class="page-content">
            <h1 class="title title--page"><?= $blog->childrenDescription->name ?></h1>
            <div class="journal-one">
                <div class="journal-one-col journal-one-col--left">
                    <div class="journal-one-slider">
                        <!-- НАЧАЛО
                        Это блок если есть 2 и больше картинок
                        -->

                        <?php if (count($blog->photos) > 1):?>
                            <div class="journal-one-slider-slides">
                                <div class="journal-one-slider-col journal-one-slider-col--left">
                                    <div class="journal-one-slider-images">

                                        <!--вывод имени тега-->
                                        <?=TagNameWidget::widget([
                                            'category' => $blog
                                        ])?>
                                        <!--/вывод имени тега-->

                                        <div class="p-actions-card-media__label">
                                            <span class="journal-label"><?= $parent->getLanguageName(); ?></span>
                                        </div>
                                        <div class="slider-arrows">
                                            <div class="slider-arrow slider-arrow__prev"></div>
                                            <div class="slider-arrow slider-arrow__next"></div>
                                        </div>
                                        <div class="js-slider-journal">
                                            <?php foreach ($blog->photos as $photo) : ?>
                                                <div class="slider-main__item slider-main__item--journal">
                                                    <figure class="slider-main__img-wrap">
                                                        <?= Html::img($photo->getThumbFileUrl('file', 'slider'), ['class' => 'slider-main__img']) ?>
                                                    </figure>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="row py-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="journal-one-slider-info__autor m-0">
                                                <?= Yii::t('app', 'Author') ?>: <?= $blog->author ?></div>
                                        </div>
                                        <div class="col-auto ml-auto order-sm-last">
                                            <button data-id="<?= $blog->id ?>"
                                                    class="<?php if ($blog->isCheckLike()) echo 'is-active' ?> journal-card__like like like--dynamic js-blog-add-like">
                                                <svg class="like__icon" width="24" height="24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     tabindex="0">
                                                    <path stroke-width="2"
                                                          d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                                </svg>
                                                <span class="js-blog-like-<?= $blog->id ?> like__count"><?= $blog->like ?></span>
                                            </button>
                                        </div>
                                        <div class="col-sm-auto">
                                            <div class="video-reviews-date"><?= $blog->getAddDate() ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="journal-one-slider-col journal-one-slider-col--right d-none d-lg-block">
                                    <div class="journal-one-slider-thumbs js-slider-journal-thumbs">
                                        <?php foreach ($blog->photos as $miniPhoto): ?>
                                            <div class="journal-one-slider-thumbs-item">
                                                <?= Html::img($miniPhoto->getThumbFileUrl('file', 'slider'), ['class' => 'journal-one-slider-thumbs__img']) ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php
                        else:
                            ?>
                            <!--start block one photo-->
                            <div class="journal-one-slider-slides">
                                <div class="journal-one-slider-col journal-one-slider-col--full">
                                    <div class="journal-one-slider-images">

                                        <!--вывод имени тега-->
                                        <?=TagNameWidget::widget([
                                            'category' => $blog
                                        ])?>
                                        <!--/вывод имени тега-->

                                        <div class="js-slider-journal">
                                            <?php foreach ($blog->photos as $photo) : ?>
                                                <div class="slider-main__item slider-main__item--journal">
                                                    <figure class="slider-main__img-wrap">
                                                        <?= Html::img($photo->getThumbFileUrl('file', 'slider'), ['class' => 'slider-main__img']) ?>
                                                    </figure>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="journal-one-slider-info">
                                        <div class="journal-one-slider-info-col journal-one-slider-info-col--left">
                                            <div class="journal-one-slider-info__autor">
                                                <?= Yii::t('app', 'Author') ?>: <?= $blog->author ?></div>
                                            <div class="video-reviews-date"><?= $blog->getAddDate() ?></div>
                                        </div>
                                        <div class="journal-one-slider-info-col journal-one-slider-info-col--right">
                                            <div class="journal-one-slider-images__label">
                                                <div class="journal-label"><?= $parent->getLanguageName() ?></div>
                                            </div>
                                            <button data-id="<?= $blog->id ?>"
                                                    class="journal-card__like like like--dynamic js-blog-add-like">
                                                <svg class="like__icon" width="24" height="24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     tabindex="0">
                                                    <path stroke-width="2"
                                                          d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                                </svg>
                                                <span class="js-blog-like-<?= $blog->id ?> like__count"><?= $blog->like ?></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!--end block one photo-->

                    </div>
                    <div class="journal-one-content">
                        <h2 class="journal-one-content__title"><?= $blog->childrenDescription->heading ?></h2>
                        <h2 class="journal-one-content__title"><?= $blog->childrenDescription->introduction ?></h2>
                        <?= $blog->childrenDescription->text ?>
                    </div>

                    <div class="journal-one-sidebar__but mob-show-x766">
                        <button class="btn btn--blue btn--full btn--lg-x btn--icon btn--icon--ls btn--icon--fb fb-share">
                            <span class="btn__inner"><i></i><?= Yii::t('app', 'Share the article on facebook') ?></span>
                        </button>
                    </div>
                    <div class="journal-one-reviews">
                        <div class="journal-one-reviews__but">
                            <button
                                    data-id="<?= $blog->id ?>"
                                    class="js-add-review js-open-modal-review btn btn--red btn--lg">
                                <span class="btn__inner"><?= Yii::t('app', 'write a feedback') ?></span>
                            </button>
                        </div>

                        <?= $this->render('common/review_popup', [
                            'model' => $model
                        ]) ?>


                        <div class="journal-one-reviews-items">
                            <?php foreach ($providers->getProvider()->getModels() as $provider) :
                                $description = $provider->blogReviewDescription;
                                $childrens = $provider->getChildrens();


                                ?>
                                <div class="product-reviews-row">
                                    <!--гланвый коммент-->
                                    <div class="product-reviews-top">
                                        <div class="product-reviews-top-col product-reviews-top-col--left">
                                            <div class="product-reviews__name"><?= $description->author ?></div>
                                        </div>

                                        <div class="product-reviews-top-col product-reviews-top-col--right">
                                            <div class="rating">
                                                <div class="rating__item rating__item--active"></div>
                                                <div class="rating__item rating__item--active"></div>
                                                <div class="rating__item rating__item--active"></div>
                                                <div class="rating__item rating__item--active"></div>
                                                <div class="rating__item"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-reviews__comments">
                                        <?= $description->text ?>
                                    </div>

                                    <div class="product-reviews-bot">
                                        <div class="product-reviews-bot-col product-reviews-bot-col--left">
                                            <div class="product-reviews-buttons">
                                                <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                                                    <button
                                                            data-id="<?= $provider->getId() ?>"
                                                            class="js-add-review-child js-open-modal-review btn btn--trans btn--lxs">
                                                        <span class="btn__inner"><?= Yii::t('app', 'answer') ?></span>
                                                    </button>
                                                </div>

                                                <?php if (!empty($childrens)): ?>
                                                    <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                                                        <div tabindex="0" class="product-reviews__link js-answers">
                                                            Комментарии <span>(<?= count($childrens) ?>)</span>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="product-reviews-bot-col product-reviews-bot-col--right">
                                            <div class="video-reviews-date"><?= date('Y-m-d H:i:s', $provider->created_at) ?></div>
                                        </div>
                                    </div>
                                    <!--/главный коммент-->

                                    <!--ответы-->

                                    <?php if (isset($childrens) && !empty($childrens)): ?>
                                        <div class="product-reviews-answers">
                                            <!--ответ-->
                                            <?php foreach ($childrens as $children): ?>
                                                <div class="product-reviews-answers-item">
                                                    <div class="product-reviews-answers__name">
                                                        <?= $children->blogReviewDescription->author ?>
                                                        <div class="video-reviews-date"><?= date('Y-m-d H:i:s', $children->created_at) ?></div>
                                                    </div>

                                                    <div class="product-reviews-answers__comment">
                                                        <?= $children->blogReviewDescription->text ?>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                            <!--/ответ-->
                                        </div>

                                    <?php endif; ?>


                                    <!--/ответы-->
                                    <!--ANSWERS-->
                                </div>
                            <?php endforeach; ?>


                        </div>

                        <?php if ($providers->showButton()) : ?>
                            <div class="journal-one-reviews-items__but">
                                <button data-page="2" data-id="<?= $blog->id ?>"
                                        class="js-btn-show-review btn btn--gray btn--lg">
                                    <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                                </button>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
                <!--left-->
                <?= RightWidget::widget([
                    'category' => $blog
                ]) ?>
                <!--right-->

            </div>
        </div>
    </div>
    <!--WRAPPER-->
</div>
<!--PAGE-->
<script>
    Share = {
        facebook: function () {
            let url = '';
            url = 'https://www.facebook.com/sharer/sharer.php?app_id=2799034640350359';
            url += '&sdk=joey'
            url += '&u=' + encodeURIComponent('<?= $currUrl ?>');
            url += '&display=popup&ref=plugin&src=share_button';
            Share.popup(url);
        },
        popup: function (url) {
            window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
        }
    };

    let elem = document.getElementsByClassName('fb-share');

    for (let i = 0; i < elem.length; i++) {
        elem[i].onclick = function () {
            Share.facebook()
        }
    }
</script>