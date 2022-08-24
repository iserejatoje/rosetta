<?
    include_once $CONFIG['engine_path'].'include/json.php';
    $json = new Services_JSON();

    $id = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);

    $addition = $this->catalogMgr->GetAddition($id);
    if($addition === null)
    {
        echo $json->encode(array(
            'status' => 'error',
            'errors' => array('Product not found'),
        ));
        exit;
    }

    echo $json->encode(array(
        'status' => 'ok',
        'html' => STPL::Fetch('modules/catalog/detail/_addition', array(
            'addition' => $addition,
        )),
    ));
    exit;