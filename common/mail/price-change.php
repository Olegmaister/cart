<?php

/**
 * @var Product $product
 */

use common\entities\Products\Product;
use common\helpers\LanguageHelper;

?>
<?= $this->render('partials/mail-header') ?>
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
                    <?= Yii::t('app', 'Product availability') ?>
                </h1>
                <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.47;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left">
                    <?= $data['title'] ?>
                </p>
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
                <table class="row product-1 dark-prices"
                       style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <th class="small-12 large-12 columns first last"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border:2px solid #eee;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding:30px 20px!important;padding-bottom:16px;padding-left:16px;padding-right:16px;padding-top:0;text-align:left;vertical-align:middle;width:707px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                        <table class="row"
                                               style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                                            <tbody>
                                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                <th class="small-12 large-5 columns first"
                                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:0!important;padding-left:0!important;padding-right:8px;padding-top:0;text-align:center;vertical-align:middle;width:41.66667%;word-wrap:break-word">
                                                    <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                        <tbody>
                                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                            <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                                <img src="https://dev.p1gtac.com/images/products/import_files/00004017/ce3a52ad5c0f11e980bc005056807e63_ce3a52ae5c0f11e980bc005056807e63-228x228.jpg"
                                                                     alt="image"
                                                                     style="-ms-interpolation-mode:bicubic;clear:both;display:block;margin:auto;max-width:100%;outline:0;text-decoration:none;width:170px">
                                                            </th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </th>
                                                <th class="small-12 large-7 columns last"
                                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:0!important;padding-left:8px;padding-right:0!important;padding-top:0;text-align:left;vertical-align:middle;width:58.33333%;word-wrap:break-word">
                                                    <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                        <tbody>
                                                        <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                            <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                                <a href="<?= 'https://dev.p1gtac.com/' . LanguageHelper::langUrl(($data['product'])->url->keyword) ?>" class="title-2"
                                                                   style="color:#000;font-family:Roboto,sans-serif;font-size:16px;font-weight:500;line-height:147%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase">
                                                                    <?= ($data['product'])->description->name ?>
                                                                </a>
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
                                                                <table class="product-1__prices"
                                                                       style="background:#1D2023;border-collapse:separate;border-spacing:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:auto!important">
                                                                    <tbody>
                                                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                                        <td class="td-border-right"
                                                                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;border-right:1px solid #505050;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:10px;padding-right:20px;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                                                        <span class="strong-1"
                                                                                              style="color:#fff;font-size:12px;font-weight:500;line-height:152%;text-transform:uppercase"><?= Yii::t('app', 'New price') ?></span>
                                                                            <table class="spacer"
                                                                                   style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                                                <tbody>
                                                                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                                                    <td height="4"
                                                                                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:4px;font-weight:400;hyphens:auto;line-height:4px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                                                        &nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <strong class="price-1"
                                                                                    style="color:#EF1B1B;font-size:16px;font-weight:500"><small
                                                                                        style="font-weight:400"><?= $data['currencySymbol'] ?></small>
                                                                                <?= $data['newPrice'] ?>
                                                                            </strong>&nbsp;&nbsp;
                                                                        </td>
                                                                        <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:10px;padding-right:10px;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                                                        <span class="strong-1"
                                                                                              style="color:#fff;font-size:12px;font-weight:500;line-height:152%;text-transform:uppercase"><?= Yii::t('app', 'Old price') ?></span>
                                                                            <table class="spacer"
                                                                                   style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                                                <tbody>
                                                                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                                                    <td height="7"
                                                                                        style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:7px;font-weight:400;hyphens:auto;line-height:7px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                                                        &nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <strong class="price-2"
                                                                                    style="color:#BEBEBE;font-size:12px;letter-spacing:.06em;text-decoration:line-through"><small
                                                                                        style="font-weight:400"><?= $data['currencySymbol'] ?></small>
                                                                                <?= $data['oldPrice'] ?>
                                                                            </strong></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="spacer"
                                                                       style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                                    <tbody>
                                                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                                        <td height="25"
                                                                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:25px;font-weight:400;hyphens:auto;line-height:25px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                                            &nbsp;
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table class="button button-2"
                                                                       style="Margin:0;border-collapse:collapse;border-spacing:0;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:auto">
                                                                    <tbody>
                                                                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                                        <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:center;vertical-align:top;word-wrap:break-word">
                                                                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                                                                <tbody>
                                                                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                                                    <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;background:#EF1B1B;border:2px solid #EF1B1B;border-collapse:collapse!important;color:#fefefe;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                                                        <a href="<?= 'https://dev.p1gtac.com/' . LanguageHelper::langUrl(($data['product'])->url->keyword) ?>"
                                                                                           style="border:0 solid #EF1B1B;border-radius:3px;color:#fefefe;display:inline-block;font-family:Roboto,sans-serif;font-size:12px!important;font-weight:700;line-height:1.47;padding:8px 16px!important;text-align:left;text-decoration:none;text-transform:uppercase">
                                                                                            <?= Yii::t('app', 'Buy product') ?>
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
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
                                </tr>
                                </tbody>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <table class="spacer"
                       style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td height="45"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:45px;font-weight:400;hyphens:auto;line-height:45px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            &nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</center>
<?= $this->render('partials/mail-footer') ?>