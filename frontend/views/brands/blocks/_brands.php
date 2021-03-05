<?php
use common\helpers\LanguageHelper;
?>
<?php foreach ($brands as $brand): ?>
    <div class="pg-col-25 pg-col-md-33 pg-col-md-s-50 pg-col-sm-100">
        <a href="<?= LanguageHelper::langUrl($brand->url->keyword) ?>" class="brands-item" data-brand_id="<?= $brand->brand_id ?>">
            <div class="brands-item-media">
                <img loading="lazy" src="/images/brands/<?= $brand->image ?>" alt="<?= $brand->description->name ?>" title="<?= $brand->description->name ?> - Prof1group">
            </div>
            <div class="brands-item-top">
                <div class="brands-item-top-col">
                    <h3 class="brands-item__name"><?= $brand->description->name ?></h3>
                </div>
                <div class="brands-item-top-col">
                    <div class="brands-item__icon">
                        <img style="width:34px; height:20px;" loading="lazy" src="/images/flags/<?= $brand->country['en-EN'] ?>.png" alt="<?= $brand->country['ru-RU'] ?>" title="Флаг <?= $brand->country['ru-RU'] ?> - Prof1group">
                    </div>
                </div>
            </div>
            <div class="brands-item__desc">
                <?= html_entity_decode($brand->description->excerpt) ?>
            </div>
            <div class="brands-item__link"><?= Yii::t('app', 'view products') ?></div>
        </a>
    </div>
<?php endforeach ?>