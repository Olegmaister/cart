<?php

use frontend\repositories\ProductRepository;
use frontend\services\ProductService;
use common\helpers\LanguageHelper;

$querySettings = ProductRepository::getSettingsByGroup(['sub_group' => 'main']);
$settings = ProductService::getGroupedSettings($querySettings);
$homeUrl = Yii::$app->params['homeUrl'];

?>
<table align="center" class="container footer"
       style="Margin:0 auto;background:#45484A;border-collapse:collapse;border-spacing:0;margin:0 auto;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:inherit;vertical-align:top;width:723px">
    <tbody>
    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
            <table class="row"
                   style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                <tbody>
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <th class="small-12 large-4 columns first"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;border-right:1px solid #565656;color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0 auto;padding-bottom:15px;padding-left:16px;padding-right:8px;padding-top:15px;text-align:left;text-transform:uppercase;vertical-align:top;width:225px;word-wrap:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                            <tbody>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;word-wrap:break-word">
                                    <?= Yii::t('app', 'Best regards, chain stores <br> for military clothing and equipment') ?>
                                    <table class="spacer"
                                           style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                            <td height="12"
                                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:12px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <img src="<?= $homeUrl ?>/images/footer/logo_<?= Yii::$app->language ?>.png" alt="PROF1Group"
                                         style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:auto">
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </th>
                    <th class="footer-middle small-12 large-3 columns"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;border-right:1px solid #565656;color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0 auto;padding-bottom:15px;padding-left:8px;padding-right:8px;padding-top:15px;text-align:left;text-transform:uppercase;vertical-align:top;width:164.75px;word-wrap:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                            <tbody>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;word-wrap:break-word">
                                    <?= Yii::t('app', 'View on the website') ?>
                                    <table class="spacer"
                                           style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                            <td height="11"
                                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:11px;font-weight:400;hyphens:auto;line-height:11px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                &nbsp;
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="row collapse footer-menu"
                                           style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                            <th class="small-6 large-6 columns first"
                                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0 auto;padding-bottom:8px;padding-left:0!important;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;width:50%;word-wrap:break-word">
                                                <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                    <tbody>
                                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                        <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;word-wrap:break-word">
                                                            <a href="<?= $homeUrl ?><?= LanguageHelper::langUrl('hits') ?>"
                                                               style="color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><?= Yii::t('app', 'Hits') ?></a>
                                                        </th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </th>
                                            <th class="small-6 large-6 columns last"
                                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0 auto;padding-bottom:8px;padding-left:0;padding-right:0!important;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;width:50%;word-wrap:break-word">
                                                <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                    <tbody>
                                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                        <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;word-wrap:break-word">
                                                            <a href="<?= $homeUrl ?><?= LanguageHelper::langUrl('aktsii') ?>"
                                                               style="color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><?= Yii::t('app', 'Promotions') ?></a>
                                                        </th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="row collapse footer-menu"
                                           style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                            <th class="small-6 large-6 columns first"
                                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0 auto;padding-bottom:8px;padding-left:0!important;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;width:50%;word-wrap:break-word">
                                                <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                    <tbody>
                                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                        <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;word-wrap:break-word">
                                                            <a href="<?= $homeUrl ?><?= LanguageHelper::langUrl('novelty') ?>"
                                                               style="color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><?= Yii::t('app', 'Novelty') ?></a>
                                                        </th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </th>
                                            <th class="small-6 large-6 columns last"
                                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0 auto;padding-bottom:8px;padding-left:0;padding-right:0!important;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;width:50%;word-wrap:break-word">
                                                <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                    <tbody>
                                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                        <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;word-wrap:break-word">
                                                            <a href="<?= $homeUrl ?><?= LanguageHelper::langUrl('catalog') ?>"
                                                               style="color:#fff;font-family:Roboto,sans-serif;font-size:10px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><?= Yii::t('app', 'Catalog') ?></a>
                                                        </th>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </th>
                    <th class="footer-contacts small-12 large-3 columns"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;border-right:1px solid #565656;color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0 auto;padding-bottom:15px;padding-left:8px;padding-right:8px;padding-top:15px;text-align:left;text-transform:uppercase;vertical-align:top;width:164.75px;word-wrap:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                            <tbody>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;word-wrap:break-word">
                                        <?php foreach ($querySettings as $setting): ?>
                                            <?php if (isset($setting['group_name']) && $setting['group_name'] == 'phone_sales'): ?>
                                                <a href="#" style="color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><?= $setting['value'] ?></a><br>
                                            <?php endif ?>
                                        <?php endforeach ?><br>

                                        <strong>
                                            <?= $settings['working'][LanguageHelper::getCurrentId()] ?>
                                        </strong>

                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </th>
                    <th class="small-12 large-1 columns last"
                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0 auto;padding-bottom:16px;padding-left:8px;padding-right:16px;padding-top:0;text-align:left;text-transform:uppercase;vertical-align:top;width:44.25px;word-wrap:break-word">
                        <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                            <tbody>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;hyphens:auto;letter-spacing:.06em;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:center;text-transform:uppercase;vertical-align:top;word-wrap:break-word">
                                    <a href="<?= $settings['facebook_networks_link'][2] ?>"
                                       style="color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><img
                                                src="<?= $homeUrl ?>/images/mails/icon-fb.png" alt="image"
                                                style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:inline-block;margin-top:21px;max-width:100%;outline:0;text-decoration:none;width:20px">
                                    </a><br>
                                    <a
                                            href="<?= $settings['instagram_networks_link'][2] ?>"
                                            style="color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><img
                                                src="<?= $homeUrl ?>/images/mails/icon-inst.png" alt="image"
                                                style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:inline-block;margin-top:21px;max-width:100%;outline:0;text-decoration:none;width:20px">
                                    </a><br>
                                    <a
                                            href="<?= $settings['youtube_networks_link'][2] ?>"
                                            style="color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><img
                                                src="<?= $homeUrl ?>/images/mails/icon-yt.png" alt="image"
                                                style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:inline-block;margin-top:21px;max-width:100%;outline:0;text-decoration:none;width:20px">
                                    </a>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    </th>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<div style="display:none;white-space:nowrap;font:15px courier;line-height:0">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
</div>
</body>
</html>
