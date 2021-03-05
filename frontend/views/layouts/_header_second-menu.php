<?php

use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;

?>
<?php $link = LanguageHelper::langUrl('our-stores') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>">
        <?= Yii::t('app', 'shops') ?>
    </a>
</li>
<?php $link = LanguageHelper::langUrl('brands') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>">
        <?= Yii::t('app', 'brands') ?>
    </a>
</li>
<?php $link = LanguageHelper::langUrl('hits') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>">
        <?= Yii::t('app', 'hits') ?>
    </a>
</li>
<?php $link = LanguageHelper::langUrl('novelty') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>">
        <?= Yii::t('app', 'new items') ?>
    </a>
</li>
<?php $link = LanguageHelper::langUrl('aktsii') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>">
        <?= Yii::t('app', 'stocks') ?>
    </a>
</li>
<?php $link = LanguageHelper::langUrl('sales') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>">
        <?= Yii::t('app', 'sell-out') ?>
    </a>
</li>
<?php $link = LanguageHelper::langUrl('novosti') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>">
        <?= Yii::t('app', 'magazine') ?>
    </a>
</li>
<?php $link = LanguageHelper::langUrl('contact-us') ?>
<li class="<?= ($url == $link) ? 'active' : '' ?>">
    <a href="<?= ($url == $link) ? '' : $link ?>">
        <?= Yii::t('app', 'contacts') ?>
    </a>
</li>