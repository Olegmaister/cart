<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;

$this->title = $name;

$settings = ProductHelper::getTextForErrorPage();
?>
    <div class="wrapper">

        <div class="page-error">

            <div class="page-error-inner">

                <div class="page-error-wrap" data-error="<?= $exception->statusCode ?>">

                    <div class="page-error-col page-error-col--left">
                        <div class="page-error__title">
                            <img loading="lazy" src="/images/404.png" alt="404" title="404 - Prof1group">
                        </div>
                    </div>
                    <!--COL-->

                    <div class="page-error-col page-error-col--right">

                        <div class="page-error-info">
                            <div class="page-error-info__title">
                                <?= Yii::t('app', 'page not found') ?>
                            </div>
                            <div class="page-error-info__desc d-none">
                                <?= isset($settings['text404']) ? $settings['text404'] : '' ?>
                            </div>
                            <div class="page-error-info-promo d-none">
                                <div class="page-error-info-promo-col page-error-info-promo-col--left">
                                    <div class="page-error-info-promo__copy"><?=  isset($settings['prom_code']) ? $settings['prom_code'] : '' ?></div>
                                </div>
                                <div class="page-error-info-promo-col page-error-info-promo-col--right">
                                    <div class="page-error-info-promo__link">
                                        <?= Yii::t('app', 'copy promo code') ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--COL-->
                </div>

                <div class="page-error-bot">
                    <button class="btn btn--red btn--lg">
                        <a href="<?= LanguageHelper::langUrl('/') ?>">
                            <span class="btn__inner"><?= Yii::t('app', 'to home') ?></span>
                        </a>
                    </button>
                </div>

            </div>
            <!--INNER-->

<!--                <h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
<!---->
<!--                <div class="alert alert-danger">-->
<!--                    --><?//= nl2br(Html::encode($message)) ?>
<!--                </div>-->

        </div>

    </div>

