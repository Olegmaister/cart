<?php

use common\helpers\LanguageHelper;

?>
<?php if (isset($brandSlider[0])): ?>
    <div class="cat-slider-wrap">
        <?php foreach ($brandSlider as $brand): ?>
            <a target="_blank" data-brand_id="<?= $brand['brand_id'] ?>"
               href="<?= LanguageHelper::langUrl($brand['keyword']) ?>" class="cat-slider-item">
                <div class="cat-slider-item-media">
                    <img data-lazy="/images/brands/<?= $brand['image'] ?>" title="<?= $brand['name'] ?> - Prof1group" alt="<?= $brand['name'] ?>">
                </div>
            </a>
        <?php endforeach ?>
    </div>
<?php endif ?>