<?php

/* @var $this yii\web\View */
/* @var $cart \core\services\cart\Cart */

/* @var $model \frontend\forms\order\OrderForm */
/* @var $invoice bool */
/* @var $number string */

use common\helpers\LanguageHelper;

$this->title = 'Checkout';
$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['/shop/catalog/index']];
$this->params['breadcrumbs'][] = ['label' => 'Shopping Cart', 'url' => ['/shop/cart/index']];
$this->params['breadcrumbs'][] = $this->title;
$classJs = 'hidden';
?>
<main class="pg-wrapper thank-page">
    <section class="thank-page-hero">
        <h1 class="thank-page-title title-h1 title--red text-center"><?= Yii::t('app', 'THANK YOU FOR YOUR PURCHASE') ?>!</h1>
        <h2 class="thank-page-subtitle title-h3 title--black text-center">
            <?php if ($invoice): ?>
                <?= Yii::t('big', 'YOUR ORDER IS IN PROCESSING. YOU CAN DOWNLOAD THE INVOICE ON THIS PAGE OR BY EMAIL') ?>
            <?php else: ?>
			    <?= Yii::t('big', 'YOUR ORDER IS IN PROCESSING. YOU WILL RECEIVE NOTIFICATIONS ON THE STATUS OF YOUR ORDER') ?>
            <?php endif; ?>
        </h2>
        <?php if ($invoice): ?>
            <button class="thank-page-btn btn btn--red btn--lg-h download-invoice" data-id="<?= $number ?>">
                <span class="btn__inner"><?= Yii::t('app', 'Download invoice') ?></span>
            </button>
        <?php endif; ?>

        <button class="thank-page-btn btn btn--red btn--lg-h">
            <a href="<?= LanguageHelper::langUrl('/') ?>" class="btn__inner"><?= Yii::t('app', 'home') ?></a>
        </button>

        <svg class="thank-page-hero__bg-image" width="296" height="293" viewBox="0 0 296 293" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M6 97L10.2752 147.495L104 197V148.815L6 97Z" fill="#E9E9E9"/>
            <path d="M172 0V210.196L148.915 221L125.5 210.196V48.1289H110V16.6978H125.5C133.415 15.3881 139.681 8.51259 139.681 0.327407V0H172Z"
                  fill="#E9E9E9"/>
            <path d="M0 17L4.26498 66.5336L104 119V71.7476L0 17Z" fill="#E9E9E9"/>
            <path d="M192 148.815V197L285.739 147.495L290 97L192 148.815Z" fill="#E9E9E9"/>
            <path d="M192 71.7476V119L291.748 66.5336L296 17L192 71.7476Z" fill="#E9E9E9"/>
            <path d="M148 245.029L15 178V178.329L19.5862 227.943L148 293L276.414 227.943L280.672 178.329L281 178L148 245.029Z"
                  fill="#E9E9E9"/>
        </svg>
    </section>

    <section class="thank-page-products">
        <h2 class="thank-page-products__title title-h3 title--black text-center d-none">
           <?= Yii::t('big', 'SEE MORE PRODUCTS WITH THE BIGGEST DISCOUNT FOR YOU') ?>!
        </h2>

        <div class="slider-extra-arrows js-slider-watched-goods-arrows">
            <div class="slider-extra-arrows__arrow slider-extra-arrows__arrow_prev js-slider-arrows-prev"></div>
            <div class="slider-extra-arrows__arrow slider-extra-arrows__arrow_next js-slider-arrows-next"></div>
        </div>
        <div class="slider-extra js-slider-watched-goods">
            <!-- Сюда надо вывести карточки товара как в фале frontend/views/products/view.php строка 791-->
            <!--				--><? //= $this->render('/parts/groups/_items',  ['items' => $items['hit'], 'name' => 'hit', 'currency' => $currency]) ?>
        </div>
    </section>

</main>


<?php if ($invoice): ?>
    <?php
        $js = <<<JS
            $('.download-invoice').on('click', function () {
                let item = $(this);
        
                download('/download-invoice?id=' + item.data('id'), 'invoice.pdf')
            });
        
            function download(url, filename) {
                fetch(url).then(function(t) {
                    if (t.status !== 200) {
                        notify('Ошибка формирования счет фактуры');
                        
                        return;
                    }
                    
                    return t.blob().then((b)=>{
                        let a = document.createElement("a");
                        a.href = URL.createObjectURL(b);
                        a.setAttribute("download", filename);
                        a.click();
                    }
                    );
                });
            }
JS;

    $this->registerJs($js);
    ?>

<?php endif; ?>
