<?php
 /**@var \common\entities\Blog\BlogCategory $category*/
?>


<div class="journal-card__tags">
    <?php use common\helpers\LanguageHelper;
    if(isset($category->tagDescriptions)):?>
        <?php foreach ($category->tagDescriptions as $tag):
            foreach ($tag->blogTagDescriptions as $blogTagDescription) {
                if($blogTagDescription->language_id == LanguageHelper::getIdByCode(Yii::$app->language)){
                    $name = $blogTagDescription->name;
                }
            }
            ?>
            <div class="journal-card__tag hash-tag"># <?= $name?></div>
        <?php endforeach;?>
    <?php endif;?>
</div>
