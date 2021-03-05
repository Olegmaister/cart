<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**@var \frontend\forms\cart\AddToCartForm $cartForm*/
/**@var \common\entities\Products\Product $product*/
/**@var $specifications array*/

?>


<select name="option" id="input-op" class="form-control js-target-option">
    <option value=""> --- Выберите --- </option>
    <?php foreach($specifications as $specification): ?>
        <option value="<?= $specification['id'] ?>"><?= $specification['name'] ?></option>
    <?php endforeach ?>
</select>
<p class="help-block help-block-error js-error-option"></p>


<?php
    $form = ActiveForm::begin([
        'action' => ['/cart/add', 'id' => $product->product_id],
        'id' => 'js-add-cart'
    ]) ?>
    <?= $form->field($cartForm, 'productId')->hiddenInput(['class' => 'js-product-id']) ?>
    <?= $form->field($cartForm, 'quantity')->textInput(['class' => 'form-control js-product-quantity']) ?>
    <div class="form-group">
        <?= Html::Button(Yii::t('app', 'add to cart'), ['class' => 'btn btn-primary btn-lg btn-block js-form-add-cart']) ?>
    </div>
<?php ActiveForm::end() ?>