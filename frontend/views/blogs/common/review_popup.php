<?php

use yii\widgets\ActiveForm;
use kartik\rating\StarRating;

?>

<style>
    .modal {
        top: 34%;
    }
</style>
<?php $form = ActiveForm::begin(
    [
        'id' => 'js-add-review'
    ]); ?>

<div class="modal modal--review">
    <div class="modal-content">
        <span class="modal__close modal__close--review"></span>
        <div class="modal__title">Добавить комментарий</div>
        <div class="modal-content-inner">
            <div class="popup-review"
                 data-empty-fields="Заполниет обязательные поля!"
                 data-phone-field="Телефонный номер может содержать только цифры!"
                 data-rating-field="Поставьте оценку кликнув на соответствующую звездочку по счету!">

                <div class="row">
                    <div class="col-md-6">
                        <div class="field">
                            <?= $form->field($model, 'name', [
                                'inputOptions' => ['class' => 'field-input', 'placeholder' => 'Имя']
                            ])->textInput()->label(false) ?>
                            <span class="field-required js-field-required">*</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="field">
                            <?= $form->field($model, 'email', [
                                'inputOptions' => ['class' => 'field-input', 'placeholder' => 'E-mail']
                            ])->textInput()->label(false) ?>
                            <span class="field-required js-field-required">*</span>
                        </div>
                    </div>
                    <div class="col-12 mt-5">
                        <div class="b-field">
                            <?= $form->field($model, 'text', [
                                'inputOptions' => ['class' => 'field-input', 'placeholder' => 'Введите текст...']
                            ])->textarea()->label(false) ?>
                            <span class="field-required js-field-required">*</span>
                        </div>
                    </div>
                </div>

                <?= $form->field($model, 'reviewId', [
                    'inputOptions' => ['class' => 'field-input', 'placeholder' => 'Введите текст...']
                ])->hiddenInput()
                ?>

                <div class="popup-review-rating mt-4">
                    <div class="rating-interactive js-rating">
                        <?= $form->field($model, 'rating', [
                            'template' => '{input}',
                            'inputOptions' => [
                                'class' => 'js-rating-input'
                            ],
                            'options' => [
                                'tag' => false
                            ]
                        ])->hiddenInput()
                        ?>
                        <span data-vote="5" class="rating-interactive__item js-rating-star"></span>
                        <span data-vote="4" class="rating-interactive__item js-rating-star"></span>
                        <span data-vote="3" class="rating-interactive__item js-rating-star"></span>
                        <span data-vote="2" class="rating-interactive__item js-rating-star"></span>
                        <span data-vote="1" class="rating-interactive__item js-rating-star"></span>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="js-btn-add-review btn btn--red btn--lxx m-auto">
                        <span class="btn__inner">отправить</span>
                    </button>
                </div>
                <p class="error-message js-error-message"></p>
            </div>
            <div class="popup-success">Спасибо за ваш комментарий! <br/>Он будет размещен на сайте после модерации</div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<!--<div class="modal modal--review-child">-->
<!--    <div class="modal-content">-->
<!--        <span class="modal__close modal__close--review"></span>-->
<!--        <div class="modal__title">Отзыв</div>-->
<!--        <div class="modal-content-inner">-->
<!--            <div class="popup-review">-->
<!--                <div class="popup-call-row">-->
<!--                    <div class="field pg-col-50 pg-col-sm-100">-->
<!---->
<!--                        <span class="field-required js-field-required">*</span>-->
<!--                    </div>-->
<!---->
<!--                    <div class="field pg-col-50 pg-col-sm-100">-->
<!---->
<!--                        <span class="field-required js-field-required">*</span>-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!--                <div class="popup-call-row">-->
<!--                    <div class="b-field">-->
<!---->
<!--                        <span class="field-required js-field-required">*</span>-->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!---->
<!--                <button class="js-btn-add-review btn btn--red btn--lxx">-->
<!--                    <span class="btn__inner">отправить</span>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->


