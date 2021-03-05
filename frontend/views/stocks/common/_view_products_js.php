<?php
/**@var \common\entities\Stock\Stock $stock*/
/**@var bool $show*/
/**@var int $limit*/
/**@var int $flagButton*/
/**@var \frontend\components\ApiCurrency $currency*/
/**@var array $model*/
?>
<div class="wrapper-stock-products">
    <div class="p-actions-content">
        <h2 class="content-extra__title">АКЦИОННЫЕ ТОВАРЫ</h2>
        <div class="product-card-wrap">
            <?= $this->render('../blocks/_items', [
                'items' => $model,
                'name' => 'new',
                'currency' => $currency,
                'productService' => $productService
            ]) ?>
        </div>
        <?php if($flagButton) :?>
            <div class="p-actions-one-but">
                <button
                    data-limit="<?=$limit?>"
                    data-id="<?=$stock->id?>"
                    class="js-view-cost-products btn btn--gray btn--lxx">
                    <span class="btn__inner">показать еще</span>
                </button>
            </div>
        <?php endif;?>
    </div>
</div>
