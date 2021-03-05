<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;

?>
<?php $link = LanguageHelper::langUrl('discount') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>"><?= ProductHelper::mbUcfirst(
            Yii::t('app', 'accumulative discount')) ?></a>
</li>
<?php $link = LanguageHelper::langUrl('delivery') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>"><?= ProductHelper::mbUcfirst(
            Yii::t('app', 'delivery')) ?></a>
</li>
<?php $link = LanguageHelper::langUrl('pay') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>"><?= ProductHelper::mbUcfirst(
            Yii::t('app', 'payment')) ?></a>
</li>
<?php $link = LanguageHelper::langUrl('opt') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>"><?= ProductHelper::mbUcfirst(
            Yii::t('app', 'wholesale')) ?></a>
</li>

<?php if (defined('IS_DEV')): ?>
    <?php $link = LanguageHelper::langUrl('video') ?>
    <li class="<?= ($url == $link) ? 'active' : '' ?>">
        <a href="<?= ($url == $link) ? '' : $link ?>"><?= ProductHelper::mbUcfirst(
                Yii::t('app', 'video reviews')) ?></a>
    </li>
<?php endif ?>

<?php $link = LanguageHelper::langUrl('warranty') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>"><?= ProductHelper::mbUcfirst(
            Yii::t('app', 'warranty and return')) ?></a>
</li>
<?php $link = LanguageHelper::langUrl('faq') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>"><?= ProductHelper::mbUcfirst(
            Yii::t('app', 'question answer')) ?></a>
</li>
<?php $link = LanguageHelper::langUrl('about') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>"><?= ProductHelper::mbUcfirst(
            Yii::t('app', 'about')) ?></a>
</li>