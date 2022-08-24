<?

if(!$OBJECTS['user']->IsInRole('e_adm_env_export'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$id = App::$Request->Get['id']->Value();

if ( empty($id) )
	Response::Status(404,RS_EXIT);

LibFactory::GetStatic('xml');
$bl = BLFactory::GetInstance('system/env');

Response::Header( array('Content-type' => 'text/xml', 'charset' => 'UTF-8') );

echo XML::ToXML($bl->LoadEnv($id));

exit;

?>