<?php

use common\helpers\LanguageHelper;

?>
<?php if (isset($categorySlider[0])): ?>
    <div class="cat-slider-wrap">
        <?php foreach ($categorySlider as $category): ?>
            <a data-category_id="<?= $category['category_id'] ?>" href="<?= LanguageHelper::langUrl($category['keyword']) ?>"
               class="cat-slider-item">
                <div class="cat-slider-item-media">
                    <img data-lazy="/images/<?= $category['image'] ? 'categories/' . $category['image'] : 'no_image_small.png'
                        ?>" title="<?= $category['name'] ?> - Prof1group" alt="<?= $category['name'] ?>">
                </div>
                <div class="cat-slider-item__name"><?= $category['name'] ?></div>
            </a>
        <?php endforeach ?>
    </div>
<?php endif ?>