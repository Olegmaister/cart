<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;

/**@var \common\entities\Customer $customer **/
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'reviews') ?></span>
                </li>
            </ul>
        </nav>
        <div class="page-content">
            <h1 class="title title--page-lg"><?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?>: <?=
			Yii::t('app', 'general') ?> <?= Yii::t('app', 'data') ?></h1>
            <section class="account-body">
                <div class="account-col account-col--left">
                    <div class="account-menu">
                        <?= $this->render('common/_menu',[
                            'customer' => $customer,
                            'active' => $active
                        ])?>
                    </div>
                </div>
                <div class="account-col account-col--right">

                    <div class="account-reviews">
                        <h2 class="account-reviews__title"><?= Yii::t('app', 'REVIEWS FOR PURCHASED PRODUCTS') ?></h2>
                        <div class="account-reviews-items">

                            <?php if(isset($reviews[0])): ?>
                                <?php foreach($reviews as $allReviews): ?>
                                    <?php foreach($allReviews as $review): ?>
                                        <div class="account-reviews-item">
                                            <div class="account-reviews-item-media">
                                                <img loading="lazy" src="<?= ProductHelper::correctedImgPath_228p($products[$review['product_id']]['image']) ?>"
                                                     alt="<?= $products[$review['product_id']]['name'] ?>">
                                            </div>
                                            <div class="account-reviews-item-content">
                                                <h3 class="account-reviews-item__name"><?= $products[$review['product_id']]['name'] ?></h3>
                                                <div class="account-reviews-item__desc">
                                                    <?= $review['text'] ?>
                                                </div>
                                                <div class="account-reviews-item-bot">
                                                    <?php if(count($review['re'])): ?>
                                                        <div class="account-reviews-item-bot-col account-reviews-item-bot-col--left">
                                                            <div class="account-reviews-item__comments"><?= Yii::t('app', 'Comments to the review') ?> (<?= count($review['re']) ?>)</div>
                                                        </div>
                                                    <?php endif ?>
                                                    <div class="account-reviews-item-bot-col account-reviews-item-bot-col--right">
                                                        <div class="account-reviews-item__date"><?= Yii::$app->formatter->asDate($review['date_added'], 'dd.MM.yyyy') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                <?php endforeach ?>
                            <?php endif ?>

                            <?php if(count($products)): ?>
                                <?php foreach($products as $product): ?>
                                        <div class="account-reviews-item">
                                            <div class="account-reviews-item-media"><img loading="lazy" src="<?= ProductHelper::correctedImgPath_228p($product['image']) ?>" alt="<?= $product['name'] ?>"></div>
                                            <div class="account-reviews-item-content">
                                                <h3 class="account-reviews-item__name"><?= $product['name'] ?></h3>
                                                <!-- div class="account-reviews-item__date mob-show-x766">13.01.2020</div -->
                                                <div class="account-reviews-item-bot account-reviews-item-bot--add">
                                                    <div class="account-reviews-item-bot-col account-reviews-item-bot-col--left">
                                                        <div class="account-reviews-add">
                                                            <div class="account-reviews-add-media"><img loading="lazy" src="/images/reviews-comment-img.svg" alt="comment"></div>
                                                            <div class="account-reviews-add__desc">
                                                                <?= Yii::t('app', 'Leave a review for the purchased product and get 100 points to your bonus account') ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="account-reviews-item-bot-col account-reviews-item-bot-col--right">
                                                        <div class="account-reviews-add-but">
                                                            <button class="js-open-modal-review btn btn--trans btn--trans-red btn--lx" data-product_id="<?= $product['product_id'] ?>">
                                                                <span class="btn__inner"><?= Yii::t('app', 'Give feedback') ?></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php endforeach ?>
                            <?php endif ?>

                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!--page-content-->
    </div>
    <!--wrapper-->
</div>
<!--page-->




<!--main wrapper-->
<div class="modal modal--review">
    <div class="modal-content">
        <span class="modal__close modal__close--review"></span>
        <div class="modal__title"><?= Yii::t('app', 'review') ?></div>
        <div class="modal-content-inner">
            <div class="popup-review js-product-review-form"
                 data-phone-field="<?= Yii::t('app', 'Phone number can only contain numbers') ?>!"
                 data-rating-field="<?= Yii::t('app', 'Rate by clicking on the corresponding star on the account') ?>!">
                <div class="popup-call-row">
                    <div class="popup-call-col">
                        <div class="b-field">
                            <input placeholder="<?= Yii::t('app', 'Name') ?>" type="text" class="field-input"
                                   name="name"
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
                        <textarea placeholder="<?= Yii::t('app', 'Your question') ?>" name="comment"
                                  class="field-textarea field-input"></textarea>
                    </div>
                </div>

                <div class="popup-call-row popup-call-but">
                    <button class="btn btn--red btn--lxx js-send-product-review">
                        <span class="btn__inner"><?= Yii::t('app', 'send') ?></span>
                    </button>
                </div>
                <p class="error-message js-error-message"></p>
            </div>
            <div class="popup-success"><?= Yii::t('app', 'Thank you for your comment') ?>!
                <br/><?= Yii::t('app', 'It will be posted on the site after moderation') ?></div>
        </div>
    </div>
</div>



<?php
$script = <<< JS
    //alert("Hi");
JS;
$this->registerJs($script);
?>