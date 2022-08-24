<?php

LibFactory::GetStatic('arrays');

class Add extends Product implements IProduct
{

    function __construct(array $info)
    {
        parent::__construct($info);
    }

    public function GetPrice()
    {
        return $this->price;
    }
}