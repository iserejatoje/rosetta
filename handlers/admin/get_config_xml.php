<?

if(!$OBJECTS['user']->IsInRole('e_adm_config_export'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$type = App::$Request->Get['type']->Value();
$id = App::$Request->Get['id']->Value();

if ( empty($type) || empty($id) )
	Response::Status(404,RS_EXIT);

LibFactory::GetStatic('xml');
$bl = BLFactory::GetInstance('system/config');

Response::Header( array('Content-type' => 'text/xml', 'charset' => 'UTF-8') );

echo XML::ToXML($bl->LoadConfig($type, $id));

exit;

?>