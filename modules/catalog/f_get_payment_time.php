<?

$bl = BLFactory::GetInstance('system/config');
$config_catalog = $bl->LoadConfig('module_engine', 'catalog');

$params = $params[0];

if($params['type'] == CatalogMgr::DT_DELIVERY) {
    
    $payment_time = CatalogMgr::getPaymentTime(date('d.m.Y', $params['delivery']['date']), $params['delivery']['from']);
    if(!CatalogMgr::validateTime('delivery', $params['delivery']['date'], $params['delivery']['from'], $params['delivery']['to'])) {
        $payment_time['errors']['time-delivery-from'] = $config_catalog['time_message']['delivery'];
    }
   
} elseif($params['type'] == CatalogMgr::DT_PICKUP) {
    $payment_time = CatalogMgr::getPaymentTime(date('d.m.Y', $params['pickup']['date']), $params['pickup']['from']);
    if(!CatalogMgr::validateTime('pickup', $params['pickup']['date'], $params['pickup']['from'], $params['pickup']['to'])) {
        $payment_time['errors']['time-pickup-from'] = $config_catalog['time_message']['pickup'];
    }
}

return $payment_time;