<?php
namespace common\entities\queries;

use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryBlogQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;
}