<?

class Cache_dummy_Trait extends CacheTrait 
{
	/**
	 * @desc Инициализация
	 */
	function Init() 
	{

	}

	/**
	 * @desc проеверка подключенности к базе
	 * @return true если подключен
	 */
	function IsEnabled() 
	{
		return false;
	}

	/**
	 * @desc проверка наличия информации в кэше
	 * @return true если есть запись в кэше
	 */
	function IsCache($id, $key) 
	{
		return false;
	}

	/**
	 * @desc Получить данные из кэша
	 * @return Значение кэша, если данных нет false
	 */
	function Get($id) 
	{
		return false;
	}

	/**
	 * @desc Добавить информацию в кэш
	 */
	function Set($id, $value, $timeout, $method = null, $tags = false)
	{
		return false;
	}

	/**
	 * @desc Удалить информацию из кэша
	 */
	function Remove($id) 
	{
		return false;
	}

	/**
	 * @desc Удалить информацию из кэша используя ключ
	 */
	function Clear($id) 
	{
		return true;
	}
	

	/**
	 * @desc Удалить информацию из кэша используя тег
	 */
	function ClearTags($tags = array())
	{
		return true;
	}

	/**
	 * @desc Очистить временную папку кеша
	 */
	function Clear_Temp($dir = '', $deleteMe = false) {

		return true;
	}

	/**
	 * @desc Продлить время жизни данных в кэше
	 */
	function Touch($id, $timeout) 
	{
	}

	private function PrepareId($path)
	{
		return false;
	}
	
	function GC() {
	}
}
?>