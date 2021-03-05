<?php

namespace common\helpers;

use Yii;

class LanguageHelper
{
    public const DEFAULT_LANGUAGE_ID = 2;
    public const EN_ID = 1;
    public const RU_ID = 2;
    public const UA_ID = 3;

    public static $defaultLang = 'ru-RU';
    public static $defaultSign = 'ru';
    public static $defaultLangId = '2';

    public static function getCurrent(): string
    {
        $lang = Yii::$app->language;

        return self::getSlugByCode($lang);
    }

    public static function getCurrentId(): string
    {
        return self::getIdByCode(Yii::$app->language);
    }

    public static function getLang(string $slug): string
    {
        $langArr = [
            'en' => 'en-EN',
            'ru' => 'ru-RU',
            'ua' => 'ua-UA',
        ];

        return $langArr[$slug] ?? self::$defaultLang;
    }

    public static function getSlugByCode(string $slug): string
    {
        $langArr = [
            'en-EN' => 'en',
            'en-US' => 'en',
            'ru-RU' => 'ru',
            'ua-UA' => 'ua',
        ];

        return $langArr[$slug] ?? self::$defaultSign;
    }

    public static function getIdByCode(string $code): string
    {
        $langArr = [
            'en-EN' => '1',
            'en-US' => '1',
            'ru-RU' => '2',
            'ua-UA' => '3',
        ];

        return $langArr[$code] ?? '3';
    }

    public static function getByCode(string $codeName): int
    {
        $langArr = [
            'en' => 1,
            'ru' => 2,
            'ua' => 3,
        ];

        return $langArr[$codeName];
    }

    public static function getPrefixById($id): string
    {
        $langPrefix = [
            1 => 'en',
            2 => 'ru',
            3 => 'ua',
        ];

        return isset($langPrefix[$id]) ? $langPrefix[$id] : '';
    }

    public static function getLangById($langId): string
    {
        $langArr = [
            1 => 'en-EN',
            2 => 'ru-RU',
            3 => 'ua-UA',
        ];

        return $langArr[$langId] ?? self::$defaultLang;
    }

    public static function getLink(string $lang): string
    {
        $link = Yii::$app->request->url;
        $lang = ($lang === 'ru') ? '' : $lang;

        if (strpos($link, '/en') !== false) {
            $link = ($lang === 'en') ? $link : str_replace('/en', '/' . $lang, $link);
        } elseif (strpos($link, '/ua') !== false) {
            $link = ($lang === 'ua') ? $link : str_replace('/ua', '/' . $lang, $link);
        } else {
            $link = ($lang === 'en' || $lang === 'ua') ? '/' . $lang . '/' . $link : $link;
        }

        $fullLink = str_replace('//', '/', $link);

        if (strlen($fullLink) > 1) {
            return (substr($fullLink, -1) === '/') ? substr($fullLink, 0, -1) : $fullLink;
        }

        return $fullLink;
    }

    /**
     * @param string $link
     * @return string
     */
    public static function langUrl($link = ''): string
    {
        $link = ($link === '/') ? '' : $link;
        $lang = self::getCurrent();
        $normalization = ($lang === 'ru') ? '' : $lang . '/';
        $fullLink = '/' . $normalization . $link;

        if (strlen($fullLink) > 1) {
            return (substr($fullLink, -1) === '/') ? substr($fullLink, 0, -1) : $fullLink;
        }

        return $fullLink;
    }

    public static function translateByLangId($libName, $word, $languageId)
    {
        $prefix = self::getPrefixById($languageId);

        $pathFile = __DIR__ . '/../../' . Yii::getAlias('frontend/') . 'messages/' . $prefix . '/' . $libName . '.php';
        if(file_exists($pathFile)) {
            $file = include($pathFile);
        }

        if(isset($file[$word])) {
            return $file[$word];
        }

        return $word;
    }

    public static function updateCustomerLanguage(): void
    {
        $user = Yii::$app->user->identity;

        $link = Yii::$app->request->url;

        if (strpos($link, '/en') !== false) {
            $lang = 'en-EN';
        } elseif (strpos($link, '/ua') !== false) {
            $lang = 'ua-UA';
        } else {
            $lang = 'ru-RU';
        }


        if (Yii::$app->user->isGuest || $user->profile->language === $lang) {
            return;
        }

        $user->profile->language = $lang;
        $user->profile->save();
    }
}
