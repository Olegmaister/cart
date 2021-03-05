<?php

use common\helpers\LanguageHelper;

?>
<div class="container">
    <div class="stock-empty-page">
        <div class="stock-empty-text">
            <svg width="296" height="293" viewBox="0 0 296 293" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6 97L10.2752 147.495L104 197V148.815L6 97Z" fill="#E9E9E9"/>
                <path d="M172 0V210.196L148.915 221L125.5 210.196V48.1289H110V16.6978H125.5C133.415 15.3881 139.681 8.51259 139.681 0.327407V0H172Z" fill="#E9E9E9"/>
                <path d="M0 17L4.26498 66.5336L104 119V71.7476L0 17Z" fill="#E9E9E9"/>
                <path d="M192 148.815V197L285.739 147.495L290 97L192 148.815Z" fill="#E9E9E9"/>
                <path d="M192 71.7476V119L291.748 66.5336L296 17L192 71.7476Z" fill="#E9E9E9"/>
                <path d="M148 245.029L15 178V178.329L19.5862 227.943L148 293L276.414 227.943L280.672 178.329L281 178L148 245.029Z" fill="#E9E9E9"/>
            </svg>
            <h1><?= Yii::t('app', 'THERE ARE NO ACTUAL SHARES AT THE MOMENT') ?></h1>
        </div>
        <a href="<?= LanguageHelper::langUrl('/') ?>" class="button-2">
            <?= Yii::t('app', 'to home') ?>
        </a>
    </div>
</div>
