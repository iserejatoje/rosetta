<?php

LibFactory::GetStatic('arrays');

class Fixed extends Product
{
    private $_cacheTypes = null;

    function __construct(array $info)
    {
        parent::__construct($info);
    }

    public function GetTypes($CatalogID = 0)
    {
        if ($this->_cacheTypes !== null)
            return $this->_cacheTypes;

        $filter = array(
            'CatalogID' => $CatalogID,
            'ids' => array($this->ID),
        );

        $result = CatalogMgr::getInstance()->GetTypesByIds($filter);

        $this->_cacheTypes = $result[$this->id];

        return $this->_cacheTypes;
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

}