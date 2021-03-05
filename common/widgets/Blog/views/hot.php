<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\Blog\TagNameWidget;
use common\helpers\LanguageHelper;
/**@var \common\entities\Blog\BlogCategory [] $model*/
/**@var \common\entities\Blog\BlogCategory $item*/

$classCol = 'pg-col-50';
?>

<?php foreach ($model as $i=>$item) :

    $photo = isset($item->mainPhoto) ? $item->mainPhoto : null;
    $url = $item->urlBlog;

    ?>
    <div class="<?php if($i == 0)echo $classCol;else echo 'pg-col-25'?> pg-col-lg-50 pg-col-md-s-100">
        <article class="journal-card">
            <a href="<?=LanguageHelper::langUrl($url->keyword)?>" class="journal-card__img-link">
                <?php if($photo):?>
                    <?=Html::img($photo->getThumbFileUrl('file', 'slider'), ['class' => 'journal-card__img'])?>
                <?php endif;?>


                <!--вывод имени тега-->
                <?=TagNameWidget::widget([
                    'category' => $item
                ])?>
                <!--/вывод имени тега-->



            </a>
            <div class="journal-card__info">
                <div class="journal-card__info-header">
                    <a href="<?=LanguageHelper::langUrl($url->keyword)?>" class="journal-card__title title-h4">
                        <?=$item->childrenDescription->name?>
                    </a>


                    <?php

                    $parent = $item->parent->mainDescription;
                    $parentName = \common\entities\Blog\BlogCategoryMainDescription::find()
                        ->where(['and',['category_id' => $parent->id],['language_id' => LanguageHelper::getCurrentId()]])
                        ->asArray()
                        ->one();

                    ?>

                    <div class="journal-card__label"><span><?=$parentName['name']?></span></div>
                </div>
                <div class="journal-card__info-footer">
                    <div class="journal-card__date"><?=$item->getAddDate()?></div>
                    <div data-id="<?=$item->id?>" class="journal-card__like like" onclick="gtag('event', 'category', {'event_category': 'Нравится пост в блоге', 'event_action': 'Нажатие на кнопку'});">
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
    </div>
<?php endforeach;?>

