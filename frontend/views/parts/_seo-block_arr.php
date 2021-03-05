<?php

use common\helpers\LanguageHelper;

?>

<section class="cat-desc">
    <div class="post-prev">
        <div class="post-prev-col post-prev-col_left">
            <div class="post-prev-img"><img
                        loading="lazy"
                        src="<?= isset($seoBlock['image']) ? $seoBlock['image'] : '' ?>"
                        alt="<?= $seoBlock['title'] ?>"
                        alt="<?= $seoBlock['title'] ?> - Prof1group"></div>
        </div>
        <div class="post-prev-col post-prev-col_right">
            <h2 class="post-prev__title mw-100">
                <?= isset($seoBlock['title']) ? $seoBlock['title'] : '' ?>
            </h2>
            <div class="post-prev__desc">
                <?= isset($seoBlock['description']) ? $seoBlock['description'] : '' ?>
            </div>

            <?php if ($seoBlock['type'] == 1 && isset($seoBlock['additionals'][0]['title'])
                    && !empty($seoBlock['additionals'][0]['title'])): ?>
                <section class="desc-accord">
                    <?php foreach ($seoBlock['additionals'] as $additional): ?>
                        <article class="desc-accord-item">
                            <header class="desc-accord-head js-toggle-slide">
                                <div class="desc-accord-head__title">
                                    <?= isset($additional['title']) ? $additional['title'] : '' ?>
                                </div>
                                <span class="material-icons b_arrow b_arrow_black">arrow_drop_down</span>
                            </header>
                            <article class="desc-accord-cont js-toggle-cont">
                                <?= isset($additional['text']) ? $additional['text'] : '' ?>
                            </article>
                        </article>
                    <?php endforeach ?>
                </section><br>
            <?php endif ?>

            <button class="btn-link btn-link--red">
                <a href="<?= LanguageHelper::langUrl($seoBlock['link']) ?>"
                   class="btn-link__inner"><?= Yii::t('app', 'read more') ?></a>
            </button>
        </div>
    </div>
</section>
