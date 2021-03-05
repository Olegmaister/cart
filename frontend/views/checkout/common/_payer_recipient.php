<?php

use borales\extensions\phoneInput\PhoneInput;
use common\services\CountriesService;

?>

<style>
    .js-wrapper-registration-data{
        display: none;
    }
</style>

<section class="checkout-payer js-checkout-payer">

    <?php if(Yii::$app->user->isGuest) : ?>
        <div class="login-buttons">
            <div class="login-buttons-col">
                <button type="button" class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--gl" onclick="gtag('event', 'category', {'event_category': 'Вход через Google', 'event_action': 'Нажатие на кнопку'});window.location.href = '/customer/network/auth?authclient=google&url=<?= Yii::$app->request->url ?>';">
                    <span class="btn__inner title-h5"><i></i><?= Yii::t('app', 'Login with google') ?></span>
                </button>
            </div>
            <div class="login-buttons-col">
                <button type="button" class="btn btn--black btn--full btn--lg-x btn--icon btn--icon--fb" onclick="gtag('event', 'category', {'event_category': 'Вход через Facebook', 'event_action': 'Нажатие на кнопку'});window.location.href = '/customer/network/auth?authclient=facebook&url=<?= Yii::$app->request->url ?>';">
                    <span class="btn__inner title-h5"><i></i><?= Yii::t('app', 'Login with facebook') ?></span>
                </button>
            </div>
        </div>
    <?php endif;?>

    <!--customer-->
    <div class="checkout-payer-data">
        <div class="checkout-payer-data__head">
			<div class="pg-row">
				<p class="checkout-payer-data__title title-h4 title--black pg-col-50"><?= Yii::t('app', 'Payer')?>:</p>
				<div class="pg-col-50 pg-col-smxs-100 checkout-payer-data__registration">
					<!--Если пользователь гость-->
					<?php if(Yii::$app->user->isGuest) : ?>
						<?=$form->field($model, 'registration')->checkbox(['class' => 'js-show-registration-data'])->label(Yii::t('app', 'I want to register'));?>
					<?php endif;?>
				</div>
			</div>

            <div class="checkout-payer-data__form pg-row">

                <div class="field pg-col-50 pg-col-sm-100">
                    <?= $form->field($model, 'firstName',[
                        'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Name')]
                    ])->textInput() ?>
                    <span class="field-required js-field-required">*</span>
                </div>

                <div class="field pg-col-50 pg-col-sm-100">
                    <?= $form->field($model, 'lastName',[
                        'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Family name')]
                    ])->textInput() ?>
                    <span class="field-required js-field-required">*</span>
                </div>


                <div class="field pg-col-50 pg-col-sm-100">
                    <?= $form->field($model, 'phone')->widget(PhoneInput::class, [
                        'jsOptions' => [
                            'preferredCountries' => ['ua', 'pl', 'no'],
                        ],
                        'options' => ['class' => 'field-input']
                    ]);
                    ?>
					<span class="field-required js-field-required">*</span>
                </div>


                <div class="field pg-col-50 pg-col-sm-100">
                    <?= $form->field($model, 'email',[
                        'inputOptions' => ['class' => 'field-input','placeholder' => 'E-mail']
                    ])->textInput() ?>
                    <span class="field-required" id="checkout-email-required">*</span>
                </div>

				<!--данные для регистрации-->
				<div class="js-wrapper-registration-data pg-col-100">
					<div class="pg-row">
						<div class="field pg-col-50 pg-col-sm-100">
							<?= $form->field($model, 'password',[
								'inputOptions' => ['class' => 'field-input','placeholder' => Yii::t('app', 'Password')]
							])->passwordInput() ?>
						</div>
						<div class="field pg-col-50 pg-col-sm-100">
							<?= $form->field($model, 'repeatPassword',[
								'inputOptions' => ['class' => 'field-input','placeholder' => Yii::t('app', 'Repeat password')]
							])->passwordInput() ?>
						</div>
					</div>
				</div>

                <div class="field pg-col-50 pg-col-sm-100">
                    <?= $form->field($model->delivery, 'country', [
                        'inputOptions' => ['class' => 'custom-select custom-select--lg js-user-country'],
                    ])->dropDownList((new CountriesService)->getCountriesList(), ['options' => ['УКРАИНА' => ['selected' => true]]])
                    ?>
                </div>

                <div class="field pg-col-50 pg-col-sm-100 payer-data-btn">
                    <button class="btn btn--primary btn--primary-red btn--primary-medium js-payer-data-btn" type="button">
                        <span class="btn__inner title-h5 title--white"><?= Yii::t('app', 'Further')?></span>
                    </button>
                </div>

                <div class="field__accept pg-col-50 pg-col-sm-100">
                    <input class="field__checkbox field__checkbox--red" type="checkbox" id="accept-terms"
                           name="accept-terms">
                    <label class="field__checkbox-fake" for="accept-terms"></label>
                    <p class="text-medium text--gray4">
                        <?= Yii::t('big', 'with custom agreement familiarized') ?>
                    </p>
                </div>
                <div class="pg-col-50 pg-col-sm-100 text-center">
					<span class="checkout-payer-data__recipient js-recipient-data-check text-medium text--black2 text--dashed-black2 js-show-recipient-data"
						  tabindex="0"><?= Yii::t('app', 'specify recipient details') ?></span>
                </div>
                <div class="pg-col-50 pg-col-sm-100 mt-2">
                    <div class="checkbox-1" id="checkout-no-email">
                        <input id="no-email" type="checkbox">
                        <label for="no-email"><?= Yii::t('app', 'I have no e-mail') ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/customer-->


</section>
<!--/Форма основные данные пользователя-->

<!--Данные получателя-->
<section class="checkout-recipient js-show-recipient">
    <div class="checkout-recipient__data">
        <button type="button" class="checkout-recipient__close js-hide-recipient js-recipient-data-check">
            <svg class="checkout-recipient__close-icon" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.75 0L18 2.24999L2.25006 17.9999L6.58121e-05 15.7499L15.75 0Z"/>
                <path d="M0 2.24999L2.24999 2.46558e-06L17.9999 15.7499L15.7499 17.9999L0 2.24999Z"/>
            </svg>
        </button>
        <p class="checkout-recipient__data-title title-h4 title--black">
            <?= Yii::t('app', 'Recipient')?>: <i class="icon-info ml-2" role="tooltip" data-microtip-size="large" data-microtip-position="top" aria-label="<?=
                isset($settings['recipient_tooltip']) ? $settings['recipient_tooltip'] : '' ?>"></i>
        </p>
        <div class="checkout-recipient__data__form pg-row">
            <div class="field pg-col-50 pg-col-sm-100">
                <?= $form->field($model->recipient, 'firstName',[
                    'inputOptions' => ['class' => 'field-input','placeholder' => Yii::t('app', 'Name')]
                ])->textInput(['value' => $model->firstName ?? '']) ?>
                <span class="field-required js-field-required">*</span>
            </div>
            <div class="field pg-col-50 pg-col-sm-100">
                <?= $form->field($model->recipient, 'lastName',[
                    'inputOptions' => ['class' => 'field-input','placeholder' => Yii::t('app', 'Surname')]
                ])->textInput(['value' => $model->lastName ?? '']) ?>
                <span class="field-required js-field-required">*</span>
            </div>
            <div class="field pg-col-50 pg-col-sm-100">
                <?= $form->field($model->recipient, 'phone')->widget(PhoneInput::class, [
                    'jsOptions' => [
                        'preferredCountries' => ['ua', 'pl', 'no'],
                    ],
                    'options' => ['class' => 'field-input'],
                    'defaultOptions' => ['value' => $model->phone ?? '']
                ]);
                ?>
                <span class="field-required js-field-required">*</span>
            </div>
            <div class="field pg-col-50 pg-col-sm-100">
                <?= $form->field($model->recipient, 'email',[
                    'inputOptions' => ['class' => 'field-input','placeholder' => 'E-mail']
                ])->textInput(['value' => $model->email ?? '']) ?>
            </div>
            <div class="field pg-col-50 pg-col-sm-100">
                <?= $form->field($model->recipient, 'ttn',[
                    'inputOptions' => ['class' => 'field-input','placeholder' => 'ТТН']
                ])->textInput(['value' => $model->ttn ?? '']) ?>
            </div>
        </div>
        <?=$form->field($model,'checkboxRecipient')->hiddenInput()?>
    </div>
</section>
