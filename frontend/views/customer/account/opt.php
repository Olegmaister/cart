<?php
/**@var \common\entities\Customer $customer * */

use common\helpers\LanguageHelper;

/* @var \common\entities\Stock\Stock $optStock**/
/* @var \common\entities\Customer\Segment $segment**/
$segment = $customer->segment;
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
                            <span class="accumulative-prices__txt"><?= Yii::t('app', 'Your discount group') ?>
                                :
                            </span>
                            <span class="accumulative-prices-amount__price ml-4">
                                <div class="price price--new"><?=$customer->getNameSegment()?></div>
                            </span>
                        </div>
                        <div class="accumulative-prices-row--discount">
                            <span class="accumulative-prices__txt"><?= Yii::t('app', 'Your discount') ?>:</span>
                            <span class="accumulative-prices-discount__procent ml-4">
                                -<?php if (isset($optStock)) echo $optStock; else echo 0 ?>%
                            </span>
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

