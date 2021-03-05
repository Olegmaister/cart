<div class="popup-banner js-popup-banner" data-duration="4" data-timeout="3" data-repeat-minutes="10">

    <button type="button" class="close js-close-banner" aria-label="Close" onclick="gtag('event', 'category', {'event_category': 'Закрыть угловой баннер', 'event_action': 'Нажатие на кнопку'});">
        <span aria-hidden="true">&times;</span>
    </button>

    <?php foreach ($bannerHtmlList as $banner): ?>
        <div class="promo-banner">
            <div class="my-auto">
                <div class="badge-1 mb-3">Акция</div>
                <div class="promo-banner__title-1 mb-2"><?= $banner->getTitle() ?></div>
                <div class="promo-banner__title-3 text-red mb-4"><?= $banner->discount ?></div>
                <a href="<?= $banner->getLink() ?>" class="button-2" onclick="gtag('event', 'category', {'event_category': 'Открыть угловой баннер', 'event_action': 'Нажатие на кнопку'});">Смотреть товары</a>
                <img class="promo-banner__img" src="<?= $banner->image ?>" alt="promo clock">
            </div>
        </div>
    <?php endforeach; ?>

    <?php foreach ($bannerImageList as $banner): ?>
        <div class="promo-banner">
            <a href="<?= $banner->getLink() ?>">
                <img src="<?= $banner->getImage() ?>">
            </a>
        </div>
    <?php endforeach; ?>
</div>
