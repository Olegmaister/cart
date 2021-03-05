<?php

use common\helpers\LanguageHelper;

?>
<?php foreach ($categories as $category): ?>
    <?php /*
         if ($category->category_id == 137004): continue endif */
        // novelty-category == 137004
        // 137001  Распродажа  sales-category
    ?>

    <div class="col-md-6 col-lg-3 mb-4">
        <a data-category_id="<?= $category->category_id ?>"
           href="<?= isset($category->url->keyword) ? LanguageHelper::langUrl( $brandSlug . '/' . $category->url->keyword ) : '#' ?>"
           class="cat-prod-card">
            <div class="cat-prod-card-img">
                <img loading="lazy" src="/images/<?= ($category->image) ?
                'categories/' . $category->image : 'no-image.png' ?>" alt="<?= isset($category->description->name) ? $category->description->name : '' ?>" title="<?=
                    isset($category->description->name) ? $category->description->name : '' ?> - Prof1group">
            </div>
            <div class="cat-prod-card-info">
                <h3 class="cat-prod-card__name"><?= isset($category->description->name) ? $category->description->name : '' ?></h3>
                <i class="cat-prod-card__arrow"></i>
            </div>
        </a>
    </div>
<?php endforeach ?>