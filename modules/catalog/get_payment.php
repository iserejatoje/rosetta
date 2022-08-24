<?php

// if(App::$User->Email != 'admin@rosetta.ru')
//     return false;

// error_reporting(E_ALL);
// error_reporting(E_ERROR);
// ini_set('display_errors', 1);

$orderid = $this->_params['orderid'];
$order = $this->catalogMgr->GetOrder($orderid);


if($order == null)
    Response::Redirect('/'.$this->_env['section'].'/notification/order_unknow/');

if($order->status != CatalogMgr::OS_NEW)
    Response::Redirect('/'.$this->_env['section'].'/notification/order_old/');

if($order->paymentstatus == CatalogMgr::PS_PAID)
    Response::Redirect('/'.$this->_env['section'].'/notification/order_was_paid/');

// $total_price = $order->totalprice + $order->deliveryprice + $order->cardprice;
$total_price = $order->totalprice; // + $order->deliveryprice + $order->cardprice;

$rk = $this->paymentMgr->GetDefaultAcc();

//if(App::$User->Email == 'admin@rosetta.ru') {
//   $total_price = 1;
//}
$params = [
    'orderid' => $order->id,
    'amount'  => $total_price,
    'order' => $order,
    // 'paymentsystem' => $order->paymentsystem,
];

$form = $rk->RenderForm($params);

// if(MODE == 'dev') {
//     echo 'OrderID: ' . $orderid;
//     exit;
// }

return STPL::Fetch('modules/catalog/payment_form', ['form' => $form]);
