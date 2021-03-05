<?php foreach ($providers->getProvider()->getModels() as $provider) :
    $description = $provider->blogReviewDescription;

    $childrens = $provider->getChildrens();

    ?>
    <div class="product-reviews-row">
        <!--гланвый коммент-->

        <div class="product-reviews-top">
            <div class="product-reviews-top-col product-reviews-top-col--left">
                <div class="product-reviews__name"><?=$description->author?></div>
            </div>

            <div class="product-reviews-top-col product-reviews-top-col--right">
                <div class="rating">
                    <div class="rating__item rating__item--active"></div>
                    <div class="rating__item rating__item--active"></div>
                    <div class="rating__item rating__item--active"></div>
                    <div class="rating__item rating__item--active"></div>
                    <div class="rating__item"></div>
                </div>
            </div>
        </div>

        <div class="product-reviews__comments">
            <?=$description->text?>
        </div>

        <div class="product-reviews-bot">
            <div class="product-reviews-bot-col product-reviews-bot-col--left">
                <div class="product-reviews-buttons">
                    <div class="product-reviews-buttons-col product-reviews-buttons-col--left">
                        <button
                                data-id="<?=$provider->getId()?>"
                                class="js-add-review-child js-open-modal-review btn btn--trans btn--lxs">
                            <span class="btn__inner"><?= Yii::t('app', 'answer') ?></span>
                        </button>
                    </div>

                    <?php if(!empty($childrens)):?>
                        <div class="product-reviews-buttons-col product-reviews-buttons-col--right">
                            <div tabindex="0" class="product-reviews__link js-answers">
                                <?= Yii::t('app', 'comments') ?> <span>(<?=count($childrens)?>)</span>
                            </div>
                        </div>
                    <?php endif;?>

                </div>

            </div>
            <div class="product-reviews-bot-col product-reviews-bot-col--right">
                <div class="video-reviews-date"><?=date('Y-m-d H:i:s',$provider->created_at)?></div>
            </div>
        </div>

        <!--/главный коммент-->

        <!--ответы-->

        <?php if(isset($childrens) && !empty($childrens)):?>
            <div class="product-reviews-answers">
                <!--ответ-->
                <?php foreach ($childrens as $children):?>
                    <div class="product-reviews-answers-item">
                        <div class="product-reviews-answers__name">
                            <?=$children->blogReviewDescription->author?>
                            <div class="video-reviews-date"><?=date('Y-m-d H:i:s',$children->created_at)?></div>
                        </div>

                        <div class="product-reviews-answers__comment">
                            <?=$children->blogReviewDescription->text?>
                        </div>
                    </div>
                <?php endforeach;?>
                <!--/ответ-->
            </div>

        <?php endif;?>


        <!--/ответы-->
        <!--ANSWERS-->
    </div>
<?php endforeach;?>