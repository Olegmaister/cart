<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "image":"<?= Yii::$app->request->hostInfo ?>/images/prof1group.png",
        "priceRange":"$",
        "email": "Sale@prof1group.com",

        "name": "Военные магазины Prof1group",
        "openingHours":"Mo-Su 9:00-21:00",
        "telephone": "+380443928449",
        "openingHoursSpecification": [
            {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": [
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday",
                    "Sunday"
                ],
                "opens": "9:00",
                "closes": "21:00"
            }
        ],
        "address": { // адрес
            "@type": "PostalAddress",
            "addressCountry":"Украина",
            "addressLocality": "Киев",
            "postalCode":"04070"
        }
    }
</script>