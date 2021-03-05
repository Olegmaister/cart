
<?php

/**@var common\entities\Blog\BlogCategory[] $blogsMenu */
/**@var frontend\entities\Blog\Blogs $provider */

use yii\helpers\Url;
use yii\helpers\Html;

?>


<?php foreach ($provider->getProvider()->getModels() as $item) :

    $photo = isset($item->mainPhoto) ? $item->mainPhoto : null;
    $url = $item->urlBlog; ?>

    <div class="a-journal-item">
        <article class="journal-card wrapper-blog-<?=$provider->getId()?>">
            <a href="<?=Url::to('/'.$url->keyword)?>" class="journal-card__img-link">
                <?php if($photo) : ?>
                    <?=Html::img($photo->getThumbFileUrl('file', 'slider'), ['class' => 'journal-card__img'])?>
                <?php endif;?>
                <div class="journal-card__tags">
                    <?php if(isset($item->tagDescriptions)) :?>
                        <?php foreach ($item->tagDescriptions as $tag) :?>
                            <div class="journal-card__tag hash-tag"># <?=$tag->name?></div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </a>
            <div class="journal-card__info">
                <div class="journal-card__info-header">
                    <a href="/" class="journal-card__title title-h4">
                        <?=$item->childrenDescription->name?>
                    </a>

                    <?php
                    $parent = $item->parent->mainDescription;
                    $parentName = isset($parent->name) ? $parent->name : '';
                    ?>


                    <div class="journal-card__label"><span><?=$parentName?></span></div>
                </div>
                <div class="journal-card__info-footer">
                    <div class="journal-card__date">10.01.2020</div>
                    <div class="journal-card__like like">
                        <svg class="like__icon" width="24" height="24" fill="none"
                             xmlns="http://www.w3.org/2000/svg"
                             tabindex="0">
                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                        </svg>
                        <span class="like__count">126</span>
                    </div>
                </div>
            </div>
        </article>
    </div>

<?php endforeach;?>
