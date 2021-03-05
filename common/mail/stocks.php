<?php

/**
 * @var \backend\models\MailStocks[] $mailStockModel
 */

use common\entities\UrlAlias;
use yii\helpers\Url;

$mailStocksList = $data['mailStockModel']->mailStocksList;
$mailStocksListCount = count($mailStocksList);
$homeUrl = Yii::$app->params['homeUrl'];
?>

<?= $this->render('partials/mail-header') ?>

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

        th.small-2 {
            display: inline-block !important;
            width: 16.66667% !important
        }

        th.small-3 {
            display: inline-block !important;
            width: 25% !important
        }

        th.small-6 {
            display: inline-block !important;
            width: 50% !important
        }

        th.small-9 {
            display: inline-block !important;
            width: 75% !important
        }

        th.small-10 {
            display: inline-block !important;
            width: 83.33333% !important
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
            padding-bottom: 32px !important;
            border-right: 1px solid #565656
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
        table.footer .large-1 img {
            margin-top: 21px !important
        }
    }

    @media only screen and (min-width: 739px) {
        .product-table__last .last th {
            text-align: right !important
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

<center style="min-width:723px;width:100%">
    <table align="center" class="container float-center"
           style="Margin:0 auto;background:#fefefe;border-collapse:collapse;border-spacing:0;float:none;margin:0 auto;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:center;vertical-align:top;width:723px">
        <tbody>
        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
            <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                <table class="spacer"
                       style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td height="40"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:40px;font-weight:400;hyphens:auto;line-height:40px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            &nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
                <h1 class="title-1"
                    style="Margin:0;Margin-bottom:10px;color:#EF1B1B;font-family:Roboto,sans-serif;font-size:22px;font-weight:500;letter-spacing:.06em;line-height:147%;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;word-wrap:normal">
                    <?= $data['title'] ?>
                </h1>
                <?php foreach ($mailStocksList as $key => $stock): ?>
                    <table class="spacer"
                           style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                        <tbody>
                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                            <td height="20"
                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:20px;font-weight:400;hyphens:auto;line-height:20px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                &nbsp;
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?php if ($mailStocksListCount === 1 || $key % 3 === 0): ?>
                        <a href="<?= Url::to('/' . isset($stock->stock->slug->keyword)) ? $stock->stock->slug->keyword : "#" ?>"
                           style="color:#EF1B1B;font-family:Roboto,sans-serif;font-weight:400;line-height:1.47;padding:0;text-align:left;text-decoration:none"><img
                                    class="w-100" src="<?= $stock->stock->photo ? $stock->stock->photo->getThumbFileUrl('file', 'slider') :  $homeUrl . '/images/mails/1.png' ?>" alt="image"
                                    style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:100%!important">
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
                            <span class="title-2 bg-red"
                                  style="background:#EF1B1B;color:#fff;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= $stock->stock->description->heading ?></span><br><span
                                    class="strong-1 fz-20"
                                    style="color:#1D2023;font-size:20px!important;font-weight:500;line-height:152%;text-transform:uppercase"><?= Yii::t('app', 'Promotion period') ?> <span
                                        class="text-red"
                                        style="color:#EF1B1B"><?= Yii::t('app', 'from') ?> <?= date('Y-m-d', $stock->stock->date_from) ?> <?= Yii::t('app', 'to') ?> <?=  date('Y-m-d', $stock->stock->date_to) ?></span></span>
                        </a>
                    <?php else: ?>
                        <table class="row special"
                               style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                            <tbody>
                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                <th class="small-6 large-6 columns first"
                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:16px;padding-left:0!important;padding-right:15px!important;padding-top:0;text-align:left;vertical-align:top;width:345.5px;word-wrap:break-word">
                                    <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                        <tbody>
                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                            <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                <a href="<?= Url::to('/' . isset($stock->stock->slug->keyword)) ? $stock->stock->slug->keyword : "#" ?>"
                                                   style="color:#EF1B1B;font-family:Roboto,sans-serif;font-weight:400;line-height:1.47;padding:0;text-align:left;text-decoration:none"><img
                                                            class="w-100"
                                                            src="<?= $stock->stock->photo ? $stock->stock->photo->getThumbFileUrl('file', 'slider') :  $homeUrl . '/images/mails/1.png' ?>"
                                                            alt="image"
                                                            style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:100%!important">
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
                                                    <span class="title-2 bg-red"
                                                          style="background:#EF1B1B;color:#fff;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= $stock->stock->description->heading ?></span><br><span
                                                            class="strong-1 fz-20"
                                                            style="color:#1D2023;font-size:20px!important;font-weight:500;line-height:152%;text-transform:uppercase"><?= Yii::t('app', 'Promotion period') ?> <span
                                                                class="text-red"
                                                                style="color:#EF1B1B"><?= Yii::t('app', 'from') ?> <?= date('Y-m-d', $stock->stock->date_from) ?> <?= Yii::t('app', 'to') ?> <?=  date('Y-m-d', $stock->stock->date_to) ?></span></span></a>
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </th>
<!--                                <th class="small-6 large-6 columns last"-->
<!--                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:16px;padding-left:15px!important;padding-right:0!important;padding-top:0;text-align:left;vertical-align:top;width:345.5px;word-wrap:break-word">-->
<!--                                    <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">-->
<!--                                        <tbody>-->
<!--                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">-->
<!--                                            <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">-->
<!--                                                <a href="#"-->
<!--                                                   style="color:#EF1B1B;font-family:Roboto,sans-serif;font-weight:400;line-height:1.47;padding:0;text-align:left;text-decoration:none"><img-->
<!--                                                            class="w-100"-->
<!--                                                            src="--><?//= $stock->stock->photo->getThumbFileUrl('file', 'slider')  ?><!--"-->
<!--                                                            alt="image"-->
<!--                                                            style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:block;max-width:100%;outline:0;text-decoration:none;width:100%!important">-->
<!--                                                    <table class="spacer"-->
<!--                                                           style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">-->
<!--                                                        <tbody>-->
<!--                                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">-->
<!--                                                            <td height="10"-->
<!--                                                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:10px;font-weight:400;hyphens:auto;line-height:10px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">-->
<!--                                                                &nbsp;-->
<!--                                                            </td>-->
<!--                                                        </tr>-->
<!--                                                        </tbody>-->
<!--                                                    </table>-->
<!--                                                    <span class="title-2 bg-red"-->
<!--                                                          style="background:#EF1B1B;color:#fff;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase">--><?//= $stock->stock->description->heading ?><!--</span><br><span-->
<!--                                                            class="strong-1 fz-20"-->
<!--                                                            style="color:#1D2023;font-size:20px!important;font-weight:500;line-height:152%;text-transform:uppercase">--><?//= Yii::t('app', 'Promotion period') ?><!-- <span-->
<!--                                                                class="text-red"-->
<!--                                                                style="color:#EF1B1B">--><?//= Yii::t('app', 'from') ?><!-- --><?//= date('Y-m-d', $stock->stock->date_from) ?><!-- --><?//= Yii::t('app', 'to') ?><!-- --><?//=  date('Y-m-d', $stock->stock->date_to) ?><!--</span></span></a>-->
<!--                                            </th>-->
<!--                                        </tr>-->
<!--                                        </tbody>-->
<!--                                    </table>-->
<!--                                </th>-->
                            </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                    <table class="spacer"
                           style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                        <tbody>
                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                            <td height="20"
                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:20px;font-weight:400;hyphens:auto;line-height:20px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                &nbsp;
                            </td>
                        </tr>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </td>
        </tr>
        </tbody>
    </table>
</center>
<?= $this->render('partials/mail-footer') ?>
