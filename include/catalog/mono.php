<?php

LibFactory::GetStatic('arrays');

class Mono extends Product
{
    private $_cacheTypes = null;

    function __construct(array $info)
    {
        parent::__construct($info);
    }

    public function GetPrice($catalogid, $count)
    {
        $catalogid = intval($catalogid);
        $type = $this->default_type;

        if($type === null)
            return false;

        $catalogid = $catalogid > 0 ? $catalogid : App::$City->CatalogId;

        return $type->GetPrice($catalogid, $count);
    }

    public function getInvetoryName($item)
    {
        $params = unserialize($item['Params']);
        return $this->name.' '.$params['flower_count'].' шт. ';
    }

}