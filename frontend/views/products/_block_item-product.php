<div class="content-extra content-extra--product<?= isset($class) ? $class : '' ?>">
    <h2 class="content-extra__title"><?= $title ?></h2>
    <div class="carousel-1 mt-n5">
        <?= $this->renderAjax('/parts/_items-common', [
            'items' => $items,
            'currency' => $currency,
            'productService' => $productService,
            'compare' => $compare,
            'wishList' => $wishList
        ]) ?>
    </div>
</div>