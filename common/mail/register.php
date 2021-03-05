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
                    <?= Yii::t('app', 'Registration on the site') ?> prof1group.ua</h1>
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
                <hr style="border-top:1px solid #E9E9E9;bottom:0">
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
                <strong class="strong-1"
                        style="color:#1D2023;font-size:12px;font-weight:500;line-height:152%;text-transform:uppercase"><?= Yii::t('app', 'Your mail') ?>:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="text-muted"
                                                                              style="color:#757575"><?= $data['email'] ?></span>
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
                <strong class="strong-1"
                        style="color:#1D2023;font-size:12px;font-weight:500;line-height:152%;text-transform:uppercase"><?= Yii::t('app', 'Your phone') ?>:</strong>&nbsp;&nbsp;&nbsp;&nbsp; <span class="text-muted"
                                                                    style="color:#757575"><?= $data['phone'] ?></span>
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
                <strong class="strong-1"
                        style="color:#1D2023;font-size:12px;font-weight:500;line-height:152%;text-transform:uppercase"><?= Yii::t('app', 'Your password') ?>:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="text-muted"
                                                                               style="color:#757575"><?= $data['password'] ?></span>
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
                <hr style="border-top:1px solid #E9E9E9;bottom:0">
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
                <strong class="strong-1"
                        style="color:#1D2023;font-size:12px;font-weight:500;line-height:152%;text-transform:uppercase"><?= Yii::t('app', 'Link to enter the personal account on the site') ?>:</strong> <a href="#" class="link-1"
                                                                     style="color:#6AA9CC;font-family:Roboto,sans-serif;font-weight:400;line-height:1.47;padding:0;text-align:left;text-decoration:none">(ссылка
                    на вход)</a>
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
                    <?= Yii::t('app', 'You can change the password in the user\'s personal account') ?></p>
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
</center>
<?= $this->render('partials/mail-footer') ?>