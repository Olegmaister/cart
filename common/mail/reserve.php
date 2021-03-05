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
                    <?= Yii::t('app', 'reserve') ?> №<?= $data['order_id'] ?></h1>
                <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.47;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left"><?= $data['title'] ?></p>
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
                <h2 class="title-2"
                    style="Margin:0;Margin-bottom:10px;color:#000;font-family:Roboto,sans-serif;font-size:16px;font-weight:500;line-height:147%;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;text-transform:uppercase;word-wrap:normal">
                    <?= Yii::t('app', 'your order') ?></h2>
                <table class="product-table"
                       style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tbody>

                    <?php foreach ($data['product_list'] as $product): ?>
                        <tr class="product-table__item"
                            style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                            <td style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:2px solid #E9E9E9;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:20px;padding-left:0;padding-right:0;padding-top:20px;text-align:left;vertical-align:middle;word-wrap:break-word">
                                <img class="img-60"
                                     src="<?= $product['product_image'] ?>"
                                     alt="image"
                                     style="-ms-interpolation-mode:bicubic;clear:both;display:block;max-width:100%;min-width:60px;outline:0;text-decoration:none;width:60px">
                            </td>
                            <td class="product-table__center"
                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:2px solid #E9E9E9;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:20px;padding-left:20px;padding-right:0;padding-top:20px;text-align:left;vertical-align:middle;width:40%;word-wrap:break-word">
                                <strong class="strong-1 d-block"
                                        style="color:#1D2023;display:block;font-size:12px;font-weight:500;line-height:152%;text-transform:uppercase"><a href="<?= $product['link'] ?>"><?= $product['name'] ?></a></strong> <strong
                                        class="price-1"
                                        style="color:#EF1B1B;font-size:16px;font-weight:500"><small
                                            style="font-weight:400"><?= $data['currencySymbol'] ?></small> <?= $product['discount_price'] ?></strong>&nbsp;&nbsp;
                                <?php if ($product['discount_price'] !== $product['origin_price']): ?>
                                    <strong
                                            class="price-2"
                                            style="color:#BEBEBE;font-size:12px;letter-spacing:.06em;text-decoration:line-through">
                                        <small style="font-weight:400"><?= $data['currencySymbol'] ?></small> <?= $product['origin_price'] ?>
                                    </strong>
                                <?php endif; ?>
                            </td>
                            <td class="product-table__last"
                                style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-bottom:2px solid #E9E9E9;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:20px;padding-left:0;padding-right:0;padding-top:20px;text-align:right;vertical-align:middle;width:100%;word-wrap:break-word">
                                        <span class="size-32"
                                              style="border:1px solid #757575;color:#757575;display:inline-block;font-size:14px;height:30px;line-height:30px;margin:0 2px;text-align:center;text-transform:uppercase;vertical-align:middle;padding: 0 10px"><?= $product['option_name'] ?></span>
                                <img class="img-32" src="https://dev.p1gtac.com<?= $product['product_color_image'] ?>"
                                     alt="image"
                                     style="-ms-interpolation-mode:bicubic;clear:both;display:inline-block;height:32px!important;margin:0 2px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:32px!important">
                                <span class="quantity"
                                      style="border:2px solid #E9E9E9;color:#757575;display:inline-block;font-size:12px;font-weight:500;height:29px;line-height:29px;margin:0 2px;padding:0 8px;text-align:center;vertical-align:middle"><?= $product['quantity'] ?> <?= Yii::t('app', 'pc.') ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td colspan="3"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
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
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="spacer"
                       style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td height="16"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:16px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            &nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="row total"
                       style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <th class="small-6 large-4 columns first"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:10px;padding-left:16px;padding-right:8px;padding-top:0;text-align:left;vertical-align:bottom;width:225px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:bottom;word-wrap:break-word">
                                                    <span class="title-2"
                                                          style="color:#000;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= Yii::t('app', 'delivery') ?>:</span>
                                        <span class="price-1"
                                              style="color:#EF1B1B;font-size:16px;font-weight:500"><small
                                                style="font-weight:400"><?= $data['currencySymbol'] ?></small> <?= $data['delivery_cost'] ?></span>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </th>
                        <th class="small-6 large-4 columns"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:10px;padding-left:8px;padding-right:8px;padding-top:0;text-align:left;vertical-align:bottom;width:225px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:bottom;word-wrap:break-word">
                                                    <span class="title-2"
                                                          style="color:#000;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= Yii::t('app', 'discount') ?>:</span>
                                        <span class="price-1"
                                              style="color:#EF1B1B;font-size:16px;font-weight:500"><small
                                                style="font-weight:400"><?= $data['currencySymbol'] ?></small> <?= $data['discount_value'] ?></span>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </th>
                        <th class="small-12 large-4 columns last"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:10px;padding-left:8px;padding-right:16px;padding-top:0;text-align:left;vertical-align:bottom;width:225px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:bottom;word-wrap:break-word">
                                                    <span class="title-2"
                                                          style="color:#000;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= Yii::t('app', 'sum') ?>:</span>
                                        <span class="price-1 price-large"
                                              style="color:#EF1B1B;font-size:30px;font-weight:500;line-height:1"><small
                                                style="font-size:60%;font-weight:400"><?= $data['currencySymbol'] ?></small> <?= $data['total_cost'] ?></span>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </th>
                    </tr>
                    </tbody>
                </table>
                <hr style="border-top:1px solid #E9E9E9;bottom:0">
                <table class="spacer"
                       style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td height="60"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:60px;font-weight:400;hyphens:auto;line-height:60px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            &nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="row collapse"
                       style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <th class="small-12 large-6 columns first"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:16px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:369.5px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                    <span class="title-2"
                                                          style="color:#000;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= Yii::t('app', 'recipient details') ?>:</span>
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
                                        <p class="text-muted"
                                           style="Margin:0;Margin-bottom:10px;color:#757575;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.47;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left">
                                            <?= Yii::t('app', 'Full name') ?>: <?= $data['customer_name'] ?><br>
                                            <?= Yii::t('app', 'Phone') ?>: <?= $data['phone'] ?><br>
                                            E-mail: <?= $data['email'] ?>
                                        </p>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </th>
                        <th class="small-12 large-6 columns last"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:16px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:369.5px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                    <span class="title-2"
                                                          style="color:#000;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= Yii::t('app', 'delivery') ?>:</span>
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
                                        <p class="text-muted"
                                           style="Margin:0;Margin-bottom:10px;color:#757575;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.47;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left">
                                            <?= $data['shop_city'] ?>, <?= $data['shop_address'] ?>
                                        </p>
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
                        <td height="30"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:30px;font-weight:400;hyphens:auto;line-height:30px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            &nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="row collapse"
                       style="border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <th class="small-12 large-6 columns first"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:16px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:369.5px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                    <span class="title-2"
                                                          style="color:#000;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= Yii::t('app', 'Order status') ?>:</span>
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
                                        <p class="text-muted"
                                           style="Margin:0;Margin-bottom:10px;color:#757575;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.47;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left"><?= $data['order_status'] ?></p></th>
                                </tr>
                                </tbody>
                            </table>
                        </th>
                        <th class="small-12 large-6 columns last"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0 auto;padding-bottom:16px;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:369.5px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:1.47;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                    <span class="title-2"
                                                          style="color:#000;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= Yii::t('app', 'Payment method') ?>:</span>
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
                                        <p class="text-muted"
                                           style="Margin:0;Margin-bottom:10px;color:#757575;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;line-height:1.47;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left"><?= $data['payment_type'] ?></p>
                                        <?php if (false): ?>
                                            <a href="#" class="faktura"
                                               style="color:#EF1B1B;font-family:Roboto,sans-serif;font-size:12px;font-weight:500;letter-spacing:.06em;line-height:132%;padding:0;text-align:left;text-decoration:none;text-transform:uppercase">СКАЧАТЬ
                                                СЧЕТ ФАКТУРУ&nbsp;&nbsp;<img class="icon-down"
                                                                             src="https://dev.p1gtac.com/images/mails/icon-down.png"
                                                                             alt
                                                                             style="-ms-interpolation-mode:bicubic;border:none;clear:both;display:inline-block;height:20px;margin-top:-3px;max-width:100%;outline:0;text-decoration:none;vertical-align:middle;width:20px">
                                            </a>
                                        <?php endif; ?>
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
                        <td height="50"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:50px;font-weight:400;hyphens:auto;line-height:50px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            &nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php if (!empty($data['comment'])): ?>
                    <span class="title-2"
                          style="color:#000;font-size:16px;font-weight:500;line-height:147%;text-transform:uppercase"><?= Yii::t('app', 'Order comment') ?>:</span>
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
                    <p class="text-muted fz-14"
                       style="Margin:0;Margin-bottom:10px;color:#757575;font-family:Roboto,sans-serif;font-size:14px;font-weight:400;line-height:1.47;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left">
                        <?= $data['comment'] ?>
                    </p>
                <?php endif; ?>
                <table class="spacer"
                       style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <td height="50"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:50px;font-weight:400;hyphens:auto;line-height:50px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                            &nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="row warning-1"
                       style="background:#1D2023;border-collapse:collapse;border-spacing:0;display:table;padding:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;position:relative;text-align:left;vertical-align:top;width:100%">
                    <tbody>
                    <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                        <th class="small-12 large-2 columns first"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:160%;margin:0 auto;padding-bottom:16px;padding-left:16px;padding-right:8px;padding-top:23px;text-align:left;vertical-align:middle;width:104.5px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:160%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                        <center style="min-width:72.5px;width:100%"><img
                                                src="https://dev.p1gtac.com/images/mails/icon-warning.png"
                                                alt="logo" align="center" class="float-center"
                                                style="-ms-interpolation-mode:bicubic;Margin:0 auto;clear:both;display:block;float:none;margin:0 auto;max-width:100%;outline:0;text-align:center;text-decoration:none;width:auto">
                                        </center>
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </th>
                        <th class="small-12 large-10 columns last"
                            style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0 auto;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:160%;margin:0 auto;padding-bottom:16px;padding-left:8px;padding-right:16px;padding-top:23px;text-align:left;vertical-align:middle;width:586.5px;word-wrap:break-word">
                            <table style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                <tbody>
                                <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                    <th style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#fff;font-family:Roboto,sans-serif;font-size:16px;font-weight:400;hyphens:auto;line-height:160%;margin:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                    <span class="title-2"
                                                          style="color:#fff;font-size:16px;font-weight:500;line-height:160%;text-transform:uppercase"><?= Yii::t('app', 'IMPORTANT INFORMATION') ?>:</span>
                                        <table class="spacer"
                                               style="border-collapse:collapse;border-spacing:0;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;width:100%">
                                            <tbody>
                                            <tr style="padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top">
                                                <td height="15"
                                                    style="-moz-hyphens:auto;-webkit-hyphens:auto;Margin:0;border-collapse:collapse!important;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:15px;font-weight:400;hyphens:auto;line-height:15px;margin:0;mso-line-height-rule:exactly;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left;vertical-align:top;word-wrap:break-word">
                                                    &nbsp;
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <p class="fz-14"
                                           style="Margin:0;Margin-bottom:10px;color:#fff;font-family:Roboto,sans-serif;font-size:14px;font-weight:400;line-height:160%;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left">
                                            <?= $data['additional_text'] ?>
                                        </p>
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
</center>
<?= $this->render('partials/mail-footer') ?>
