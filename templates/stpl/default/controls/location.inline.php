<?

global $OBJECTS;

if ( is_object($OBJECTS['title']) )
{
	$OBJECTS['title']->AddStyles(array(
		'/_styles/jquery/autocomplete/jquery.autocomplete.css',
		'/_styles/jquery/location/inline.css',
	));

	$OBJECTS['title']->AddScripts(array(
		'/_scripts/themes/frameworks/jquery/jquery.js',
		'/_scripts/themes/frameworks/jquery/jquery.ajaxQueue.js',
		'/_scripts/themes/frameworks/jquery/autocomplete/jquery.autocomplete.js',
		'/_scripts/themes/location.inline.js',
	));
}

LibFactory::GetStatic('location');
LibFactory::GetStatic('data');

$_params = array(
	'active_level' => array(
		Location::OL_CONTINENTS	=> 0,
		Location::OL_COUNTRIES	=> 0,
		Location::OL_REGIONS	=> 1,
		Location::OL_DISTRICTS	=> 0,
		Location::OL_CITIES		=> 1,
		Location::OL_VILLAGES	=> 0,
		Location::OL_STREETS	=> 1,
	),

	'level_type' => array(
		Location::OL_CONTINENTS	=> Location::$TC_CONTINENTS,
		Location::OL_COUNTRIES	=> Location::$TC_COUNTRIES,
		Location::OL_REGIONS	=> array_merge(
			Location::$TC_REGIONS
		),
		Location::OL_DISTRICTS	=> Location::$TC_DISTRICTS,
		Location::OL_CITIES		=> array_merge(
			(array) Location::ST_REGION_CENTER_CITY,
			Location::$TC_CITIES,
			Location::$TC_VILLAGES
		),
		Location::OL_VILLAGES	=> Location::$TC_VILLAGES,
		Location::OL_STREETS	=> Location::$TC_STREETS,
	),

	'important' => array(
		Location::OL_CONTINENTS	=> 0,
		Location::OL_COUNTRIES	=> 0,
		Location::OL_REGIONS	=> 0,
		Location::OL_DISTRICTS	=> 0,
		Location::OL_CITIES		=> 1,
		Location::OL_VILLAGES	=> 0,
		Location::OL_STREETS	=> 0,
	),

	'suggest_limit' => 20,
	'search_limit' => 50,

	'limit' => array(
		Location::OL_CONTINENTS	=> null,
		Location::OL_COUNTRIES	=> null,
		Location::OL_REGIONS	=> null,
		Location::OL_DISTRICTS	=> null,
		Location::OL_CITIES		=> null,
		Location::OL_VILLAGES	=> 150,
		Location::OL_STREETS	=> 150,
	),

	'select_text' => array(
		Location::OL_CONTINENTS	=> '- Выберите континент -',
		Location::OL_COUNTRIES	=> '- Выберите страну -',
		Location::OL_REGIONS	=> '- Выберите область -',
		Location::OL_DISTRICTS	=> '- Выберите район -',
		Location::OL_CITIES		=> '- Выберите город -',
		Location::OL_VILLAGES	=> '- Выберите населенный пункт -',
		Location::OL_STREETS	=> '- Выберите улицу -',
	),

	'select_other_text' => array(
		Location::OL_CONTINENTS	=> '- Другой -',
		Location::OL_COUNTRIES	=> '- Другая -',
		Location::OL_REGIONS	=> '- Другой -',
		Location::OL_DISTRICTS	=> '- Другой -',
		Location::OL_CITIES		=> '- Другой -',
		Location::OL_VILLAGES	=> '- Другой -',
		Location::OL_STREETS	=> '- Другая -',
	),

	'select_tree' => array(
		Location::OL_CONTINENTS	=> 0,
		Location::OL_COUNTRIES	=> 0,
		Location::OL_REGIONS	=> 0,
		Location::OL_DISTRICTS	=> 0,
		Location::OL_CITIES		=> 0,
		Location::OL_VILLAGES	=> 0,
		Location::OL_STREETS	=> 0,
	),
	
	'suggest_text' => array(
		Location::OL_CONTINENTS	=> 'Название континента...',
		Location::OL_COUNTRIES	=> 'Название страны...',
		Location::OL_REGIONS	=> 'Название области...',
		Location::OL_DISTRICTS	=> 'Название района...',
		Location::OL_CITIES		=> 'Название города...',
		Location::OL_VILLAGES	=> 'Название населенного пункта...',
		Location::OL_STREETS	=> 'Название улицы...',
	),

	'link_text' => array(
		Location::OL_CONTINENTS	=> 'изменить континент',
		Location::OL_COUNTRIES	=> 'изменить страну',
		Location::OL_REGIONS	=> 'изменить регион',
		Location::OL_DISTRICTS	=> 'изменить район',
		Location::OL_CITIES		=> 'изменить город',
		Location::OL_VILLAGES	=> 'изменить поселок',
		Location::OL_STREETS	=> 'изменить улицу',
	),
	'use_link_text' => array(
		Location::OL_CONTINENTS	=> 0,
		Location::OL_COUNTRIES	=> 0,
		Location::OL_REGIONS	=> 0,
		Location::OL_DISTRICTS	=> 0,
		Location::OL_CITIES		=> 0,
		Location::OL_VILLAGES	=> 0,
		Location::OL_STREETS	=> 0,
	),

	'code' => '0000000000000000000000',

	'brake' => ' <em class="brake">»</em> ',
	'house' => 'house',
	'result' => 'location',

	'onSelect' => null,
	'onSelectLast' => null,
	'onChangeLocation' => null,
	'onChangeCode' => null,
);


//$_params = Data::array_merge_recursive_changed($_params, $vars);

// двухуровневое слияние массивов
foreach ( $vars as $k => $v )
{
	if ( is_array($v) )
	{
		foreach ( $v as $k1 => $v1 )
			$_params[$k][$k1] = $v1;
	}	
	else
	{
		$_params[$k] = $v;
	}
}	
if (isset($_params['code']) && empty($_params['code']))
	return ;
	
if (strlen($_params['code']) < 22)
	$_params['code'] .= str_repeat('0', 22-strlen($_params['code']));

$defaultCodes = Location::ParseCode($_params['code']);
//$defaultCodes['ActualCode'] = -1;
$objectLevel = Location::ObjectLevel($defaultCodes);

$id = md5(microtime(true));

?>

<div id="<?=$id?>" class="location-inline">
<input type="hidden" class="location-inline-v" name="<?=$_params['result']?>" value="<?=$_params['code']?>" />
<?

$path = array();
$list = array();
$types = array();

$_types = Location::GetAbbr();
foreach ( $_types as $v )
	$types[$v['SocrId']] = $v;
	
//print_R($_params['active_level']);
$e_objectLevel = $objectLevel;
for($level=0;$level<=$objectLevel;$level++) {
	$jump = 0;
	// Уровень отключен (не отображается вообще ни как)
	if ((int) $_params['active_level'][$level] == 0 || (int) $_params['active_level'][$level] === 4)
		continue ;

	if ($level != $objectLevel) {
		if ($level == 4 && $defaultCodes['VillageCode'] != '000' && (int) $_params['active_level'][$level+1] == 0 && 
			($defaultCodes['CityCode'] == '000' || sizeof(array_diff(Location::$TC_VILLAGES, $_params['level_type'][$level])) == 0)
		) {
			$level++;
			$jump--;
			$e_objectLevel--;
		}
		$location = Location::GetParentObject($defaultCodes, $level+1);
	} else {
		$location = Location::GetObjects($defaultCodes);
	}

	if (empty($location)) {
		//throw new Exception('Location code "'.$_params['code'].'" not found');
		//error_log('Location code "'.$_params['code'].'" not found');
		break;
	}

	$lastLocation = $location[0];
	if ($objectLevel == 2 && $lastLocation['Type'] == 2) {
		$objectLevel = 4;
		$level++;
			$jump--;
			$e_objectLevel=4;
	}
	
	if ( $level+$jump == 4 || $level+$jump == 5 )
		$path[$level+$jump] = $lastLocation['Name'];
	else
		$path[$level+$jump] = $lastLocation['FullName'];

	$last_level = $level+$jump;
	if ($_params['active_level'][$level+$jump] === 2)
		continue ;

	$count = Location::GetSubordinateObjectsCount($_params['code'], array(
		'Important'	=> ($_params['important'][$level+$jump] == true ? 1 : null),
	), $level+$jump);

	if ($_params['limit'][$level+$jump] === null) {
		$location = Location::GetSubordinateObjects($_params['code'], array(
			'Important'	=> (($_params['important'][$level+$jump] == true && $count)? 1 : null),
			'field'		=> 'Name',
		), $level+$jump);
	} else {
		$location = Location::GetSubordinateObjects($_params['code'], array(
			'Important'	=> (($_params['important'][$level+$jump] == true && $count)? 1 : null),
			'field'		=> 'Name',
			'limit'		=> $_params['limit'][$level+$jump],
		), $level+$jump);
	}

	$list[$level+$jump] = $location;
}

foreach($path as $k => $v) {
	?><span class="location-inline-c-<?=$k?>"><?
	if ($_params['active_level'][$k] !== 2) {
		if ($_params['use_link_text'][$k] == 1) {
			?><span class="location-inline-l-<?=$k?>"><span class="link-title"><?=$v?></span>&nbsp;<a class="subscript" href="javascript:;"><?=$_params['link_text'][$k]?></a></span><?
		} else {
			?><a class="location-inline-l-<?=$k?>" href="javascript:;"><?=$v?></a><?
		}
	} else
		echo $v;
	?></span><?

	if ($k != $e_objectLevel)
		echo $_params['brake'];
}
for($level;isset($_params['active_level'][$level]);$level++) {

	if ((int) $_params['active_level'][$level] === 0 || (int) $_params['active_level'][$level] === 4)
		continue ;

	//if ($_params['limit'][$level] < 100)
		//$_params['limit'][$level] = 100;

	$count = Location::GetSubordinateObjectsCount($_params['code'], array(
		'Important'	=> ($_params['important'][$level] == true ? 1 : null),
		'Type' => array(
			'in' => $_params['level_type'][$level]
		),
	), $level);

	if ($_params['active_level'][$level] === 3 || $_params['active_level'][$level] === 4) {

		$location = Location::GetSubordinateObjects($_params['code'], array(
			'Important'	=> (($_params['important'][$level] == true && $count)? 1 : null),
			'field'		=> $_params['select_tree'][$level] ? 'Type, Name' : 'Name',
			'limit'		=> $_params['limit'][$level],
			'Type' => array(
				'in' => $_params['level_type'][$level]
			),
		), false);

	} else {
		
		$filter = array(
			'Important'	=> (($_params['important'][$level] == true && $count)? 1 : null),
			'field'		=> $_params['select_tree'][$level] ? 'Type, Name' : 'Name',
			'limit'		=> $_params['limit'][$level],
			'Type' => array(
				'in' => $_params['level_type'][$level]
			),
		);

		if ($lastLocation['Type'] == 2 && $level == 4) {
			$filter['OtherCodes'] = array($lastLocation['Code']);
		} else if ($lastLocation['Type'] == 2 && $level == 6) {
			$filter['OtherCodes'] = array($lastLocation['Code']);
		}

		$location = Location::GetSubordinateObjects($_params['code'], $filter, false);
	}

	$full_count = Location::GetSubordinateObjectsCount($_params['code'], array(
		'Important'	=> null,
		'Type' => array(
			'in' => $_params['level_type'][$level]
		),
	), $level);
	
	$list[$level] = $location;

	if (sizeof($path))
		echo $_params['brake'];

	?><span class="location-inline-c-<?=$level?>"><?

	if ($_params['limit'][$level] === null || $_params['limit'][$level] >= $count) {
		
		$_type = -1;
		?>

		<select class="location-inline-o-<?=$level?> list">
		
			<option><?=$_params['select_text'][$level]?></option>
			<?
				if ($full_count > sizeof($location)) {
					?><option value="-1" style="font-weight:bold"><?=$_params['select_other_text'][$level]?></option><?
				}
			?>
			<? if (0 && $_params['search_limit'] > 0 && $count > $_params['search_limit']) { ?>
			<option>-------------</option>
			<option value="-1">Поиск по списку</option>
			<option>-------------</option>
			<?
			}

			foreach($location as $v) {
				
				if ( $_params['select_tree'][$level] && $_type != $v['Type'] ) {
					if ( $_params['select_tree'][$level] && $_type != -1 ) {
						?>
							</optgroup>
						<?
					}
					?>
						<optgroup label="<?=$types[$v['Type']]['SocrText']?>">
					<?
					$_type = $v['Type'];
				}
				?>
				<option value="<?=$v['Code']?>"><?=$_params['select_tree'][$level] ? $v['Name'] : $v['FullName']?></option>
				<?}

				if ( $_params['select_tree'][$level] ) {
					?>
						</optgroup>
					<?
				}
				
				if ($full_count > sizeof($location)) {
					?><option value="-1" style="font-weight:bold"><?=$_params['select_other_text'][$level]?></option><?
				}
				?>				
		</select>
		<?

	} else {
	
		?>

		<input type="text" class="location-inline-s-<?=$level?> suggest" value="<?=$_params['suggest_text'][$level]?>" />

		<?
	}

	?></span><?
	break;
}
?>
</div>
<?
// На основании тикета http://redmine.www.d.rugion.ru/issues/3745
if( !is_array($_params['level_type_suggest']) && is_array($_params['level_type']) )
	$_params['level_type_suggest'] = $_params['level_type'];
?>
<script>
	<?
		foreach($_params as &$v) {
			if (is_array($v)) {
				foreach($v as &$v1) {
					if (is_string($v1))
						$v1 = iconv('WINDOWS-1251', 'UTF-8', $v1);
				}
			} else if (is_string($v))
				$v = iconv('WINDOWS-1251', 'UTF-8', $v);
		}

		$_params['code'] = array(
			($defaultCodes['ContinentCode'] ? $defaultCodes['ContinentCode'] : '???'),
			($defaultCodes['CountryCode'] ? $defaultCodes['CountryCode'] : '???'),
			($defaultCodes['RegionCode'] ? $defaultCodes['RegionCode'] : '???'),
			($defaultCodes['DistrictCode'] ? $defaultCodes['DistrictCode'] : '???'),
			($defaultCodes['CityCode'] ? $defaultCodes['CityCode'] : '???'),
			($defaultCodes['VillageCode'] ? $defaultCodes['VillageCode'] : '???'),
			($defaultCodes['StreetCode'] ? $defaultCodes['StreetCode'] : '???'),
		);
	?>

	var RefreshLIContainer<?=$id?> = '';

	var RefreshLI<?=$id?> = function() {
		var o = <? echo json_encode($_params); ?>;

		var temp = RefreshLIContainer<?=$id?>.clone();
		
		$('#<?=$id?>').after(temp);
		$('#<?=$id?>').remove();

		temp.location_inline(o);
	}

	$(document).ready(function() {
		var o = <? echo json_encode($_params); ?>;

		RefreshLIContainer<?=$id?> = $('#<?=$id?>').clone();

		$('#<?=$id?>').location_inline(o);
	});
</script>