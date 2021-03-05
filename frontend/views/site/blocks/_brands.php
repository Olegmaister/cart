<div class="wrapper">
    <div class="brands-head">
        <div class="brands__title"><?= Yii::t('app', 'Brands') ?></div>
        <div class="brands-arrows">
            <div class="brands-arrows__arrow brands-arrows__arrow_prev"></div>
            <div class="brands-arrows__arrow brands-arrows__arrow_next"></div>
        </div>
    </div>
    <div class="brands-slider">
        <div class="brands-slider-wrap">
            <?php if (isset($brands[0])): ?>
                <?php foreach ($brands as $brand): ?>
                    <a href="<?= $brand['keyword'] ?>" class="brands-slider__item">
                        <img loading="lazy" src="<?= ($brand['image']) ?
                            '/images/brands/' . $brand['image'] :
                            '/images/no-image.png' ?>" title="<?= $brand['name'] ?> - Prof1group" alt="<?= $brand['name'] ?>">
                    </a>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</div>
