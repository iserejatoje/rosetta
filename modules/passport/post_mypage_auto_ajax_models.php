<?

$parent = App::$Request->Post['parent']->Int(0, Request::UNSIGNED_NUM);

if ( $parent == 0 ) exit;

LibFactory::GetStatic('source');
$models = Source::GetData('db:auto', array( 'type' => 2, 'parent' => $parent ));

include $CONFIG['engine_path'].'include/json.php';

$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';
echo $json->encode($models);

exit;

?>