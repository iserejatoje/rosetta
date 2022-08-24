<?
/***************************************************************************
 * Библиотека для цезурирования строковых данных v2
 ***************************************************************************/

class lib_censor
{
	public $dictionaries;	
	public $db;
			
	public static $common_dictionaries = array(
		'stopword_common.txt', 'mat.txt', 'spam.txt'
	);
	
	protected $dict_index = null;
	
	function __construct ( $load_common = true )
	{
		// 2do: убрать когда уберем engine_v1
		//setlocale(LC_ALL, array('ru_RU.cp1251', 'ru_RU.win1251'));
		
		$this->db = DBFactory::GetInstance('sources');
		
		$args = func_get_args();
		array_shift($args);
		
		if ( $load_common === true )
			$this->load_dictionary(self::$common_dictionaries);
		
		foreach ( $args as $arg )
			$this->load_dictionary($arg);
	}
		
	/**
	  Загрузка словаря
	**/
	public function load_dictionary ( $dictionary )
	{		
		if ( is_array($dictionary) )
			$dicts = $dictionary;
		else
			$dicts = explode(',', $dictionary);
		
		foreach ($dicts as $dict )
		{		
			if ( empty($this->dictionaries[$dict]) )
			{
				$sql = "SELECT w.`Value`, w.`WordID`, d.`DictionaryID` FROM `stopwords_words` w";
				$sql.= " INNER JOIN `stopwords_dictionary` d ON d.`DictionaryID` = w.`DictionaryID`";
				$sql.= " WHERE d.`Name` =  '". addslashes($dict) ."'";
				
				$res = $this->db->query($sql);
				if ( $res )
				{
					LibFactory::GetStatic('data');
					while ( $row = $res->fetch_assoc() )
					{
						$this->dictionaries[$dict][$row['WordID']] = Data::ToLatin(strtoupper(trim($row['Value'])));
						$this->dict_index[$dict] = $row['DictionaryID'];
					}
				} else
					error_log("Dictionary '$dict' not found");
			}
		}
	}
	
	/**
	  Проверка массива полей
	**/
	public function is_censored ()
	{
		$args = func_get_args();
		$str = trim($this->implode_recursive(' ', $args));
		
		LibFactory::GetStatic('data');
		$str = ' '.Data::ToLatin(strtoupper($str)).' ';
				
		if ( count($this->dictionaries) > 0 )
			foreach ( $this->dictionaries as $dict => $dictionary )
			{
				if ( count($dictionary) > 0 )
					foreach ( $dictionary as $word )
					{
						$word = trim($word);
						if ( empty($word) )
							continue;
						
						if ( strlen($word) > 1 && substr($word, 0, 1) == '@' && substr($word, -1, 1) == '@' )
						{
							if ( preg_match($word .'i', $str) )
							{
								// проверяем по границе слова
								return false;
							}
						}
						else
						{
							$word = str_replace('@', '\@', preg_quote($word));
							//error_log("'".$str."' - '".$word."'");
							$pattern1 = '@[^\w]+'.$word.'[^\w]+@i';
							if ( strcmp($word, $str) === 0 || preg_match($pattern1, $str) )
							{
								// проверяем по границе слова
								return false;
							}
						}						
					}
			}
		
		return true;
	}
	
	/**
	  Получение списка слов, которые не прошли проверку
	**/
	function get_censored()
	{
		$args = func_get_args();
		$str = $this->implode_recursive(' ', $args);
		$censored_words = array();
		
		LibFactory::GetStatic('data');
		$str = ' '.Data::ToLatin(strtoupper($str)).' ';
				
		if ( count($this->dictionaries) > 0 )
			foreach ( $this->dictionaries as $dict => $dictionary )
			{
				if ( count($dictionary) > 0 )
					foreach ( $dictionary as $word ) 
					{
						$word = trim($word);
						if ( empty($word) )
							continue;
						
						if ( strlen($word) > 1 && substr($word, 0, 1) == '@' && substr($word, -1, 1) == '@' )
						{
							if ( preg_match($word, $str) )
							{
								// проверяем по границе слова
								$censored_words[] = array( 'dictionary' => $dict, 'word' => $word );
							}
						}
						else
						{
							$word = str_replace('@', '\@', preg_quote($word));
							//error_log("'".$str."' - '".$word."'");
							$pattern1 = '@[^\w]+'.$word.'[^\w]+@i';
							if ( strcmp($word, $str) === 0 || preg_match($pattern1, $str) )
							{
								// проверяем по границе слова
								$censored_words[] = array( 'dictionary' => $dict, 'word' => stripslashes($word) );
							}
						}
					}
			}
		
		return $censored_words;
	}
	
	
	private function implode_recursive()
	{
		$args = func_get_args();
		$value = array_pop($args);
		$glue = array_pop($args);
		
		$ret = '';
		
		if ( is_array($value) )
		{
			foreach ( $value as $v )
			{
				if ( is_array($v) )
				{
					foreach ( $v as $_v )
					{
						if(!empty($ret))
							$ret.= $glue;
						$ret.= $this->implode_recursive($glue, $_v);
					}
				}
				else
				{
					if ( !empty($ret) )
						$ret.= $glue;
					$ret.= $v;
				}
			}
		}
		else
			$ret = $value;
		
		return $ret;
	}
	
	public function add_dictionary ( $dict )
	{
		if ( $this->dict_index[$dict] > 0 )
			return $this->dict_index[$dict];
		else
		{
			$sql = "INSERT IGNORE INTO `stopwords_dictionary` SET";
			$sql.= " `Name` = '". addslashes($dict) ."'";		
			$this->db->query($sql);
			return $this->db->insert_id;
		}
		return 0;
	}
	
	public function add_word ( $dict, $word )
	{
		if ( !is_string($dict) || !is_string($word) )
			return 0;
		
		if ( $this->dict_index[$dict] > 0 )
		{
			$id = $dict_index[$dict];
		}
		else
		{
			$sql = "SELECT `DictionaryID` FROM `stopwords_dictionary`";
			$sql.= " WHERE `Name` = '". addslashes($dict) ."'";
			
			$res = $this->db->query($sql);
			if ($res === false)
				return 0;
			if (list($id) = $res->fetch_row())
				$dict_index[$dict] = $id;
			else
				return 0;
		}
		
		return $this->add_word_by_id($id,$word);
	}
	
	public function add_word_by_id ( $dict_id, $word )
	{
		if ( $dict_id <= 0 )
			return 0;

		$sql = "INSERT IGNORE INTO `stopwords_words` SET";
		$sql.= " `DictionaryID` = ".$dict_id.",";
		$sql.= " `Value` = '". addslashes($word) ."'";
		
		$this->db->query($sql);
		
		if ( is_array($this->dict_index) )
		{
			$dict = array_search($dict_id, $this->dict_index);
			if ( !empty($dict) && isset($this->dictionaries[$dict]) )
			{
				//error_log("w ".$word);
				if ( array_search($word, $this->dictionaries[$dict]) )
					$this->dictionaries[$dict][] = $word;
			}
		}
		return $this->db->insert_id;
	}
	
	public function remove_dictionary ( $dict )
	{
		$sql = "SELECT `DictionaryID` FROM `stopwords_dictionary`";
		$sql.= " WHERE `Name` = '". addslashes($dict) ."'";
		
		$res = $this->db->query($sql);
		
		if ( $res && false !== (list($id) = $res->fetch_row()) )
			$this->remove_dictionary_by_id($id);
	}
	
	public function remove_dictionary_by_id ( $dict_id )
	{
		$dict_id = intval($dict_id);
		if ( $dict_id <= 0 )
			return;
		
		$sql = "DELETE FROM `stopwords_words` WHERE `DictionaryID` = {$dict_id}";
		$this->db->query($sql);
		$sql = "DELETE FROM `stopwords_dictionary` WHERE `DictionaryID` = {$dict_id}";
		$this->db->query($sql);
		
		if ( is_array($this->dict_index) )
		{
			$dict = array_search($dict_id,$this->dict_index);
			if ( $dict !== false)
			{
				unset ( $this->dictionaries[$dict] );
				unset ( $this->dict_index[$dict] );
			}
		}
	}
	
	public function remove_word ( $dict, $word )
	{
		if ( !is_string($dict) || !is_string($word) )
			return;
		
		$sql = "SELECT `DictionaryID` FROM `stopwords_dictionary`";
		$sql.= " WHERE `Name` = '". addslashes($dict) ."'";
		
		$res = $this->db->query($sql);
		
		if ( $res && false !== (list($did) = $res->fetch_row()) )
		{
			$sql = "DELETE FROM `stopwords_words` WHERE `DictionaryID` = {$did} AND `Value` = '". addslashes($word) ."'";
			$this->db->query($sql);
			
			if ( isset($this->dictionaries[$dict]) )
			{
				$key = array_search($word,$this->dictionaries[$dict]);
				if ( $key !== false )
					unset ( $this->dictionaries[$dict][$key] );
			}
		}
	}
	
	public function remove_word_by_id ( $dict_id, $id )
	{
		if ( $dict_id <= 0 || $id <= 0 )
			return;
				
		$sql = "DELETE FROM `stopwords_words` WHERE ";
		$sql.= "`DictionaryID` = {$dict_id}";
		if ( is_array($id) )
			$sql.= " AND `WordID` IN (".implode(',',$id).")";
		else
			$sql.= " AND `WordID` = {$id}";
		$this->db->query($sql);
		
		if ( is_array($this->dict_index) )
		{
			$dict = array_search($this->dict_index,$dict_id);
			if ( $dict !== false )
			{
				if ( is_array($id) )
					foreach ( $id as $l )
						unset ($this->dictionaries[$dict][$l]);
				else			
					unset ($this->dictionaries[$dict][$id]);
			}
		}
	}
	
	public function get_dictionary_list()
	{
		$sql = "SELECT * FROM `stopwords_dictionary` ORDER BY `Name`";
		$res = $this->db->query($sql);
		
		$list = array();
		while ( $row = $res->fetch_assoc() )
			$list[$row['DictionaryID']] = $row;
		return $list;
	}
	
	public function get_word_list($dict_id)
	{
		if ( !is_numeric($dict_id) || $dict_id == 0 )
			return array();
		
		$sql = "SELECT * FROM `stopwords_words`";
		$sql.= " WHERE `DictionaryID` = {$dict_id}";
		$sql.= " ORDER BY `Value`";
		$res = $this->db->query($sql);
		
		$list = array();
		while ( $row = $res->fetch_assoc() )
			$list[] = $row;
		return $list;
	}
	
}
?>
