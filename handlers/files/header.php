<?php

require_once ($CONFIG['engine_path'].'handlers/files.php');

class HFilesPluginHeader extends HFilesPluginBase
{
	protected $_mode;
	
	function __construct() {
		$this->_mode = HFilesPluginBase::MODE_HEADER;
	}

	public function SendHeader(){
		parent::SendHeader();

		Response::Header('X-Accel-Redirect', $this->_params['redirect']);
	}
}

?>