<?php
namespace common\readModels\Stock;

use common\entities\Stock\Stock;
use common\helpers\DateHelper;

class StockReadRepository
{

    public function relevant($limit,$sort = null,$type = null)
    {

        $query =  Stock::find()
            ->relevant()
            ->andWhere(['in','type',['product','brand','category','present']])
            ->with(['description','slug','photo'])
            ->limit($limit);

        $query->orderBy([
            'stock.date_from' => $this->getSortDate($sort),
        ]);


        if($type){
            $query->andWhere([
                'stock.type' => $type
            ]);
        }

        return $query->all();
    }

    public function relevantCount($type = null)
    {
        $query = Stock::find()
            ->andWhere(['in','type',['product','brand','category','present']])
            ->relevant();
        if($type){
            $query->andWhere(['type' => $type]);
        }

        return $query->count();
    }


    public function checkSlider()
    {
        return Stock::find()
            ->where(['and',
                ['stock.active' => Stock::STATUS_ACTIVE],
                ['slider' => Stock::SLIDER_SHOW],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->all();
    }

    private function getSortDate($sort)
    {
        if(!$sort) return SORT_ASC;
        if($sort == 'asc') return SORT_ASC;
        if($sort == 'desc') return SORT_DESC;
    }

}
