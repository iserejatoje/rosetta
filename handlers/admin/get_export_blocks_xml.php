<?

if(!$OBJECTS['user']->IsInRole('e_adm_block_export'))
	Response::Status(403, RS_SENDPAGE | RS_EXIT);

$id = $this->pathinfo['section'];
if ( empty($id) )
	Response::Status(404,RS_EXIT);

LibFactory::GetStatic('xml');
$bl = BLFactory::GetInstance('system/blocks');

Response::Header( array(
	'Content-type' => 'text/xml', 'charset' => 'UTF-8',
	'Content-Disposition' => 'attachment; filename=blocks_'.$id.'.xml') );

$blocks = $bl->ExportToXML($id);

echo $blocks;

exit;

?>