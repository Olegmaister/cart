<?php

use yii\helpers\Url;
use common\widgets\Blog\BlogWidget;

/**@var \common\entities\Blog\BlogCategory [] $blogsMenu */


$classActive = ' active';
?>

<section class="journal s_tabs">
    <div class="wrapper">

        <h2 class="journal__title title-h2"><?= Yii::t('app', 'military') ?> - <?= Yii::t('app', 'magazine') ?></h2>

        <div class="row align-items-center mb-4 flex-lg-nowrap">
            <div class="col-md my-2">
                <ul class="blog-nav js-blog-nav s_tabs_list">
                    <li tabindex="0" class="active"><?= Yii::t('app', 'all') ?></li>
                    <?php foreach ($blogsMenu as $i => $menu):?>
                        <li tabindex="0"><?= $menu->mainDescription->name ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-auto my-2">
                <button class="btn btn--lg btn--red all-posts-btn">
                    <a href="/novosti" class="btn__inner"><?= Yii::t('app', 'all') ?> <?= Yii::t('app', 'publications') ?></a>
                </button>
            </div>
        </div>

        <div class="journal-content-wrapper">

            <div class="journal-content s_tabs_content active">
                <div class="pg-row">
                    <?= \common\widgets\Blog\BlogHotWidget::widget([]) ?>
                </div>
            </div>

            <!--вывод в цикле-->
            <?php foreach ($blogsMenu as $i => $category): ?>
                <div class="journal-content s_tabs_content">
                    <div class="pg-row">
                        <?= BlogWidget::widget([
                            'category' => $category
                        ]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>