<?
    include_once $CONFIG['engine_path'].'include/json.php';
    include_once $CONFIG['engine_path'].'include/osgallery/osgallerymgr.php';
    $json = new Services_JSON();

    $answer = ServiceMgr::getInstance()->getAlerts();

    echo $json->encode($answer);

    exit;