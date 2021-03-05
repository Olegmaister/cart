<?php

namespace common\services;

use Yii;
use common\entities\Categories\CategoryPath;
use frontend\services\CategoriesService;
use common\api\oneC\SynchronizeGood;
use common\entities\Brands\Brand;
use common\entities\Brands\BrandDescription;
use common\entities\Categories\Category;
use common\entities\Categories\CategoryDescription;
use common\entities\Color;
use common\entities\Products\ProductDescription;
use common\entities\Products\ProductInCategory;
use common\entities\SlugManager;
use yii\helpers\Inflector;

class CreateProductService
{
    public static function getColorId($colorId, $colorName)
    {
        //d( $colorId );
        //dd(  $colorName );

        $color = Color::findOne(['code_1c' => $colorId]);

        if (!$color) {
            $color = new Color();
            $color->code_1c = trim($colorId);
            $color->name = trim($colorName);
            //$color->guid = '';
            //$color->image = '';

            if (!$color->save()) {
                if (SynchronizeGood::LOG_ERROR_DB) {
                    LogErrorService::saveValidateToString('save product 1C', $color->errors, __FILE__ . ' ' . __LINE__);
                }
            } else {
                return $color->id;
            }
        } else {
            return $color->id;
        }
    }

    public static function getBradId($brandName, $guid, $priceGroup = '')
    {
        $brand = Brand::findOne(['guid' => $guid]);
        if ($brand) {
            //if($brand->blog_tag_description) {
            // c20c4f69-0736-11eb-810a-005056807e63 Это распродажа
            if ($priceGroup != '' && $priceGroup != 'c20c4f69-0736-11eb-810a-005056807e63') {
                $brand->guid_group_price = $priceGroup;
                $brand->save();
            }
            //}
            return $brand->brand_id;
        } else {
            return self::createBrand($brandName, $guid, $priceGroup);
        }
    }

    public static function createBrand($name, $guid, $priceGroup = '')
    {
        $brand = new Brand();
        $brand->guid = $guid;
        //$brand->image = '';
        $brand->country_id = 62;
        $brand->limitation_discount = 10;

        // c20c4f69-0736-11eb-810a-005056807e63 Это распродажа
        $brand->guid_group_price = ($priceGroup != 'c20c4f69-0736-11eb-810a-005056807e63') ? $priceGroup : '';

        if ($brand->save()) {
            foreach ([1, 2, 3] as $lang) {
                $brandDescription = new BrandDescription();
                $brandDescription->language_id = $lang;
                $brandDescription->brand_id = $brand->brand_id;
                $brandDescription->name = $name;
                $brandDescription->save();
            }

            // Создаем url для бренда
            $brandUrl = self::checkAvailabilityUrl($brand->brand_id, $name, 'brands', 'view');
            // Создаем url для каталога бренда
            self::checkAvailabilityUrl($brand->brand_id, 'brand-catalog-' . $brandUrl, 'brands', 'view-catalog');

            return $brand->brand_id;
        }  else {
            //dd($brand->errors);
        }

        return null;
    }

    public static function checkKeywordUrl($name)
    {
        $keyword = SlugManager::findOne(['keyword' => $name]);
        if (!$keyword) {
            return $name;
        } else {
            return self::checkKeywordUrl($name . '-' . rand(0, 10));
        }
    }

    public static function checkAvailabilityUrl($id, $nameRu, $controller, $action)
    {
        $url = SlugManager::findOne(['controller' => $controller, 'action' => $action, 'id' => $id]);
        if (!$url) {
            $url = new SlugManager();
            $url->controller = $controller;
            $url->action = $action;
            $url->query = 'new';
            $url->id = $id;

            // Транслитирация по рус. имени
            $keyword = Inflector::slug($nameRu);
            // Проверяем что урла нет в таблице урлов
            $url->keyword = self::checkKeywordUrl($keyword);

            if (!$url->save()) {
                if (SynchronizeGood::LOG_ERROR_DB) {
                    LogErrorService::saveValidateToString('save product 1C', $url->errors, __FILE__ . ' ' . __LINE__);
                }
            } else {
                return $url->keyword;
            }
        } else {
            return $url->keyword;
        }
    }

    public static function saveDescriptions($product, $data)
    {
        $productId = $product->product_id; // namerus
        $descriptionRu = ProductDescription::findOne(['product_id' => $productId, 'language_id' => 2]);
        if ($descriptionRu) {
            // если в админке стоит чекбокс, то не обновляем
            if($product->not_update_1c != 1) {
                $descriptionRu->name = isset($data['namerus']) ? $data['namerus'] : '';
            }
            $descriptionRu->excerpt = isset($data['description']) ? $data['description'] : '';

        } else {
            $descriptionRu = new ProductDescription();
            $descriptionRu->product_id = $productId;
            $descriptionRu->name = isset($data['namerus']) ? $data['namerus'] : '';
            $descriptionRu->language_id = 2;
            $descriptionRu->excerpt = isset($data['description']) ? $data['description'] : '';
        }

        if (!$descriptionRu->save()) {
            if (SynchronizeGood::LOG_ERROR_DB) {
                LogErrorService::saveValidateToString('save product 1C', $descriptionRu->errors, __FILE__ . ' ' . __LINE__);
            }
        }

        $descriptionUa = ProductDescription::findOne(['product_id' => $productId, 'language_id' => 3]);
        if ($descriptionUa) {
            // если в админке стоит чекбокс, то не обновляем
            if($product->not_update_1c != 1) {
                $descriptionUa->name = isset($data['nameukr']) ? $data['nameukr'] : '';
            }
        } else {
            $descriptionUa = new ProductDescription();
            $descriptionUa->product_id = $productId;
            $descriptionUa->name = isset($data['nameukr']) ? $data['nameukr'] : '';
            $descriptionUa->language_id = 3;
        }

        if (!$descriptionUa->save()) {
            if (SynchronizeGood::LOG_ERROR_DB) {
                LogErrorService::saveValidateToString('save product 1C', $descriptionUa->errors, __FILE__ . ' ' . __LINE__);
            }
        }

        $descriptionEn = ProductDescription::findOne(['product_id' => $productId, 'language_id' => 1]);
        if ($descriptionEn) {
            /*$descriptionEn->name = isset($data['nameen']) ? $data['nameen'] : '';*/
        } else {
            $descriptionEn = new ProductDescription();
            $descriptionEn->product_id = $productId;
            $descriptionEn->name = '-';//isset($data['namerus']) ? $data['namerus'] : '';
            $descriptionEn->language_id = 1;
        }

        if (!$descriptionEn->save()) {
            if (SynchronizeGood::LOG_ERROR_DB) {
                LogErrorService::saveValidateToString('save product 1C', $descriptionEn->errors, __FILE__ . ' ' . __LINE__);
            }
        }
    }

    public static function uploadImage($image, $productId)
    {
        $pathImage = Yii::getAlias('@productImages/');
        $prefix = 'import_files/' . $productId . '/';

        if (!is_dir($pathImage . $prefix)) {
            mkdir($pathImage . $prefix);
        }

        $prefix .= hash('ripemd160', Yii::$app->security->generateRandomString(10));
        $ext = UploadService::createImgWithBase64($pathImage . $prefix, $image);
        if ($ext) {
            return $prefix . '.' . $ext;
        } else {
            if (SynchronizeGood::LOG_ERROR_DB) {
                LogErrorService::saveDB('save product 1C', 'not upload file', __FILE__ . ' ' . __LINE__);
            }

            return false;
        }
    }

    public static function getCategoryIdByGuid($guid)
    {
        return Category::findOne(['guid' => $guid]);
    }

    public static function getCategoryIdByRusName($name)
    {
        return CategoryDescription::findOne(['name' => $name, 'language_id' => 2]);
    }

    // Передаем ид всех категорий по возрастанию где 1-я (главная) подкатегория
    public static function saveAllProductInCategories($catIds, $productId)
    {
        foreach ($catIds as $categoryId) {
            if (!ProductInCategory::findOne(['product_id' => $productId, 'category_id' => $categoryId])) {
                $productInCategory = new ProductInCategory();
                $productInCategory->product_id = $productId;
                $productInCategory->category_id = $categoryId;
                if (!$productInCategory->save()) {
                    if (SynchronizeGood::LOG_ERROR_DB) {
                        LogErrorService::saveValidateToString('save product 1C', $productInCategory->errors, __FILE__ . ' ' . __LINE__);
                    }
                }
            }
        }
    }

    public static function checkAndSaveCategory($productId, $categoryName, $guid)
    {
        // Трекинговая обувь
        // 5208d94c-b3c4-11e1-9f3e-9439e5dc8e50

        $category = self::getCategoryIdByGuid($guid);
        /*
         * Если нашло гуид менять рус название (если не пустое)
         * Если гуид не нашло но нашло по названию ру
             то проверяем если гуид пуст или   00000000-0000-0000-0000-000000000000   меняем или создаем ГУИД
         */

        // Ищим по $guid
        if (isset($category->category_id)) {
            $categoryId = $category->category_id;
            if(!empty($categoryName)) {
                $categoryDescription = CategoryDescription::findOne(['language_id' => 2, 'category_id' => $categoryId]);
                $categoryDescription->name = $categoryName;
                $categoryDescription->save();
            }

        } else {
            // Ищим по рус имени
            $category = self::getCategoryIdByRusName($categoryName);
            if(isset($category->category_id)) {
                $categoryId = $category->category_id;
                if (!empty($guid) && $guid != '00000000-0000-0000-0000-000000000000') {
                    $cat = Category::findOne(['category_id' => $categoryId]);
                    if(empty($cat->guid)) { // || $guid != '00000000-0000-0000-0000-000000000000'
                        $cat->guid = $guid;
                        $cat->save();
                    }
                }
            }
        }

        if (isset($categoryId)) {
            $ids = CategoriesService::getParentCategoriesUpTree($categoryId);
            $catIds = array_column($ids, 'category_id');
            self::saveAllProductInCategories($catIds, $productId);

        } else {
            $newCategoryId = self::createNewCategory($categoryName, $guid);

            if ($newCategoryId) {
                $productInCategory = new ProductInCategory();
                $productInCategory->category_id = $newCategoryId;
                $productInCategory->product_id = $productId;
                if (!$productInCategory->save()) {
                    if (SynchronizeGood::LOG_ERROR_DB) {
                        LogErrorService::saveValidateToString('save product 1C', $productInCategory->errors, __FILE__ . ' ' . __LINE__);
                    }
                }
            }
        }
    }

    public static function createNewCategory($name, $guid)
    {
        $category = new Category();
        $category->status = Category::STATUS_ACTIVE;
        $category->guid = $guid;

        if (!$category->save()) {
            if (SynchronizeGood::LOG_ERROR_DB) {
                LogErrorService::saveValidateToString('save product 1C', $category->errors, __FILE__ . ' ' . __LINE__);
            }
        }

        foreach ([1, 2, 3] as $lang) {
            $categoryDescription = new CategoryDescription();
            $categoryDescription->category_id = $category->category_id;
            $categoryDescription->language_id = $lang;
            $categoryDescription->name = $name;
            if (!$categoryDescription->save()) {
                if (SynchronizeGood::LOG_ERROR_DB) {
                    LogErrorService::saveValidateToString('save product 1C', $categoryDescription->errors, __FILE__ . ' ' . __LINE__);
                }
            }
        }

        $categoryPath = new CategoryPath();
        $categoryPath->category_id = $category->category_id;
        $categoryPath->parent_id = $category->category_id;
        $categoryPath->level = 0;
        if (!$categoryPath->save()) {
            if (SynchronizeGood::LOG_ERROR_DB) {
                LogErrorService::saveValidateToString('save product 1C', $categoryPath->errors, __FILE__ . ' ' . __LINE__);
            }
        }

        self::checkAvailabilityUrl($category->category_id, $name, 'categories', 'view');

        return $category->category_id;
    }
}
