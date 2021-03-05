<?php

use common\helpers\LanguageHelper;

$this->title = Yii::t('app', 'Search results');
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'Search results') ?></span>
                </li>
            </ul>
        </nav>
        <div class="page-content">
            <h1 class="title title--page-lg"><?= Yii::t('app', 'Search results') ?>: "<?= $searchText ?>"</h1>
				<div class="product-card-wrap js-more-search-container">
					<?= $this->render('partials/product_tile',
						[
							'items' => $products,
							'name' => 'searchList',
							'currency' => $currency
						]
					) ?>
				</div>
				<?php if ($products['count'] > 12): ?>
					<div class="pg-d-flex pg-justify-center">
						<button class="btn btn--lg btn--black js-more-search-btn"
								data-cards-count="<?php echo $products['count']; ?>"
								data-search-text="<?= $searchText ?>">
							<span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
						</button>
					</div>
				<?php endif; ?>
        </div>
    </div>
</div>
