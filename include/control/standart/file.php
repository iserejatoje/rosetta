<?php
/**
 * @author husainov
 * @version 1.0
 * @created 14:16 12.11.2009
 */

class Control_standart_file extends Control_TemplateControl
{
	function __construct($parent = null)
	{
		parent::__construct($parent, 'standart_file');
		$this->SetTemplate('controls/standart/file/default');
		$this->SetDrawContainer(false);
	}

	public function Draw()
	{
		return $this->Fetch(array(
			'this' => $this));
	}
	
	public function PreRender()	{}
	
	// проверка наличия файла	
	public function IsFile()
	{
		return (bool)is_file($_FILES[$this->GetId().'_file']['tmp_name']);
	}
	
	// получение размера файла
	public function GetFilesize()
	{
		if ( $this->IsFile() === true )
			return $_FILES[$this->GetId().'_file']['size'];
		
		return false;
	}
	
	// получение содержимого файла
	public function GetContents()
	{
		if ( $this->IsFile() !== true )
			return null;
		
		return file_get_contents($_FILES[$this->GetId().'_file']['tmp_name']);
	}
	
	// сохранение файла по указанному пути
	public function SaveAs($path)
	{
		Libfactory::GetStatic('filestore');
		
		if ( FileStore::IsDir(dirname($path)) )
			return Filestore::Copy_NEW($_FILES[$this->GetId().'_file']['tmp_name'], $path);
		
		return false;
	}
	
	// загрузка файла в хранилище
	public function Upload($dir, $prefix, $type = null, $max_size = null, $params = array(), $index = null)
	{
		if ( $this->IsFile() !== true )
			return false;
		
		Libfactory::GetStatic('filestore');
		
		return Filestore::Upload_NEW($this->GetId().'_file', $prefix, $type, $max_size, $params, $index);
	}
}
?>