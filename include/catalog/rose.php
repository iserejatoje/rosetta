<?php

LibFactory::GetStatic('arrays');

class Rose extends Product implements IProduct
{

    function __construct(array $info)
    {
        parent::__construct($info);
    }

    // public function getDefaultLen()
    // {
    //     $lens = $this->GetLens();
    //     foreach($lens as $len) {
    //         if($len->isdefault) {
    //             return $len->id;
    //         }
    //     }

    //     return $lens[0]->id;
    // }

    public function GetLens()
    {
        if ($this->_cacheLens !== null)
            return $this->_cacheLens;

        $filter = [
            'flags' => [
                'objects' => true,
                'IsVisible' => 1,
                'ProductID' => $this->id,
            ],
            'field' => ['Ord'],
            'dir' => ['ASC'],
            'dbg' => 0,
        ];

        $lens = CatalogMgr::GetInstance()->GetLens($filter);

        $this->_cacheLens = $lens;
        return $this->_cacheLens;
    }

    public function GetDefaultLen()
    {
        $sql  = "SELECT * FROM ".CatalogMgr::GetInstance()->_tables['rose_len'];
        $sql .= " WHERE ProductID = ".$this->ID;
        $sql .= " AND IsDefault = 1";
        $sql .= " AND IsVisible = 1";

        $res = CatalogMgr::getInstance()->_db->query($sql);
        if ( !$res || !$res->num_rows ) {
            // берем первую длину
            $lens = $this->GetLens();
            if(count($lens) > 0)
                return $lens[0]->len;
        }

        $data = $res->fetch_assoc();
        return $data['Len'];
    }

    public function GetPrice($length, $count, $catalogid)
    {
        $length = intval($length);
        $length = $length > 0 ? $length : $this->GetDefaultLen();
        // echo $length," ",$count," ",$catalogid,"<br>";

        $catalogid = App::$City->CatalogId > 0? App::$City->CatalogId : $catalogid;

        if(intval($count) <= 0 )
            $count = $this->count;

        $lens = $this->GetLens();
        $arrRoses = [];
        foreach($lens as $len) {
            $member = CatalogMgr::GetInstance()->GetMember($len->memberid);
            if($member === null)
                continue;

            $areaRefs = $member->GetAreaRefs($catalogid);

            $arrRoses[$len->Len] = $areaRefs['Price'];
        }

        $type = $this->GetDefaultType($catalogid);
        $composition_price = $type->GetPrice($catalogid);

        $rose_price = 0;
        if(isset($arrRoses[$length]))
            $rose_price = intval($arrRoses[$length]) * $count;

        return $composition_price + $rose_price;
    }

    public function getInvetoryName($item)
    {
        $params = unserialize($item['Params']);
        return $this->name.' '.$params['roses_count'].' шт. '.$params['length'].' см.';
    }
}