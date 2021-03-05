<?php
use common\helpers\LanguageHelper;
?>
<?php /* ?>
<!--div class="wrapper"-->
    <h2 class="title"><?= Yii::t('app', 'catalog') ?></h2>
    <div class="row mt-4 align-items-center">
        <div class="col-lg mb-4">
            <ul class="content-nav s_tabs_list list_by-params">
                <li class="content-nav__item active" data-link="<?= LanguageHelper::langUrl('hits') ?>"
                    data-title="<?= Yii::t('app', 'leaders') ?>"><?= Yii::t('app', 'leaders') ?></li>
                <li class="content-nav__item" data-link="<?= LanguageHelper::langUrl('novelty') ?>"
                    data-title="<?= Yii::t('app', 'new items') ?>"><?= Yii::t('app', 'new items') ?></li>
                <li class="content-nav__item" data-link="<?= LanguageHelper::langUrl('sales') ?>"
                    data-title="<?= Yii::t('app', 'sales') ?>"><?= Yii::t('app', 'sale') ?></li>
                <li class="content-nav__item" data-link="<?= LanguageHelper::langUrl('recommend') ?>"
                    data-title="<?= Yii::t('app', 'recommended') ?>"><?= Yii::t('app', 'recommend') ?></li>
                <?php if (isset($productGroup[4]) && $productGroup[4] == 'shares'): ?>
                    <li class="content-nav__item" data-link="<?= LanguageHelper::langUrl('aktsii') ?>"
                        data-title="<?= Yii::t('app', 'aktsii') ?>"><?= Yii::t('app', 'aktsii') ?></li>
                <?php endif ?>
            </ul>
        </div>
        <div class="col-lg-auto d-none d-lg-block mb-4">
            <a href="<?= LanguageHelper::langUrl('hits') ?>" class="button-6" id="all-hits-btn"><?= Yii::t('app', 'all') ?> <?= Yii::t('app', 'leaders') ?></a>
            <button class="btn btn--lg btn--red d-none">
                <a class="_full-page" href="<?= LanguageHelper::langUrl('hits') ?>">
                    <span class="btn__inner"><?= Yii::t('app', 'all') ?>
                        <span class="inner_text-label"><?= Yii::t('app', 'leaders') ?></span></span>
                </a>
            </button>
        </div>
    </div>
<?php */ ?>

    <?php if (count($items) > 0): ?>
        <?php foreach ($productGroup as $group): ?>
            <div class="product-card-wrap s_tabs_content <?= $group == 'hit' ? 'active' : '' ?>">
                <div class="block_product-list__<?= $group ?>" style="display: contents;">
                    <?= $this->render('/parts/_items-common', [
                        'items' => $items[$group],
                        'name' => $group,
                        'currency' => $currency,
                        'productService' => $productService,
                        'compare' => $compare,
                        'wishList' => $wishList
                    ]) ?>
                </div>
                <?php if($items[$group]['existNextPage']): ?>
                    <div class="card-more-but">
                        <button class="btn btn--lg btn--black view-more_by-field btn-list__<?= $group ?>"
                                onclick="gtag('event', 'category', {'event_category': 'Показать еще в каталоге', 'event_action': 'Нажатие на кнопку'});"
                                data-field="<?= $group ?>" data-page="2">
                            <a href="#" class="btn__inner"><?= Yii::t('app', 'show more') ?></a>
                        </button>
                    </div>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    <?php endif ?>

<!--/div-->