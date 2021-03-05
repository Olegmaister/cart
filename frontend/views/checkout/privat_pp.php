<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="wrapper-clearance-data">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'id' => 'payment-parts',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('CheckoutPrivatBank') ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
<script>
    document.getElementById("payment-parts").submit();
</script>
