<?

$cacheid = $this->_env['sectionid'];
return $this->RenderBlock(
	$this->_config['templates']['ssections'][$this->_page],
	array(),
	array($this, '_Get_TreePlain'),
	true,
	86400,
	$cacheid,
	'page'
);

?>
