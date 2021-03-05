<?php if(Yii::$app->user->isGuest) : ?>
<div class="checkout-user-status-btns">
    <p class="text-medium mb-3">*
        <?= Yii::t('app', 'To receive a discount on your discount card, you need to log in') ?>
    </p>
	<button type="button"
		class="checkout-user-status-btn btn btn--secondary btn--secondary-black btn--secondary-bg-gray btn--secondary-medium js-open-modal-login">
		<span class="btn__inner title-h5"><?= Yii::t('app', 'I AM A REGULAR CUSTOMER') ?></span>
	</button>
</div>
<?php endif;?>