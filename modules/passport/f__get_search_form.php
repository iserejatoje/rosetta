<?

$params = $params[0];

switch ($this->_page) {

	default:
		// значения по дефолту
		$defaults = array(
			'query' => '',
			'city' => App::$Request->Get['city']->Value(Request::OUT_HTML_AREA | Request::OUT_HTML_CLEAN),
			'age_from' => 0,
			'age_to' => 100,
			'photo' => 0,
			'gender1' => 1,
			'gender2' => 1,
			'firstname' => 'Имя',
			'midname' => 'Отчество',
			'lastname' => 'Фамилия',
		);

		$form = $defaults;
		$form['defaults'] = $defaults;

		LibFactory::GetStatic('location');

		if (!$form['city']) {
			$form['city'] = Location::GetPartcodeByLevel($CONFIG['env']['site']['city_code'], Location::OL_CITIES);
		} else {
			$loc_pc = Location::ParseCode($form['city']);
			if (Location::ObjectLevel($loc_pc) < Location::OL_REGIONS)
				$form['city'] = Location::GetPartcodeByLevel($CONFIG['env']['site']['city_code'], Location::OL_REGIONS);
		}
		
		if ( isset(App::$Request->Get['photo']) )
			$form['photo'] = App::$Request->Get['photo']->Int(0, Request::UNSIGNED_NUM) > 0 ? 1 : 0;

		$form['age_from'] = App::$Request->Get['age_from']->Int($form['age_from'], Request::UNSIGNED_NUM);
		$form['age_to'] = App::$Request->Get['age_to']->Int($form['age_to'], Request::UNSIGNED_NUM);

		$form['gender1'] = App::$Request->Get['gender1']->Enum(0, array(0,1));
		$form['gender2'] = App::$Request->Get['gender2']->Enum(0, array(0,1));
		if($form['gender1'] == $form['gender2'])
			$form['gender1'] = $form['gender2'] = 1;

		$form['firstname'] = App::$Request->Get['firstname']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
		$form['lastname'] = App::$Request->Get['lastname']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
		$form['midname'] = App::$Request->Get['midname']->Value(Request::OUT_HTML_CLEAN | Request::OUT_HTML);
		if(empty($form['firstname']))
			$form['firstname'] = $defaults['firstname'];
		if(empty($form['lastname']))
			$form['lastname'] = $defaults['lastname'];
		if(empty($form['midname']))
			$form['midname'] = $defaults['midname'];

		$form['query'] = '';
}
return $form;
?>