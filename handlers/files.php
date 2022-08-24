<?php

class Handler_files extends IHandler
{
	private $_params;
		
	public function Run(){
	
		global $OBJECTS, $CONFIG;
		
		if (!ctype_alnum( $this->_params['type'] ) 
			|| !is_file( $CONFIG['engine_path'].'handlers/files/'.$this->_params['type'].'.php' )
			)
			Response::Status(404, RS_SENDPAGE | RS_EXIT);
		
		include $CONFIG['engine_path'].'handlers/files/'.$this->_params['type'].'.php';
		$cname = 'HandlerPlugin_files_'.$this->_params['type'];
		$obj = new $cname;
				
		if ($obj->Init( $this->_params )){
			
			if ($obj->GetMode() & HFilesPluginBase::MODE_HEADER)
				$obj->SendHeader();
				
			if ($obj->GetMode() & HFilesPluginBase::MODE_FILE)
				$obj->SendFile();			
		} else {
			Response::Status(404, RS_SENDPAGE | RS_EXIT);
		}
	}
	
	public function Init($params){
	
		$this->_params = $params;
		$this->_params['id']		= $_GET['id'];
		$this->_params['type'] 	= $_GET['type'];
	}
	
	public function IsLast(){
		return true;
	}
	
	public function Dispose(){
	
	}
}


class HFilesPluginBase
{
	// заголовок
	protected $_header;
	
	// режим работы плагина, объеденеяет режимы побитовым И
	protected $_mode;
	//
	protected $_params;
	
	// режим отправки заголовка
	const  MODE_HEADER = 1;

	// отправка файла
	const  MODE_FILE = 2;
	
	function __construct() {
	
	}
	
	// вернуть заголовок
	public function GetHeader(){
		return $this->_header;
	}
	
	//возвращает режим отправки файла
	public function GetMode(){
		return $this->_mode;
	}
	
	//есть ли роль на отправку файла для данных параметров, пустой метод
	public function IsInRole() {
	
	}
	
	//отправить файл, вызывается только если CanSendFile() == true, пустой метод
	public function SendFile() {
	
	}
	
	//отправить заголовок, пустой метод
	public function SendHeader() {
		Response::Header($this->_header);
	}
	
	//инициализация плагина
	public function Init($params){
	
		if (is_array( $params ))
			$this->_params = $params;
		else{
			$this->_params = array();
			return false;
		}
			
		if (!isset( $this->_params['mimetype'] ))
			$this->_params['mimetype'] = 'application/octet-stream';
			
			$this->_header = array();
		if (file_exists( $this->_params['path'] )) {
		
			$this->_header['Content-Type'] 		= $this->_params['mimetype'];
			$this->_header['Last-Modified']		= gmdate('r', filemtime($this->_params['path']));
			$this->_header['ETag'] 					=  sprintf('%x-%x-%x', fileinode($this->_params['path']), filesize($this->_params['path']), filemtime($this->_params['path']));
			$this->_header['Content-Length'] 	= filesize($this->_params['path']);
			$this->_header['Connection'] 		= 'close';			
			$this->_header['Pragma'] 				= 'no-cache';
			
			$ff 		= strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false;
			$opera 	= strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false;
			$fname 	= $this->_params['filename'];
			
			if ($ff) // FireFox не понимает пробелы в имени файла
				$fname = str_replace(' ', '_', $fname);
			
			if ($opera) // Opera Только в UTF-8 воспринимает
				$fname = iconv('WINDOWS-1251', 'UTF-8', $fname);
			
			$this->_header['Content-Disposition'] = 'attachment; filename="'.$fname.'";';
			
			return true;
		}else{
			return false;
		}
	}
}

?>