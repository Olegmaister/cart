<div class="s_tabs product-card-tabs">
    <ul class="content-nav s_tabs_list list_by-params">
        <li class="content-nav__item active" data-link="hits"
            data-title="<?= Yii::t('app', 'leaders') ?>"><?= Yii::t('app', 'leaders') ?></li>
        <li class="content-nav__item" data-link="novelty"
            data-title="<?= Yii::t('app', 'new items') ?>"><?= Yii::t('app', 'new items') ?></li>
        <li class="content-nav__item" data-link="sales"
            data-title="<?= Yii::t('app', 'sale') ?>"><?= Yii::t('app', 'sale') ?></li>
        <li class="content-nav__item" data-link="recommend"
            data-title="<?= Yii::t('app', 'recommend') ?>"><?= Yii::t('app', 'recommend') ?></li>
        <li class="content-nav__item" data-link="shares"
            data-title="<?= Yii::t('app', 'aktsii') ?>"><?= Yii::t('app', 'aktsii') ?></li>
    </ul>

    <?php foreach ($productGroup as $key => $group): ?>
        <div class="product-card-wrap s_tabs_content<?= $key === 0 ? ' active' : '' ?>">
            <div class="carousel-1c <?= $key !== 0 ? 'unslick' : '' ?>">
                <?= $this->render('/parts/_items-common', [
                    'items' => $items[$group],
                    'name' => $group,
                    'currency' => $currency,
                    'productService' => $productService,
                    'wishList' => $wishList,
                    'compare' => $compare,
                    //'email' => $email,
                    //'stockWatch' => $stockWatch,
                    //'presents' => $presentsArr
                ]) ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
