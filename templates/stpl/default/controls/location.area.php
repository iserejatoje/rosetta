<?

App::$Title->AddScript(        "/_scripts/themes/location.area.js"  );

LibFactory::GetStatic('location');

$_params = array(
	'select_text' 	=> '- Выберите район -',
	'result' 		=> 'Area',
	'multiple' 		=> 0,
	'listAlign'		=> 'bottom'
);

$_params = array_merge($_params, $vars);

if (empty($_params['parent']))
	return ;
if (strlen($_params['parent']) < 22)
	$_params['parent'] .= str_repeat('0', 22-strlen($_params['parent']));

$pc = Location::ParseCode($_params['parent']);

$list = Location::GetAreas($pc);

?>

<? if ( $_params['multiple'] ): ?>
	<script type="text/javascript" language="javascript">
		$(document).ready(function() {
		    $(".location-area select").asmSelect({
				prefix: 'Ar',
				listType: 'ul',
		        animate: true,
				sortable: false,
				hideWhenAdded: true,
				highlight: false,
				<? if ( $_params['removeLabel'] ): ?>removeLabel: '<?=$_params['removeLabel']?>',<? endif; ?>
				<? if ( $_params['parent_container'] ): ?>parent_container: '<?=$_params['parent_container']?>',<? endif; ?>
		        addItemTarget: 'bottom',
				<? if ( $_params['listAlign'] ): ?>listAlign: '<?=$_params['listAlign']?>'<? endif; ?>
		    });
		});
	</script>
<? endif; ?>

<div class="location-area">
	<select class="list location-area-o" name="<?=$_params['result']?><? if ( $_params['multiple'] ): ?>[]<? endif; ?>"<? if ( $_params['multiple'] ): ?> multiple="multiple" style="display:none" title="<?=$_params['select_text']?>"<? endif; ?>>
		<? if ( !$_params['multiple'] ): ?><option value="0"><?=$_params['select_text']?></option><? endif; ?>
		<? foreach ( $list as $l ): ?>
			<? if ( $_params['multiple'] ): ?>
				<option value="<?=$l['Code']?>"<? if ( is_array($_params['Code']) && in_array($l['Code'], $_params['Code'], true) ): ?> selected="selected"<? endif; ?>><?=$l['FullName']?></option>
			<? else: ?>
				<option value="<?=$l['Code']?>"<? if ( !empty($_params['Code']) && $l['Code'] === $_params['Code'] ): ?> selected="selected"<? endif; ?>><?=$l['FullName']?></option>
			<? endif; ?>
		<? endforeach; ?>
	</select>
</div>

<? if ( !empty($_params['parent_container']) && !$_params['multiple'] && count($list) == 0 ): ?>
	<script type="text/javascript" language="javascript">
		$('.<?=$_params['parent_container']?>').css('display','none');
	</script>
<? endif; ?>