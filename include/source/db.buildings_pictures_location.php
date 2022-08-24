<?php

function source_db_buildings_pictures_location($params)
{
	$db = DBFactory::GetInstance('sources');

	$data	= array();	
	switch(	$params['type'] ) {
		case 'list':
		break;
		
		case 'count':
			
		break;
	}
		
	return $data;
}

?>
