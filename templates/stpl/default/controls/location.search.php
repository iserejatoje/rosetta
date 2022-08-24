<?
LibFactory::GetStatic('location');

$_params = array(
	'suggest_limit'	=> 20,
	'limit' 		=> 150,
	'suggest_text' 	=> 'Название места...',
	'parent' 		=> '',
	'type'			=> array_merge(
							Location::$TC_CITIES,
							Location::$TC_VILLAGES,
							Location::$TC_STREETS,
							Location::$TC_COTTAGES,
							Location::$TC_GARDENS,
							Location::$TC_GARAGES
						),
	'result'		=> '',
	'input'			=> ''
);

$_params = array_merge($_params, $vars);

if (empty($_params['parent']))
	return ;

if (strlen($_params['parent']) < 22)
	$_params['parent'] .= str_repeat('0', 22-strlen($_params['parent']));

$id = md5(microtime(true));

?>

<div id="<?=$id?>" class="location-search">
	<input type="hidden" class="location-search-v" name="<?=$_params['result']?>" value="" />
	<input type="text" id="<?=$_params['input']?>" name="<?=$_params['input']?>" class="location-search-s suggest" autocomplete="off" value="<?=$_params['suggest_text']?>" />
</div>

<?
	include_once ENGINE_PATH.'include/json.php';
	$json = new Services_JSON();
	$json->charset = 'WINDOWS-1251';
?>

<script type="text/javascript" language="javascript">
	$(document).ready(function() {
		var o = <? echo $json->encode($_params); ?>;
		$('#<?=$id?>').location_search(o);
	});
</script>