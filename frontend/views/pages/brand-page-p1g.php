<div class="page">
    <div class="hero-1">
        <img class="hero-1__bg" src="https://dev.p1gtac.com/images/slider-content/hero_slide_1.jpg" alt="image">
        <div class="hero-1__content">
            <img src="/images/p1g-icon.png" alt="image">
            <h1 class="hero-1__title">ПЕРВЫЙ УКРАИНСКИЙ БРЕНД ВОЕННОЙ ОДЕЖДЫ</h1>
            <img class="hero-1__trident" src="/images/trident.svg" alt="image">
        </div>
    </div>
    <div class="brand-page-about">
        <div class="container">
            <div class="row">
                <div class="col-md-5"><h2 class="title-line mb-5">ПРО P1G</h2></div>
                <div class="col-md-7 article">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                        gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor.
                        Cum
                        sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum,
                        nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget. Lorem
                        ipsum
                        dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida
                        dolor
                        sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis
                        natoque
                        penatibus et magnis dis</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab alias, aliquid at atque blanditiis
                        cumque, delectus dicta dolores eaque error facere fuga fugiat incidunt inventore iste magnam
                        magni nemo nihil non numquam odit possimus provident quae quas quis quos repellendus sapiente
                        sed soluta tempora veniam voluptas voluptate voluptates. Necessitatibus, voluptas!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 offset-md-6"><h2 class="title-line py-5">Наша<br/>продукция</h2></div>
        </div>
        <div class="row">
            <?php for ($item = 0; $item < 8; $item++): ?>
                <div class="col-md-6 col-lg-3 mb-4">
                    <a data-category_id="192" href="/bryuki" class="cat-prod-card">
                        <div class="cat-prod-card-img">
                            <img loading="lazy" src="/images/categories/ae8006d85b6f81e2149b7f6637f9d24def84ae44.png"
                                 title="Брюки" alt="Брюки">
                        </div>
                        <div class="cat-prod-card-info">
                            <h3 class="cat-prod-card__name">Брюки</h3>
                            <i class="cat-prod-card__arrow"></i>
                        </div>
                    </a>
                </div>
            <?php endfor ?>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 offset-md-1"><h2 class="title-line py-5">Новые<br/>товары</h2></div>
        </div>
        <div class="row">
            <?php for ($new = 0; $new < 4; $new++): ?>
                <div class="col-6 col-lg-3 mb-4">
                    <article class="product-card no-colors">
                        <header class="product-card__header">
                            <div class="product-card-labels js-product-card-labels">
                                <span class="product-card__label background_hit">лидер</span><span
                                        class="product-card__label background_stock_shares">акция</span></div>
                            <div class="product-card__option">
                                <button type="button" class="product-card__option-item js-favorite ">
                                <span class="product-card__option-icon product-card__option-icon--fav">
                                    <svg width="32" height="21" viewBox="0 0 32 21" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z"
                                              stroke-width="2"></path>
                                    </svg>
                                </span>
                                </button>
                                <button class="product-card__option-item  js-compare ">
                                <span class="product-card__option-icon product-card__option-icon--comp">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="74.333px"
                                         height="51.981px" viewBox="23.083 23.843 74.333 51.981"
                                         enable-background="new 23.083 23.843 74.333 51.981" xml:space="preserve"><rect
                                                x="57.946" y="23.843" width="4.5" height="51.981"></rect><polygon
                                                points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"></polygon><path
                                                d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"></path><path
                                                d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"></path></svg>
                                </span>
                                </button>
                            </div>
                        </header>


                        <div class="product-card__body loaded">

                            <div class="product-card__img-slider js-product-card-img-slider slick-initialized slick-slider">
                                <div class="slick-list">
                                    <div class="slick-track" style="opacity: 1; width: 216px;">
                                        <div class="slick-slide slick-current slick-active" data-slick-index="0"
                                             aria-hidden="false"
                                             style="width: 216px; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;">
                                            <div class="slick-slide-inners"><a class="product-card__img-link  "
                                                                               data-product-id="54"
                                                                               data-product-name="Линза сменная  для стрелковых очков &quot;ESS Crossblade Lense&quot;, [1226] Hi-Def Bronze"
                                                                               data-product-price="2830.8"
                                                                               data-product-old-price="4044"
                                                                               data-product-label="[{&quot;label&quot;:&quot;hit&quot;,&quot;name&quot;:&quot;\u043b\u0438\u0434\u0435\u0440&quot;},{&quot;label&quot;:&quot;stock_shares&quot;,&quot;name&quot;:&quot;\u0430\u043a\u0446\u0438\u044f&quot;}]"
                                                                               data-sizes="[{&quot;option_id&quot;:9668,&quot;name&quot;:&quot;10&quot;}]"
                                                                               href="/linza-smennaya-dlya-strelkovyh-ochkov-quotess-crossblade-lensequot-1226-hidef-bronze"
                                                                               style="width: 100%; display: inline-block;"
                                                                               tabindex="0">
                                                    <img title="Линза сменная  для стрелковых очков &quot;ESS Crossblade Lense&quot;, [1226] Hi-Def Bronze"
                                                         alt="Линза сменная  для стрелковых очков &quot;ESS Crossblade Lense&quot;, [1226] Hi-Def Bronze"
                                                         class="product-card__img"
                                                         src="https://dev.p1gtac.com/images/products/import_files/00000440/e78524e85bcd11e980bc005056807e63_e78524e95bcd11e980bc005056807e63-228x228.jpg"
                                                         style="opacity: 1;">
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card__color-slider js-product-card-color-slider _c slick-initialized slick-slider">
                                <div class="slick-list draggable">
                                    <div class="slick-track"
                                         style="opacity: 1; width: 0px; transform: translate3d(0px, 0px, 0px);"></div>
                                </div>
                            </div>

                        </div>

                        <footer class="product-card__footer">
                            <a href="#" class="product-card__gift" data-text="<?= Yii::t('app', 'Gift') ?>">
                                <img src="https://dev.p1gtac.com/images/products/import_files/00001883/fd8cb06f5bef11e980bc005056807e63_03abb9215bf011e980bc005056807e63-228x228.jpg"
                                     alt="gift">
                            </a>
                            <h3 class="product-card__name" data-category_id="54" data-product-id="54">
                                <a href="/linza-smennaya-dlya-strelkovyh-ochkov-quotess-crossblade-lensequot-1226-hidef-bronze"
                                   class="product-card__name-link">
                                    Линза сменная для стрелковых очков "ESS Crossblade Lense", [1226] Hi-Def Bronze </a>
                            </h3>
                            <div class="product-card-bot-view-2">


                                <div class="product-card__prices">

                                    <div class="product-card__price product-card__price--new">
                                        <span class="product-card__price-currency--new">₴</span>
                                        <span class="product-card__price-new js-product-new-price">2831</span>
                                    </div>
                                    <!--old-->
                                    <div class="product-card__price product-card__price--old">
                                        <span class="product-card__price-currency--old">₴</span>
                                        <span class="js-product-old-price">4044</span>
                                    </div>

                                </div>

                                <button class="product-card__cart js-open-modal-size">
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z"
                                              stroke="#1D2023" stroke-width="2"></path>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"></path>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                    </svg>
                                </button>
                            </div>
                        </footer>
                    </article>
                </div>
            <?php endfor ?>
        </div>
        <div class="text-center">
            <button class="button-3 px-md-5"><?= Yii::t('app', 'show more') ?></button>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 offset-md-1"><h2 class="title-line py-5">Популярные<br/>товары</h2></div>
        </div>
        <div class="row">
            <?php for ($popular = 0; $popular < 4; $popular++): ?>
                <div class="col-6 col-lg-3 mb-4">
                    <article class="product-card no-colors">
                        <header class="product-card__header">
                            <div class="product-card-labels js-product-card-labels">
                                <span class="product-card__label background_hit">лидер</span><span
                                        class="product-card__label background_stock_shares">акция</span></div>
                            <div class="product-card__option">
                                <button type="button" class="product-card__option-item js-favorite ">
                                <span class="product-card__option-icon product-card__option-icon--fav">
                                    <svg width="32" height="21" viewBox="0 0 32 21" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1.63818 4.85714L15.6382 19L29.6382 4.85714L25.82 1H19.4564L15.6382 4.85714L11.82 1H5.45637L1.63818 4.85714Z"
                                              stroke-width="2"></path>
                                    </svg>
                                </span>
                                </button>
                                <button class="product-card__option-item  js-compare ">
                                <span class="product-card__option-icon product-card__option-icon--comp">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="74.333px"
                                         height="51.981px" viewBox="23.083 23.843 74.333 51.981"
                                         enable-background="new 23.083 23.843 74.333 51.981" xml:space="preserve"><rect
                                                x="57.946" y="23.843" width="4.5" height="51.981"></rect><polygon
                                                points="84.368,44.274 79.868,44.274 79.868,36.897 40.524,36.897 40.524,44.274 36.024,44.274 36.024,32.397 84.368,32.397 	"></polygon><path
                                                d="M38.47,70.721c-8.197,0-15.387-7.657-15.387-16.388v-2.25h30.775v2.25 C53.858,63.063,46.667,70.721,38.47,70.721z M27.797,56.583c1.024,5.342,5.573,9.638,10.673,9.638c5.1,0,9.649-4.296,10.673-9.638 H27.797z"></path><path
                                                d="M82.029,70.721c-8.196,0-15.387-7.657-15.387-16.388v-2.25h30.773v2.25 C97.417,63.063,90.227,70.721,82.029,70.721z M71.357,56.583c1.022,5.342,5.572,9.638,10.672,9.638 c5.101,0,9.648-4.296,10.673-9.638H71.357z"></path></svg>
                                </span>
                                </button>
                            </div>
                        </header>


                        <div class="product-card__body loaded">

                            <div class="product-card__img-slider js-product-card-img-slider slick-initialized slick-slider">
                                <div class="slick-list">
                                    <div class="slick-track" style="opacity: 1; width: 216px;">
                                        <div class="slick-slide slick-current slick-active" data-slick-index="0"
                                             aria-hidden="false"
                                             style="width: 216px; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;">
                                            <div class="slick-slide-inners"><a class="product-card__img-link  "
                                                                               data-product-id="54"
                                                                               data-product-name="Линза сменная  для стрелковых очков &quot;ESS Crossblade Lense&quot;, [1226] Hi-Def Bronze"
                                                                               data-product-price="2830.8"
                                                                               data-product-old-price="4044"
                                                                               data-product-label="[{&quot;label&quot;:&quot;hit&quot;,&quot;name&quot;:&quot;\u043b\u0438\u0434\u0435\u0440&quot;},{&quot;label&quot;:&quot;stock_shares&quot;,&quot;name&quot;:&quot;\u0430\u043a\u0446\u0438\u044f&quot;}]"
                                                                               data-sizes="[{&quot;option_id&quot;:9668,&quot;name&quot;:&quot;10&quot;}]"
                                                                               href="/linza-smennaya-dlya-strelkovyh-ochkov-quotess-crossblade-lensequot-1226-hidef-bronze"
                                                                               style="width: 100%; display: inline-block;"
                                                                               tabindex="0">
                                                    <img title="Линза сменная  для стрелковых очков &quot;ESS Crossblade Lense&quot;, [1226] Hi-Def Bronze"
                                                         alt="Линза сменная  для стрелковых очков &quot;ESS Crossblade Lense&quot;, [1226] Hi-Def Bronze"
                                                         class="product-card__img"
                                                         src="https://dev.p1gtac.com/images/products/import_files/00000440/e78524e85bcd11e980bc005056807e63_e78524e95bcd11e980bc005056807e63-228x228.jpg"
                                                         style="opacity: 1;">
                                                </a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card__color-slider js-product-card-color-slider _c slick-initialized slick-slider">
                                <div class="slick-list draggable">
                                    <div class="slick-track"
                                         style="opacity: 1; width: 0px; transform: translate3d(0px, 0px, 0px);"></div>
                                </div>
                            </div>

                        </div>

                        <footer class="product-card__footer">
                            <a href="#" class="product-card__gift" data-text="<?= Yii::t('app', 'Gift') ?>">
                                <img src="https://dev.p1gtac.com/images/products/import_files/00001883/fd8cb06f5bef11e980bc005056807e63_03abb9215bf011e980bc005056807e63-228x228.jpg"
                                     alt="gift">
                            </a>
                            <h3 class="product-card__name" data-category_id="54" data-product-id="54">
                                <a href="/linza-smennaya-dlya-strelkovyh-ochkov-quotess-crossblade-lensequot-1226-hidef-bronze"
                                   class="product-card__name-link">
                                    Линза сменная для стрелковых очков "ESS Crossblade Lense", [1226] Hi-Def Bronze </a>
                            </h3>
                            <div class="product-card-bot-view-2">


                                <div class="product-card__prices">

                                    <div class="product-card__price product-card__price--new">
                                        <span class="product-card__price-currency--new">₴</span>
                                        <span class="product-card__price-new js-product-new-price">2831</span>
                                    </div>
                                    <!--old-->
                                    <div class="product-card__price product-card__price--old">
                                        <span class="product-card__price-currency--old">₴</span>
                                        <span class="js-product-old-price">4044</span>
                                    </div>

                                </div>

                                <button class="product-card__cart js-open-modal-size">
                                    <svg class="product-card__cart-svg" width="28" height="25" viewBox="0 0 28 25"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.10239 17.5686L5.58679 5.84314H26.6815L23.3984 17.5686H7.10239Z"
                                              stroke="#1D2023" stroke-width="2"></path>
                                        <path d="M7.13725 17.4706L4.94118 1H0" stroke="#1D2023" stroke-width="2"></path>
                                        <circle cx="10.4314" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                        <circle cx="20.3138" cy="21.8627" r="2.19608" fill="#1D2023"></circle>
                                    </svg>
                                </button>
                            </div>
                        </footer>
                    </article>
                </div>
            <?php endfor ?>
        </div>
        <div class="text-center">
            <button class="button-3 px-md-5"><?= Yii::t('app', 'show more') ?></button>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 offset-md-4"><h2 class="title-line py-5">Презентации<br/>товаров</h2></div>
        </div>
        <div class="grid-1">
            <div class="grid-1__big">
                <div class="product-1">
                    <img src="http://image.alex-d.xyz/334x385/people/3" alt="image">
                    <div class="product-1__text">
                        <a href="#" class="product-1__title">ЛУЧШИЕ ВЕТРОВКИ PIG</a>
                    </div>
                </div>
            </div>
            <div class="grid-1__item">
                <div class="product-1">
                    <img src="http://image.alex-d.xyz/334x334/people/9" alt="image">
                    <div class="product-1__text">
                        <a href="#" class="product-1__title">НОВИНКИ ВЕСНЫ. ДЖИНСЫ PIG</a>
                    </div>
                </div>
            </div>
            <div class="grid-1__item">
                <div class="product-1">
                    <img src="http://image.alex-d.xyz/334x334/people/9" alt="image">
                    <div class="product-1__text">
                        <a href="#" class="product-1__title">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Optio,
                            reiciendis?
                        </a>
                    </div>
                </div>
            </div>
            <div class="grid-1__item">
                <div class="product-1">
                    <img src="http://image.alex-d.xyz/334x334/people/9" alt="image">
                    <div class="product-1__text">
                        <a href="#" class="product-1__title">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Optio,
                            reiciendis?
                        </a>
                    </div>
                </div>
            </div>
            <div class="grid-1__item">
                <div class="product-1">
                    <img src="http://image.alex-d.xyz/334x334/people/9" alt="image">
                    <div class="product-1__text">
                        <a href="#" class="product-1__title">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Optio,
                            reiciendis?
                        </a>
                    </div>
                </div>
            </div>
            <div class="grid-1__item">
                <div class="product-1">
                    <img src="http://image.alex-d.xyz/334x334/people/9" alt="image">
                    <div class="product-1__text">
                        <a href="#" class="product-1__title">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Optio,
                            reiciendis?
                        </a>
                    </div>
                </div>
            </div>
            <div class="grid-1__item">
                <div class="product-1">
                    <img src="http://image.alex-d.xyz/334x334/people/9" alt="image">
                    <div class="product-1__text">
                        <a href="#" class="product-1__title">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Optio,
                            reiciendis?
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <img class="w-100" src="http://image.alex-d.xyz/452x306/people/4" alt="image">
            </div>
            <div class="col-md-8">
                <div class="article">
                    <h3 class="title-1 mb-3">Какие виды военного снаряжения бывают?</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, animi, asperiores atque ea
                        eaque enim fugit harum incidunt ipsa iste molestiae nemo numquam optio perspiciatis porro
                        possimus provident quas recusandae repellendus rerum sint sunt tempora voluptate! Assumenda,
                        beatae corporis delectus facilis inventore iusto laboriosam minus nostrum quos repellendus
                        soluta tenetur unde. Asperiores culpa dolores in iure iusto nihil qui vero voluptatibus?
                        Dignissimos dolorum harum illo labore neque unde? Aliquid animi architecto doloribus ducimus
                        eaque excepturi facere facilis fugiat inventore, ipsum iste labore laborum magni molestias
                        necessitatibus neque numquam obcaecati officia officiis pariatur possimus quaerat quam quidem
                        sapiente sint sunt voluptatem.</p>
                    <section class="desc-accord mt-4">
                        <article class="desc-accord-item">
                            <header class="desc-accord-head js-toggle-slide">
                                <div class="desc-accord-head__title">Как правильно выбирать военное снаряжение?</div>
                                <span class="material-icons b_arrow b_arrow_black">arrow_drop_down</span>
                            </header>
                            <article class="desc-accord-cont js-toggle-cont">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum
                                    laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin
                                    sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis Lorem ipsum
                                    dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                                    gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales
                                    pulvinar tempor. Cum sociis natoque penatibus et magnis dis Lorem ipsum dolor sit
                                    amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida
                                    dolor</p>
                            </article>
                        </article>
                        <article class="desc-accord-item">
                            <header class="desc-accord-head js-toggle-slide">
                                <div class="desc-accord-head__title">Как правильно выбирать военное снаряжение?</div>
                                <span class="material-icons b_arrow b_arrow_black">arrow_drop_down</span>
                            </header>
                            <article class="desc-accord-cont js-toggle-cont">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum
                                    laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin
                                    sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis Lorem ipsum
                                    dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                                    gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales
                                    pulvinar tempor. Cum sociis natoque penatibus et magnis dis Lorem ipsum dolor sit
                                    amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida
                                    dolor</p>
                            </article>
                        </article>
                        <article class="desc-accord-item">
                            <header class="desc-accord-head js-toggle-slide">
                                <div class="desc-accord-head__title">Как правильно выбирать военное снаряжение?</div>
                                <span class="material-icons b_arrow b_arrow_black">arrow_drop_down</span>
                            </header>
                            <article class="desc-accord-cont js-toggle-cont">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum
                                    laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin
                                    sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis Lorem ipsum
                                    dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin
                                    gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales
                                    pulvinar tempor. Cum sociis natoque penatibus et magnis dis Lorem ipsum dolor sit
                                    amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida
                                    dolor</p>
                            </article>
                        </article>
                    </section>
                </div>
            </div>
        </div>
    </div>

</div>