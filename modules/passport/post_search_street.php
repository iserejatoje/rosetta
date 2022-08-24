<?php


	$query = App::$Request->Post['query']->Value('');
	$city = App::$Request->Post['city']->Int(0);

	if ( !$query || $city==0 ) 
		exit('');
		
	$query = iconv('UTF-8','WINDOWS-1251',$query);
	
	LibFactory::GetStatic('source');
	$result = Source::GetData('db:location', array('type' => 'street', 'city' => $city, 'name' => $query, 'name_match' => 2));

	foreach ($result as $id => $street) {
		echo iconv('WINDOWS-1251','UTF-8', $street['name'])."\t".$id."\n";
	}
	exit;
?> 