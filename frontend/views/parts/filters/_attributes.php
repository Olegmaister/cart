<?php if ($filtersData['attributes']): ?>

    <?php $checkedAttributes = isset($get['attributes']) ? explode(',', $get['attributes']) : [] ?>

    <?php foreach ($filtersData['attributes'] as $attributes): ?>
        <div class="sidebar-item">
            <h2 class="sidebar-item__title"><?= $attributes['group_name'] ?>:</h2>

            <div class="sidebar-item-content sidebar-item-content--hidden sidebar-item-content--hidden-atribute">
                <div>
                    <?php foreach ($attributes['attributes'] as $key => $attribute): ?>
                        <div class="check-txt-row">
                            <div class="check-txt">
                                <input id="attribute-<?= $key ?>" type="checkbox" value=""
                                       <?= in_array($key, $checkedAttributes) ? 'checked' : '' ?>>
                                <label for="attribute-<?= $key ?>">
                                <span class="check-txt__item">
                                    <?= isset($attribute) ? $attribute : '!! НЕТ ИМЕНИ !!' ?>
                                </span>
                                </label>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <?php if (count($attributes['attributes']) > 5): ?>
                <div class="sidebar-item__arrow sidebar-item__arrow--atributes js-toggle-h-prev"></div>
            <?php endif ?>
        </div>
    <?php endforeach ?>

<?php endif ?>

