<?php

use yii\helpers\Url;

/**@var common\entities\Stock\Stock [] $stock */
/**@var \common\entities\Stock\Stock $item */
/**@var \common\entities\Stock\Stock $row */

?>

<?php if ($slider) : ?>
    <div class="row no-gutters">
        <div class="col-lg-8">
            <div class="journal-one-slider-images journal-one-slider-images--actions">
                <div class="slider-arrows">
                    <div class="slider-arrow slider-arrow__prev"></div>
                    <div class="slider-arrow slider-arrow__next"></div>
                </div>
                <div class="js-slider-action">


                    <!--wrapper one slider-->

                    <?php
                    /** @var \common\entities\Stock\Stock $item */
                    foreach ($stock as $item) : ?>
                        <?php if ($item->slider == 1) :
                            if ($item->existsPhotos()) :
                                $photo = isset($item->photo) ? $item->photo : null;
                                ?>

                                <div class="slider-main__item slider-main__item--journal">
                                    <figure class="slider-main__img-wrap">
                                        <a href="<?= Url::to('/' . isset($item->slug->keyword)) ? $item->slug->keyword : "#" ?>"></a>
                                        <?php if ($photo->getThumbFileUrl('file')): ?>
                                            <img src="<?= $photo->getThumbFileUrl('file'); ?>" alt="">
                                        <?php else: ?>
                                            <img src="/images/prof-no-pic-<?=Yii::$app->language ?>.jpg" alt="no image">
                                        <?php endif ?>
                                        <div class="p-actions-card-media__label">
                                            <span class="journal-label"><?= $item->description->name ?></span>
                                            <br>
                                            <span class="journal-label">скидка - <?= $item->getValueDiscount() ?><?= $item->getSign() ?></span>
                                        </div>
                                    </figure>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <!--/wrapper one slider-->
                </div>
            </div>
        </div>
        <div class="col-lg-4 bg-white">
            <div class="js-slider-actions-thumbs p-actions-times-slides">

                <?php foreach ($stock as $row) : ?>
                    <?php if ($row->slider == 1) :
                        $dd = \common\helpers\DateHelper::downcounter($row->date_to);
                        $string = $dd['hours'] . 'h' . $dd['minutes'] . 'm' . $dd['seconds'] . 's';
                        ?>
                        <div class="p-actions-times">
                            <div class="p-actions-times-top flex-fill">
                                <?= $row->description->description ?>
                            </div>
                            <div class="p-actions-times-bot">
                                <div class="p-actions-times-bot__title"><?= Yii::t('app', 'Promotion is valid') ?>:
                                </div>
                                <div class="p-actions-counter timer-actions">
                                    <div class="js-timer timer-actions-count"><?= $string ?></div>
                                    <!--                                    <div class="js-timer timer-actions-count">24h00m59s</div>-->
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
