<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
</style>


<script>
	function checkaction()
	{
		obj = document.getElementById("action");
		if(obj.options[obj.selectedIndex].value=='')
			return false;
		return true;
	}

	$(document).ready(function() {
		$('.check-all').on('change', function() {	
			if (this.checked) { 
				$(document).find('.ids_action').prop('checked', true); 
				$('.ids_action').val(1); 
			}  else  { 
				$(document).find('.ids_action').prop('checked', false); 
				$('.ids_action').val(0); 
			}
		});


		$('.input-ord').on('change', function() {
			var value = $(this).val();
			$(this).attr('value', value);
		});

		$('.ids_action').on('change', function() {
			if($(this).attr('value') == 0 || $(this).attr('value') == undefined)
				$(this).attr('value', 1);
			else 
				$(this).attr('value', 0);
		});
	});
	
</script>

<?
	$service_id = App::$Request->Get['serviceid']->Value(Request::OUT_HTML | Request::OUT_CHANGE_NL);
?>

<p>
    <a href="?section_id=<?=$vars['section_id']?>&action=new_filter&service_id=<?= $service_id ?>" class="btn btn-primary btn-sm">
    <span class="glyphicon glyphicon-plus"></span>
        Добавить фильтр
    </a>
</p>
<? /*
*/ ?>

<form method="post"  enctype="multipart/form-data" onsubmit="return checkaction();">
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
<table class="sortable table table-bordered table-hover table-striped">
	<tr>
		<th width="5%">ID</th>
		<th width="35%">Название</th>
		<th width="40%">Параметры</th>
		<th width="15%">Порядок</th>
		<th><input type="checkbox" class="check-all"/></th>
	</tr>
	<? if (is_array($vars['filters']) && sizeof($vars['filters']) > 0) { ?>
		<? foreach ($vars['filters'] as $l) { ?>
		<tr>
			<td align="center">
				<?= $l->ID ?>
			</td>
			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_filter&id=<?= $l->ID ?>" name="filter<?= $l->ID ?>"><?= $l->Name ?></a>
			</td>

			<td>
				<?
					$attrs = [
					    'field' => ['Ord'],
					    'dir'   => ['ASC'],
					];
				?>
				<? $items = $l->GetParams($attrs); ?>
				<? if (is_array($items) && sizeof($items) > 0) { ?>
					<? foreach ($items as $ll) {
						echo $ll['Name'];

						if (!empty($ll['Value'])) echo ' - '. $ll['Value'];

						echo '<br/>';
						}
					?>
				<? } else { ?>
				&nbsp;
				<? } ?>
			</td>

			<td><input type="text" class="input-ord form-control" name="param_ord[<?=$l->ID?>]" value="<?=$l->Ord?>"></td>

			<td align="center">
				<input class="ids_action ids_action_<?= $l->ID ?>" type="checkbox" name="ids_action[<?= $l->ID ?>]" />   <?/*value="<?= $l->ID ?>*/?>
			</td>
		</tr>
		<? } ?>
	<? } ?>
</table>
<div align="right"><nobr>
	<div class="form-group">
			<select name="action" id="action" class="form-control" style="max-width: 200px; display: inline-block;">
				<option value="filters_save">Сохранить порядок</option>
				<option value="filters_delete">Удалить элементы</option>
			</select>
			<input type="submit" value="OK" class="btn btn-primary btn-sm">
		</nobr>
	</div>
</div>
</form>