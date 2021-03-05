<?php
use yii\widgets\ActiveForm;
/* @var \frontend\forms\customer\AvatarForm $model**/
?>

<div class="account-user-info-media">
    <i class="account-user-info__hover-img">
        <svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><g class="_path" clip-path="url(#clip0)"><path d="M9 13.5A3.75 3.75 0 109 6a3.75 3.75 0 000 7.5z"/><path d="M16.5 3.75h-2.379c-.3 0-.582-.117-.795-.33l-1.371-1.37a1.863 1.863 0 00-1.326-.55H7.37c-.5 0-.971.195-1.326.55l-1.37 1.37c-.213.213-.496.33-.796.33H1.5c-.827 0-1.5.673-1.5 1.5V15c0 .827.673 1.5 1.5 1.5h15c.827 0 1.5-.673 1.5-1.5V5.25c0-.827-.673-1.5-1.5-1.5zM9 14.25a4.505 4.505 0 01-4.5-4.5c0-2.481 2.019-4.5 4.5-4.5s4.5 2.019 4.5 4.5-2.019 4.5-4.5 4.5zm6-6.75A.751.751 0 0115 6a.751.751 0 010 1.5z"/></g><defs><clipPath id="clip0"><path class="_path" d="M0 0h18v18H0z"/></clipPath></defs></svg>
    </i>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <img loading="lazy" src="/images/account/ava.svg" class="account-user-info__avatar">
    <?= $form->field($model, 'avatar',[
        'inputOptions' => ['class' => 'account-user-info__avatar','placeholder' => 'E-mail']
    ])->fileInput() ?>

    <?php ActiveForm::end() ?>


</div>