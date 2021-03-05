<?php

use frontend\services\ProductService;
use yii\helpers\Url;
use common\helpers\LanguageHelper;

/**@var \frontend\forms\customer\CustomerForm $model * */
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?></span>
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


                    <!--main form customer-->
                    <?= $this->render('common/_form_update', [
                        'model' => $model
                    ]); ?>


                    <div class="account-quest">
                        <h2 class="account-quest__title"><?= Yii::t('app', 'WRITE YOUR QUESTION OR REMARKS') ?></h2>
                        <div class="account-quest-colums">
                            <div class="account-quest-col account-quest-col--left">

                                <div class="account-quest-form">
                                    <form action=""
									      data-success="<?= Yii::t('app', 'Thank you for your message') ?>!<br> <?= Yii::t('app', 'We will contact you shortly') ?>"				  
										  data-error="<?= Yii::t('app', 'Fills in required fields') ?>!"
                                          class="auxiliary_form">
                                        <div class="account-quest-form-field">
                                            <textarea class="account-quest-form-field__textarea" name="message"
                                                      placeholder=""></textarea>
                                        </div>

                                        <input type="hidden" name="user_name"
                                               value="<?= isset($model->profile->firstName) ? $model->profile->firstName : '' ?>">
                                        <input type="hidden" name="user_email"
                                               value="<?= isset($model->email) ? $model->email : '' ?>">
                                        <input type="hidden" name="user_phone"
                                               value="<?= isset($model->phone) ? $model->phone : '' ?>">
                                        <input type="hidden" name="type" value="personal account question">

                                        <div class="account-quest-form-but">
                                            <button class="btn btn--red btn--lx">
                                                <span class="btn__inner"><?= Yii::t('app', 'send') ?></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="account-quest-col account-quest-col--right">
                                <div class="account-quest-subscribe">
                                    <div class="account-quest-subscribe-check">
                                        <div class="check-reviews">
                                            <input id="x20" type="checkbox" value="">
                                            <label for="x20">
                                        <span class="check-reviews__item">
											<?= isset($settings['letter_subscription_title']) ?
                                                $settings['letter_subscription_title'] : '' ?>
                                        </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="account-quest-subscribe__desc">
                                        <?= isset($settings['letter_subscription_text']) ?
                                            $settings['letter_subscription_text'] : '' ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--account-quest-->

                </div>
            </section>
        </div>
        <!--page-content-->
    </div>
    <!--wrapper-->
</div>
<!--page-->