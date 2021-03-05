<?php
/**@var \yii\data\ActiveDataProvider $provider*/

use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php foreach ($provider->getProvider()->getModels() as $item) :

    $photo = isset($item->mainPhoto) ? $item->mainPhoto : null;
    $url = $item->urlBlog; ?>
    <article class="journal-card">
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

        <?php
        $parent = $item->parent->mainDescription;
        $parentName = $parent->getLanguageName();
        ?>

        <div class="journal-card__info">
            <div class="journal-card__info-header">
                <a href="<?=Url::to('/'.$url->keyword)?>" class="journal-card__title title-h4"><?=$item->childrenDescription->name?></a>
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
