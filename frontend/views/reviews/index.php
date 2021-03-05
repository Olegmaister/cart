<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\widgets\CustomLinkPager;

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

            <h1 class="title title--page"><?= Yii::t('app', 'all') ?> <?= Yii::t('app', 'reviews') ?></h1>

            <div class="p-reviews">


                <?php foreach ($reviews->getModels() as $review): ?>
                    <div class="product-reviews-row product-reviews-row--columns">

                        <div class="product-reviews-col product-reviews-col--left">
                            <div class="product-reviews-user">
                                <a href="<?= LanguageHelper::langUrl($review->url['keyword']) ?>">
                                    <img loading="lazy"
                                         src="<?= ProductHelper::correctedImgPath_228p($review->product['image']) ?>"
                                         alt="<?= $review->productDescription['name'] ?>"
                                         class="product-reviews-user__photo">
                                </a>
                            </div>
                        </div>

                        <div class="product-reviews-col product-reviews-col--right">

                            <div class="product-reviews-top">
                                <div class="product-reviews-top-col product-reviews-top-col--left">
                                    <div class="product-reviews__name-prod">
                                        <a href="<?= LanguageHelper::langUrl($review->url['keyword']) ?>">
                                            <?= $review->productDescription['name'] ?>
                                        </a>
                                    </div>
                                    <div class="product-reviews__name"><?= $review['author'] ?></div>
                                </div>
                                <div class="product-reviews-top-col product-reviews-top-col--right">
                                    <div class="rating">
                                        <?= ProductHelper::getRatingStars($review) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="product-reviews__comments">
                                <?= $review['text'] ?>
                            </div>


                            <div class="product-reviews-bot">
                                <div class="product-reviews-bot-col product-reviews-bot-col--left">
                                    <div class="product-reviews-buttons">
                                        <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                                            <button class="js-open-modal-review btn btn--trans btn--lxs answer_review"
                                                    data-product_id="<?= $review->product_id ?>"
                                                    data-review_id="<?= $review->review_id ?>">
                                                <span class="btn__inner"><?= Yii::t('app', 'answer') ?></span>
                                            </button>
                                        </div>

                                        <?php if (isset($review->re[0])): ?>
                                            <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                                                <div class="product-reviews__link js-answers">
                                                    <?= Yii::t('app', 'comments') ?>
                                                    <span>(<?= count($review->re) ?>)</span>
                                                </div>
                                            </div>
                                        <?php endif ?>
                                    </div>
                                </div>

                                <div class="product-reviews-bot-col product-reviews-bot-col--right">
                                    <div class="video-reviews-date"><?= Yii::$app->formatter->asDate($review['date_modified'], 'dd.MM.yyyy') ?></div>
                                </div>
                            </div>

                            <?php if (isset($review->re[0])): ?>
                                <div class="product-reviews-answers">
                                    <?php foreach ($review->re as $re): ?>
                                        <div class="product-reviews-answers-item">
                                            <div class="product-reviews-answers__name">
                                                <?= $re->author ?>
                                                <div class="video-reviews-date"><?= Yii::$app->formatter->asDate($re->date_modified, 'dd.MM.yyyy') ?></div>
                                            </div>
                                            <div class="product-reviews-answers__comment">
                                                <?= $re->text ?>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>

                        </div>

                    </div>
                <?php endforeach ?>

            </div>
            <!--P-REVIEWS-->

            <div class="p-reviews-bot">
                <?php if ($reviews): ?>
                    <?= CustomLinkPager::widget([
                        'pagination' => $reviews->getPagination()
                    ]); ?>
                <?php endif ?>

                <!-- button class="btn btn--gray btn--lxx">
                    <span class="btn__inner">показать еще</span>
                </button -->

            </div>

        </div>
        <!--PAGE CONTENT-->

    </div>
    <!--WRAPPER-->

</div>
<div class="modal modal--review">
    <div class="modal-content">
        <span class="modal__close modal__close--review"></span>
        <div class="modal__title"><?= Yii::t('app', 'review') ?></div>
        <div class="modal-content-inner">
            <div class="popup-review js-product-review-form"
                 data-empty-fields="<?= Yii::t('app', 'Fills in required fields') ?>!"
                 data-phone-field="<?= Yii::t('app', 'Phone number can only contain numbers') ?>!"
                 data-rating-field="<?= Yii::t('app', 'Rate by clicking on the corresponding star on the account') ?>!">
                <div class="popup-call-row">
                    <div class="popup-call-col">
                        <div class="b-field">
                            <input placeholder="<?= Yii::t('app', 'Name') ?>" type="text" class="field-input" name="name"
                                   value="<?= isset($user->username) ? $user->username : '' ?>">
                            <span class="field-required js-field-required">*</span>
                        </div>
                    </div>
                    <div class="popup-call-col">
                        <div class="b-field">
                            <input placeholder="E-mail" class="field-input" name="email" autocomplete="off"
                                   value="<?= isset($user->email) ? $user->email : '' ?>">
                        </div>
                    </div>
                </div>
                <div class="popup-call-row">
                    <div class="b-field">
                        <span class="b-field__label js-field-required">*</span>
                        <textarea placeholder="<?= Yii::t('app', 'Your question') ?>" name="comment" class="field-textarea field-input"></textarea>
                    </div>
                </div>
                <div class="popup-call-row">
                    <div class="popup-review-rating">
                        <div class="rating-interactive js-rating">
                            <input type="hidden" class="js-rating-input" value="0">
                            <span data-vote="5" class="rating-interactive__item js-rating-star"></span>
                            <span data-vote="4" class="rating-interactive__item js-rating-star"></span>
                            <span data-vote="3" class="rating-interactive__item js-rating-star"></span>
                            <span data-vote="2" class="rating-interactive__item js-rating-star"></span>
                            <span data-vote="1" class="rating-interactive__item js-rating-star"></span>
                        </div>
                    </div>
                </div>
                <div class="popup-call-row popup-call-but">
                    <button class="btn btn--red btn--lxx js-send-product-review">
                        <span class="btn__inner"><?= Yii::t('app', 'send') ?></span>
                    </button>
                </div>
                <p class="error-message js-error-message"></p>
            </div>
            <div class="popup-success"><?= Yii::t('app', 'Thank you for your comment') ?>! <br/><?= Yii::t('app', 'It will be posted on the site after moderation') ?></div>
        </div>
    </div>
</div>