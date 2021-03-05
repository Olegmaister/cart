<?php
namespace api\repositories;

class OneCRepository
{
    public function getIdentifiers($class, $row, $rowSynch , $guids)
    {
        if(!$result =  $class::find()
            ->select($row)
            ->where(['in',$rowSynch,$guids])
            ->asArray()
            ->distinct()
            ->all()){
            throw new \DomainException('Нет совпадений по guid. class ' . __CLASS__.': line '.__LINE__);
        }

        return $result;
    }
}