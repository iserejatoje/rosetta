<?
LibFactory::GetStatic('location');

$_params = array(
	'type' 				=> array(),
	
	'important' 		=> 0,
	
	'suggest_limit'		=> 20,
	'search_limit' 		=> 50,
	
	'limit' 			=> 150,
	
	'select_text' 		=> '- Выберите ориентир -',
	'select_other_text'	=> '- Другой -',
	'select_tree' 		=> 0,
	
	'suggest_text' 		=> '',
	
	'parent' 			=> '',
	'code' 				=> '',
	
	'result' 			=> 'Landmark',
	'input' 			=> 'LandmarkText',
	
	'container_class_name'	=> 'location-landmark',
	
	'multiple' 			=> 0
);


$_params = array_merge($_params, $vars);

if (empty($_params['parent']))
	return ;

if (strlen($_params['parent']) < 22)
	$_params['parent'] .= str_repeat('0', 22-strlen($_params['parent']));
	
$defaultCodes = Location::ParseCode($_params['parent']);

$_types = Location::GetAbbr();
foreach ( $_types as $v )
	$types[$v['SocrId']] = $v;

?>

<? if ( $_params['multiple'] ): ?>
	<? $_params['onSelect'] = 'landmarkChange(code)' ?>
	<select id="s_Landmark" name="LandmarkID[]" multiple="multiple" style="display:none"></select>
	
	<script type="text/javascript" language="javascript">
		$(document).ready(function() {
		    $("#s_Landmark").asmSelect({
				<? if ( $_params['removeLabel'] ): ?>removeLabel: '<?=$_params['removeLabel']?>',<? endif; ?>
				prefix: 'Lm',
				listType: 'ul',
		        animate: true,
				sortable: false,
				hideWhenAdded: true,
				highlight: false
		    });
			
			if ( $.browser.msie )
				$('#LmasmSelect0').css('display','none').css('height','0px').css('width','0px');
		});
		
		function landmarkChange(landmark)
		{
			if ( landmark != -1 )
			{
				obj = $('.location-landmark-o', '.<?=$_params['container_class_name']?>').get(0);
				if ( obj != null )
				{
					var landmark_text = obj.options[obj.selectedIndex].innerHTML;					
					obj.selectedIndex = 0;
				}
				else
				{
					var landmark_text = $('.location-landmark-s', '.<?=$_params['container_class_name']?>').val();
					$('.location-landmark-s', '.<?=$_params['container_class_name']?>').val('');
				}
				var $option = $('<option/>').attr('value',landmark).text(landmark_text).attr('selected','selected');
				
				$('#s_Landmark').append($option).change();
			}
		}
	</script>
<? endif; ?>

<div class="<?=$_params['container_class_name']?>">
<input type="hidden" class="location-landmark-v"<? if ( !$_params['multiple'] ):?> name="<?=$_params['result']?>"<? endif; ?> value="<?=$_params['code']?>" />
<?

	$count = Location::GetSubordinateLandmarksCount($_params['parent'], array(
		'Important'	=> ($_params['important'] == true ? 1 : null),
	));
	
	if ($_params['limit'] === null) {
		list($list, $count) = Location::GetSubordinateLandmarks($_params['parent'], array(
			'Type'	=> array('not_in' => array(0)),
			'Important'	=> (($_params['important'] == true && $count)? 1 : null),
			'field'		=>  $_params['select_tree'] ? 'Type, Name' : 'Name',
		), false, true);
	} else {
		list($list, $count) = Location::GetSubordinateLandmarks($_params['parent'], array(
			'Type'	=> array('not_in' => array(0)),
			'Important'	=> (($_params['important'] == true && $count)? 1 : null),
			'field'		=> $_params['select_tree'] ? 'Type, Name' : 'Name',
			'limit'		=> $_params['limit'][$level],
		), false, true);
	}
	
	if ( !empty($_params['code']) )
	{
		$in_list = false;
		foreach ( $list as $v )
		{
			if ( $v['LandmarkID'] == $_params['code'] )
			{
				$in_list = true;
				break;
			}
		}
	}
	else
		$in_list = true;
	
	?>
	
	<span class="location-landmark-c">
	
	<? if ( $in_list && $_params['limit'] >= $count && $count > 0 ): ?>
		<? $_type = -1; ?>
		
		<select class="location-landmark-o list"<? if ( !$_params['multiple'] ): ?> name="<?=$_params['result']?>"<? endif; ?>>
			<option><?=$_params['select_text']?></option>
			<? if ($count > sizeof($list))
				?>
					<option value="-1" style="font-weight:bold"><?=$_params['select_other_text']?></option>
				<?
			?>
			
			<? foreach($list as $v): ?>
			
			
				<? if ( $_params['select_tree'] && $_type != $v['Type'] ): ?>
					<? if ( $_params['select_tree'] && $_type != -1 ): ?>
							</optgroup>
					<? endif; ?>
					<optgroup label="<?=$types[$v['Type']]['SocrText']?>">
					<? $_type = $v['Type']; ?>
				<? endif; ?>
			
				<option value="<?=$v['LandmarkID']?>" <? if ( $in_list == true && $v['LandmarkID'] == $_params['code'] ): ?>selected="selected"<? endif; ?>><? if ( $_params['select_tree'] ): ?><?=$v['Name']?><? else: ?><?=$v['FullName']?><? endif; ?></option>
			<? endforeach; ?>
			
			<? if ( $_params['select_tree'] ): ?>
				</optgroup>
			<? endif; ?>
			<? if ($count > sizeof($list))
				?>
					<option value="-1" style="font-weight:bold"><?=$_params['select_other_text']?></option>
				<?
			?>
		</select>
	
	<? else: ?>
		<?
			if ( !empty($_params['code']) )
			{
				$lm = Location::GetLandmarkById($_params['code']);
				$_params['suggest_text'] = $lm['FullName'];
			}
		?>
		<input type="text" name="<?=$_params['input']?>" class="location-landmark-s suggest" autocomplete="off" value="<?=$_params['suggest_text']?>" 
		<?
		/*
		onblur="if( this.value=='Выберите ориентир' || this.value=='' ) this.value='Выберите ориентир';" onclick="if( this.value=='Выберите ориентир') this.value=''"  
		*/
		?>
		/>
	
	<? endif; ?>
	</span>
	
</div>

<script type="text/javascript" language="javascript">
	
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
		
		$_params['code'] = array_values($defaultCodes);
	?>
	
	$(document).ready(function() {
		var o = <? echo json_encode($_params); ?>;
		$('.<?=$_params['container_class_name']?>').location_landmark(o);
	});
</script>