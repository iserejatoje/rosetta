<?php

$orderid = $this->_params['orderid'];

$order = $this->catalogMgr->GetOrder($orderid);

$rk = $this->paymentMgr->GetDefaultAcc();


$json = $rk->getXmlInventory($order);

echo '<pre>';
print_r($json);
echo '</pre>';

exit;