<?

$pointColors = array('wt','do','db','bl','gn','gr','lb','nt','or','pn','rd','vv','yw');

if ( !isset($vars['Type']) )
	$vars['Type'] = 'map';
if ( !is_array($vars['Size']) )
	$vars['Size'] = array(400,300);
if ( !isset($vars['zLevel']) )
	$vars['zLevel'] = 16;

// собираем параметры запроса
$params[] = 'l='. $vars['Type'];
if ( isset($vars['Points']) )
{
	$points = array();
	$ptSize = isset($vars['PointSize']) ? $vars['PointSize'] : 'm';
	foreach ( $vars['Points'] as $i => $pt )
	{
		$point = $pt['x'] .','. $pt['y'];
		$point.= ',pm'. $pointColors[$i % count($pointColors)];
		$point.= $ptSize;
		$point.= $i+1;
		$points[] = $point;
	}
	$params[] = 'pt='. implode('~',$points);
}
else
{
	$params[] = 'll='. $vars['Coords'][0] .','. $vars['Coords'][1];
	$params[] = 'spn='. $vars['Span'][0] .','. $vars['Span'][1];
}

$params[] = 'size='. $vars['Size'][0] .','. $vars['Size'][1];
$params[] = 'z='. $vars['zLevel'];
$params[] = 'key='. $vars['mapkey'];

// собираем url карты
$url = 'http://static-maps.yandex.ru/1.x/?'. implode('&',$params);

?>
<img src="<?=$url?>" />
