<?php
namespace common\repositories;

use common\entities\UrlAlias;

class UrlAliasRepository
{
    public function getByKeyword($keyword)
    {
        return UrlAlias::find()->where(['keyword' => $keyword])->one();
    }
}

