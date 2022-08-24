<?php

if(1)
{
	$error_code = 0;
	define('ERR_A_PAGE_MASK', 0x00590000);
	define('ERR_A_PAGE_UNKNOWN_ERROR', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_PAGE_UNKNOWN_ERROR] = 'Незвестная ошибка.';

	define('ERR_A_PAGE_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_PAGE_NOT_FOUND] = 'Страница не найдена.';

	define('ERR_A_PAGE_NAME_EXCEED', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_PAGE_NAME_EXCEED] = 'Максимальная длина Названия 200 символов.';

	define('ERR_A_PAGE_NAME_EMPTY', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_PAGE_NAME_EMPTY] = 'Название не может быть пустым.';

	define('ERR_A_PAGE_NAMEID_EMPTY', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_PAGE_NAMEID_EMPTY] = 'ID домена не может быть пустым.';

	define('ERR_A_CITY_DOMAIN_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_CITY_DOMAIN_NOT_FOUND] = 'Город (домен) не найден.';

	define('ERR_A_CITY_DELIVERY_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_CITY_DELIVERY_NOT_FOUND] = 'Город доставки не найден.';

	define('ERR_A_DISTRICT_DELIVERY_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_DISTRICT_DELIVERY_NOT_FOUND] = 'Район доставки не найден.';

	define('ERR_A_STORE_NOT_FOUND', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_STORE_NOT_FOUND] = 'Магазин не найден.';

	define('ERR_A_STORE_EMAIL_WRONG_FORMAT', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_STORE_EMAIL_WRONG_FORMAT] = 'Неверный формат электронной почты';

	define('ERR_A_STORE_ERROR_UPLOAD_IMAGE', ERR_A_PAGE_MASK | $error_code++);
	UserError::$Errors[ERR_A_STORE_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';
}


class AdminModule
{
	static $TITLE = 'Текстовая страница';

	private $_db;

	private $_config;

	private $_page;
	private $_id;
	private $_title;
	private $citymgr;
	private $pmmgr;

	function __construct($config, $aconfig, $id) {
		global $OBJECTS;

		$this->_id = &$id;
		$this->_config = &$config;
		$this->_aconfig = &$aconfig;
		$this->_db = DBFactory::GetInstance($this->_config['db']);

		LibFactory::GetMStatic('cities', 'citiesmgr');
		LibFactory::GetMStatic('payments', 'paymentmgr');

		$this->citymgr = CitiesMgr::GetInstance();
		$this->pmmgr = PaymentMgr::GetInstance();

		LibFactory::GetStatic("data");
		LibFactory::GetStatic("ustring");

		LibFactory::GetStatic('cache');
		LibFactory::GetStatic('data');

		App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-1.10.2.js');
		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js');

		App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
		App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');

		App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');
		App::$Title->AddScript('http://api-maps.yandex.ru/2.1/?lang=ru_RU');
	}

	// обязательные функции
	function Action()
	{
		if($this->_PostAction()) return;
		$this->_GetAction();
	}

	function GetPage()
	{
		switch($this->_page)
		{
			// stores
			case 'stores':
				$this->_title = "Список магазинов";
				$html = $this->_GetStores();
				break;
			case 'new_store':
				$this->_title = "Добавить магазин";
				$html = $this->_GetStoreNew();
				break;
			case 'edit_store':
				$this->_title = "Редактировать магазин";
				$html = $this->_GetStoreEdit();
				break;
			case 'delete_store':
				$this->_GetStoreDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&deliveryid='.$_GET['deliveryid']);
				break;
			case 'ajax_store_toggle_available':
				$this->_GetAjaxToggleStoreAvailable();
				break;
			case 'ajax_store_toggle_pickup':
				$this->_GetAjaxToggleStorePickup();
				break;
			// delivery districts
			case 'districts':
				$this->_title = "Список районов";
				$html = $this->_GetDeliveryDistricts();
				break;
			case 'new_district':
				// $this->_title = "Добавить район";
				$html = $this->_GetDeliveryDistrictNew();
				break;
			case 'edit_district':
				$this->_title = "Редактировать район";
				$html = $this->_GetDeliveryDistrictEdit();
				break;
			case 'delete_district':
				$this->_GetDeliveryDistrictDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&deliveryid='.$_GET['deliveryid']);
				break;
			// cities domain
			case 'cities':
				$this->_title = "Список городов";
				$html = $this->_GetCities();
				break;
			case 'new_city':
				$this->_title = "Добавить домен";
				$html = $this->_GetCityNew();
				break;
			case 'edit_city':
				$this->_title = "Редактировать домен";
				$html = $this->_GetEditCity();
				break;
			case 'ajax_city_toggle_visible':
				$this->_GetAjaxToggleCityVisible();
				break;
			case 'ajax_city_toggle_default':
				$this->_GetAjaxToggleCityDefault();
				break;
			case 'delete_city':
				$this->_GetCityDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
				break;
			case 'delivery_cities':
				$html = $this->_GetDeliveryCities();
				break;
			case 'new_delivery':
				$this->_title = "Добавить город";
				$html = $this->_GetDeliveryNew();
				break;
			case 'edit_delivery':
				$this->_title = "Редактировать город";
				$html = $this->_GetDeliveryEdit();
				break;
			case 'ajax_city_toggle_available':
				$this->_GetAjaxToggleDeliveryAvailable();
				break;
			case 'ajax_district_toggle_available':
				$this->_GetAjaxToggleDeliveryDistrictAvailable();
				break;
			case 'delete_delivery':
				$this->_GetDeliveryDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=delivery_cities&id='.$_GET['cityid']);
				break;
			default:
				$this->_title = "Редактировать домены";
				$html = $this->_GetCities();
				break;
		}
		return $html;
	}

	function GetTabs() {
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'cities', 'text' => 'Поддомены'),
			),
			'selected' => $this->_page);
	}

	function GetTitle() {
		return $this->_title;
	}

	// обработка запросов
	private function _PostAction() {
		global $DCONFIG, $OBJECTS;

		switch($_POST['action'])
		{
			// store actions
			case 'new_store':
				if ($this->_PostStoreNew())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&deliveryid='.$_POST['deliveryid']);
				break;
			case 'edit_store':
				if ($this->_PostStoreEdit())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&deliveryid='.$_POST['deliveryid']);
				break;
			case 'save_stores':
				if ($this->_PostStoresSave())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=stores&deliveryid='.$_POST['deliveryid']);
				break;
			// districts actions
			case 'new_district':
				if ($this->_PostDeliveryDistrictNew())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&deliveryid='.$_POST['deliveryid']);
				break;
			case 'edit_district':
				if ($this->_PostDeliveryDistrictEdit())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&deliveryid='.$_POST['deliveryid']);
				break;
			case 'save_districts':
				if ($this->_PostDeliveryDistrictsSave())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=districts&deliveryid='.$_POST['deliveryid']);
				break;

			case 'new_city':
				if ($this->_PostCityNew())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
				break;
			case 'edit_city':
				if ($this->_PostCityEdit())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
				break;
			// Редирект на список доставок, а не городов/доменов.
			case 'new_delivery':
				if ($this->_PostDeliveryNew())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=delivery_cities&id='.$_POST['сityid']);
				break;
			case 'edit_delivery':
				if ($this->_PostDeliveryEdit())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=delivery_cities&id='.$_POST['сityid']);
				break;
		}
		return false;
	}

	private function _GetAction() {
		global $DCONFIG;
		switch($_GET['action'])
		{
			default:
				$this->_page = $_GET['action'];
				break;
		}
	}


	private function _GetCities()
	{
		global $DCONFIG, $CONFIG;

		// $page		= App::$Request->Get['page']->Int(1, Request::UNSIGNED_NUM);

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => -1,
				// 'SectionID' => $this->_id,
			),
			'field' => array(
				'Date',
			),
			'dir' => array(
				'DESC',
			),
			// 'offset'=> ($page - 1) * self::$ROW_ON_PAGE,
			// 'limit' => self::$ROW_ON_PAGE,
			// 'calc'	=> true,
		);

		$cities = $this->citymgr->GetCities($filter);

		// $pages = Data::GetNavigationPagesNumber(
		// 	self::$ROW_ON_PAGE, self::$PAGES_ON_PAGE, $count, $page,
		// 	"?section_id=". $this->_id ."&action=articles&page=@p@");

		return STPL::Fetch('admin/modules/cities/cities_list', array(
			'section_id' => $this->_id,
			'cities' => $cities,
			// 'pages' => $pages,
		));
	}

	private function _GetCityNew() {

		global $DCONFIG, $CONFIG, $OBJECTS;

		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');

		$form = array();

		$form['SectionID'] = $this->_id;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Name']      = App::$Request->Post['Name']->Value(Request::OUT_HTML);
			$form['NameID']    = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
			$form['Street']    = App::$Request->Post['Street']->Value(Request::OUT_HTML);
			$form['Domain']    = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
			$form['CatalogId'] = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
			$form['PhoneCode'] = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
			$form['Phone']     = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
			$form['Latitude']  = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
			$form['Longitude'] = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
			$form['SEOText']   = App::$Request->Post['SEOText']->Value();
			$form['Metrika']   = App::$Request->Post['Metrika']->Value();
		}
		else
		{
			$form['NameID']      = '';
			$form['Street']    = '';
			$form['Domain']    = '';
			$form['CatalogId'] = '';
			$form['PhoneCode'] = '';
			$form['Phone']     = '';
			$form['Latitude']  = '';
			$form['Longitude'] = '';
			$form['SEOText']   = '';
			$form['Metrika']   = '';
			$form['IsVisible'] = 1;
			$form['IsDefault'] = 0;
		}

		return STPL::Fetch('admin/modules/cities/edit_city', array(
			'section_id' 	=> $this->_id,
			'form' 			=> $form,
			'action' 		=> 'new_city',
		));
	}

	// Редактировать
	private function _GetEditCity()
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jqueryui/jquery-ui-1.8.14.custom.min.js');

		$CityID = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

		$city = $this->citymgr->GetCity($CityID);
		if ($city === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_PAGE_NOT_FOUND);
			return STPL::Fetch('admin/modules/cities/edit_city');
		}

		$form['CityID']	= $city->ID;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['action'] = 'new_city';
			$form['Name'] = App::$Request->Post['Name']->Value(Request::OUT_HTML);
			$form['NameID'] = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
			$form['Street'] = App::$Request->Post['Street']->Value(Request::OUT_HTML);
			$form['Domain'] = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
			$form['CatalogId'] = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
			$form['PhoneCode'] = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
			$form['Phone'] = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
			$form['Latitude'] = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
			$form['Longitude'] = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
			$form['SEOText'] = App::$Request->Post['SEOText']->Value();
			$form['Metrika'] = App::$Request->Post['Metrika']->Value();
		}
		else
		{
			$form['action']    = 'edit_city';
			$form['Name']      = $city->Name;
			$form['NameID']      = $city->NameID;
			$form['IsVisible'] = (int) $city->IsVisible;
			$form['IsDefault'] = (int) $city->IsDefault;
			$form['Street']    = $city->Street;
			$form['Domain']    = $city->Domain;
			$form['CatalogId'] = $city->CatalogId;
			$form['PhoneCode'] = $city->PhoneCode;
			$form['Phone']     = $city->Phone;
			$form['Latitude']  = $city->Latitude != "" ? $city->Latitude : 0;
			$form['Longitude'] = $city->Longitude!= "" ? $city->Longitude : 0;
			$form['SEOText']   = $city->SEOText;
			$form['Metrika']   = $city->Metrika;
		}

		return STPL::Fetch('admin/modules/cities/edit_city', array(
			'section_id' 	=> $this->_id,
			'form' 			=> $form,
			'action' 		=> 'edit_city',
		));
	}

	private function _GetAjaxToggleCityVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$CityID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$city = $this->citymgr->GetCity($CityID);
		if ($city === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}

		$city->IsVisible = !$city->IsVisible;
		$city->Update();

		$json->send(array(
			'status' => 'ok',
			'visible' => (int) $city->IsVisible,
			'cityid' => $CityID,
		));
		exit;
	}

	private function _GetAjaxToggleCityDefault()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$CityID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$city = $this->citymgr->GetCity($CityID);
		if ($city === null)
		{
			$json->send(array('status' => 'error'));
			exit;
		}

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => -1,
			),
		);
		$cities = $this->citymgr->GetCities($filter);
		foreach ($cities as $item) {
			// $item->IsDefault = 0;
			$item->IsDefault = !$item->IsDefault;
			$item->Update();
		}

		$city->IsDefault = !$city->IsDefault;
		$city->Update();

		$json->send(array(
			'status' => 'ok',
			'default' => (int) $city->IsDefault,
			'cityid' => $CityID,
		));
		exit;
	}

	private function _GetCityDelete()
	{
		$CityID	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$city = $this->citymgr->GetCity($CityID);
		if ($city === null)
			return;

		$city->Remove();
		return;
	}

	// Создать
	private function _PostCityNew()
	{
		$Name = App::$Request->Post['Name']->Value(Request::OUT_HTML);
		$NameID = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
		$IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$IsDefault = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
		$Street = App::$Request->Post['Street']->Value(Request::OUT_HTML);
		$Domain = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
		$CatalogId = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
		$PhoneCode = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
		$Phone = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
		$Latitude = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
		$Longitude = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
		$SEOText = App::$Request->Post['SEOText']->Value();
		$Metrika = App::$Request->Post['Metrika']->Value();

		if (strlen($Name) == 0)
			UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

		if (strlen($Name) == 0)
			UserError::AddErrorIndexed('NameID', ERR_A_PAGE_NAMEID_EMPTY);

		if (strlen($Name) > 200)
			UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EXCEED);

		if (UserError::IsError())
			return false;

		$data = array(
			'SectionID'		=> $this->_id,
			'Name'			=> $Name,
			'NameID'			=> $NameID,
			'IsVisible'		=> $IsVisible,
			'IsDefault'		=> $IsDefault,
			'Street'		=> $Street,
			'Domain'		=> $Domain,
			'CatalogId'		=> $CatalogId,
			'PhoneCode'		=> $PhoneCode,
			'Phone'			=> $Phone,
			'Latitude'		=> $Latitude,
			'Longitude'		=> $Longitude,
			'SEOText'		=> $SEOText,
			'Metrika'		=> $Metrika,
		);

		$city = new City($data);
		$city->Update();

		return true;
	}

	// Обновить
	private function  _PostCityEdit()
	{
		$CityID    = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$Name      = App::$Request->Post['Name']->Value(Request::OUT_HTML);
		$NameID    = App::$Request->Post['NameID']->Value(Request::OUT_HTML);
		$IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$IsDefault = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
		$Street    = App::$Request->Post['Street']->Value(Request::OUT_HTML);
		$Domain    = App::$Request->Post['Domain']->Value(Request::OUT_HTML);
		$CatalogId = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
		$PhoneCode = App::$Request->Post['PhoneCode']->Value(Request::OUT_HTML);
		$Phone     = App::$Request->Post['Phone']->Value(Request::OUT_HTML);
		$Latitude  = App::$Request->Post['Latitude']->Value(Request::OUT_HTML);
		$Longitude = App::$Request->Post['Longitude']->Value(Request::OUT_HTML);
		$SEOText   = App::$Request->Post['SEOText']->Value();
		$Metrika   = App::$Request->Post['Metrika']->Value();

		$city = $this->citymgr->GetCity($CityID);
		if ($city === null)
			UserError::AddErrorIndexed('global', ERR_A_PAGE_NOT_FOUND);

		if (UserError::IsError())
			return false;

		if (strlen($Name) == 0)
			UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EMPTY);

		if (strlen($NameID) == 0)
			UserError::AddErrorIndexed('NameID', ERR_A_PAGE_NAMEID_EMPTY);

		if (strlen($Name) > 200)
			UserError::AddErrorIndexed('Name', ERR_A_PAGE_NAME_EXCEED);

		if (UserError::IsError())
			return false;

		$city->Name = $Name;
		$city->NameID = $NameID;
		$city->IsVisible = $IsVisible;
		$city->IsDefault = $IsDefault;
		$city->Street = $Street;
		$city->Domain = $Domain;
		$city->CatalogId = $CatalogId;
		$city->PhoneCode = $PhoneCode;
		$city->Phone = $Phone;
		$city->Latitude = $Latitude;
		$city->Longitude = $Longitude;
		$city->SEOText = $SEOText;
		$city->Metrika = $Metrika;

		$res = $city->Update();

		return true;
	}

}
