<?php


/**
 * @author Евгений Овчинников
 * @version 1.0
 * @created 30-июл-2008 14:21:21
 */
class lib_address
{

	/**
	 * страна, идентификатор
	 */
	private $_Country = 0;
	
	/**
	 * область, идентификатор
	 */
	private $_Region = 0;
	
	/**
	 * город, идентификатор
	 */
	private $_City = 0;
	
	/**
	 * улица, идентификатор
	 * зарезервировано (не реализовывать)
	 */
	private $_Street = 0;
	
	/**
	 * номер дома, идентификатор
	 * зарезервировано (не реализовывать)
	 */
	private $_House = 0;
	
	/**
	 * страна текст
	 */
	private $_CountryAsText = null;
	
	/**
	 * область текст
	 */
	private $_RegionAsText = null;
	
	/**
	 * город текст, изменяемое поле, если при инициализации поле не задано,
	 * подтягивать имя из source:location при запросе, если инициализировано, то
	 * использтвать переданный текст, в случае изменения поля, попробовать найти в
	 * базе городов, если отсутствует: сбросить City в 0 и установить CityText, если
	 * найдет, то в City установить идентификатор и сбросить CityText
	 */
	private $_CityAsText = null;
	
	/**
	 * улица, текст
	 */
	private $_StreetText = null;
	
	/**
	 * номер дома, текст
	 */
	private $_HouseText = null;
	
	/**
	 * постфикс номера дома
	 * зарезервировано (не реализовывать)
	 */
	private $_Postfix = null;
	
	/**
	 * текстовое представление адреса, если при инициализации задается, то
	 * используется только это поле
	 */
	public $Text = null;
	
	function __construct()
	{
		LibFactory::GetStatic('source');
	}

	/**
	 * 
	 * @param info    Поля из бд
	 */
	public function Init(array $info)
	{
		if ( !sizeof($info) )
			return false;
			
		$info = array_change_key_case($info, CASE_LOWER);
		
		if ( !empty($info['text']) )
			$this->Text = $info['text'];

		// Инициализация страны
		if ( $info['country'] && Data::Is_Number($info['country']) )
			$this->_Country = $info['country'];
		else if ( !empty($info['countrytext']) )
			$this->_CountryAsText = $info['countrytext'];
		
		// Инициализация региона
		if ( $info['region'] && Data::Is_Number($info['region']) )
			$this->_Region = $info['region'];
		else if ( !empty($info['regiontext']) )
			$this->_RegionAsText = $info['regiontext'];
		
		// Инициализация города
		if ( $info['city'] && Data::Is_Number($info['city']) )
			$this->_City = $info['city'];
		else if ( !empty($info['citytext']) )
			$this->_CityAsText = $info['citytext'];
			
		if ( !empty($info['streettext']) )
			$this->_StreetText = $info['streettext'];
			
		if ( !empty($info['housetext']) )
			$this->_HouseText = $info['housetext'];
			
		return true;
	}
	 
	public function Check()
	{	

		if ( $this->Text !== null )
			return true;

		// Инициализация страны
		if ( $this->_Country > 0 ) {
			$country = Source::GetData('db:location', array('type' => 'country', 'id' => $this->_Country));
			
			if ( !isset($country[$this->_Country]) ) 
				return false;
				
			$this->_CountryAsText = $country[$this->_Country]['name'];
		} else if ( $this->CountryAsText !== null ) {
			$this->_CountryText = $this->CountryAsText;
		} else
			return false;
		
		// Инициализация региона
		if ( $this->_Region > 0 ) {
			$region = Source::GetData('db:location', array('type' => 'region', 
				'country' => $this->_Country, 'id' => $this->_Region));
				
			if ( !isset($region[$this->_Region]) ) 
				return false;
				
			$this->_RegionAsText = $region[$this->_Region]['name'];
		} else if ( $this->RegionAsText !== null )
			$this->_RegionText = $this->RegionAsText;
		else
			return false;
		
		// Инициализация города
		if ( $this->_City > 0 ) {
			$city = Source::GetData('db:location', array('type' => 'city', 
				'country' => $this->_Country,  'region' => $this->_Region, 'id' => $this->_City));
				
			if ( !isset($city[$this->_City]) ) 
				return false;
			
			$this->_CityAsText = $city[$this->_City]['name'];
		} else if ( $this->CityAsText !== null )
			$this->_CityText = $this->CityAsText;
			
		return true;
	}
	
	function __set($name, $value) {
	
		switch ($name) {
			case 'Country':
				if (Data::Is_Number($value))
					$this->_Country = $value;
			break;
			case 'Region':
				if (Data::Is_Number($value))
					$this->_Region = $value;
			break;
			case 'City':
				if (Data::Is_Number($value))
					$this->_City = $value;
			break;
			case 'CountryText':
				$src = array_keys(Source::GetData('db:location', array('type' => 'country', 'name' => $value)));

				if ( !empty($src[0]) )
					$this->_Country = $src[0];
				else
					$this->_Country = 0;
				
				$this->_CountryAsText = $value;
			break;
			
			case 'RegionText':
				$src = array_keys(Source::GetData('db:location', array('type' => 'region', 
					'country' => $this->_Country, 'name' => $value)));
				if ( !empty($src[0]) )
					$this->_Region = $src[0];
				else
					$this->_Region = 0;
				
				$this->_RegionAsText = $value;
			break;
			
			case 'CityText':
			
				$value = trim($value);
				
				if ( !empty($value) ) {
					$src = array_keys(Source::GetData('db:location', array('type' => 'city', 
						'country' => $this->_Country,  'region' => $this->_Region, 'name' => $value)));
						
					if ( !empty($src[0]) )
						$this->_City = $src[0];
					else
						$this->_City = 0;
					
					$this->_CityAsText = $value;
				}
			break;
			
			case 'StreetText':
				$this->_StreetText = $value;
			break;
			case 'HouseText':
				$this->_HouseText = $value;
			break;
		}
		return null;
	}
	
	function __get($name) {
	
		//if ( $this->Text !== null && !in_array($name, array('CountryAsText','RegionAsText','CityAsText')) )
		//	return '';
		
		switch ($name) {
			case 'CountryText':
				if ( $this->_Country )
					return '';
				return $this->CountryAsText;
			case 'CountryAsText':
				if ( $this->_CountryAsText !== null || !$this->_Country)
					return $this->_CountryAsText;
			
				$country = Source::GetData('db:location', array('type' => 'country', 'id' => $this->_Country));
				if ( !isset($country[$this->_Country]) ) 
					return $this->_CountryAsText = '';
					
				return $this->_CountryAsText = $country[$this->_Country]['name'];
			break;
			
			case 'RegionText':
				if ( $this->_Region )
					return '';
				return $this->RegionAsText;
			case 'RegionAsText':
				if ( $this->_RegionAsText !== null || !$this->_Region)
					return $this->_RegionAsText;
				
				$region = Source::GetData('db:location', array('type' => 'region', 
					'country' => $this->_Country, 'id' => $this->_Region));
				
				if ( !isset($region[$this->_Region]) ) 
					return $this->_RegionAsText = '';
					
				return $this->_RegionAsText = $region[$this->_Region]['name'];
			break;
			
			case 'CityText':
				if ( $this->_City )
					return '';
				return $this->CityAsText;
			case 'CityAsText':
				if ( $this->_CityAsText !== null || !$this->_City)
					return $this->_CityAsText;
			
				$city = Source::GetData('db:location', array('type' => 'city', 
					'country' => $this->_Country,  'region' => $this->_Region, 'id' => $this->_City));
				
				if ( !isset($city[$this->_City]) ) 
					return $this->_CityAsText = '';
				
				return $this->_CityAsText = $city[$this->_City]['name'];
			break;
			
			case 'Country':
				return $this->_Country;
			case 'Region':
				return $this->_Region;
			case 'City':
				return $this->_City;
			case 'StreetText':
				return $this->_StreetText;
			case 'HouseText':
				return $this->_HouseText;
			case 'Street':
				return $this->_Street;
			case 'House':
				return $this->_House;
			case 'Postfix':
				return $this->_Postfix;
		}
		return null;
	}
	
	function __destruct()
	{
	}
}














?>