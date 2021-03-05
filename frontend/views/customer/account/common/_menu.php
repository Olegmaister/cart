<?php

use common\helpers\LanguageHelper;
// use frontend\widgets\Customer\AvatarWidget;
/**@var \common\entities\Customer $customer **/

?>

<style>
    .customer-active{
        color:red;
    }
   #upload_avatar>input {
        display: none;
    }
</style>

<script>
    function onFileSelected(event) {
        var selectedFile = event.target.files[0];
        var reader = new FileReader();
        var imgtag = document.getElementById("my_image");
        imgtag.title = selectedFile.name;

        reader.onload = function(event) {
            imgtag.src = event.target.result;
        };

        reader.readAsDataURL(selectedFile);
        var formData = new FormData($('#upload_avatar')[0]);

        $.ajax({
            url: '/account/upload-avatar',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);

            }
        });
    }
</script>

<div class="account-menu-top">
    <div class="account-user-info">
        <div class="account-user-info-media image-upload">
            <img src="<?= $customer->profile->avatar ? '/images/avatar/' . $customer->profile->avatar : '/images/foto.png' ?>" style="pointer-events: none" class="account-user-info__avatar __avatar" id="my_image"/>

            <form id="upload_avatar" action="/account/account/upload-avatar" method="post" enctype="multipart/form-data">
                <input type="hidden"  name="customer_id" value="<?= $customer->customer_id ?>" />

                <label for="myimage">
                    <i class="account-user-info__hover-img">
                        <svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><g class="_path" clip-path="url(#clip0)"><path d="M9 13.5A3.75 3.75 0 109 6a3.75 3.75 0 000 7.5z"/><path d="M16.5 3.75h-2.379c-.3 0-.582-.117-.795-.33l-1.371-1.37a1.863 1.863 0 00-1.326-.55H7.37c-.5 0-.971.195-1.326.55l-1.37 1.37c-.213.213-.496.33-.796.33H1.5c-.827 0-1.5.673-1.5 1.5V15c0 .827.673 1.5 1.5 1.5h15c.827 0 1.5-.673 1.5-1.5V5.25c0-.827-.673-1.5-1.5-1.5zM9 14.25a4.505 4.505 0 01-4.5-4.5c0-2.481 2.019-4.5 4.5-4.5s4.5 2.019 4.5 4.5-2.019 4.5-4.5 4.5zm6-6.75A.751.751 0 0115 6a.751.751 0 010 1.5z"/></g><defs><clipPath id="clip0"><path class="_path" d="M0 0h18v18H0z"/></clipPath></defs></svg>
                    </i>
                </label>

                <?php /*if($active == 'account') : */ ?>
                    <input id="myimage" type="file"  onchange="onFileSelected(event)" name="Profile[imageFile]" accept="image/*" />
                <?php /* endif */ ?>
            </form>
        </div>

        <div class="account-user-info__name">
            <span><?=$customer->fullName()?></span>
        </div>
    </div>
</div>

<nav class="account-menu__nav">
    <ul>
        <li><a class="<?php if($active == 'account') echo 'customer-active'?>" href="<?=LanguageHelper::langUrl('account/account')?>"><?= Yii::t('app', 'common') ?> <?= Yii::t('app', 'information') ?></a></li>
        <li><a class="<?php if($active == 'wishlist') echo 'customer-active'?>" href="<?=LanguageHelper::langUrl('account/wishlist')?>"><?= Yii::t('app', 'favorites') ?></a></li>
        <li><a class="<?php if($active == 'order') echo 'customer-active'?>" href="<?=LanguageHelper::langUrl('account/order')?>"><?= Yii::t('app', 'your') ?> <?= Yii::t('app', 'orders') ?></a></li>
        <li><a class="<?php if($active == 'reserve') echo 'customer-active'?>" href="<?=LanguageHelper::langUrl('account/reserve')?>"><?= Yii::t('app', 'your') ?> <?= Yii::t('app', 'reserves') ?></a></li>
        <li><a class="<?php if($active == 'accumulative') echo 'customer-active'?>" href="<?=LanguageHelper::langUrl('account/accumulative')?>"><?= Yii::t('app', 'accumulative discount') ?></a></li>
        <?php if (defined('IS_DEV')): ?>
            <li><a class="<?php if($active == 'only') echo 'customer-active'?>" href="<?=LanguageHelper::langUrl('account/only-for-you')?>"><?= Yii::t('app', 'only for you') ?></a></li>
        <?php endif ?>
        <li class="d-none <?php if($active == 'bulk-orders') echo 'customer-active'?>"><a href="<?=LanguageHelper::langUrl('account/bulk-orders')?>"><?= Yii::t('app', 'wholesale orders') ?></a></li>
        <?php if (defined('IS_DEV')): ?>
            <li><a class="<?php if($active == 'reviews') echo 'customer-active'?>" href="<?=LanguageHelper::langUrl('account/reviews')?>"><?= Yii::t('app', 'your') ?> <?= Yii::t('app', 'reviews') ?></a></li>
        <?php endif ?>
        <li><a href="<?=LanguageHelper::langUrl('logout')?>"><?= Yii::t('app', 'exit') ?></a></li>
    </ul>
</nav>
