<?php

use common\helpers\LanguageHelper;
use yii\helpers\Html;

/**@var \common\entities\Stock\Stock $stock*/
/**@var bool $show*/
/**@var int $limit*/
/**@var int $flagButton*/
/**@var \frontend\components\ApiCurrency $currency*/
/**@var array $viewed*/
?>
<div class="page">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <ul class="breadcrumbs__list">
                <li><a href="<?= LanguageHelper::langUrl('/') ?>"><?= Yii::t('app', 'home') ?></a></li>
                <li class="breadcrumbs__item">
                    <a href="<?= LanguageHelper::langUrl('aktsii') ?>"><?= Yii::t('app', 'stocks') ?></a>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?=isset($stock->description->name) ? $stock->description->name : ''?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">


            <h1 class="p-actions-one__title">
                <?=isset($stock->description->name) ? $stock->description->name : ''?>
                <?php if(!$stock->ifTypePresent()) : ?>
                    <span><?= Yii::t('app', 'discount') ?> - <?= $stock->getValueDiscount() ?><?= $stock->getSign()?></span>
                <?php endif;?>
            </h1>

            <div class="p-actions">
                <div class="row no-gutters">
                    <div class="col-lg-8">
                        <div class="p-actions-one__img">
                            <?php if($stock->existsPhoto(\common\entities\Stock\StockPhoto::SLIDER)) :?>
                                <?= Html::img($stock->photo->getThumbFileUrl('file', 'slider')); ?>
                            <?php else:
                                echo "<img src='/images/no_image.png' alt='gift' title='gift - Prof1group'>";
                            endif;?>
                        </div>
                    </div>
                    <div class="col-lg-4 bg-white">
                        <div class="p-actions-one__text">
                            <div class="p-actions-one__name mt-3">
                                <?= Yii::t('app', 'Promotion period') ?>
                                <span><?= Yii::t('app', 'from') ?> <?=date('d-m-Y',$stock->date_from)?> <?= Yii::t('app', 'to') ?> <?=date('d-m-Y',$stock->date_to)?></span>
                            </div>
                            <div class="p-actions-one__desc">
                                <?=isset($stock->description->description) ? $stock->description->description : ''?>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="wrapper-stock-products">
                    <div class="p-actions-content">
                        <h2 class="content-extra__title">АКЦИОННЫЕ ТОВАРЫ</h2>
                        <div class="product-card-wrap">
                            <?= $this->render('blocks/'.$view, [
                                    'items' => $viewed,
                                    'name' => 'new',
                                    'currency' => $currency,
                                    'productService' => $productService,
                                    'stock' => $stock
                            ]) ?>
                        </div>
                        <?php if($flagButton) :?>
                            <div class="p-actions-one-but">
                                <button
                                    data-limit="<?=$limit?>"
                                    data-id="<?=$stock->id?>"
                                    class="js-view-cost-products btn btn--gray btn--lxx">
                                    <span class="btn__inner">показать еще</span>
                                </button>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
