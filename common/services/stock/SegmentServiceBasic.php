<?php
namespace common\services\stock;

class SegmentServiceBasic
{
    protected function existsSegment($segments, $customer)
    {
        if(!isset($segments[$customer->type_id]['value']) || empty($segments[$customer->type_id]['value']))
            return false;

        return $segments[$customer->type_id];

    }
}