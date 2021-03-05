<?php

namespace frontend\widgets\PromoBannerWidget;

use backend\helpers\BannerHelper;
use yii\base\Widget;

class PromoBannerWidget extends Widget
{
    public function run()
    {
        return $this->render('promo-banner', [
            'bannerImageList' => (new BannerHelper())->getSimpleBannerList(),
            'bannerHtmlList' => (new BannerHelper())->getAdvancedBannerList(),
        ]);
    }
}
