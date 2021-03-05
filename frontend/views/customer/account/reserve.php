<?php

use common\entities\Customer;
use common\entities\Order;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;
use yii\web\View;
use frontend\widgets\Customer\PriceOutputWidget;
use common\entities\Settings\Settings;

/** @var Customer $customer * */
/** @var Order[] $orders * */
/** @var View $this * */

$this->title = 'Ваши резервы';
$currency = new ApiCurrency();
$langId = LanguageHelper::getCurrentId();
$reserveTerm = Settings::findOne(['group_name' => 'reserve_term', 'language_id' => $langId]);

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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'reserve') ?></span>
                </li>
            </ul>
        </nav>
        <div class="page-content">
            <h1 class="title title--page-lg"><?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?>: <?=
                Yii::t('app', 'your') ?> <?= Yii::t('app', 'reserves') ?></h1>
            <section class="account-body">

                <div class="account-col account-col--left">
                    <div class="account-menu">
                        <?= $this->render('common/_menu', [
                            'customer' => $customer,
                            'active' => $active
                        ]) ?>
                    </div>
                </div>

                <div class="account-col account-col--right">
                    <?php if (!$orders): ?>
                        <div class="account-item-bg h-100 d-flex p-0" style="min-height: 150px">
                            <h2 class="m-auto text-uppercase text-muted"><?= Yii::t('app', 'You have no reserves in stores yet') ?></h2>
                        </div>
                    <?php else: ?>
                    <div class="account-reserve-top">
                        <div class="info-block">
                              <?= isset($reserveTerm->value) ? $reserveTerm->value : ''; ?>
                        </div>
                    </div>
                    <div class="account-reserve-items short">

                        <?php foreach ($orders as $order): ?>
                            <?php
                            if ($order->store):
                                $itemCount = $order->getItems()->count();
                                ?>
                                <div class="account-reserve-item">
                                    <div class="account-reserve-adress">
                                        <div class="account-reserve-adress__txt account-reserve-adress__txt--title">
                                            <?= Yii::t('app', 'Reserve in store by address') ?>:
                                        </div>
                                        <div class="account-reserve-adress__txt account-reserve-adress__txt--info">
                                            <?= Yii::t('app', 'shop') ?> <?= $order->store->description->name ?>
                                            <?= $order->store->description->city ?>
                                            <?= $order->store->description->address ?>
                                            <?= Yii::t('app', 'phone') ?> <?= $order->store->telephone ?>
                                        </div>

                                        <div class="account-reserve-adress__txt" style="font-weight: bolder">
                                            <?= Yii::t('app', 'order') ?> № <?= $order->id ?>
                                        </div>
                                    </div>
                                    <div class="account-reserve-table-wrap" style="margin-bottom: 40px">
                                        <table class="c-table-gr c-table-gr--reserve">
                                            <thead>
                                            <tr>
                                                <td class="c-table-gr__padding">
                                                    <?= Yii::t('app', 'photo') ?>
                                                </td>
                                                <td class="c-table-gr__padding">
                                                    <?= Yii::t('app', 'Naming of goods') ?>
                                                </td>
                                                <td class="c-table-gr-head__txt">
                                                    <?= Yii::t('app', 'price') ?>
                                                </td>
                                                <td class="c-table-gr-head__txt tr-hidden"
                                                    width="355"><?= Yii::t('app', 'Reserve duration') ?></td>
                                                <td class="c-table-gr-head__txt"><?= Yii::t('app', 'sum') ?></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($order->items as $key => $item): ?>
                                                <tr class="c-table-gr-row c-table-gr-row--no-border">
                                                <td class="c-table-gr-media">
                                                    <img loading="lazy"
                                                         src="<?= ProductHelper::correctedImgPath($item->product->image) ?>"
                                                         alt="" class="c-table-gr__img">
                                                </td>
                                                <td class="c-table-gr__padding">
                                                   <span class="c-table-gr__name">
                                                       <a href="<?= LanguageHelper::langUrl($item->product->url->keyword) ?>"
                                                          target="_blank">
                                                             <?php if (isset($item->product->description->name)) { ?>
                                                                 <?= $item->product->description->name ?>
                                                             <?php } else { ?>
                                                                 <?= $item->product_name ?>
                                                             <?php } ?>
                                                       </a>
                                                   </span>
                                                </td>
                                                <td>
                                                       <?=PriceOutputWidget::widget([
                                                            'item' => $item
                                                        ])?>
                                                </td>
                                                <?php if ($key === 0): ?>
                                                    <td rowspan="<?= $itemCount ?>">
                                                        <div class="c-table-times">
                                                            <div class="c-table-times__txt c-table-times__txt--reserve">
                                                                <?= Yii::t('app', 'Reserve duration') ?>
                                                            </div>
                                                            <div class="c-table-times__txt c-table-times__txt--date">
                                                                <?= $order->created_at ?>
                                                                с 8-00 до 20-00
                                                            </div>
                                                            <?php if (strtotime($order->created_at) === date('d.m.Y')): ?>
                                                                <div class="c-table-times__txt c-table-times__txt--hour">
                                                                    (осталось 6 час.)
                                                                </div>
                                                            <?php endif; ?>
                                                            <div class="c-table-times-buttons">

                                                                <button class="btn btn--red btn--lg-lx px-3 d-none">
                                                                    <span class="btn__inner w-auto"><?= Yii::t('app', 'arrange delivery') ?></span>
                                                                </button>

                                                                <?php if (strtotime($order->created_at) === date('d.m.Y')): ?>
                                                                    <div class="c-table-times-buttons-col c-table-times-buttons-col--right">
                                                                        <a href=""
                                                                           class="link"><?= Yii::t('app', 'Cancel the order') ?></a>
                                                                    </div>
                                                                <?php endif; ?>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="tr-hidden" rowspan="<?= $itemCount ?>">
                                                <span class="c-table-gr__price">
                                                    <?= $currency->getCurrencySign() ?> <?= $currency->getPrice($order->cost) ?>
                                                </span>
                                                    </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <tr class="c-table-gr-info-adaptive c-table-gr-info-adaptive--bot">
                                                <td>
                                                    <?= Yii::t('app', 'sum') ?>
                                                </td>
                                                <td>
                                        <span class="c-table-gr__price">
                                            <?= $currency->getCurrencySign() ?> <?= $currency->getPrice($order->cost) ?>
                                        </span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="account-reserve-table-but d-none">
                                        <div class="account-reserve-table-but-row account-reserve-table-but-row--top">
                                            <button class="btn btn--red btn--full btn--lg-lx">
                                                <span class="btn__inner"><?= Yii::t('app', 'Cancel the order') ?></span>
                                            </button>
                                        </div>
                                        <div class="account-reserve-table-but-row account-reserve-table-but-row--bot">
                                            <?php if (strtotime($order->created_at) === date('d.m.Y')): ?>
                                                <a href="" class="link"><?= Yii::t('app', 'Cancel the order') ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($orders) > 5): ?>
                    <div class="text-center">
                        <button class="button-1 py-3 px-5 js-show-more-reserve" data-alt="Показать меньше">Показать больше</button>
                    </div>
                    <?php endif ?>
                </div>

        </div>
        <?php endif; ?>
        </section>
    </div>
    <!--page-content-->
</div>
<!--wrapper-->
</div>
<!--page-->
