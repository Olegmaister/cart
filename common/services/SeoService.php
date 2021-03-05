<?php


namespace common\services;


use common\entities\Seo\Seo;
use common\entities\Seo\SeoAdditionalDescription;
use common\entities\Seo\SeoDescription;
use common\entities\UrlAlias;

class SeoService
{
    public static function getOtherGroups()
    {
        // Это группы из бд по полю и статические страницы
        return [
            'page_home' => 'Главная страница',
            'page_brands' => 'Бренды',
            'page_aktsii' => 'Акции',
            'page_our-stores' => 'Магазины',
            'page_video' => 'Видео обзоры',

            'group_hit' => 'Лидеры',
            'group_new' => 'Новинки',
            'group_sale' => 'Распродажи',
            'group_recommend' => 'Рекомендуемые'
        ];
    }

    public static function getOnPagesData()
    {
        $onPages = UrlAlias::find()
            ->select('keyword, id')
            ->where(['controller' => 'categories'])
            ->all();

        $groups = self::getOtherGroups();

        $onPage = [];
        foreach ($onPages as $page) {
            if(isset($page->categoryDescription->name)) {
                //$onPage[$page->id] = $page->categoryDescription->name;
                $onPage[$page->keyword] = $page->categoryDescription->name;
            }
        }

        return array_merge($groups, $onPage);
    }

    public static function createDescription($post, $seoId)
    {
        foreach ($post as $langId => $data) {
            $description = new SeoDescription();
            $description->seo_id = $seoId;
            $description->language_id = $langId;
            $description->title = $data['title'];
            $description->description = $data['description'];

            $description->save();
        }
    }

    public static function createAdditional($post, $seoId)
    {
        foreach ($post as $langId => $data) {
            foreach ($data as $position => $d) {
                $description = new SeoAdditionalDescription();
                $description->seo_id = $seoId;
                $description->language_id = $langId;
                $description->title = $d['title'];
                $description->text = $d['text'];
                $description->position = $position;

                $description->save();
            }
        }
    }

    public static function upateDescription($post, $seoId)
    {
         foreach ($post as $langId => $data) {
            if (isset($data['id'])) {
                $description = SeoDescription::findOne(['id' => $data['id']]);
            } else {
                $description = new SeoDescription();
                $description->language_id = $langId;
                $description->seo_id = $seoId;
            }


            $description->title = $data['title'];
            $description->description = $data['description'];
            if(!$description->save()) {
                // dd($description->errors);
            }
        }
    }

    public static function upateAdditional($post, $seoId)
    {
        foreach ($post as $langId => $data) {

            foreach ($data as $position => $d) {
                if(isset($d['id'])) {
                    $description = SeoAdditionalDescription::findOne(['id' => $d['id']]);
                } else {
                    $description = new SeoAdditionalDescription();
                }

                $description->seo_id = $seoId;
                $description->language_id = $langId;
                $description->title = $d['title'];
                $description->text = $d['text'];
                $description->position = $position;

                if(!$description->save()) {
                   // dd($description->errors);
                }
            }
        }
    }

    public static function getAdditionalGroups($additionals)
    {
        $additGroups = [];
        foreach ($additionals as $additional) {
            $additGroups[$additional['language_id']][$additional['position']] = $additional;
        }
        return $additGroups;
    }

    public static function getDropDovnOnPages($onPage, $selected = null)
    {
        $html = '<select name="Seo[on_page]" class="form-control" id="on_page">';
        $seo = Seo::find()
            ->select('on_page')
            ->asArray()
            ->all();

        $onPageSelected = array_column($seo,'on_page');

        foreach ($onPage as $key => $val) {
            $select = ($selected != null && $selected == $key) ? ' selected' : '';
            $class = in_array($key, $onPageSelected) ? 'grey' : '';
            $html .= "<option value=\"{$key}\" class=\"{$class}\"{$select}>{$val}</option>";
        }
        $html .= '</select>';

        return $html;
    }
}