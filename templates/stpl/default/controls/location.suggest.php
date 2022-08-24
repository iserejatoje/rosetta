<?
LibFactory::GetStatic('location');

$_params = array(
	'suggest_limit'	=> 20,
	'limit' 		=> 150,
	'code'			=> '',
	'house'			=> '',
	'suggest_text' 	=> 'Введите адрес...',
	'text' 			=> '',
	'parent' 		=> '',
	'multiple' 		=> 0,
	'list'			=> array(),
	'type'			=> array_merge(
							Location::$TC_CITIES,
							Location::$TC_VILLAGES,
							Location::$TC_STREETS,
							Location::$TC_COTTAGES,
							Location::$TC_GARDENS,
							Location::$TC_GARAGES
						),
	'i_result'		=> '',
	'i_house'			=> '',
	'default_location'	=> '',
	'onSelect'		=> '',
);

$_params = array_merge($_params, $vars);

if (empty($_params['parent']))
	return ;

if (!is_array($_params['parent']) && strlen($_params['parent']) < 22)
	$_params['parent'] .= str_repeat('0', 22-strlen($_params['parent']));

$id = md5(microtime(true));

?>


<div id="<?=$id?>" class="location-suggest">
	<? if ( $_params['multiple'] ): ?>
		<select class="list multiple location-suggest-o" name="<?=$_params['i_result']?>" style="display:none" multiple="multiple">
			<? if ( is_array($_params['list']) ): ?>
				<? foreach ( $_params['list'] as $l ): ?>
					<? if ( empty($l['Code']) || empty($l['Name']) ) continue; ?>
					<option value="<?=$l['Code']?>" selected="selected"><?=$l['Name']?></option>
				<? endforeach; ?>
			<? endif; ?>
		</select>
	<? endif; ?>
	
	<? if ( $vars['show_hint'] ): ?><b>Выбрано: <span class="location-suggest-hint"><?=$_params['code'] ? $_params['suggest_text'] : '-ничего-'?></span></b><br /><? endif; ?>
	<input type="hidden" class="location-suggest-v" name="<?=$_params['i_result']?>" value="<?=$_params['code']?>" />
	<input type="hidden" class="location-suggest-h" name="<?=$_params['i_house']?>" value="<?=$_params['house']?>" />
	<input type="text" class="location-suggest-s suggest" style="margin-top:2px;" autocomplete="off" <? if ( $_params['input'] ): ?>name="<?=$_params['input']?>"<? endif; ?> value="<?=($_params['text'] ? $_params['text'] : $_params['suggest_text'])?>" title="Введите адрес и выберите один вариант из предложенного списка" /><? if ( $vars['help_link'] ): ?>&nbsp;<a href="<?=$vars['help_link']?>" target="_blank"><img src="/_img/design/200710_dom/help.gif" border="0" alt="?" title="Помощь" /></a><? endif; ?>
	
	<? if ( $_params['multiple'] && !empty($_params['onAddAddress']) ): ?>
		<div class="location-suggest-a" style="text-align:right;<? if ( count($_params['list']) == 0 && empty($_params['code']) ): ?>display:none<? endif; ?>">
			<span class="rl_underline_dashed_2" onclick="<?=$_params['onAddAddress']?>">добавить еще адрес</span>
		</div>
	<? endif; ?>
</div>

<?
	include_once ENGINE_PATH.'include/json.php';
	$json = new Services_JSON();
	$json->charset = 'WINDOWS-1251';
?>

<script type="text/javascript" language="javascript">
	$(document).ready(function() {
		var o = <? echo $json->encode($_params); ?>;
		var location_suggest = $('#<?=$id?>').location_suggest(o);
		<? if ( $_params['onSelect'] ): ?>
			location_suggest.suggest( function(o, value) {
				var onSelect = new Function('parent', 'level', '<?=$_params['onSelect']?>');
				onSelect(value.id, value.level);
			});
		<? endif; ?>
	});
</script>