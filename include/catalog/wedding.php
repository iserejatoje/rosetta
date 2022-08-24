<?php

LibFactory::GetStatic('arrays');

class Wedding extends Product
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

}