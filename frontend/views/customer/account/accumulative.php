<?php
/**@var \common\entities\Customer $customer * */

use common\helpers\LanguageHelper;

$currency = new \frontend\components\ApiCurrency();
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'accumulative discount') ?></span>
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

                    <div class="accumulative-prices">
                        <div class="accumulative-prices-row--amount mb-3">
                            <span class="accumulative-prices__txt">
                                <?= Yii::t('app', 'You bought for the bag') ?>:
                                <div class="price price--new">
                                    <span><?= $currency->getCurrencySign() ?></span> <?= $currency->getPrice($customer->getAccumulatedSales()) ?>
                                </div>
                            </span>
                        </div>
                        <div class="accumulative-prices-row--discount">
                            <span class="accumulative-prices__txt"><?= Yii::t('app', 'Your discount') ?>:</span>
                            <span class="accumulative-prices-discount__procent ml-4">
                                -<?php if (isset($percent->percent)) echo $percent->percent; else echo 0 ?>%
                            </span>
                        </div>
                        <div class="accum-responsive-scroll">
                            <div class="accumulative-prices-row accumulative-prices-row--range">

                                <!-- В data-total-money ложим сколько потратил чел на покупки -->
                                <div class="accumulation-progress js-accumulation-progress"
                                     data-total-money="<?= $customer->getAccumulatedSales() ?>">
                                    <div class="accumulation-progress__line-default"></div>
                                    <div class="accumulation-progress__line-active js-progress-line"></div>
                                    <div class="accumulation-progress__box js-accumulation-progress-box">
                                        <!-- эти блоки выводим циклом, сколько надо,
                                        график будет адаптироваться
                                        В data-percent передаем процент скидки
                                        В data-money сколько надо потратить для достижения скидки
                                        -->
                                        <?php foreach ($model as $item) : ?>
                                            <div class="accumulation-progress__box-item js-accumulation-point"
                                                 data-percent="<?= $item->stock->percent ?>%"
                                                 data-money="<?= $currency->getPrice($item->cost) ?> <?php echo $currency->getCurrencySign()
                                                 /*Yii::t('app', 'UAH')*/ ?>">
                                            </div>
                                        <?php endforeach; ?>
                                        <!--											<div class="accumulation-progress__box-item js-accumulation-point"-->
                                        <!--												 data-percent="3%"-->
                                        <!--												 data-money="7 000 грн">-->
                                        <!--                                            </div>-->

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="accumulative-desc">
                        <h2 class="accumulative-desc__title"><?= isset($settings['discount_terms_title']) ?
                                $settings['discount_terms_title'] : '' ?></h2>
                        <div class="accumulative-desc__txt">
                            <p>
                                <?= isset($settings['discount_terms_text']) ?
                                    $settings['discount_terms_text'] : '' ?>
                            </p>
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
