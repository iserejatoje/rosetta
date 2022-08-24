<?php

/*
CREATE TABLE `cart_trying` (
`CartCode` varchar(100) NOT NULL,
`Count` tinyint(1) UNSIGNED DEFAULT 0,
`UpdatedAt` INT(11) UNSIGNED,
PRIMARY KEY (`CartCode`),
KEY `idx_cart_trying_stock_CartCode` (`CartCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/

class CartTrying
{
    const MAX_COUNT = 2;
    const TIME_LIMIT = 60 * 15;

    private $code;
    private $count;
    private $updatedAt;
    private $isNull = false;

    private $repo;

    function __construct($code)
    {
        $this->repo = CatalogMgr::getInstance();
        $this->code = addslashes($code);

        if(!$this->code) {
            $this->isNull = true;
            return;
        }

        $tmp = $this->repo->getTrying($code);
        $this->count = $tmp['Count'];
        $this->updatedAt = $tmp['UpdatedAt'];
    }

    public function can()
    {
        if($this->isNull)
            return false;

        if($this->count < self::MAX_COUNT)
            return true;

        if(time() - $this->updatedAt > self::TIME_LIMIT) {

            $this->reset();

            return true;
        }

        return false;
    }

    public function reset()
    {
        $this->repo->changeTryingCounter($this->code);
    }

    public function inc()
    {
        return $this->repo->changeTryingCounter($this->code, false);
    }

    public function getMessage()
    {
        if($this->isNull)
            return 'Срок действия корзины закончен';

        return 'Вы исчерпали количество попыток ввода. Повторите позже.';

        // return 'Вы исчерпали количество попыток. Повторите через ' . ($this->updatedAt + self::TIME_LIMIT - time()) . ' сек.';
    }

    public function getRemainingTime()
    {
        $time = $this->updatedAt + self::TIME_LIMIT - time();
        return $time > 0 ? $time : 0;
    }
}