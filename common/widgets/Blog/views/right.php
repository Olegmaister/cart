<?php

use common\widgets\Blog\TagNameWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\LanguageHelper;
/**@var \common\entities\Blog\BlogCategory[] $model*/
/**@var \common\entities\Blog\BlogCategory $item*/
?>
<div class="journal-one-col journal-one-col--right">
    <div class="journal-one-sidebar">
        <div class="journal-one-sidebar__but mob-hide-x766">
            <button class="btn btn--blue btn--full btn--lg-x btn--icon btn--icon--ls btn--icon--fb fb-share">
                <span class="btn__inner"><i></i><?= Yii::t('app', 'Share the article on facebook') ?></span>
            </button>
        </div>
        <h3 class="journal-one-sidebar__title mob-hide-x766"><?= Yii::t('app', 'similar articles') ?></h3>

        <div class="journal-one-sidebar-items mob-hide-x766">

            <?php foreach ($model as $item):
                $photo = $item->mainPhoto;
                $url = $item->urlBlog;
                ?>
            <div class="journal-one-sidebar-item">
                <div class="journal-rev-top journal-rev-top--min">
                    <?= isset($item->mainPhoto) ?
                        Html::img($photo->getThumbFileUrl('file', 'thumb'), ['class' => 'journal-rev-img']) :
                        ''
                    ?>

                    <!--вывод имени тега-->
                    <?=TagNameWidget::widget([
                        'category' => $item
                    ])?>
                    <!--/вывод имени тега-->

                </div>
                <div class="journal-rev-bot journal-rev-bot--min">
                    <div class="journal-rev-bot-row">
						<h3 class="journal-rev__name">
							<a href="<?= LanguageHelper::langUrl($url->keyword) ?>" class="journal-card__title title-h4">
								<?=$item->childrenDescription->name?>
							</a>
						</h3>
						<p class="journal-rev__label mob-hide-x766"><?=$parent->getLanguageName()?></p>
                    </div>
                    <div class="journal-rev-bot-row">
						<div class="journal-rev__date"><?=$item->getAddDate()?></div>
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
            </div>
            <?php endforeach;?>

        </div>
    </div>
</div>
