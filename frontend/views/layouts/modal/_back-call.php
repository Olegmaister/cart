<div class="modal modal--call">
    <div class="modal-content">
        <span class="modal__close modal__close--call"></span>
        <div class="modal__title"><?= Yii::t('app', 'back call') ?></div>
        <div class="modal-content-inner">

            <form class="popup-call auxiliary_form" id="back-call-form"
                  data-success="<?= Yii::t('app', 'Thank you for your message') ?>!<br> <?= Yii::t('app', 'We will contact you shortly') ?>"				  
                  data-error="<?= Yii::t('app', 'Fills in required fields') ?>!" method="post">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="b-field">
                            <span class="b-field__label js-field-required">*</span>
                            <input class="field-input" value="<?= isset($user->username) ? $user->username : '' ?>"
                                   type="text" name="user_name" placeholder="<?= Yii::t('app', 'Name') ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="b-field">
                            <span class="b-field__label js-field-required">*</span>
                            <input class="field-input" value="<?= isset($user->email) ? $user->email : '' ?>"
                                   type="text" name="user_phone" placeholder="<?= Yii::t('app', 'Phone') ?>">
                        </div>
                    </div>
                </div>

                <div class="account-quest-form-field">
                    <textarea class="account-quest-form-field__textarea" name="message"
                              placeholder="<?= Yii::t('app', 'Your question') ?>"></textarea>
                </div>

                <input type="hidden" name="type" value="call_back">

                <div class="popup-call-row popup-call-but">
                    <button class="btn btn--red btn--lxx" type="submit">
                        <span class="btn__inner"><?= Yii::t('app', 'send') ?></span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
