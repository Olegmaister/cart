<?php $checkedBrands = isset($get['brands']) ? explode(',', $get['brands']) : [] ?>
<?php foreach ($filtersData['brands'] as $brand): ?>
    <div class="check-txt-row">
        <div class="check-txt">
            <input id="brand-<?= $brand['manufacturer_id'] ?>" type="checkbox"
                   value=""
                   <?= in_array($brand['manufacturer_id'], $checkedBrands) ? 'checked' : '' ?>>
            <label for="brand-<?= $brand['manufacturer_id'] ?>">
            <span class="check-txt__item">
               <?= $brand['brandName']['name'] ?>
            </span>
            </label>
        </div>
    </div>
<?php endforeach ?>