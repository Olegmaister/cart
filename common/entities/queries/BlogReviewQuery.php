<?php
namespace common\entities\queries;

use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class BlogReviewQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;
}