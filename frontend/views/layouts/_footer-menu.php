<?php

use common\helpers\LanguageHelper;

?>

<?php if (isset($position) && $position == 'left'): ?>
    <?php $link = LanguageHelper::langUrl('video') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'video reviews') ?></a></li>

    <?php $link = LanguageHelper::langUrl('opt') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'for wholesalers') ?></a></li>

    <?php $link = LanguageHelper::langUrl('pay') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'payment') ?></a></li>

    <?php $link = LanguageHelper::langUrl('delivery') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'delivery') ?></a></li>

    <?php $link = LanguageHelper::langUrl('discount') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'discount') ?></a></li>

    <?php $link = LanguageHelper::langUrl('warranty') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'warranty period') ?></a></li>

    <?php $link = LanguageHelper::langUrl('oplata-chastyami') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'payment in installments') ?></a></li>
<?php endif ?>


<?php if (isset($position) && $position == 'center'): ?>
    <?php $link = LanguageHelper::langUrl('our-stores') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'shops') ?></a></li>

    <?php $link = LanguageHelper::langUrl('aktsii') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'stocks') ?></a></li>

    <?php $link = LanguageHelper::langUrl('about') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'about') ?></a></li>

    <?php $link = LanguageHelper::langUrl('novosti') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'magazine') ?></a></li>

    <?php $link = LanguageHelper::langUrl('contact-us') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'contacts') ?></a></li>

    <?php $link = LanguageHelper::langUrl('polzovatelskoe-soglashenie') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'terms of use') ?></a></li>

    <?php $link = LanguageHelper::langUrl('brands') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'brands') ?></a></li>
<?php endif ?>


<?php if (isset($position) && $position == 'right'): ?>
    <?php $link = LanguageHelper::langUrl('faq') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'FAQ') ?></a></li>

    <?php $link = LanguageHelper::langUrl('pravila-vikoristanna-promokodiv') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'Rules for using promo codes') ?></a></li>

    <?php $link = LanguageHelper::langUrl('oferta') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'contract offer') ?></a></li>

    <?php $link = LanguageHelper::langUrl('quality-control') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'quality control') ?></a></li>

    <?php $link = LanguageHelper::langUrl('reviews') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'all') ?> <?= Yii::t('app', 'reviews') ?></a></li>

    <?php $link = LanguageHelper::langUrl('subscription') ?>
    <li><a href="<?= ($url == $link) ? '' : $link ?>"><?= Yii::t('app', 'Newsletter subscription') ?></a></li>

<?php endif ?>
