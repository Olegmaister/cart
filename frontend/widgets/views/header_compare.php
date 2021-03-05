<?php

use common\helpers\LanguageHelper;

?>
<?php if (isset($data['categories'])): ?>
    <?php foreach ($data['categories'] as $key => $cat): ?>
        <div class="header-comp-list-item">
            <a href="<?= LanguageHelper::langUrl('comparison/' . $key) ?>">
                <span class="header-comp-list__inner">
                    <?= $cat['name'] ?>
                    <span><?= count($cat['productIds']) ?></span>
                </span>
            </a>
            <i class="remove_compare_string" data-link="<?= $key ?>" tabindex="0">
                <svg class="_patch" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.5 0L12 1.5 1.5 12 0 10.5 10.5 0z"/>
                    <path d="M0 1.5L1.5 0 12 10.5 10.5 12 0 1.5z"/>
                </svg>
            </i>
        </div>
    <?php endforeach ?>
    <a href="#" class="header-comp-list-item clear-all-compares"><?= Yii::t('app', 'clear the list') ?></a>
<?php endif ?>