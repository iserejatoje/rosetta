<?php

ini_set('max_execution_time', '60');

if(1)
{
	$error_code = 0;
	define('ERR_A_CITY_MASK', 0x00590000);
	define('ERR_A_CITY_UNKNOWN_ERROR', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_CITY_UNKNOWN_ERROR] = 'Незвестная ошибка.';

	define('ERR_A_CITY_NOT_FOUND', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_CITY_NOT_FOUND] = 'Город не найдена.';

	define('ERR_A_ADDRESS_NAMEID_EMPTY', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_ADDRESS_NAMEID_EMPTY] = 'Не указано nameid';

	define('ERR_A_CITY_NAME_EXCEED', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_CITY_NAME_EXCEED] = 'Максимальная длина Названия 200 символов.';

	define('ERR_A_CITY_NAME_EMPTY', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_CITY_NAME_EMPTY] = 'Название не может быть пустым.';

	define('ERR_A_CITY_NAMEID_EMPTY', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_CITY_NAMEID_EMPTY] = 'ID домена не может быть пустым.';

	define('ERR_A_CITY_DOMAIN_NOT_FOUND', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_CITY_DOMAIN_NOT_FOUND] = 'Город (домен) не найден.';

	define('ERR_A_STORE_EMAIL_WRONG_FORMAT', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_STORE_EMAIL_WRONG_FORMAT] = 'Неверный формат электронной почты';

	define('ERR_A_STORE_ERROR_UPLOAD_IMAGE', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_STORE_ERROR_UPLOAD_IMAGE] = 'Не удалось загрузить изображение';

	define('ERR_A_ADDRESS_NAME_EMPTY', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_ADDRESS_NAME_EMPTY] = 'Необходимо ввести адрес';

	define('ERR_A_ADDRESS_NOT_FOUND', ERR_A_CITY_MASK | $error_code++);
	UserError::$Errors[ERR_A_ADDRESS_NOT_FOUND] = 'Адрес не найден';
}

class AdminModule
{
	static $TITLE = 'Города';

	static $ROW_ON_PAGE = 20;
	static $PAGES_ON_PAGE = 5;

	private $_db;
	private $_config;
	private $_aconfig;
	private $_page;
	private $_id;
	private $_title;
	private $_params;

	private $_citiesmgr;

	function __construct($config, $aconfig, $id)
	{
		global $CONFIG,$DCONFIG, $OBJECTS;
		LibFactory::GetMStatic('cities', 'citiesmgr');

		LibFactory::GetStatic("data");
		LibFactory::GetStatic("ustring");


		$this->_id = &$id;
		$this->_config = &$config;

		if ($this->_config['root']) {
				$this->_id = ($this->_config['root']);
		}

		$this->_db = DBFactory::GetInstance($this->_config['db']);

		if (empty($_GET['action']) && empty($_POST['action']))
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');

		$this->_citiesmgr = CitiesMgr::getInstance(false);

		App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
		App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');

		App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');

		App::$Title->AddScript('/resources/scripts/themes/editors/tinymce/js/tinymce/tinymce.min.js');
		App::$Title->AddScript('http://api-maps.yandex.ru/2.1/?lang=ru_RU');


		session_start();
	}

	function Action()
	{
		if($this->_PostAction()) return;
		$this->_GetAction();
	}

	function GetPage()
	{
		global $DCONFIG, $OBJECTS;
		switch($this->_page)
		{
			case 'city_address':
				$this->_title = "Адреса";
				$html = $this->_GetCityAddressList();
				break;
			case 'new_address':
				$this->_title = "Добавить адрес";
				$html = $this->_GetAddressNew();
				break;
			case 'edit_address':
				$this->_title = "Добавить адрес";
				$html = $this->_GetAddressEdit();
				break;
			// ---------------------------
			case 'new_city':
				$this->_title = "Добавить город";
				$html = $this->_GetCityNew();
				break;
			case 'edit_city':
				$this->_title = "Редактировать город";
				$html = $this->_GetCityEdit();
				break;
			case 'delete_city':
				$this->_GetCityDelete();
				Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
				break;
			case 'cities':
				$this->_title = "Список акций";
				$html = $this->_GetCities();
				break;
			case 'ajax_city_toggle_visible':
				$this->_GetAjaxToggleCityVisible();
				break;
			default:
				$this->_title = "Список городов";
				$html = $this->_GetCities();
				break;
		}
		return $html;
	}

	function GetTabs()
	{
		return array(
			'tabs' => array(
				array('name' => 'action', 'value' => 'cities', 'text' => 'Города'),
			),
			'selected' => $this->_page
		);
	}

	function GetTitle()
	{
		return $this->_title;
	}

	private function _setMessage($message = 'Данные сохранены.') {
		$_SESSION['user_message'] = array(
			'message' => $message,
		);
	}

	private function _GetAction()
	{
		global $DCONFIG;
		switch($_GET['action'])
		{
			default:
				$this->_page = $_GET['action'];
				break;
		}
	}

	private function _PostAction()
	{
		global $DCONFIG, $OBJECTS;

		switch($_POST['action'])
		{
			case 'new_city':
                if (($pid = $this->_PostCity()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
                break;
            case 'edit_city':
				if (($pid = $this->_PostCity()) > 0)
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
				break;
			case 'new_address':
                if (($pid = $this->_PostAddress()) > 0)
                    Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=city_address&id='.$_POST["id"]);
                break;
            case 'edit_address':
				if (($pid = $this->_PostAddress()) > 0)
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=city_address&cityid='.$_POST['cityid']."&id=".$_POST['id']);
				break;
			case 'save_cities':
				if($this->_PostSaveCities())
					Response::Redirect('?'.$DCONFIG['SECTION_ID_URL'].'&action=cities');
		}
		return false;
	}

	private function _GetCities()
	{
		global $DCONFIG, $CONFIG;

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsVisible' => -1,
			),
			'field' => array('Ord'),
			'dir' => array('ASC'),
			'dbg' => 1,
		);

		$cities = $this->_citiesmgr->GetCities($filter);

		return STPL::Fetch('admin/modules/cities/cities_list', array(
			'cities'    => $cities,
			'section_id' => $this->_id,
		));
	}



	private function _GetAjaxToggleCitiesVisible()
	{
		include_once ENGINE_PATH.'include/json.php';
		$json = new Services_JSON();

		$cityid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$city = $this->_citiesmgr->GetCity($cityid);
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
			'cityid' => $cityid,
		));
		exit;
	}

	private function _GetCityDelete()
	{
		$cityid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$city = $this->_citiesmgr->GetCity($cityid);
		if ($city === null)
			return;

		$city->Remove();
		return;
	}

	private function _PostSaveCities()
	{
		global $CONFIG, $OBJECTS;

		$orders = App::$Request->Post['Ord']->AsArray(array(), Request::UNSIGNED_NUM);

		if (!is_array($orders) || count($orders) == 0)
			return true;

		foreach($orders as $cityid => $ord)
		{
			$city = $this->_citiesmgr->GetCity($cityid);
			if ($city === null)
				continue;

			$city->Ord = $ord;
			$city->Update();
		}
		return true;
	}

	 private function _GetCiytNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = array();

        if ( App::$Request->requestMethod === Request::M_POST )
        {
			$form['Name']      = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN );
			$form['NameID']    = App::$Request->Post['NameID']->Value();
			$form['Domain']    = App::$Request->Post['Domain']->Value();
			$form['Street']    = App::$Request->Post['Street']->Value();
			$form['CatalogId'] = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
			$form['PhoneCode'] = App::$Request->Post['PhoneCode']->Value();
			$form['Phone']     = App::$Request->Post['Phone']->Value();
			$form['Latitude']  = App::$Request->Post['Latitude']->Value();
			$form['Longitude'] = App::$Request->Post['Longitude']->Value();
			$form['SEOText']   = App::$Request->Post['SEOText']->Value();
			$form['Metrika']   = App::$Request->Post['Metrika']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
        }
        else
        {
			$form['Name']      = "";
			$form['NameID']    = "";
			$form['Domain']    = "";
			$form['Street']    = "";
			$form['CatalogId'] = 0;
			$form['PhoneCode'] = "";
			$form['Phone']     = "";
			$form['Latitude']  = "";
			$form['Longitude'] = "";
			$form['SEOText']   = "";
			$form['Metrika']   = "";
			$form['IsVisible'] = 1;
			$form['IsDefault'] = 0;
        }

        return STPL::Fetch('admin/modules/cities/edit_city', array(
			'form'       => $form,
			'action'     => 'new_city',
			'section_id' => $this->_id,
        ));
    }

     /**
     * @return array|bool|null
     */
    private function _PostCity()
    {
        global $CONFIG, $OBJECTS;

		$cityid    = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$Name      = App::$Request->Post['Name']->Value();
		$NameID    = App::$Request->Post['NameID']->Value();
		$Domain    = App::$Request->Post['Domain']->Value();
		$Street    = App::$Request->Post['Street']->Value();
		$CatalogId = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
		$PhoneCode = App::$Request->Post['PhoneCode']->Value();
		$Phone     = App::$Request->Post['Phone']->Value();
		$Latitude  = App::$Request->Post['Latitude']->Value();
		$Longitude = App::$Request->Post['Longitude']->Value();
		$SEOText   = App::$Request->Post['SEOText']->Value();
		$Metrika   = App::$Request->Post['Metrika']->Value();
		$IsVisible = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
		$IsDefault = App::$Request->Post['IsDefault']->Enum(0, array(0,1));


        if (strlen($Name) == 0)
			UserError::AddErrorIndexed('Name', ERR_A_CITY_NAME_EMPTY);

		if (strlen($NameID) == 0)
			UserError::AddErrorIndexed('NameID', ERR_A_CITY_NAMEID_EMPTY);

		if (UserError::IsError())
		{
			return false;
		}
// -----------------------------
        if($cityid > 0)
        {
            $city = $this->_citiesmgr->GetCity($cityid);
            if ($city === null) {
                UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
                return false;
            }

			$city->Name      = $Name;
			$city->NameID    = $NameID;
			$city->Domain    = $Domain;
			$city->Street    = $Street;
			$city->CatalogId = $CatalogId;
			$city->PhoneCode = $PhoneCode;
			$city->Phone     = $Phone;
			$city->Latitude  = $Latitude;
			$city->Longitude = $Longitude;
			$city->SEOText   = $SEOText;
			$city->Metrika   = $Metrika;
			$city->IsVisible = $IsVisible;
			$city->IsDefault = $IsDefault;
        }
        else
        {
            $Data = array(
            	// 'Created' => 'now()',
				'Name'      => $Name,
				'NameID'    => $NameID,
				'Domain'    => $Domain,
				'Street'    => $Street,
				'CatalogId' => $CatalogId,
				'PhoneCode' => $PhoneCode,
				'Phone'     => $Phone,
				'Latitude'  => $Latitude,
				'Longitude' => $Longitude,
				'SEOText'   => $SEOText,
				'Metrika'   => $Metrika,
				'IsVisible' => $IsVisible,
				'IsDefault' => $IsDefault,
            );

            $city = new City($Data);
        }

        $city->Update();
        $this->_setMessage();

        return $city->ID;
    }

     /**
     * @return array|bool|null
     */
    private function _PostAddress()
    {
        global $CONFIG, $OBJECTS;

		$addressid   = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
		$cityid      = App::$Request->Post['cityid']->Int(0, Request::UNSIGNED_NUM);
		$Address     = App::$Request->Post['Address']->Value();
		$IsAvailable = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
		$arrPhone       = App::$Request->Post['Phone']->AsArray();
		$arrSkype       = App::$Request->Post['Skype']->AsArray();
		$arrICQ         = App::$Request->Post['ICQ']->AsArray();
		$arrEmail       = App::$Request->Post['Email']->AsArray();
		$Latitude    = App::$Request->Post['Latitude']->Value();
		$Longitude   = App::$Request->Post['Longitude']->Value();

        if (strlen($Address) == 0)
			UserError::AddErrorIndexed('Address', ERR_A_ADDRESS_NAME_EMPTY);

		if (UserError::IsError())
		{
			return false;
		}
// -----------------------------
        if($addressid > 0)
        {
            $address = $this->_citiesmgr->GetAddress($addressid);
            if ($address === null) {
                UserError::AddErrorIndexed('global', ERR_A_ADDRESS_NOT_FOUND);
                return false;
            }

			$address->Address     = $Address;
			$address->IsAvailable = $IsAvailable;
			$address->Latitude    = $Latitude;
			$address->Longitude   = $Longitude;

			$address->Phone       = $arrPhone;
			$address->SKype       = $arrSkype;
			$address->ICQ         = $arrICQ;
			$address->Email       = $arrEmail;
			$address->LastUpdated       = 'NOW()';
        }
        else
        {
            $Data = array(
            	'Created' => 'now()',
				'Address'     => $Address,
				'CityID' => $cityid,
				'IsAvailable' => $IsAvailable,
				'Latitude'    => $Latitude,
				'Longitude'   => $Longitude,
				'Phone'       => count($arrPhone) > 0 ? serialize($arrPhone) : "",
				'Skype'       => count($arrSkype) > 0 ? serialize($arrSkype) : "",
				'ICQ'         => count($arrICQ) > 0 ? serialize($arrICQ) : "",
				'Email'       => count($arrICQ) > 0 ? serialize($arrICQ) : "",
            );

            $address = new Address($Data);
        }

        $address->Update();
        $this->_setMessage();

        return $address->ID;
    }

    private function _GetCityEdit()
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$cityid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$city = $this->_citiesmgr->GetCity($cityid);
		if ($city === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
			return STPL::Fetch('admin/modules/cities/edit_city');
		}

		$form['CityID']    = $city->ID;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Name']      = App::$Request->Post['Name']->Value();
			$form['NameID']    = App::$Request->Post['NameID']->Value();
			$form['Street']    = App::$Request->Post['Street']->Value();
			$form['Domain']    = App::$Request->Post['Domain']->Value();
			$form['CatalogId'] = App::$Request->Post['CatalogId']->Int(0, Request::UNSIGNED_NUM);
			$form['PhoneCode'] = App::$Request->Post['PhoneCode']->Value();
			$form['Phone']     = App::$Request->Post['Phone']->Value();
			$form['Latitude']  = App::$Request->Post['Latitude']->Value();
			$form['Longitude'] = App::$Request->Post['Longitude']->Value();
			$form['SEOText']   = App::$Request->Post['SEOText']->Value();
			$form['Metrika']   = App::$Request->Post['Metrika']->Value();
			$form['IsVisible'] = App::$Request->Post['IsVisible']->Enum(0, array(0,1));
			$form['IsDefault'] = App::$Request->Post['IsDefault']->Enum(0, array(0,1));
		}
		else
		{
			$form['Name']      = $city->Name;
			$form['NameID']    = $city->NameID;
			$form['Street']    = $city->Street;
			$form['Domain']    = $city->Domain;
			$form['CatalogId'] = $city->CatalogId;
			$form['PhoneCode'] = $city->PhoneCode;
			$form['Phone']     = $city->Phone;
			$form['Longitude']  = $city->Longitude;
			$form['Latitude']  = $city->Latitude;
			$form['SEOText']   = $city->SEOText;
			$form['Metrika']   = $city->Metrika;
			$form['IsVisible'] = $city->IsVisible;
			$form['IsDefault'] = $city->IsDefault;
		}

		return STPL::Fetch('admin/modules/cities/edit_city', array(
			'form' 			=> $form,
			'action' 		=> 'edit_city',
			'section_id'	=> $this->_id,
		));
	}

	// ==========================================
	private function _GetCityAddressList()
	{
		$cityid = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$city = $this->_citiesmgr->GetCity($cityid);
		if ($city === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
			return STPL::Fetch('admin/modules/cities/address_list');
		}

		$filter = array(
			'flags' => array(
				'objects' => true,
				'IsAvailable' => -1,
				'CityID' => $cityid,
			),
			'dbg' => 1,
		);
		$address_list = $this->_citiesmgr->GetAddressList($filter);

		return STPL::Fetch('admin/modules/cities/address_list', array(
			'list'       => $address_list,
			'section_id' => $this->_id,
			'cityid'     => $cityid,
		));
	}

	private function _GetAddressNew()
	{
		$cityid = App::$Request->Get['cityid']->Int(0, Request::UNSIGNED_NUM);
		$city = $this->_citiesmgr->GetCity($cityid);
		if ($city === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
			return STPL::Fetch('admin/modules/cities/address_edit');
		}

		$form['CityID'] = $cityid;
		if ( App::$Request->requestMethod === Request::M_POST )
        {
			$form['Name']        = App::$Request->Post['Name']->Value(Request::OUT_HTML_CLEAN );
			$form['Address']     = App::$Request->Post['Address']->Value();
			$form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
			$form['PhoneCode']   = App::$Request->Post['PhoneCode']->Value();
			$form['Phone']       = App::$Request->Post['Phone']->AsArray();
			$form['Latitude']    = App::$Request->Post['Latitude']->Value();
			$form['Longitude']   = App::$Request->Post['Longitude']->Value();
			$form['Skype']       = App::$Request->Post['Skype']->AsArray();
			$form['ICQ']         = App::$Request->Post['ICQ']->AsArray();
			$form['Email']       = App::$Request->Post['Email']->AsArray();
			$form['HasPickup']   = App::$Request->Post['HasPickup']->Enum(0, array(0,1));
        }
        else
        {
			$form['Name']        = "";
			$form['Address']     = "";
			$form['IsAvailable'] = "";
			$form['PhoneCode']   = "";
			$form['Phone']       = array();
			$form['Latitude']    = "0.00";
			$form['Longitude']   = "0.00";
			$form['Skype']       = array();
			$form['ICQ']         = array();
			$form['Email']       = array();
			$form['HasPickup']   = 0;
        }

        return STPL::Fetch('admin/modules/cities/edit_address', array(
			'form'       => $form,
			'action'     => 'edit_address',
			'section_id' => $this->_id,
			'city'       => $city,
		));
	}

	private function _GetAddressEdit()
	{
		global $DCONFIG, $CONFIG, $OBJECTS;

		$addressid	= App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
		$cityid	= App::$Request->Get['cityid']->Int(0, Request::UNSIGNED_NUM);

		$city = $this->_citiesmgr->GetCity($cityid);
		if ($city === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_CITY_NOT_FOUND);
			return STPL::Fetch('admin/modules/cities/edit_address');
		}

		$address = $this->_citiesmgr->GetAddress($addressid);
		if ($address === null)
		{
			UserError::AddErrorIndexed('global', ERR_A_ADDRESS_NOT_FOUND);
			return STPL::Fetch('admin/modules/cities/edit_address');
		}

		$form['CityID']    = $cityid;
		$form['AddressID'] = $addressid;

		if ( App::$Request->requestMethod === Request::M_POST )
		{
			$form['Name']    = App::$Request->Post['Name']->Value();
			$form['Address'] = App::$Request->Post['Address']->Value();
			$form['IsAvailable'] = App::$Request->Post['IsAvailable']->Enum(0, array(0,1));
			$form['PhoneCode']   = App::$Request->Post['PhoneCode']->Value();
			$form['Phone']       = App::$Request->Post['Phone']->AsArray();
			$form['Latitude']    = App::$Request->Post['Latitude']->Value();
			$form['Longitude']   = App::$Request->Post['Longitude']->Value();
			$form['Skype']       = App::$Request->Post['Skype']->AsArray();
			$form['ICQ']         = App::$Request->Post['ICQ']->AsArray();
			$form['Email']       = App::$Request->Post['Email']->AsArray();
			$form['HasPickup']   = App::$Request->Post['HasPickup']->Enum(0, array(0,1));
		}
		else
		{
			$form['Name']        = $address->Name;
			$form['Address']     = $address->Address;
			$form['IsAvailable'] = $address->IsAvailable;
			$form['PhoneCode']   = $address->PhoneCode;
			$form['Phone']       = $address->Phone;
			$form['Latitude']    = $address->Latitude;
			$form['Longitude']   = $address->Longitude;
			$form['Skype']       = $address->Skype;
			$form['ICQ']         = $address->ICQ;
			$form['Email']       = $address->Email;
			$form['HasPickup']   = $address->HasPickup;
		}

		return STPL::Fetch('admin/modules/cities/edit_address', array(
			'form'       => $form,
			'action'     => 'edit_address',
			'section_id' => $this->_id,
			'city' => $city,
		));
	}
}