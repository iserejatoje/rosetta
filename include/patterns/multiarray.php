<?
// позволяет работать с данными в виде многомерных массивов
// прокидывая в функции список уровней в виде массива
// работа с данными обязательно через статические методы и свойства
abstract class MultiArray implements ArrayAccess
{
	private $layers = 1;
	private $path;
	public function __construct($layers = 1, $path = array())
	{
		$this->layers = $layers;
		$this->path = $path;
	}
	
	public function newLayer($layers, $path)
	{
		$cn = get_class($this);
		return new $cn($layers, $path);
	}
	
	public function offsetExists($offset)
	{
		array_push($this->path, $offset);
		$res = $this->maExists($this->path, $value);
		array_pop($this->path);
		return $res;
	}
	
	public function offsetGet($offset)
	{
		array_push($this->path, $offset);
		if($this->layers == 1)
			$res = $this->maGet($this->path);
		else
			$res = $this->newLayer($this->layers - 1, $this->path);
		array_pop($this->path);
		return $res;
	}
	
	public function offsetSet($offset, $value)
	{
		array_push($this->path, $offset);
		$this->maSet($this->path, $value);
		array_pop($this->path);
	} 
	
	public function offsetUnset($offset)
	{
		array_push($this->path, $offset);
		$this->maUnset($this->path, $value);
		array_pop($this->path);
	}
	
	function maExists($offset){}
	function maGet($offset){}
	function maSet($offset, $value){}
	function maUnset($offset){}
}
?>