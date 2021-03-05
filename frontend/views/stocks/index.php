<?php
use common\helpers\LanguageHelper;

/**@var \common\entities\Stock\Stock [] $model*/
/**@var bool $show*/
/**@var int $limit*/
/**@var int $flagButton*/
?>


<div class="page">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'stocks') ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">
            <h1 class="title title--page"><?= Yii::t('app', 'stocks') ?></h1>
            <div class="p-actions">
				<?php echo $this->render('common/_slider',[
				    'stock' => $model,
                    'slider' => $slider
                ])?>
                <div class="p-actions-content">

                    <?=$this->render('common/_sort',[
                            'modelType' => $modelType
                    ])?>

                   <?= $this->render('common/_stocks_view',[
                        'model' => $model,
                        'show' => $show,
                        'limit' => $limit,
                        'flagButton' => $flagButton
                   ])?>


                    <?php if(isset($seoBlock) && !empty($seoBlock)) : ?>
                        <?= $this->render('/parts/_seo-block', ['seoBlock' => $seoBlock]) ?>
                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>
</div>
