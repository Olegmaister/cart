<?php
use yii\helpers\Url;


/**@var \common\entities\Blog\BlogCategory [] $blogsMenu*/
?>

<section class="journal s_tabs">
    <div class="wrapper">

        <h2 class="journal__title title-h2"><?= Yii::t('app', 'military') ?> - <?= Yii::t('app', 'magazine') ?></h2>

        <ul class="journal-content__nav s_tabs_list">
            <li class="content-nav__item active" tabindex="0"><?= Yii::t('app', 'all') ?></li>
            <li class="content-nav__item" tabindex="0"><?= Yii::t('app', 'articles') ?></li>
            <li class="content-nav__item" tabindex="0"><?= Yii::t('app', 'reviews') ?></li>
            <li class="content-nav__item" tabindex="0"><?= Yii::t('app', 'updates') ?></li>
            <li class="content-nav__item" tabindex="0"><?= Yii::t('app', 'story') ?></li>
        </ul>

        <div class="journal-content-wrapper">

            <div class="journal-content s_tabs_content active">
                <div class="pg-row">
                    <div class="pg-col-50 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div class="journal-content s_tabs_content">
                <div class="pg-row">
                    <div class="pg-col-50 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div class="journal-content s_tabs_content">
                <div class="pg-row">
                    <div class="pg-col-50 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div class="journal-content s_tabs_content">
                <div class="pg-row">
                    <div class="pg-col-50 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div class="journal-content s_tabs_content">
                <div class="pg-row">
                    <div class="pg-col-50 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="pg-col-25 pg-col-lg-50 pg-col-md-s-100">
                        <article class="journal-card">
                            <a href="<?=Url::to('blogs/index')?>" class="journal-card__img-link">
                                <img loading="lazy" src="/images/journal/1.jpg" class="journal-card__img" alt="">
                                <div class="journal-card__tags">
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'new season') ?></div>
                                    <div class="journal-card__tag hash-tag"># <?= Yii::t('app', 'history reference') ?></div>
                                </div>
                            </a>
                            <div class="journal-card__info">
                                <div class="journal-card__info-header">
                                    <a href="<?=Url::to('blogs/index')?>"
                                       class="journal-card__title title-h4">
                                        <?= Yii::t('app', 'article title') ?>
                                    </a>
                                    <div class="journal-card__label">ОБЗОР</div>
                                </div>
                                <div class="journal-card__info-footer">
                                    <div class="journal-card__date">10.01.2020</div>
                                    <div class="journal-card__like like">
                                        <svg class="like__icon" width="24" height="24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg"
                                             tabindex="0">
                                            <path stroke-width="2" d="M3 7.5h4.5v12H3zM14.25 3L7.5 9.75v9H18l3-2.625V8.25h-6L17.625 3H14.25z"/>
                                        </svg>
                                        <span class="like__count">126</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div class="journal-content__btn">
                <button class="btn btn--lg btn--red">
                    <a href="/" class="btn__inner"><?= Yii::t('app', 'all') ?> <?= Yii::t('app', 'publications') ?></a>
                </button>
            </div>
        </div>

    </div>
</section>