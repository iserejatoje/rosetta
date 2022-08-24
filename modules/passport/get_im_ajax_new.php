<?

Response::NoCache();

if($template === null)
{
	$OBJECTS['smarty']->force_compile = true;
	$template = $this->_config['templates']['im_ajax_new'];
}

include_once $CONFIG['engine_path'].'include/json.php';

$json = new Services_JSON();
$json->charset = 'WINDOWS-1251';

$params['rtype'] = 'ajax';
	
if ( !$OBJECTS['user']->IsAuth() ) {
	$template = $this->_config['templates']['ssections']['login_ajax'];
	$response = array(
		'status' => 'login', 
		'data' => $this->RenderBlock($template, array($params), array($this, '_Get_Login'))
	);
} else 
	$response = array(
		'status' => 'ok', 
		'data' => $this->RenderBlock($template, array($params), array($this, '_Get_IM_New'))
	);

				
echo $json->encode( $response );
exit();

?>