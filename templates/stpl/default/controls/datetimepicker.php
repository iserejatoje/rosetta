<?

global $OBJECTS;

if ( is_object($OBJECTS['title']) )
{
	$OBJECTS['title']->AddStyles(array(
		'/_styles/jquery/datetimepicker/ui.datetimepicker.css',
	));

	$OBJECTS['title']->AddScripts(array(
		'/_scripts/themes/frameworks/jquery/jquery.datetimepicker.js',
	));
}

$_params = array(
	'result'		=> 'datepicker', //Имя input'а для пикера
	'datetime'		=> false,		 //false - выбор только даты, true - дата и время	
	'date'			=> null,		 //Текущая дата в формате ...
);

foreach($_params as $k => $v)
{	
	if (isset($vars[$k]) && $vars[$k] != $_params[$k])
		$_params[$k] = $vars[$k];
}

if ($_params['date'] !== null)
{
	if ( ($time = strtotime($_params['date'])) === -1)
		$_params['date'] = $time;
	
	$_params['date'] = date("d.m.Y".($_params['datetime'] === true ? " H:i" : ""), $_params['date']);
}
?>


<script type="text/javascript">	
<!--
	$(document).ready(function() {
		$("#<?=$_params['result']?>").DateTimepicker({
				<?if ($_params['datetime'] === true) { ?>pickDateOnly: false,<? }else { ?>timeFormat: '',<? } ?>
				
				changeMonth: false,
				changeYear: false
		});
	});
-->
</script>
<input type="text" autocomplete="off" name="<?=$_params['result']?>" id="<?=$_params['result']?>"<? if ($_params['date'] != null) { ?> value="<?=$_params['date']?>"<? } ?>>
