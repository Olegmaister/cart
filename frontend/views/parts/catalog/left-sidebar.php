<?php

use common\helpers\ProductHelper;

?>

<div class="page-content-col page-content-col--left page-content-col--left-cat">
    <div class="d-md-none page-options justify-content-center <?= ProductHelper::checkGetParams($get) ? '' : ' hide' ?>" style="min-height: 16px;">
        <div class="sidebar-link clear_filters">
            <div class="sidebar-link__close">
                <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="_patch" d="M14 0l2 2L2 16l-2-2L14 0z"/>
                    <path class="_patch" d="M0 2l2-2 14 14-2 2L0 2z"/>
                </svg>
            </div>
            <div class="sidebar-link__txt"><?= Yii::t('app', 'clear') ?> <?= Yii::t('app', 'filter') ?></div>
        </div>
    </div>
    <button class="btn btn--red btn--full btn--lg-h mob-show-x766 js-toggle-sidebar">
        <span class="btn__inner"><?= Yii::t('app', 'filter') ?></span>
    </button>
    <div class="sidebar js-catalog-filter">

        <button tabindex="0" class="sidebar-link__close sidebar-link__close-global js-toggle-sidebar-close">
            <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path class="_patch" d="M14 0l2 2L2 16l-2-2L14 0z"/>
                <path class="_patch" d="M0 2l2-2 14 14-2 2L0 2z"/>
            </svg>
        </button>

        <div class="page-options <?= ProductHelper::checkGetParams($get) ? '' : ' hide' ?>" style="min-height: 16px;">
            <div class="sidebar-link clear_filters">
                <div class="sidebar-link__close">
                    <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="_patch" d="M14 0l2 2L2 16l-2-2L14 0z"/>
                        <path class="_patch" d="M0 2l2-2 14 14-2 2L0 2z"/>
                    </svg>
                </div>
                <div class="sidebar-link__txt"><?= Yii::t('app', 'clear') ?> <?= Yii::t('app', 'filter') ?></div>
            </div>
        </div>

        <?php if($filtersData['minPrice'] != $filtersData['maxPrice']): ?>
            <div class="sidebar-item sidebar-item sidebar-item--price">
                <h2 class="sidebar-item__title"><?= Yii::t('app', 'price') ?>:</h2>
                <div class="sidebar-item-content section_filter-price">
                    <?= $this->render('/parts/filters/_price', ['filtersData' => $filtersData, 'get' => $get]) ?>
                </div>
            </div>
        <?php endif ?>

        <!--SIDEBAR ITEM-->
        <div class="sidebar-item sidebar-item--colors">
            <h2 class="sidebar-item__title"><?= Yii::t('app', 'by color') ?>:</h2>
            <div class="sidebar-item-content sidebar-item-content--hidden-colors">
                <div id="js-height-colors" class="filter-colors filter-colors_checkbox p-0">
                    <?= $this->render('/parts/filters/_color_group', ['filtersData' => $filtersData, 'get' => $get]) ?>
                </div>
            </div>
            <div class="sidebar-item__arrow sidebar-item__arrow--colors js-toggle-h-prev"></div>
        </div>
        <!--SIDEBAR ITEM-->

        <?php if (isset($filtersData['brands'])): ?>
            <div class="sidebar-item sidebar-item--manufacturer">
                <h2 class="sidebar-item__title"><?= Yii::t('app', 'by manufacturer') ?>:</h2>
                <div class="filter-brands_checkbox sidebar-item-content sidebar-item-content--scroll sidebar-item-content--hidden sidebar-item-content--hidden-manufacturer">
                    <div id="js-height-manufactured">
                        <?= $this->render('/parts/filters/_brands', ['filtersData' => $filtersData, 'get' => $get]) ?>
                    </div>
                </div>
            </div>
        <?php endif ?>

        <!--SIDEBAR ITEM-->
        <div class="sidebar-item--atributes">
            <?= $this->render('/parts/filters/_attributes', ['filtersData' => $filtersData, 'get' => $get]) ?>
        </div>

    </div>
    <!--sidebar-->
</div>
