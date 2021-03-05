<?php

use common\widgets\Customer\LoginWidget;
use common\widgets\Customer\PasswordRecoveryWidget;
use common\widgets\Customer\RegistrationWidget;
use common\helpers\LanguageHelper;

?>



<div class="modal modal--login modal--transform">
    <div class="modal-content">
        <section class="login login-transform login-transform--front s_tabs _flex">
            <!--buttons-->
            <div class="login-top">
                <ul class="s_tabs_list">
                    <li class="active">
                        <div class="login-top-col login-top-col--but">
                            <button class="js-register-height-login btn btn--full btn--trans btn--trans--v2">
                                <span class="btn__inner"><?= Yii::t('app', 'entrance') ?></span>
                            </button>
                        </div>
                    </li>
                    <li>
                        <div class="login-top-col login-top-col--but">
                            <button class="js-register-height-reg btn btn--full btn--trans btn--trans--v2">
                                <span class="btn__inner"><?= Yii::t('app', 'registration') ?></span>
                            </button>
                        </div>
                    </li>
                </ul>
                <div class="login-top-col login-top-col--close modal__close--login">
                    <i class="login__close"></i>
                </div>
            </div>

            <div class="login-inner">
                <div class="s_tabs_content active">
                    <!--login-->
                    <div class="login">
                        <div class="login-inner">
                            <div class="login-buttons">
                                <div class="login-buttons-col">
                                    <button
                                            class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--lx btn--icon--gl"
                                            onclick="gtag('event', 'category', {'event_category': 'Вход через Google', 'event_action': 'Нажатие на кнопку'});window.location.href = '<?= LanguageHelper::langUrl('customer') ?>/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>'">
                                        <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with google') ?></span>
                                    </button>
                                </div>
                                <div class="login-buttons-col">
                                    <button
                                            class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--lx btn--icon--fb"
											onclick="gtag('event', 'category', {'event_category': 'Вход через Facebook', 'event_action': 'Нажатие на кнопку'});window.location.href = '<?= LanguageHelper::langUrl('customer') ?>/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>'">
                                        <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with facebook') ?></span>
                                    </button>
                                </div>
                            </div>

                            <!--login widget-->
                            <?=LoginWidget::widget()?>

                            <div class="login-bottom">
                                <div class="js-link-transformed link-line-dotted link-line-dotted--red"
                                onclick="gtag('event', 'category', {'event_category': 'Забыли пароль', 'event_action': 'Нажатие на кнопку'});"
                                ><?= Yii::t('app', 'You forgot your password') ?>?</div>
                            </div>
                        </div>
                    </div>
                    <!--/login-->

                </div>
                <div class="s_tabs_content">
                    <div class="login">
                        <div class="login-inner">
                            <div class="login-buttons">
                                <div class="login-buttons-col">
                                    <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl" onclick="gtag('event', 'category', {'event_category': 'Вход через Google', 'event_action': 'Нажатие на кнопку'});window.location.href = '<?= LanguageHelper::langUrl('customer') ?>/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                                        <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with google') ?></span>
                                    </button>
                                </div>
                                <div class="login-buttons-col">
                                    <button class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb" onclick="gtag('event', 'category', {'event_category': 'Вход через Facebook', 'event_action': 'Нажатие на кнопку'});window.location.href = '<?= LanguageHelper::langUrl('customer') ?>/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
                                        <span class="btn__inner"><i></i><?= Yii::t('app', 'Login with facebook') ?></span>
                                    </button>
                                </div>
                            </div>
                            <!--register widget-->
                            <?=RegistrationWidget::widget()?>
                        </div>
                    </div>
                </div>
            </div>
            <!--INNER-->
        </section>
        <section class="login login-transform login-transform--back">
            <?=PasswordRecoveryWidget::widget()?>
        </section>
    </div>
</div>

