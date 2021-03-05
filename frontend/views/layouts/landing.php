<?php

\frontend\assets\LandingAsset::register($this);

// Добавляем заголовки LastModified (по умолчаиню -1 день)
\frontend\services\SEOSarvice::setHeaderLastModified();

$this->beginPage()

?>
<?= $this->render('_header'); ?>
<body>
<header id="header">
    <div class="container-fluid">
        <div class="row align-items-center flex-nowrap">
            <div class="col-auto mr-auto flex-shrink-1">
                <a href="/" id="logo"><img loading="lazy" src="http://p1g.alex-d.xyz/img/logo.svg" alt="logo"></a>
            </div>
            <div class="col d-none d-lg-block">
                <nav class="row justify-content-end">
                    <div class="col-auto"><a href="#" class="nav-item">Видео</a></div>
                    <div class="col-auto"><a href="#" class="nav-item">Достоинства</a></div>
                    <div class="col-auto"><a href="#" class="nav-item">Фото</a></div>
                    <div class="col-auto"><a href="#" class="nav-item">Обзор</a></div>
                    <div class="col-auto"><a href="#" class="nav-item">Описание</a></div>
                </nav>
            </div>
            <div class="col-auto"><a href="#modal-order-1" class="button-1 h-order-btn js-modal">Заказать</a></div>
            <div class="col-auto d-none d-lg-block">
                <div class="dropdown-1 dd-phones">
                    <div class="dropdown-1__current">+38 (050) 555-55-55</div>
                    <div class="dropdown-1__list">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="dd-title mt-2">Отдел продаж</div>
                                <a href="tel:+380675557777" class="dd-phone">+38 (067) 555-77-77</a>
                                <a href="tel:+380675557777" class="dd-phone">+38 (066) 555-88-88</a>
                                <a href="tel:+380675557777" class="dd-phone">+38 (050) 555-55-55</a>
                                <div class="dd-title mt-2">Отдел улучшения качества:</div>
                                <a href="tel:+380675557777" class="dd-phone">+38 (067) 555-77-77</a>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <div class="dd-title">Оптовый отдел</div>
                                <a href="tel:+380675557777" class="dd-phone">+38 (067) 555-77-77</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto d-lg-none">
                <button class="hamburger hamburger--spin" type="button">
          <span class="hamburger-box">
            <span class="hamburger-inner"></span>
          </span>
                </button>
            </div>
        </div>
    </div>
</header>

<?php $this->beginBody() ?>

<?= $content ?>

<div id="modal-sizes" class="mfp-hide popup-2">
    <div class="title-6 mb-3">РАЗМЕРНАЯ СЕТКА</div>
    <img src="http://ticketto.alex-d.xyz/img/sizes.png" alt="image">
</div>

<div id="modal-order-1" class="mfp-hide popup-1">
    <div class="title-6 mb-4">БЫСТРЫЙ ЗАКАЗ</div>
    <div class="row">
        <div class="col-sm-5 col-md-4 mb-3">
            <div class="label-1 mb-3">выбрать цвет:</div>
            <div class="slider-2">
                <div><img loading="lazy" src="http://ticketto.alex-d.xyz/img/tovar-1.webp" alt="product"></div>
                <div><img loading="lazy" src="http://ticketto.alex-d.xyz/img/tovar-2.webp" alt="product"></div>
                <div><img loading="lazy" src="http://ticketto.alex-d.xyz/img/tovar-3.webp" alt="product"></div>
            </div>
        </div>
        <div class="col-sm-7 col-md-8">
            <form>
                <div class="row gutter-20 align-items-end">
                    <div class="col-md-6 mb-3">
                        <div class="field-required">
                            <input type="text" class="input-1" placeholder="Имя / Фамилия">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="field-required">
                            <input type="text" class="input-1" placeholder="Телефон">
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="label-1 mb-1">размер:</div>
                        <select name="size" class="wide">
                            <option value="s">S</option>
                            <option value="m">M</option>
                            <option value="x">X</option>
                            <option value="xl">XL</option>
                            <option value="xxl">XXL</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3 mb-3">
                        <div class="label-1 mb-1">количество:</div>
                        <input type="number" min="1" value="1" class="input-1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="#modal-sizes" class="button-5 w-100 js-modal">размерная сетка</a>
                    </div>
                    <div class="col-12 mb-3">
                        <textarea name="message" class="textarea-1" placeholder="Комментарий"></textarea>
                    </div>
                    <div class="col-md-6">
                        <a href="#" class="button-3 w-100">Отправить</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<footer id="footer" class="pt-4">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <a href="#"><img loading="lazy" src="http://p1g.alex-d.xyz/img/logo-white.svg" alt="logo footer"></a>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="footer-title">Отдел продаж</div>
                        <a href="#" class="footer-link">+38 (050) 555-55-55</a>
                        <a href="#" class="footer-link">+38 (050) 555-55-55</a>
                        <a href="#" class="footer-link">+38 (050) 555-55-55</a>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="footer-title">Оптовый отдел</div>
                        <a href="#" class="footer-link">+38 (050) 555-55-55</a>
                        <a href="#" class="footer-link">opt@gmail.com</a>
                    </div>
                    <div class="col-sm-6 col-md-4 mb-4">
                        <div class="footer-title">Отдел улучшения качества</div>
                        <a href="#" class="footer-link">+38 (050) 555-55-55</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
