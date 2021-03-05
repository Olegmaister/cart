<?php

use backend\models\Subscribe;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\widgets\ChatMessenger\ChatMessenger;
use frontend\widgets\PromoBannerWidget\PromoBannerWidget;
use common\services\RedisService;

$redis = new RedisService();
$querySettings = $redis->getQuerySettings();
$settings = $redis->getSettings();
$url = Yii::$app->request->url;
$link = LanguageHelper::langUrl('/');

?>
<footer class="footer">
    <div class="footer-top">
        <div class="wrapper">
            <div class="footer-top-col footer-top-col_left">
                <a href="<?= (!empty($url) && $url != $link) ? $link : '' ?>">
                    <img src="/images/footer/logo_<?=Yii::$app->language ?>.svg" alt="PROF1Group" title="PROF1Group">
                </a>
            </div>
            <div class="footer-top-col footer-top-col_right mob-hide-x766">
                <div class="footer-reviews">
                    <div class="footer-reviews-col footer-reviews-col_left">
                        <div class="footer-reviews__txt"><?= Yii::t('app', 'subscribe to shares (footer)') ?></div>
                    </div>
                    <div class="footer-reviews-col footer-reviews-col_right subscribe-wrapper_js">
                        <div class="subscribe-form">
                            <div class="subscribe-form-field">
                                <input type="text" value="" placeholder="E-mail "
                                       class="subscribe-form-input field_effect">
                            </div>
                            <div class="subscribe-form-but">
                                <button class="btn btn--full btn--red subscribe-btn_js" data-type="<?= Subscribe::SHARE_TYPE ?>"
                                        onclick="gtag('event', 'category', {'event_category': 'Подписаться на Акции', 'event_action': 'Нажатие на кнопку'});">
                                    <span class="btn__inner"><?= Yii::t('app', 'subscribe') ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="footer-middle">
            <div class="footer-middle-col footer-middle-col_left">
                <h2 class="footer-title"><?= Yii::t('app', 'contacts') ?></h2>
                <div class="footer-middle-colums">
                    <div class="footer-middle-colums-col">
                        <div class="footer-list">
                            <h3 class="footer-list__title"><?= Yii::t('app', 'Sales department') ?></h3>
                            <ul class="footer-list-menu">
                                <?php $i=1; foreach ($querySettings as $setting): ?>
                                    <?php if (isset($setting['group_name']) && $setting['group_name'] == 'phone_sales'): ?>
                                        <li><a onclick="gtag('event', 'category', {'event_category': 'Телефон <?= $i++ ?>', 'event_action': 'Нажатие на кнопку'});"
                                            ><?= $setting['value'] ?></a></li>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-middle-colums-col">
                        <div class="footer-list">
                            <h3 class="footer-list__title"><?= Yii::t('app', 'Wholesale department') ?></h3>
                            <ul class="footer-list-menu">
                                <?php foreach ($querySettings as $wholesale): ?>
                                    <?php if (isset($wholesale['group_name']) && $wholesale['group_name'] == 'phone_wholesale'): ?>
                                        <li><a href=""><?= $wholesale['value'] ?></a></li>
                                    <?php endif ?>
                                <?php endforeach ?>
                                <li><a href=""><?= $settings['e_mail_opt'][2] ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-middle-colums-col">
                        <?php /* ?>
                            <div class="footer-list">
                                <h3 class="footer-list__title">
                                    <?= Yii::t('app', 'Quality improvement department') ?>:
                                </h3>
                                <ul class="footer-list-menu">
                                    <li><a href=""><?= $settings['phone_improvement'][2] ?></a></li>
                                </ul>
                            </div>
                        <?php */ ?>
                    </div>
                    <div class="footer-middle-colums-col">
                        <div class="footer-list">
                            <h3 class="footer-list__title">
                                <?= Yii::t('app', 'Central office post') ?>:
                            </h3>
                            <ul class="footer-list-menu">
                                <li><a href=""><?= $settings['e_mail'][2] ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-middle-col footer-middle-col_center">
                <h3 class="footer-title footer-title_time">
                    <?= Yii::t('app', 'Online store working hours') ?>:
                </h3>
                <div class="footer-list">
                    <ul class="footer-list-menu footer-list-menu_day">
                        <?= ProductHelper::wrapToList($settings['working'][LanguageHelper::getCurrentId()]) ?>
                    </ul>
                </div>
                <a href="/our-stores" class="footer-atention d-block">
                    <?= Yii::t('app', 'You can make a reservation in any of our stores!') ?>
                </a>
            </div>
            <div class="footer-middle-col footer-middle-col_right">
                <h3 class="footer-title footer-title_right"><?= Yii::t('app', 'menu') ?></h3>
                <div class="row">
                    <div class="col-6 col-sm-4 mb-3">
                        <ul class="footer-menu">
                            <?= $this->render('_footer-menu', ['position' => 'left', 'url' => $url]) ?>
                        </ul>
                    </div>
                    <div class="col-6 col-sm-4 mb-3">
                        <ul class="footer-menu">
                            <?= $this->render('_footer-menu', ['position' => 'center', 'url' => $url]) ?>
                        </ul>
                    </div>
                    <div class="col-6 col-sm-4 mb-3">
                        <ul class="footer-menu">
                            <?= $this->render('_footer-menu', ['position' => 'right', 'url' => $url]) ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-subscribe mob-show-x766">
                <div class="subscribe-form subscribe-form_mob subscribe-form_footer subscribe-wrapper_js">
                    <div class="footer-reviews__txt"><?= Yii::t('app', 'subscribe to shares') ?></div>
                    <div class="subscribe-form-field">
                        <input type="text" value="" placeholder="E-mail " class="subscribe-form-input field_effect">
                    </div>
                    <div class="subscribe-form-but">
                        <button class="but but-red subscribe-btn_js" data-type="<?= Subscribe::SHARE_TYPE ?>"
                                onclick="gtag('event', 'category', {'event_category': 'Подписаться на Акции', 'event_action': 'Нажатие на кнопку'});"><span><?= Yii::t('app', 'subscribe') ?></span></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MIDDLE -->
    </div>
    <div class="footer-bot">
        <div class="wrapper">
            <div class="footer-bot-col footer-bot-col_left">
                <div class="footer-copy"><?= Yii::t('app', 'All rights reserved') ?> P1G 2020</div>
            </div>
            <div class="footer-bot-col footer-bot-col_right">
                <div class="footer-social">
                    <div class="footer-social__txt"><?= Yii::t('app', 'We are in social networks') ?></div>
                    <ul class="footer-social-icons">
                        <li class="footer-social-icon footer-social-icon_fb">
                            <a rel="nofollow" href="<?= $settings['facebook_networks_link'][2] ?>"
                               onclick="gtag('event', 'category', {'event_category': 'Соц сети Facebook', 'event_action': 'Нажатие на кнопку'});"></a>
                        </li>
                        <li class="footer-social-icon footer-social-icon_inst">
                            <a rel="nofollow" href="<?= $settings['instagram_networks_link'][2] ?>"
                              onclick="gtag('event', 'category', {'event_category': 'Соц сети Instagram', 'event_action': 'Нажатие на кнопку'});" ></a>
                        </li>
                        <li class="footer-social-icon footer-social-icon_yt">
                            <a rel="nofollow" href="<?= $settings['youtube_networks_link'][2] ?>"
                               onclick="gtag('event', 'category', {'event_category': 'Соц сети YouTube', 'event_action': 'Нажатие на кнопку'});"></a>
                        </li>
                        <li class="footer-social-icon">
                            <a rel="nofollow" href="<?= $settings['twitter_networks_link'][2] ?>"
                               onclick="gtag('event', 'category', {'event_category': 'Соц сети Telegram', 'event_action': 'Нажатие на кнопку'});">
                                <svg fill="currentColor" width="1em" height="1em" viewBox="0 0 24 24">
                                    <path xmlns="http://www.w3.org/2000/svg" d="m.415 11.196 5.869 2.925c.227.112.495.104.712-.023l5.224-3.037-3.162 2.802c-.161.143-.253.347-.253.562v6.825c0 .72.919 1.023 1.35.451l2.537-3.373 6.274 3.573c.44.253 1.004-.001 1.106-.504l3.913-19.5c.117-.586-.466-1.064-1.008-.846l-22.5 8.775c-.604.236-.643 1.081-.062 1.37zm21.83-8.249-3.439 17.137-5.945-3.386c-.324-.185-.741-.103-.971.201l-1.585 2.107v-4.244l8.551-7.576c.677-.599-.101-1.664-.874-1.21l-11.39 6.622-3.992-1.989z"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?= ChatMessenger::widget() ?>
    <?= PromoBannerWidget::widget() ?>
</footer>
