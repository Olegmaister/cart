<?php

use common\helpers\LanguageHelper;

?>
<?php foreach ($categories as $category): ?>
    <li class="header-cat-menu__item js-cat-menu-li">
        <i class="header-cat-menu-sub__arrow js-cat-menu-sub-show"></i>
        <?php $url = ($pathInfo != $category['url']['keyword']) ? LanguageHelper::langUrl($category['url']['keyword']) : '' ?>
        <a data-category_id="<?= $category['category_id'] ?>"
           href="<?= $url ?>" class="header-cat-menu__link">
            <div class="header-cat-menu__icon">
                <img loading="lazy"
                     src="<?= Yii::getAlias('@web/') ?>images/slider-content/<?= $category['url']['keyword'] ?>.svg"
                     title="<?= $category['description']['name'] ?> - PROF1Group"
                     alt="<?= $category['description']['name'] ?>">
            </div>
            <span class="header-cat-menu__link-txt"><?= $category['description']['name'] ?></span>
        </a>
        <ul class="header-cat-menu header-cat-menu_sub js-cat-menu-sub">
            <span class="header-cat-menu-transform-txt"><?= $category['description']['name'] ?></span>
            <?php if (isset($category['children'])):
                 foreach ($category['children'] as $subCategory):
                     $subUrl = ($pathInfo != $subCategory['url']['keyword']) ?
                        LanguageHelper::langUrl($subCategory['url']['keyword']) : ''
                    ?><li class="header-cat-menu__item header-cat-menu__item_sub">
                        <a data-category_id="<?= $subCategory['category_id'] ?>"
                           class="header-cat-menu__link header-cat-menu__link_sub js-cat-menu-link"
                           href="<?= $subUrl ?>"><?= $subCategory['description']['name']
                        ?></a>
                        <div class="header-cat-menu-sub-img">
								<span class="header-cat-menu-transform-txt js-cat-menu-img-text"><?=
                                    $subCategory['description']['name']
                                ?></span>
                            <img class="js-cat-menu-img-src"
                                 data-lazy="<?= Yii::getAlias('@web/') ?>images/categories/<?= $subCategory['image'] ?>"
                                 title="<?= $subCategory['description']['name'] ?> - PROF1Group"
                                 alt="<?= $subCategory['description']['name'] ?>">
                        </div>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
    </li>
<?php endforeach ?>

<?php if (count($categories) > 13): ?>
    <li>
        <div class="header-cat__show _hidden"></div>
    </li>
<?php endif ?>

<?php if (count($categories) > 13): ?>
    <div class="header-cat__show"></div>
<?php endif ?>
