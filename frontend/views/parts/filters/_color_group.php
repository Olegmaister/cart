<?php

use common\entities\Colors\ColorGroup;
use common\entities\Color;

$checkedColorGroup = isset($get['color_group']) ? explode(',', $get['color_group']) : [];
$checkedColors = isset($get['colors']) ? explode(',', $get['colors']) : [];
$colors = ColorGroup::find()->select('group_id, image')->where(['in', 'group_id', $filtersData['color_group']])->indexBy('group_id')->asArray()->all();
$images = array_column(Color::find()->select('id, image')->asArray()->all(), 'image', 'id');
//dd($filtersData);
?>

<?php foreach ($filtersData['color_group'] as $color): ?>
    <div class="filter-colors-col">
        <div class="check-color">
            <div class="check-color__parent">
                <input class="main" id="color-<?= $color ?>" type="checkbox"<?= in_array($color, $checkedColorGroup) ? ' checked' : '' ?>>
                <label for="color-<?= $color ?>">
                    <img class="check-color__item"
                         src="/images/colors/<?= isset($colors[$color]['image']) ? $colors[$color]['image'] : '' ?>"
                         loading="lazy"
                         data-color-="<?= $color ?>" alt="color">
                </label>
            </div>

            <?php if(isset($filtersData['colors'][$color])): ?>
                <div class="check-color__children">
                    <div class="row">
                        <?php foreach($filtersData['colors'][$color] as $id => $colorN):  ?>
                            <div class="col-6 my-1">
                                <input id="parent-<?= $id ?>" type="checkbox"<?= in_array($colorN, $checkedColors) ? ' checked' : '' ?>>
                                <label for="parent-<?= $id ?>">
                                    <img class="check-color__item" src="/images/colors/<?= $images[$colorN] ?>" data-color-="<?= $id ?>" alt="color">
                                </label>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            <?php endif ?>

        </div>
    </div>
<?php endforeach ?>