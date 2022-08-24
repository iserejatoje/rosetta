<?php

	$form = array();
	
	$form['placeinfo']['type'] = $params[1];
	$form['placeinfo']['placeid'] = '';
	$form['placeinfo']['name'] = '';
	
	$place = PlaceSimpleMgr::getInstance()->GetPlaceAsIs($params[2]);
	if ( $place !== null ) {
		$form['placeinfo']['placeid'] = $place['PlaceID'];
		$form['placeinfo']['name'] = $place['Name'];
		$form['placeinfo']['country'] = $place['Country'];
		$form['placeinfo']['region'] = $place['Region'];
		$form['placeinfo']['city'] = $place['City'];
		$form['placeinfo']['citytext'] = $place['CityText'];
	}
	
	LibFactory::GetStatic('source');
	$form['country_arr'] = Source::GetData('db:location', array('type' => 'country'));

	if ( App::$Request->requestMethod === Request::M_POST ) {
		$defLoc = Source::GetData('db:location', array('type' => 'default_location', 'city' => $this->_config['default_city']));

		if ( sizeof($defLoc) ) {
			$form['placeinfo']['country'] = $defLoc['CountryID'];
			$form['placeinfo']['region'] = $defLoc['RegionID'];
			$form['placeinfo']['city'] = $defLoc['CityID'];
		}
	}

	if(!empty($form['placeinfo']['country']) && is_numeric($form['placeinfo']['country']))
	{
		$form['region_arr'] = Source::GetData('db:location', array('type' => 'region', 'country' => $form['placeinfo']['country']));
		if(!empty($form['placeinfo']['region']) && is_numeric($form['placeinfo']['region']))
			$form['city_arr'] = Source::GetData('db:location', array('type' => 'city', 'region' => $form['placeinfo']['region']));
	}

	if ( $form['placeinfo']['type'] === PlaceSimpleMgr::PT_HIGHER_EDUCATION ) {
		$form['grad_years_arr'] = array_reverse(range(idate('Y')-53,idate('Y')+6));
		$form['years_arr'] = array_reverse(range(idate('Y')-53,idate('Y')));
		$form['course_form_arr'] = PlaceSimpleMgr::$course_form_arr;
		$form['status_arr'] = PlaceSimpleMgr::$status_arr;

	} else if ( $form['placeinfo']['type'] === PlaceSimpleMgr::PT_SECONDARY_EDUCATION ) {

		$form['years_arr'] = array_reverse(range(idate('Y')-53,idate('Y')));
		$form['grad_years_arr'] = array_reverse(range(idate('Y')-53,idate('Y')+6));
		$form['class_arr'] = PlaceSimpleMgr::getClassArr();
	} else {
		$form['years_arr'] = array_reverse(range(idate('Y')-53,idate('Y')+1));
	}

	$form['placeinfo']['fix'] = $params[0];

	return $form;

?>