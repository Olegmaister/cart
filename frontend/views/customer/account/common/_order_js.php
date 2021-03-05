<?php

use common\helpers\order\StatusesHelper;
use common\helpers\ProductHelper;
use \frontend\widgets\Customer\PriceOutputWidget;

/**@var \common\entities\Customer $customer **/
/**@var \common\entities\Order[] $orders **/
/**@var \frontend\entities\Order\OrderProvider $provider*/

$currency = new \frontend\components\ApiCurrency();
?>

<?php foreach ($provider->getProvider()->getModels() as $order): ?>
    <?php if(isset($order->items)):?>

        <div class="c-table-row">
            <div class="c-table-adapt-col c-table-adapt-col--first">

                <?php
                /**@var \common\entities\OrderItem $item*/
                foreach ($order->items as $item) :


                    /**@var \common\entities\Products\Product $product*/
                    $product = $item->product;

                    $presents = \common\entities\Order\OrderPresent::find()
                        ->where(['and',['order_id' => $order->id],['parent_key' => md5($item->product_id.$item->option_id)]])
                        ->all();
                    ?>
                    <div class="c-table-row-item">
                        <a href="<?= '/'.$product->url->keyword ?>" target="_blank" class="c-table-col">
                            <img loading="lazy" src="<?= ProductHelper::correctedImgPath($product->image) ?>" alt="<?=$item->product_name ?>" title="<?=$item->product_name ?> - Prof1group" class="order-products__img">
                        </a>
                        <div class="c-table-col c-table-col--name">
                            <a href="<?= '/'.$product->url->keyword ?>" target="_blank" class="c-table-col__txt c-table-col__txt--name">

                                <?php if(isset($item->product->description->name)) { ?>
                                    <?=$item->product->description->name?>
                                <?php }else{ ?>
                                    <?=$item->product_name?>
                                <?php }?>

                            </a>
                        </div>
                        <?=PriceOutputWidget::widget([
                            'item' => $item
                        ])?>
                    </div>


                    <!--товар в подарок-->
                    <?php if(isset($presents) && !empty($presents)) : ?>
                    <?php foreach ($presents as $present) :
                        $productPresent = $present->getOrderPresent();
                        ?>
                        <div class="c-table-row-item">
                            <a href="<?= '/'.$productPresent->url->keyword ?>" target="_blank" class="c-table-col">
                                <img loading="lazy" src="<?= ProductHelper::correctedImgPath($productPresent->image) ?>" alt="<?=$item->product_name ?>" title="<?=$item->product_name ?> - Prof1group" class="order-products__img">
                            </a>
                            <div class="c-table-col c-table-col--name">
                                <a href="<?= '/'.$productPresent->url->keyword ?>" target="_blank" class="c-table-col__txt c-table-col__txt--name">

                                    <?php if(isset($productPresent->description->name)) { ?>
                                        <?=$productPresent->description->name?>
                                    <?php }else{ ?>
                                        <?=$present->parent_key?>
                                    <?php }?>

                                </a>
                            </div>
                            <div class="c-table-col">
                                                                            <span class="c-table-col__txt c-table-col__txt--price d-inline-block">
                                                                                ₴ <?= $currency->getPrice($present->price) ?><small class="text-dark ml-1">(<?= $present->quantity ?><?= Yii::t('app', 'pc.') ?>)</small>
                                                                            </span>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                    <!--/товар в подарок-->

                <?php endforeach;?>

            </div>
            <!--ADAPTIVE COLUMN-->

            <div class="c-table-adapt-col c-table-adapt-col--middle">

                <div class="c-table-col c-table-col--date">
                    <div class="c-table-col__txt c-table-col__txt--label mob-show-x766"><?= Yii::t('app', 'order date') ?></div>
                    <span class="c-table-col__txt c-table-col__txt--date">
                                                                    <?= $order->created_at ?>
                                                                </span>
                </div>

                <div class="c-table-col c-table-col--status">
                                                                <span class="c-table-col__txt c-table-col__txt--status c-table-col__txt--status--new">
                                                                    <?=StatusesHelper::statusName($order->current_status)?>
                                                                </span>
                </div>

            </div>
            <!--ADAPTIVE COLUMN-->

            <div class="c-table-adapt-col c-table-adapt-col--last">

                <div class="c-table-col c-table-col--amount justify-content-center align-items-start pl-2 pr-2">
                    <div class="c-table-col__txt c-table-col__txt--label mob-show-x766">
                        <?= Yii::t('app', 'sum') ?>
                    </div>
                    <span class="c-table-col__txt c-table-col__txt--price align-items-start p-0">
                                                                    <?= $currency->getCurrencySign() ?> <?= $currency->getPrice($order->cost) ?>
                                                                </span>
                    <span class="download-invoice button-small mt-2" data-id="<?= md5($order->id) ?>">
                                                                    <?= Yii::t('app', 'Download invoice') ?>
                                                                </span>
                </div>

            </div>
            <!--ADAPTIVE COLUMN-->

        </div>

    <?php endif;?>

<?php endforeach;?>

