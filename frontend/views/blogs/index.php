<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\LanguageHelper;
use common\widgets\Blog\TagNameWidget;
$classActive = ' active';
?>
<div class="page">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                        <span itemprop="name" content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li>
                    <span><?= Yii::t('app', 'magazine') ?></span>
                </li>
            </ul>
        </nav>
        <div class="page-content">
            <div class="p-journal">
                <div class="p-journal-top">
                    <div class="p-journal-top-col p-journal-top-col--left">
                        <h1 class="title-h2"><?= Yii::t('app', 'magazine') ?></h1>
                    </div>
                </div>
                <div class="p-journal-content">



                    <!--три последнии статьи-->
                    <?=\common\widgets\Blog\LatestBlogsWidget::widget()?>
                    <!--/три последнии статьи-->

                    <section class="p-journal-tabs s_tabs">
                        <ul class="blog-nav js-blog-nav s_tabs_list mb-4">
                            <li class="active" tabindex="0"><?= Yii::t('app', 'all') ?></li>
                            <?php foreach ($blogsMenu as $i=>$menu):?>
                                <li tabindex="0"><?=$menu->mainDescription->name?></li>
                            <?php endforeach;?>
                        </ul>

                        <?php foreach ($providers as $i=>$provider): ?>
                            <section class="p-journal-tabs-content s_tabs_content <?php if($i == 0) echo $classActive?>"">
                            <div class="p-journal-posts">
                                <div class="posts-grid wrapper-blog-<?=$provider->getId()?>">
                                    <?php foreach ($provider->getProvider()->getModels() as $item) :
                                        $photo = isset($item->mainPhoto) ? $item->mainPhoto : null;
                                        $url = $item->urlBlog; ?>
                                    <article class="journal-card">
										<a href="<?= LanguageHelper::langUrl($url->keyword)?>" class="journal-card__img-link">
                                            <?php if($photo) : ?>
                                                <?=Html::img($photo->getThumbFileUrl('file', 'slider'), ['class' => 'journal-card__img'])?>
											<?php endif;?>


                                            <!--вывод имени тега-->
                                            <?=TagNameWidget::widget([
                                                'category' => $item
                                            ])?>
                                            <!--/вывод имени тега-->

										</a>

                                        <?php
                                        /**@var \common\entities\Blog\BlogCategoryMainDescription $parent*/
                                        $parent = $item->parent->mainDescription;
                                        $parentName = $parent->getLanguageName();
                                        ?>

										<div class="journal-card__info">
											<div class="journal-card__info-header">
												<a href="<?= LanguageHelper::langUrl($url->keyword)?>" class="journal-card__title title-h4"><?=$item->childrenDescription->name?></a>
												<div class="journal-card__label"><span><?=$parentName?></span></div>
											</div>
											<div class="journal-card__info-footer">
												<div class="journal-card__date"><?=$item->getAddDate()?></div>
                                                <div data-id="<?=$item->id?>" class="journal-card__like like">
                                                    <svg class="like__icon" width="24" height="24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg"
                                                         tabindex="0">
                                                        <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                                    </svg>
                                                    <span class="js-blog-like-<?=$item->id?> like__count"><?=$item->like?></span>
                                                </div>
											</div>
										</div>
									</article>
                                    <?php endforeach;?>
									<!--Подгружать новые статьи можно прямо сюда-->
                                </div>
                                <?php if($provider->showButton()):?>
                                    <div class="js-blog-show-more js-wrapper-blog-page-<?=$provider->getId()?> p-journal__btn" data-page="2" data-id="<?=$provider->getId()?>">
                                        <button class="btn btn--gray btn--lxx btn_brand_view-more">
                                            <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                                        </button>
                                    </div>
                                <?php endif;?>
                            </div>
                        </section>
                        <?php endforeach;?>
                    </section>
                </div>
            </div>
        </div>
        <!--page content-->

    </div>
    <!--wrapper-->
</div>
<!--page-->