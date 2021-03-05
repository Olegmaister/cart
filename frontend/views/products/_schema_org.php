<?php
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
?>

<script type="application/ld+json">
{
    "@context": "https://schema.org/",
    "@type": "Product",
    "name": "<?= html_entity_decode(ProductHelper::clearQuotes($product->description->name)) ?>",
    "sku": "<?= $product->sku ?>",
    "mpn": "<?= $product->mpn ?>",
    "image": "<?= ProductHelper::correctedImgPath_500p($product->image) ?>",
    "brand": {
        "@type": "Thing",
        "name": "Бренд:"
    },
    "url": "<?= $absoluteUrl ?>",
    "description": "<?= trim(strip_tags(ProductHelper::clearQuotes(html_entity_decode($product->description->description)))) ?>",
    "offers": {
        "@type": "Offer",
        "priceCurrency": "<?= $currency->getCurrencyName() ?>",
        "price": "<?= $product->price ?>",
        "itemCondition": "new",
        "availability": "https://schema.org/InStock",
        "url": "<?= $absoluteUrl ?>"
    }<?php
        if ($reviews) {
            $ratingCount = count($reviews);
            $ratingSum = array_sum(array_column($reviews, 'rating'));
            $ratingValue =  ceil($ratingSum / $ratingCount);
            echo ',
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "'.$ratingValue.'",
        "ratingCount": "'.$ratingValue.'",
        "reviewCount": "'.$ratingValue.'"
    }';
        }
    ?>
}
</script>
