<?php

use common\helpers\LanguageHelper;
use common\helpers\order\StatusesHelper;
use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;
use frontend\widgets\Customer\PriceOutputWidget;

/**@var \common\entities\Customer $customer **/
/**@var \common\entities\Order[] $orders **/
/**@var \frontend\entities\Order\OrderProvider $provider*/

$currency = new ApiCurrency();
?>

<div class="page">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="breadcrumbs__item">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('account/account') ?>">
                        <?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?>
                    </a>
                    <meta itemprop="position" content="2"/>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'orders') ?></span>
                </li>
            </ul>
        </nav>
        <div class="page-content">
            <h1 class="title title--page-lg"><?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?>: <?=
			Yii::t('app', 'general') ?> <?= Yii::t('app', 'data') ?></h1>
            <section class="account-body">
                <div class="account-col account-col--left">
                    <div class="account-menu">
                        <?= $this->render('common/_menu',[
                            'customer' => $customer,
                            'active' => $active
                        ])?>
                    </div>
                </div>
                <div class="account-col account-col--right">
                    <?php if (count($provider->getProvider()->getModels()) === 0): ?>
                    <div class="account-item-bg h-100 d-flex">
                        <div class="m-auto text-center">
                            <h2 class="text-uppercase text-muted mb-3"><?= Yii::t('app', 'You have no orders yet') ?></h2>
                            <button class="btn btn--lg btn--red all-posts-btn">
                                <a href="<?= LanguageHelper::langUrl('/catalog') ?>" class="btn__inner"><?= Yii::t('app', 'catalog of goods') ?></a>
                            </button>
                        </div>
                    </div>
                    <?php else: ?>
                        <div class="account-tabs s_tabs s_tabs--slick">
                            <div class="account-content">

                                <div class="p-order-table">

                                    <div class="c-table">

                                        <div class="c-table-row c-table-row--head">

                                            <div class="c-table-adapt-col c-table-adapt-col--first">

                                                <div class="c-table-col c-table-col--head">
                                                    <span class="c-table-col__txt"><?= Yii::t('app', 'photo') ?></span>
                                                </div>
                                                <div class="c-table-col c-table-col--name c-table-col--head">
                                                    <span class="c-table-col__txt"><?= Yii::t('app', 'Naming of goods') ?></span>
                                                </div>
                                                <div class="c-table-col c-table-col--head">
                                                    <span class="c-table-col__txt"><?= Yii::t('app', 'price') ?></span>
                                                </div>

                                            </div>
                                            <!--ADAPTIVE COLUMN-->

                                            <div class="c-table-adapt-col c-table-adapt-col--middle">

                                                <div class="c-table-col c-table-col--head c-table-col--head--mobile">
                                                    <span class="c-table-col__txt"><?= Yii::t('app', 'order date') ?></span>
                                                </div>

                                                <div class="c-table-col c-table-col--head">
                                                    <span class="c-table-col__txt"><?= Yii::t('app', 'Status') ?></span>
                                                </div>

                                            </div>
                                            <!--ADAPTIVE COLUMN-->
                                            <div class="c-table-adapt-col c-table-adapt-col--last">

                                                <div class="c-table-col c-table-col--head">
                                                    <span class="c-table-col__txt"><?= Yii::t('app', 'sum') ?></span>
                                                </div>

                                            </div>
                                            <!--ADAPTIVE COLUMN-->
                                        </div>
                                        <div class="posts-grid wrapper-account-order">
                                            <?php foreach ($provider->getProvider()->getModels() as $order): ?>
                                            <?php if ((int)$order->delivery_method_id === 4) {continue;}?>

                                                <?php if(isset($order->items)):?>

                                                    <div class="c-table-row">
                                                        <div class="c-table-adapt-col c-table-adapt-col--first">

                                                            <?php
                                                            /**@var \common\entities\OrderItem $item*/
                                                            foreach ($order->items as $key => $item) :


                                                                /**@var \common\entities\Products\Product $product*/
                                                                $product = $item->product;

                                                                $presents = \common\entities\Order\OrderPresent::find()
                                                                    ->where(['and',['order_id' => $order->id],['parent_key' => md5($item->product_id.$item->option_id)]])
                                                                    ->all();
                                                                ?>
                                                                <div class="c-table-row-item">
                                                                    <a href="<?= LanguageHelper::langUrl($product->url->keyword) ?>" target="_blank" class="c-table-col">
                                                                        <img loading="lazy" src="<?= ProductHelper::correctedImgPath($product->image) ?>" alt="<?=$item->product_name ?>" title="<?=$item->product_name ?> - Prof1group" class="order-products__img">
                                                                    </a>
                                                                    <div class="c-table-col c-table-col--name">
                                                                        <a href="<?= LanguageHelper::langUrl( $product->url->keyword) ?>" target="_blank" class="c-table-col__txt c-table-col__txt--name">
                                                                             <?php if ($key === 0): ?>
                                                                                 <span class="d-block text-muted"><?= Yii::t('app', 'Order') ?> №<?= $order->id ?></span>
                                                                            <?php endif; ?>

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
                                                                                <?= $currency->getCurrencySign() ?> <?= $currency->getPrice($present->price) ?><small class="text-dark ml-1">(<?= $present->quantity ?><?= Yii::t('app', 'pc.') ?>)</small>
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
                                        </div>


                                    </div>
                                    <?php if($provider->showButton()) :?>
                                        <div class="p-order-but">
                                            <button data-page="<?=$provider->getPage()?>" class="js-account-order-show-more btn btn--gray btn--lxx">
                                                <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                                            </button>
                                        </div>
                                    <?php endif;?>
                                </div>


                            </div>
                        </div>
                    <?php endif ?>
                </div>
            </section>
        </div>
        <!--page-content-->
    </div>
    <!--wrapper-->
</div>
<!--page-->

<?php
$js = <<<JS
    $(document).on('click', '.download-invoice:not(.disabled)', function () {
        let item = $(this);

        item.addClass('disabled');
        download('/download-invoice?id=' + item.data('id'), 'invoice.pdf')
    });

    function download(url, filename) {
        fetch(url).then(function(t) {
            if (t.status !== 200) {
                notify('Ошибка формирования счет фактуры');
                
                return;
            }
            
            return t.blob().then((b)=>{
                $('.download-invoice').removeClass('disabled');
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
