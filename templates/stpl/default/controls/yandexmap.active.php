<?

$mapTypes = array(
			1 => 'map',
			2 => 'sat',
			3 => 'sat,skl'
		);
$defaultMap = array(
			'Type'		=> 1,
			'Coords'	=> array(
				61.380024,
				55.173632,
			),
			'Span' => array(
				0.17561165489253483,
				0.06690597279549593,
			),
			'PointSize'	=> 1
		);

if ( count($vars['Points']) )
{
	include_once ENGINE_PATH.'include/json.php';	
	$json = new Services_JSON();
	$json->charset = 'windows-1251';
	
	$max_x = $max_y = -10000;
	$min_x = $min_y = 10000;			
	foreach ( $vars['Points'] as &$point )
	{
		if ( $point['x'] > $max_x )
			$max_x = $point['x'] + $point['span'][0];
		if ( $point['x'] < $min_x )
			$min_x = $point['x'] - $point['span'][0];
		$point['x'] = Data::NormalizeFloat($point['x']);
		
		if ( $point['y'] > $max_y )
			$max_y = $point['y'] + $point['span'][1];
		if ( $point['y'] < $min_y )
			$min_y = $point['y'] - $point['span'][1];
		$point['y'] = Data::NormalizeFloat($point['y']);
		
		$point['showBalloon'] = count($vars['Points']) > 1 ? false : true;
	}
	
	if ( $vars['ArrangeByPoints'] === true )
	{
		// центруем по точкам
		$vars['Coords'] = array(
			Data::NormalizeFloat($min_x + ($max_x - $min_x)/2),
			Data::NormalizeFloat($min_y + ($max_y - $min_y)/2)
		);
		
		// вычисляем размер области
		$vars['Span'] = array(
			Data::NormalizeFloat(($max_x - $min_x)/2),
			Data::NormalizeFloat(($max_y - $min_y)/2)
		);
	}
	
	$vars['PointsJS'] = $json->encode($vars['Points']);
	
	unset($json);
}

if ( count($vars['Polygons']) )
{
	include_once ENGINE_PATH.'include/json.php';	
	$json = new Services_JSON();
	$json->charset = 'windows-1251';
	
	foreach ( $vars['Polygons'] as &$polygon )
	{
		if ( !isset($polygon['fill']) )
			$polygon['fill'] = true;
		if ( !isset($polygon['outline']) )
			$polygon['outline'] = true;
		if ( !isset($polygon['strokeWidth']) )
			$polygon['strokeWidth'] = 0;
		if ( !isset($polygon['fillColor']) )
			$polygon['fillColor'] = 'ff000000';
		if ( !isset($polygon['strokeColor']) )
			$polygon['strokeColor'] = $polygon['fillColor'];
		if ( !isset($polygon['hasHint']) )
			$polygon['hasHint'] = false;
		if ( !isset($polygon['hasBalloon']) )
			$polygon['hasBalloon'] = false;
	}
	
	$vars['PolygonsJS'] = $json->encode($vars['Polygons']);
}

// параметры по умолчанию
if ( !isset($vars['Type']) )
	$vars['Type'] = $mapTypes[$defaultMap['Type']];
	
if ( !isset($vars['Coords']) )
{
	$vars['Coords'] =  array(
		Data::NormalizeFloat($defaultMap['Coords'][0]),
		Data::NormalizeFloat($defaultMap['Coords'][1])
	);
}
if ( !isset($vars['Span']) )
{
	$vars['Span'] =  array(
		Data::NormalizeFloat($defaultMap['Span'][0]),
		Data::NormalizeFloat($defaultMap['Span'][1])
	);
}

?>

<? if ( $vars['ControlBox'] ): ?>
	<table id="map_control_box" border="0" cellspacing="0" cellpadding="0">
		<tr><td><span class="map_control_btnTitle">Карта</span></td>
		<td><?=( App::$CurrentEnv['regid'] == 74 ? STPL::Display( 'controls/banner', array('version'=>2, 'id'=>2071) ) : '' )?></td>
		<td align="right" class="rl_note1">
			<? if ( $vars['closeMapUrl'] ): ?>
				<a href="<?=$vars['closeMapUrl']?>">убрать карту</a>
			<? endif; ?>
			<span class="map_control_btnRestore"<? if ( $vars['State'] == 1 ): ?> style="display:none"<? endif; ?>>обычный размер</span>
			<span class="map_control_btnMaximize"<? if ( $vars['State'] == 2 ): ?> style="display:none"<? endif; ?>>большой размер</span>
		</td>
	</table>
<? endif; ?>
<div id="map_area"></div>

<script type="text/javascript" language="javascript">

function showYandexMap()
{
	$('#map_area').yandexmap({
		placeMarksList: <? if ( !empty($vars['PointsJS']) ):?><?=$vars['PointsJS']?><? else: ?>[]<? endif; ?>,
		polygonList: <? if ( !empty($vars['PolygonsJS']) ):?><?=$vars['PolygonsJS']?><? else: ?>[]<? endif; ?>,
		RulerState: '',
		enableScrollZoom: <?=isset($vars['enableScrollZoom']) ? ($vars['enableScrollZoom'] ? 'true' : 'false') : 'true'?>,
		enableDragging: <?=isset($vars['enableDragging']) ? ($vars['enableDragging'] ? 'true' : 'false') : 'true'?>,
		enableDblClickZoom: <?=isset($vars['enableDblClickZoom']) ? ($vars['enableDblClickZoom'] ? 'true' : 'false') : 'true'?>,
		placeMarkCode: '',
		geoSearchQuery: '',
		<? if ( !empty($vars['onUpdate']) ): ?>onUpdate: '<?=addslashes($vars['onUpdate'])?>',<? endif; ?>
		<? if ( !empty($vars['onBoundsChange']) ): ?>onUpdate: '<?=addslashes($vars['onBoundsChange'])?>',<? endif; ?>
		<? if ( !empty($vars['onDragEnd']) ): ?>onDragEnd: '<?=addslashes($vars['onDragEnd'])?>',<? endif; ?>
		mapCenter: {
			Coords: [
				'<?=$vars['Coords'][0]?>',
				'<?=$vars['Coords'][1]?>'
			],
			Span: [
				'<?=$vars['Span'][0]?>',
				'<?=$vars['Span'][1]?>'
			],
			Type: 'MAP'
		},
		controlsList: {
			ToolBar: {
				enable: <?=$vars['controlsList']['ToolBar'] ? 'true' : 'false'?>
			},
			TypeControl: {
				enable: <?=$vars['controlsList']['TypeControl'] ? 'true' : 'false'?>
			},
			Zoom: {
				enable: <?=$vars['controlsList']['Zoom'] ? 'true' : 'false'?>
			},
			MiniMap: {
				enable: <?=$vars['controlsList']['MiniMap'] ? 'true' : 'false'?>
			},
			ScaleLine: {
				enable: <?=$vars['controlsList']['ScaleLine'] ? 'true' : 'false'?>
			},
			SmallZoom: {
				enable: <?=$vars['controlsList']['SmallZoom'] ? 'true' : 'false'?>
			}
		}
	});
}

$(document).ready(function(){
<? if ( $vars['State'] > 0 ): ?>
	showYandexMap();
<? endif; ?>
<? if ( $vars['ControlBox'] ): ?>
	$('.map_control_btnRestore').click(function() {
		$('.map_control_btnMaximize').css('display','');
		$('.map_control_btnRestore').css('display','none');
		
		$('#map_area').css('height', <?=$vars['Height']?>);
		
		showYandexMap();
	});
	$('.map_control_btnMaximize').click(function() {
		$('.map_control_btnMaximize').css('display','none');
		$('.map_control_btnRestore').css('display','');
		
		$('#map_area').css('height', <?=$vars['MaxHeight']?>);
		
		showYandexMap();
	});
	$('.map_control_btnTitle').click(function() {
		if ( $('.map_control_btnRestore').css('display') == 'none' )
		{
			$('.map_control_btnMaximize').css('display','none');
			$('.map_control_btnRestore').css('display','');
			
			$('#map_area').css('height', <?=$vars['MaxHeight']?>);
			
			showYandexMap();
		}
		else
		{
			$('.map_control_btnMaximize').css('display','');
			$('.map_control_btnRestore').css('display','none');
			
			$('#map_area').css('height', <?=$vars['Height']?>);
			
			showYandexMap();
		}
	});
<? endif; ?>
});
</script>
