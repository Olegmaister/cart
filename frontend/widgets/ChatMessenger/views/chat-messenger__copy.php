<style>
    .chat {
        font-family: Gilroy, sans-serif;
        font-size: 16px;
        font-weight: 400;
        line-height: 1.4;
        height: 100%;
        width: 100%;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        margin: 40px 100px;
        -ms-text-size-adjust: auto;
        -webkit-text-size-adjust: auto
    }

/**
    body {
        min-width: 320px;
        position: relative;
        overflow-x: hidden;
        padding: 0
    }

    body, figure {
        margin: 0
    }

*/

    img,
    a,
    button {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -ms-touch-action: pan-y;
        touch-action: pan-y;
        -webkit-tap-highlight-color: transparent;
    }

    img {
        max-width: 100%
    }

    .chat {
        position: fixed;
        right: 0;
        bottom: 40px;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background-color: #00a1ff;
        box-shadow: 0 5px 20px 0 rgba(0, 161, 255, .3);
        padding: 20px;
        cursor: pointer;
        transition: box-shadow .2s ease-in
    }

    @media (max-width: 500px) {
        .chat {
            right: 20px;
            bottom: 20px
        }
    }

    .chat:hover {
        box-shadow: 0 5px 20px 0 rgba(0, 161, 255, .7)
    }

    .chat:before {
        content: "Задать вопрос";
        display: block;
        width: 110px;
        font-size: 13px;
        padding: 10px;
        background: #fff;
        color: #2d2d2d;
        border-radius: 5px;
        line-height: 1.5;
        border: 1px solid #dbdbdb;
        box-shadow: 0 5px 20px 0 rgba(0, 0, 0, .3);
        position: absolute;
        top: -50px;
        right: 0;
        opacity: 1;
        transition: opacity .2s ease-in
    }

    .chat:after {
        content: "";
        border-style: solid;
        background: none;
        position: absolute;
        width: 0;
        height: 0;
        box-sizing: border-box;
        top: -12px;
        right: 12px;
        z-index: 0;
        border-width: 8px 8px 0;
        border-color: #fff transparent transparent
    }

    .chat.isOpen:before {
        opacity: 0
    }

    .chat__messenger {
        display: block;
        width: 210px;
        font-size: 13px;
        background: #fff;
        color: #2d2d2d;
        border-radius: 5px;
        line-height: 1.5;
        border: 1px solid #dbdbdb;
        box-shadow: 0 5px 20px 0 rgba(0, 0, 0, .3);
        position: absolute;
        top: -257px;
        right: 0;
        opacity: 0;
        pointer-events: none;
        transition: opacity .2s ease-in
    }

    .chat__messenger-item {
        font-size: 14px;
        padding: 10px;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        text-decoration: none;
        color: #2d2d2d;
        transition: background-color .2s ease-in
    }

    .chat__messenger-item:hover {
        background-color: #f3f3f3
    }

    .chat__messenger-icon {
        width: 20px;
        margin-right: 14px
    }

    .chat.isOpen .chat__messenger {
        opacity: 1;
        pointer-events: auto
    }

    .chat__icon {
        width: 100%;
        height: 100%;
        position: relative
    }

    .chat__icon-message {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transform: scale(1);
        transition: transform .2s ease-in, opacity .2s ease-in
    }

    .chat__icon-close, .isOpen .chat__icon-message {
        opacity: 0;
        transform: scale(0)
    }

    .chat__icon-close {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        transition: transform .2s ease-in, opacity .2s ease-in
    }

    .isOpen .chat__icon-close {
        opacity: 1;
        transform: scale(.6)
    }

    /*# sourceMappingURL=main.min.css.map */

</style>

<div class="chat js-chat">
    <div class="chat__messenger">

        <!-- E-mail -->
        <a href="mailto:info@prof1group.com" class="chat__messenger-item">
            <img src="https://www.ermakovlawyer.com/wp-content/themes/ermakovlawyer/image/email.svg" alt="icon E-mail" class="chat__messenger-icon">
            <span class="chat__messenger-name">Написать на E-mail</span>
        </a>

        <!-- Messenger -->
        <a href="http://m.me/prof1groupcompany" class="chat__messenger-item" target="_blank" rel="noopener">
            <img src="https://www.ermakovlawyer.com/wp-content/themes/ermakovlawyer/image/facebook.svg" alt="icon Facebook" class="chat__messenger-icon">
            <span class="chat__messenger-name">Написать в Messenger</span>
        </a>

        <!-- Viber -->
        <a href="viber://chat?number=+380506595979" class="chat__messenger-item">
            <img src="https://www.ermakovlawyer.com/wp-content/themes/ermakovlawyer/image/viber.svg" alt="icon Viber" class="chat__messenger-icon">
            <span class="chat__messenger-name">Написать в Viber</span>
        </a>
        <a href="skype:bb77eb6704f389f5?chat" class="chat__messenger-item">
            <img src="https://www.ermakovlawyer.com/wp-content/themes/ermakovlawyer/image/skype.svg" alt="icon Skype" class="chat__messenger-icon">
            <span class="chat__messenger-name">Написать в Skype</span>
        </a>

        <!-- Telegram -->
        <a href="tg://resolve?domain=Prof1_site" class="chat__messenger-item" target="_blank" rel="noopener">
            <img src="https://www.ermakovlawyer.com/wp-content/themes/ermakovlawyer/image/telegram.svg" alt="icon Telegram" class="chat__messenger-icon">
            <span class="chat__messenger-name">Написать в Telegram</span>
        </a>


        <!-- WhatsApp -->
        <a href="https://wa.me/+380506595979" class="chat__messenger-item" target="_blank" rel="noopener">
            <img src="https://www.ermakovlawyer.com/wp-content/themes/ermakovlawyer/image/whatsapp.svg" alt="icon WhatsApp" class="chat__messenger-icon">
            <span class="chat__messenger-name">Написать в WhatsApp</span>
        </a>
    </div>
    <div class="chat__icon">
        <img src="https://www.ermakovlawyer.com//wp-content/themes/ermakovlawyer/image/chat.svg" alt="icon live chat is open" class="chat__icon-message">
        <img src="https://www.ermakovlawyer.com//wp-content/themes/ermakovlawyer/image/cross.svg" alt="icon live chat is closed" class="chat__icon-close">
    </div>
</div>