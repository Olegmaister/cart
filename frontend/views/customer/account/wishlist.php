<?php

use frontend\helpers\WishListHelper;
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'wishlist') ?></span>
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

                <div class="account-col account-col--favorite account-col--right">
                    <?php if ($items['products']): ?>
                        <div class="favorites-service d-block" data-total-count="<?= $totalCount ?>">
                            <div class="row flex-nowrap">
                                <div class="col-auto mr-auto py-1">
                                    <button type="button" class="favorites-service__btn js-delete-check-favorites">
                                        <span class="sidebar-link__close">
                                            <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path class="_patch" d="M14 0l2 2L2 16l-2-2L14 0z"/><path class="_patch"
                                                                                                          d="M0 2l2-2 14 14-2 2L0 2z"/>
                                            </svg>
                                        </span>
                                        <span class="sidebar-link__txt"><?= Yii::t('app', 'remove from list') ?></span>
                                    </button>
                                </div>
                                <div class="col-auto py-1">
                                    <button type="button"
                                            style="background: none"
                                            class="link link--red"
                                            id="clear-all-favorite"
                                            aria-label="Очистить список избранного">
                                        <?= Yii::t('app', 'Clear favorites') ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="favorite-empty">
                            <p class="favorite-empty__title title-h2"><?= Yii::t('app', 'Your favorites list is empty') ?>!</p>
                            <p class="favorite-empty__subtitle title-h2"><?= Yii::t('app', 'You can select a product in catalog') ?>:</p>
                            <div class="favorite-empty__btn">
                                <button class="btn btn--primary btn--primary-red btn--primary-medium">
                                    <a href="<?= LanguageHelper::langUrl('catalog') ?>" class="btn__inner title-h4 text-white"><?= Yii::t('app', 'catalog of goods') ?></a>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="product-card-wrap product-card-wrap--card-3x js-load-favorite-container">
                        <?= $this->render('blocks/_viewed', [
                            'items' => $items,
                            'name' => 'wishlist',
                            'currency' => $currency,
                            'productService' => $productService,
                        ]) ?>
                    </div>
                    <div class="page-content-inner-row favorite-row">
                        <?php if ($totalCount > WishListHelper::SHOW_LIMIT_COUNT): ?>
                            <div class="page-content-inner-row-col page-content-inner-row-col--right">
                                <button class="btn btn--lg btn--black js-load-favorite-btn">
                                    <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
