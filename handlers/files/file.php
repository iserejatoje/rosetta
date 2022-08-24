<?php

require_once ($CONFIG['engine_path'].'handlers/files.php');

class HFilesPluginFile extends HFilesPluginBase
{
	protected $_mode;

	function __construct() {
		$this->_mode = HFilesPluginBase::MODE_HEADER | HFilesPluginBase::MODE_FILE;
	}
	
	public function SendFile() {		
		$fp = fopen($this->_params['path'], 'rb');
		fpassthru($fp);
		fclose($fp);
	}
}

?>