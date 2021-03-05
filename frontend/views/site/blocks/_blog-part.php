<?php

use common\helpers\LanguageHelper;
$classCol = 'pg-col-50';

?>

<?php foreach ($blogsMenu as $i => $item): ?>
    <div class="<?php if ($i == 0) echo $classCol; else echo 'pg-col-25' ?> pg-col-lg-50 pg-col-md-s-100">
        <article class="journal-card">
            <a href="<?= LanguageHelper::langUrl($item['keyword']) ?>" class="journal-card__img-link">
                <!-- TODO  data-lazy=  -->
                <img src="<?=$item['image_url'] ?>" class="journal-card__img" alt="<?= $item['name'] ?>">

                <!--вывод имени тега-->
                <div class="journal-card__tags">
                    <?php if (isset($item['tags'][0])): ?>
                        <?php foreach ($item['tags'] as $tag): ?>
                            <div class="journal-card__tag hash-tag"># <?= $tag['name'] ?></div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
                <!--/вывод имени тега-->
            </a>

            <div class="journal-card__info">
                <div class="journal-card__info-header">
                    <a href="<?= LanguageHelper::langUrl($item['keyword']) ?>" class="journal-card__title title-h4">
                        <?= $item['name'] ?>
                    </a>
                    <div class="journal-card__label"><span><?= $item['category_name'] ?></span></div>
                </div>
                <div class="journal-card__info-footer">
                    <div class="journal-card__date"><?= $item['date_formate'] ?></div>
                    <div data-id="<?= $item['id'] ?>" class="journal-card__like like"
                         onclick="gtag('event', 'category', {'event_category': 'Нравится пост в блоге', 'event_action': 'Нажатие на кнопку'});">
                        <svg class="like__icon" width="24" height="24" fill="none"
                             xmlns="http://www.w3.org/2000/svg"
                             tabindex="0">
                            <path stroke-width="2"
                                  d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                        </svg>
                        <span class="js-blog-like-<?= $item['id'] ?> like__count"><?= $item['like'] ?></span>
                    </div>
                </div>
            </div>
        </article>
    </div>
<?php endforeach ?>