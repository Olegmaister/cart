<?php
use yii\helpers\Url;
use common\helpers\LanguageHelper;

/**@var \common\entities\Customer $customer **/
?>
<div class="page">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="breadcrumbs__item">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('account/account') ?>">
                        <?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?>
                    </a>
                    <meta itemprop="position" content="2"/>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'bulk order') ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">
            <h1 class="title title--page-lg"><?= Yii::t('app', 'private') ?> <?= Yii::t('app', 'cabinet') ?>: <?=
			Yii::t('app', 'general') ?> <?= Yii::t('app', 'data') ?></h1>
            <section class="account-body">
                <div class="account-col account-col--left">
                    <div class="account-menu">
                        <?= $this->render('common/_menu',[
                            'customer' => $customer,
                            'active' => $active
                        ])?>
                    </div>
                </div>
                <div class="account-col account-col--bulk account-col--right">
                    <div class="account-tabs s_tabs s_tabs--slick">
                        <nav class="account-tabs-nav">
                            <i class="_border"></i>
                            <div class="account-tabs-nav-but account-tabs-nav-but--prev">
                                <div class="account-tabs-nav-but__arrow">
                                    <svg class="_svg" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path class="_path" d="M8.485 1.571l8.486 8.485-8.486 8.486" stroke-width="3"/>
                                    </svg>
                                </div>
                            </div>
<!--                            <div class="account-tabs-nav__all">ВСЕ ТОВАРЫ</div>-->
                            <ul class="account-tabs-nav-list js-slider-account-thumbs s_tabs_list s_tabs_list--slick">
                                <li><span>ВСЕ ТОВАРЫ</span></li>
                                <li><span>ОБУВЬ</span></li>
                                <li><span>СНАРЯЖЕНИЕ</span></li>
                                <li><span>ПРИЦЕЛЫ</span></li>
                                <li><span>ПРИЦЕЛЫ</span></li>
                                <li><span>ПРИЦЕЛЫ</span></li>
                                <li><span>ПРИЦЕЛЫ</span></li>
                                <li><span>ПРИЦЕЛЫ</span></li>
                                <li><span>ПРИЦЕЛЫ</span></li>
                                <li><span>ПРИЦЕЛЫ</span></li>
                            </ul>
                            <div class="account-tabs-nav-but account-tabs-nav-but--next">
                                <div class="account-tabs-nav-but__arrow">
                                    <svg class="_svg" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path class="_path" d="M8.485 1.571l8.486 8.485-8.486 8.486" stroke-width="3"/>
                                    </svg>
                                </div>
                            </div>
                        </nav>
                        <div class="account-top-row">
                            <div class="account-top-row-col account-top-row-col--left">
                                <div class="search-pages search-pages--lg search-pages--lg-md">
                                    <input type="text" placeholder="<?= Yii::t('app', 'Search by name') ?>" class="search-pages__field">
                                    <button class="search-pages__but">
                                        <svg width="26" height="27" viewBox="0 0 26 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="11.3137" cy="12" r="7" transform="rotate(-45 11.3137 12)" stroke="#1D2023" stroke-width="2"></circle>
                                            <path d="M19.799 20.4853L16.2634 16.9498" stroke="#1D2023" stroke-width="2"></path>
                                        </svg>

                                    </button>
                                </div>
                            </div>
                            <div class="account-top-row-col account-top-row-col--right">
                                <div class="select-pages select-pages--lg">
                                    <select class="custom-select custom-select--lg" data-nice-select>
                                        <option selected disabled><?= Yii::t('app', 'Search by country') ?></option>
                                        <option value="1">Ukraine</option>
                                        <option value="2">USA</option>
                                        <option value="3">Italy</option>
                                        <option value="4">France</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="account-content js-slider-account">
                            <div class="p-order-table s_tabs_content active">
                               <table class="c-table-gr">
                                   <thead>
                                       <tr>
                                           <td class="c-table-gr__padding">
                                               Фото
                                           </td>
                                           <td class="c-table-gr__padding">
                                                Найменование товаров
                                           </td>
                                           <td class="c-table-gr-head__txt c-table-gr-head__txt--min">цвет</td>
                                           <td class="c-table-gr-head__txt c-table-gr-head__txt--min">РРЦ <br> (грн.)</td>
                                           <td class="c-table-gr-head__txt c-table-gr-head__txt--min">Оптовая <br> цена</td>
                                           <td class="c-table-gr-head__txt c-table-gr-head__txt--min"><?= Yii::t('app', 'discount') ?> <br> (%)</td>
                                           <td class="c-table-gr__padding c-table-gr__padding--none">
                                               <div class="account-table-size-slider">
                                                   <div class="account-table-size-slider-but account-table-size-slider-but--prev">
                                                       <svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg"><path class="_path" opacity=".3" d="M11.485 2L3 10.485l8.485 8.486" stroke-width="3"/></svg>
                                                   </div>
                                                   <div class="account-table-size-slider-inner js-slider-table-size">
                                                       <div class="account-table-size-slider__item">
                                                           <div class="sizes-switch__item">4xl</div>
                                                       </div>
                                                       <div class="account-table-size-slider__item">
                                                           <div class="sizes-switch__item">4xl</div>
                                                       </div>
                                                       <div class="account-table-size-slider__item">
                                                           <div class="sizes-switch__item">4xl</div>
                                                       </div>
                                                       <div class="account-table-size-slider__item">
                                                           <div class="sizes-switch__item">4xl</div>
                                                       </div>
                                                       <div class="account-table-size-slider__item">
                                                           <div class="sizes-switch__item">4xl</div>
                                                       </div>
                                                       <div class="account-table-size-slider__item">
                                                           <div class="sizes-switch__item">4xl</div>
                                                       </div>
                                                       <div class="account-table-size-slider__item">
                                                           <div class="sizes-switch__item">4xl</div>
                                                       </div>
                                                       <div class="account-table-size-slider__item">
                                                           <div class="sizes-switch__item">4xl</div>
                                                       </div>
                                                   </div>
                                                   <div class="account-table-size-slider-but account-table-size-slider-but--next">
                                                       <svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg"><path class="_path" opacity=".3" d="M8.485 2l8.486 8.485-8.486 8.486" stroke-width="3"/></svg>
                                                   </div>
                                               </div>
                                           </td>
                                           <td class="c-table-gr-head__txt">
                                               СУММА
                                           </td>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       <tr class="c-table-gr-row">
                                           <td aria-label="Фото">
                                               <a class="c-table-gr-photo__link" href="">
                                                   <img loading="lazy" src="/images/cart-img.png" alt="" class="c-table-gr__img">
                                               </a>
                                           </td>
                                           <td aria-label="НАЙМЕНОВАНИЕ ТОВАРОВ" class="c-table-gr__padding">
                                               <a href="" class="c-table-gr__name">
                                                   Куртка демисезонная
                                               утепляющая "URSUS POWER-FILL"
                                               </a>
                                           </td>
                                           <td aria-label="ЦВЕТ" class="c-table-gr__padding c-table-gr__padding--none">
                                               <div class="el-color el-color--green"></div>
                                           </td>
                                           <td aria-label="РРЦ (ГРН.)"><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td aria-label="ОПТОВАЯ ЦЕНА"><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td aria-label="СКИДКА (%)"><span class="c-table-gr__action">-15</span></td>
                                           <td aria-label="Размеры">
                                               <div class="c-table-gr-sizes">
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                               </div>
                                           </td>
                                           <td aria-label="СУММА"><span class="c-table-gr__price">₴ 34 100</span></td>
                                       </tr>
                                       <tr class="c-table-gr-row">
                                           <td aria-label="Фото">
                                               <a class="c-table-gr-photo__link" href="">
                                                   <img loading="lazy" src="/images/cart-img.png" alt="" class="c-table-gr__img">
                                               </a>
                                           </td>
                                           <td aria-label="НАЙМЕНОВАНИЕ ТОВАРОВ" class="c-table-gr__padding">
                                               <a href="" class="c-table-gr__name">
                                                   Куртка демисезонная
                                                   утепляющая "URSUS POWER-FILL"
                                               </a>
                                           </td>
                                           <td aria-label="ЦВЕТ" class="c-table-gr__padding c-table-gr__padding--none">
                                               <div class="el-color el-color--green"></div>
                                           </td>
                                           <td aria-label="РРЦ (ГРН.)"><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td aria-label="ОПТОВАЯ ЦЕНА"><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td aria-label="СКИДКА (%)"><span class="c-table-gr__action">-15</span></td>
                                           <td aria-label="Размеры">
                                               <div class="c-table-gr-sizes">
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                               </div>
                                           </td>
                                           <td aria-label="СУММА"><span class="c-table-gr__price">₴ 34 100</span></td>
                                       </tr>
                                       <tr class="c-table-gr-row">
                                           <td aria-label="Фото">
                                               <a class="c-table-gr-photo__link" href="">
                                                   <img loading="lazy" src="/images/cart-img.png" alt="" class="c-table-gr__img">
                                               </a>
                                           </td>
                                           <td aria-label="НАЙМЕНОВАНИЕ ТОВАРОВ" class="c-table-gr__padding">
                                               <a href="" class="c-table-gr__name">
                                                   Куртка демисезонная
                                                   утепляющая "URSUS POWER-FILL"
                                               </a>
                                           </td>
                                           <td aria-label="ЦВЕТ" class="c-table-gr__padding c-table-gr__padding--none">
                                               <div class="el-color el-color--green"></div>
                                           </td>
                                           <td aria-label="РРЦ (ГРН.)"><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td aria-label="ОПТОВАЯ ЦЕНА"><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td aria-label="СКИДКА (%)"><span class="c-table-gr__action">-15</span></td>
                                           <td aria-label="Размеры">
                                               <div class="c-table-gr-sizes">
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                               </div>
                                           </td>
                                           <td aria-label="СУММА"><span class="c-table-gr__price">₴ 34 100</span></td>
                                       </tr>



                                      <!-- <tr class="c-table-gr-row">
                                           <td>
                                               <a class="c-table-gr-photo__link" href="">
                                                   <img loading="lazy" src="/images/cart-img.png" alt="" class="c-table-gr__img">
                                               </a>
                                           </td>
                                           <td class="c-table-gr__padding">
                                               <a href="" class="c-table-gr__name">
                                                   Куртка демисезонная
                                               утепляющая "URSUS POWER-FILL"
                                               </a>
                                           </td>
                                           <td class="c-table-gr__padding c-table-gr__padding--none">
                                               <div class="el-color el-color--green"></div>
                                           </td>
                                           <td><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td><span class="c-table-gr__action">-15</span></td>
                                           <td>
                                               <div class="c-table-gr-sizes">
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                               </div>
                                           </td>
                                           <td><span class="c-table-gr__price">₴ 34 100</span></td>
                                       </tr>
                                       <tr class="c-table-gr-row">
                                           <td>
                                               <a class="c-table-gr-photo__link" href="">
                                                   <img loading="lazy" src="/images/cart-img.png" alt="" class="c-table-gr__img">
                                               </a>
                                           </td>
                                           <td class="c-table-gr__padding">
                                               <a href="" class="c-table-gr__name">
                                                   Куртка демисезонная
                                               утепляющая "URSUS POWER-FILL"
                                               </a>
                                           </td>
                                           <td class="c-table-gr__padding c-table-gr__padding--none">
                                               <div class="el-color el-color--green"></div>
                                           </td>
                                           <td><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td><span class="c-table-gr__action">-15</span></td>
                                           <td>
                                               <div class="c-table-gr-sizes">
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                               </div>
                                           </td>
                                           <td><span class="c-table-gr__price">₴ 34 100</span></td>
                                       </tr>
                                       <tr class="c-table-gr-row">
                                           <td>
                                               <a class="c-table-gr-photo__link" href="">
                                                   <img loading="lazy" src="/images/cart-img.png" alt="" class="c-table-gr__img">
                                               </a>
                                           </td>
                                           <td class="c-table-gr__padding">
                                               <a href="" class="c-table-gr__name">
                                                   Куртка демисезонная
                                               утепляющая "URSUS POWER-FILL"
                                               </a>
                                           </td>
                                           <td class="c-table-gr__padding c-table-gr__padding--none">
                                               <div class="el-color el-color--green"></div>
                                           </td>
                                           <td><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td><span class="c-table-gr__action">-15</span></td>
                                           <td>
                                               <div class="c-table-gr-sizes">
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                               </div>
                                           </td>
                                           <td><span class="c-table-gr__price">₴ 34 100</span></td>
                                       </tr>
                                       <tr class="c-table-gr-row">
                                           <td>
                                               <a class="c-table-gr-photo__link" href="">
                                                   <img loading="lazy" src="/images/cart-img.png" alt="" class="c-table-gr__img">
                                               </a>
                                           </td>
                                           <td class="c-table-gr__padding">
                                               <a href="" class="c-table-gr__name">
                                                   Куртка демисезонная
                                               утепляющая "URSUS POWER-FILL"
                                               </a>
                                           </td>
                                           <td class="c-table-gr__padding c-table-gr__padding--none">
                                               <div class="el-color el-color--green"></div>
                                           </td>
                                           <td><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td><span class="c-table-gr__price">₴ 2100</span></td>
                                           <td><span class="c-table-gr__action">-15</span></td>
                                           <td>
                                               <div class="c-table-gr-sizes">
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                                   <div class="sizes-switch__item">0</div>
                                               </div>
                                           </td>
                                           <td><span class="c-table-gr__price">₴ 34 100</span></td>
                                       </tr>-->
                                   </tbody>
                               </table>
                                <div class="p-order-but p-order-but--multy">
                                    <div class="p-order-but-col p-order-but-col--left">
                                        <div class="p-order-but-col-inner p-order-but-col-inner--left">
                                            <button class="btn btn--gray btn--lxx">
                                                <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                                            </button>
                                        </div>
                                        <div class="p-order-but-col-inner p-order-but-col-inner--right">
                                            <div class="amount-and-price">
                                                <div class="amount-and-price-col">
                                                    <div class="amount-and-price__txt">Сумма:</div>
                                                </div>
                                                <div class="amount-and-price-col">
                                                    <div class="price price--new"><span>₴</span> 3500</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="p-order-but-col p-order-but-col--right">
                                        <div class="p-order-but-col-inner p-order-but-col-inner--50 p-order-but-col-inner--left">
                                            <button class="btn btn--red btn--full btn--lg-x">
                                                <span class="btn__inner"><?= Yii::t('app', 'checkout') ?></span>
                                            </button>
                                        </div>
                                        <div class="p-order-but-col-inner p-order-but-col-inner--50 p-order-but-col-inner--right">
                                            <button class="btn btn--black btn--full btn--lg-x">
                                                <span class="btn__inner"><?= Yii::t('app', 'download order to file') ?></span>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="p-order-table s_tabs_content">
                                2
                            </div>
                            <div class="p-order-table s_tabs_content">
                                3
                            </div>
                            <div class="p-order-table s_tabs_content">
                               4
                            </div>
                            <div class="p-order-table s_tabs_content">
                               5
                            </div>
                            <div class="p-order-table s_tabs_content">
                                6
                            </div>
                            <div class="p-order-table s_tabs_content">
                                7
                            </div>
                            <div class="p-order-table s_tabs_content">
                                8
                            </div>
                            <div class="p-order-table s_tabs_content">
                                9
                            </div>
                            <div class="p-order-table s_tabs_content">
                                10
                            </div>
                            <div class="p-order-table s_tabs_content">
                                11
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!--page-content-->
    </div>
    <!--wrapper-->
</div>
<!--page-->