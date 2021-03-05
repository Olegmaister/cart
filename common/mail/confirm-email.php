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
                    <?= Yii::t('app', 'Confirmation code') ?>
                </h1>
                <p style="Margin:0;Margin-bottom:10px;color:#0a0a0a;font-family:Roboto,sans-serif;font-size:24px;font-weight:400;line-height:1.47;margin:0;margin-bottom:10px;padding-bottom:0;padding-left:0;padding-right:0;padding-top:0;text-align:left">
                    <?= $data['code'] ?>
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</center>
<?= $this->render('partials/mail-footer') ?>
