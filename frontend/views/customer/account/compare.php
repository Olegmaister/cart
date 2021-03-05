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
                        <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'COMPARE GOODS') ?></span>
                    </li>
                </ul>
            </nav>

            <div class="page-content">

                <h1 class="title title--page"
                    data-category="<?= $category ?>"><?= Yii::t('app', 'COMPARE GOODS') ?></h1>

                <div class="p-compare">

                    <div class="p-compare-slider__arrow p-compare-slider__arrow--prev">
                        <svg class="_patch js-arrow-compare" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.97 9.314l-8.485 8.485L2 9.314" stroke-width="3"/>
                        </svg>
                    </div>

                    <div class="p-compare-slider">
                        <?= $this->render('/customer/account/blocks/_compare-items', [
                            'idMpn' => $idMpn,
                            'items' => $items,
                            'currency' => $currency,
                            'productService' => $productService,
                            'otherData' => $otherData
                        ]) ?>
                    </div>
                    <!--SLIDER-->

                    <div class="p-compare-slider__arrow p-compare-slider__arrow--next">
                        <svg class="_patch js-arrow-compare" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.97 9.314l-8.485 8.485L2 9.314" stroke-width="3"/>
                        </svg>
                    </div>

                    <div style="height: 20px" class="js-ancor"></div>
                </div>
                <!--P-COMPARE-->

            </div>
            <!--CONTENT-->

        </div>
        <!--WRAPPER-->

    </div>
    <!--PAGE-->

<?php echo $this->render('common/_fast_buy') ?>