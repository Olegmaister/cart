<?php

use yii\helpers\Html;
use yii\helpers\Url;
use \common\entities\Stock\StockPhoto;

/**@var \common\entities\Stock\Stock [] $model */
/**@var \common\entities\Stock\Stock $stock */
/**@var bool $show */
/**@var int $limit */
/**@var int $flagButton */
?>


<style>
    .journal-label {
        color: white;
    }
</style>


<!--list stocks-->
<div class="row wrapper-stocks-list">
    <?php foreach ($model as $stock) : ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="p-actions-card">
                <div class="p-actions-card-media">
                    <a href="<?= Url::to('/' . isset($stock->slug->keyword)) ? $stock->slug->keyword : "#" ?>"
                       class="p-actions-card-media-link">
                        <?php if ($stock->existsPhoto(StockPhoto::SLIDER)) : ?>
                            <?= Html::img($stock->photo->getThumbFileUrl('file', 'slider'), ['class' => 'p-actions-card__img', 'alt' => 'p-dfg-card__img']); ?>
                        <?php else: ?>
                            <?php if (false): ?>
                                <img src='/images/no_image.png' alt='gift' title='gift - Prof1group'>
                            <?php endif; ?>
                            <img src="/images/prof-no-pic-<?= Yii::$app->language ?>.jpg" alt="no image">
                        <?php endif; ?>
                        <div class="p-actions-card-media__label">
                            <span class="journal-label"><?= isset($stock->description->name) ? $stock->description->name : '' ?></span>
                            <br>
                            <?php if ($stock->ifTypePresent()) : ?>
                                <span class="journal-label"><?= Yii::t('app', 'Goods as a gift') ?></span>
                            <?php endif; ?>

                            <?php if (!$stock->ifTypePresent()) : ?>
                                <span class="journal-label"><?= Yii::t('app', 'discount') ?> - <?= $stock->getValueDiscount() ?><?= $stock->getSign() ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
                <div class="p-actions-card-info">
                    <?= Yii::t('app', 'Promotion period') ?>
                    <span><?= Yii::t('app', 'from') ?> <?= date('d-m-Y', $stock->date_from) ?>  <?= Yii::t('app', 'to') ?> <?= date('d-m-Y', $stock->date_to) ?></span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="row justify-content-center">
    <?php if ($flagButton) : ?>
        <div class="col-md-4 col-lg-3 mt-3">
            <button
                    data-limit="<?= $limit ?>"
                    class="js-view-cost btn btn--gray btn--full btn--lg-x">
                <span class="btn__inner">показать еще</span>
            </button>
        </div>
    <?php endif; ?>

    <!--info js-->
    <div
            data-limit="<?= $limit ?>"
            class="js-stocks-info">

    </div>

    <div class="col-md-4 col-lg-3 mt-3 d-none">
        <button class="btn btn--black btn--full btn--lg-x">
            <span class="btn__inner"><?= Yii::t('app', 'stock archive') ?></span>
        </button>
    </div>
</div>


