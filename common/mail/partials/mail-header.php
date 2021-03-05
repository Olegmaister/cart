<?php

use common\helpers\LanguageHelper;
use frontend\services\ProductService;
use frontend\repositories\ProductRepository;

$querySettings = ProductRepository::getSettingsByGroup(['sub_group' => 'main']);
$settings = ProductService::getGroupedSettings($querySettings);
$homeUrl = Yii::$app->params['homeUrl'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="background:#fff!important">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?= isset($title) ? $title : 'Заказ №4345' ?></title>
    <style>@media only screen {
            html {
                min-height: 100%;
                background: #f3f3f3
            }
        }

        @media only screen and (max-width: 739px) {
            .small-float-center {
                margin: 0 auto !important;
                float: none !important;
                text-align: center !important
            }
        }

        @media only screen and (max-width: 739px) {
            table.body img {
                width: auto;
                height: auto
            }

            table.body center {
                min-width: 0 !important
            }

            table.body .container {
                width: 95% !important
            }

            table.body .columns {
                height: auto !important;
                -moz-box-sizing: border-box;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                padding-left: 16px !important;
                padding-right: 16px !important
            }

            table.body .columns .columns {
                padding-left: 0 !important;
                padding-right: 0 !important
            }

            table.body .collapse .columns {
                padding-left: 0 !important;
                padding-right: 0 !important
            }

            th.small-6 {
                display: inline-block !important;
                width: 50% !important
            }

            th.small-12 {
                display: inline-block !important;
                width: 100% !important
            }

            .columns th.small-12 {
                display: block !important;
                width: 100% !important
            }

            table.menu {
                width: 100% !important
            }

            table.menu td, table.menu th {
                width: auto !important;
                display: inline-block !important
            }

            table.menu.vertical td, table.menu.vertical th {
                display: block !important
            }

            table.menu[align=center] {
                width: auto !important
            }
        }

        @media only screen and (max-width: 739px) {
            table.header .columns {
                padding-top: 15px;
                padding-bottom: 15px
            }
        }

        @media only screen and (min-width: 739px) {
            table.header .header-center {
                width: 290px !important;
                padding-left: 40px !important
            }
        }

        @media only screen and (min-width: 739px) {
            table.header .last {
                padding-left: 40px !important
            }
        }

        @media only screen and (min-width: 739px) {
            table.footer .large-3, table.footer .large-4 {
                padding-top: 33px !important;
                padding-bottom: 32px !important
            }
        }

        @media only screen and (min-width: 739px) {
            table.footer .large-4.first {
                width: 228px !important;
                padding-left: 30px !important
            }
        }

        @media only screen and (min-width: 739px) {
            table.footer .footer-middle {
                padding-left: 30px !important
            }
        }

        @media only screen and (min-width: 739px) {
            table.footer .footer-contacts {
                padding-left: 30px !important
            }
        }

        @media only screen and (min-width: 739px) {
            table.footer .large-1 {
                padding-left: 20px !important
            }
        }

        @media only screen and (min-width: 739px) {
            .total .last th {
                text-align: right !important
            }
        }

        @media only screen and (max-width: 739px) {
            .special th.first {
                padding-left: 0 !important;
                padding-right: 8px !important
            }
        }

        @media only screen and (max-width: 739px) {
            .special th.last {
                padding-right: 0 !important;
                padding-left: 8px !important
            }
        }

        @media only screen and (max-width: 739px) {
            .special-grid {
                border-collapse: collapse;
                border-spacing: 0
            }
        }

        @media only screen and (max-width: 739px) {
            .special-grid > tbody > tr > td {
                display: inline-block !important;
                width: 50% !important;
                box-sizing: border-box;
                border: 0;
                padding: 8px !important
            }
        }

        @media only screen and (max-width: 739px) {
            .container-1 {
                width: 95% !important
            }
        }

        @media only screen and (max-width: 739px) {
            .news-big .news-title {
                border-spacing: 15px
            }
        }

        @media only screen and (max-width: 739px) {
            .product-1 > tbody > tr > .columns {
                padding: 15px 20px !important
            }
        }

        @media only screen and (max-width: 739px) {
            .table-news {
                border-spacing: 0
            }
        }

        @media only screen and (max-width: 739px) {
            .table-news > tbody > tr > td {
                display: inline-block !important;
                width: 100% !important;
                box-sizing: border-box;
                border: 0;
                padding-bottom: 20px !important
            }
        }

        @media only screen and (min-width: 739px) {
            .percent-align > tbody > tr > th.columns {
                padding: 0 !important
            }
        }

        @media only screen and (max-width: 739px) {
            .product-1__prices > tbody > tr > td {
                padding-right: 20px !important
            }
        }</style>
</head>
<body style="-moz-box-sizing:border-box;-ms-text-size-adjust:100%;-webkit-box-sizing:border-box;-webkit-text-size-adjust:100%;Margin:0;background:#fff!important;box-sizing:border-box;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.47;margin:0;min-width:100%;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;width:100%!important">
<span class="preheader"
      style="color:#f3f3f3;display:none!important;font-size:1px;line-height:1px;max-height:0;max-width:0;mso-hide:all!important;opacity:0;overflow:hidden;visibility:hidden"></span>
<table class="body"
       style="Margin:0;background:#fff!important;border-collapse:collapse;border-spacing:0;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;height:100%;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
        <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
            <table align="center" class="container header"
                   style="Margin:0 auto;background:#1D2023;border-collapse:collapse;border-spacing:0;margin:0 auto;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:inherit;vertical-align:top;width:723px">
                <tbody>
                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                    <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                        <table class="row"
                               style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                            <tbody>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <th class="small-12 large-4 columns first"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;border-right:1px solid #3a3a3a;color:#fff;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:152%;margin:0 auto;padding-bottom:20px;padding-left:16px;padding-right:8px;padding-top:20px;text-align:left;vertical-align:middle;width:225px;word-wrap:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                            <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:middle;word-wrap:break-word">
                                                <?php /* Yii::$app->request->hostInfo */ ?>
                                                <a href="<?= $homeUrl ?><?= LanguageHelper::langUrl('') ?>"
                                                   style="color:#fff;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none">
                                                    <center style="min-width:193px;width:100%"><img
                                                                src="<?= $homeUrl ?>/images/footer/logo_<?= Yii::$app->language ?>.png" alt="PROF1Group"
                                                                align="center" class="float-center"
                                                                style="-ms-interpolation-mode:bicubic;Margin:0 auto;border:none;clear:both;display:inline-block;float:none;margin:0 auto;max-width:100%;outline:0;text-align:center;text-decoration:none;width:auto">
                                                    </center>
                                                </a></th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </th>
                                <th class="header-center small-12 large-4 columns"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;border-right:1px solid #3a3a3a;color:#fff;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:152%;margin:0 auto;padding-bottom:20px;padding-left:8px;padding-right:8px;padding-top:20px;text-align:left;vertical-align:middle;width:225px;word-wrap:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                            <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:middle;word-wrap:break-word">
                                                <span class="header-title"
                                                      style="font-size:14px;font-weight:500;line-height:147%"><?= Yii::t('app', 'ONLINE STORE OF MILITARY CLOTHING AND EQUIPMENT') ?></span>
                                                <table class="spacer"
                                                       style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                    <tbody>
                                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                        <td height="10"
                                                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:10px;font-weight:400;hyphens:auto;line-height:10px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                            &nbsp;
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?php /* Yii::$app->request->hostInfo */ ?>
                                                <a href="<?= $homeUrl ?><?= LanguageHelper::langUrl('') ?>" class="header-link"
                                                   style="color:#6AA9CC;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none">www.prof1group.ua</a>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </th>
                                <th class="small-12 large-4 columns last"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;border-right:1px solid #3a3a3a;color:#fff;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:152%;margin:0 auto;padding-bottom:20px;padding-left:8px;padding-right:16px;padding-top:20px;text-align:left;vertical-align:middle;width:225px;word-wrap:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                            <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:12px;font-weight:400;hyphens:auto;line-height:152%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:middle;word-wrap:break-word">
                                                <?php foreach ($querySettings as $setting): ?>
                                                    <?php if (isset($setting['group_name']) && $setting['group_name'] == 'phone_sales'): ?>
                                                        <a href="#" style="color:#fff;font-family:Roboto,sans-serif;font-size:11px;font-weight:500;letter-spacing:.06em;line-height:152%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase"><?= $setting['value'] ?></a><br>
                                                    <?php endif ?>
                                                <?php endforeach ?><br>

                                                <strong
                                                        style="font-size:12px;letter-spacing:.06em;text-transform:uppercase">
                                                    <?= $settings['working'][LanguageHelper::getCurrentId()] ?>
                                                </strong>

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
