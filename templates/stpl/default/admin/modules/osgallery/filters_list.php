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
</script>

<p>
    <a href="?section_id=<?=$vars['section_id']?>&action=new_filter" class="btn btn-primary btn-sm">
    <span class="glyphicon glyphicon-plus"></span>
        Добавить фильтр
    </a>
</p>
<? /*
*/ ?>

<form method="post" onsubmit="return checkaction();">
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
<table class="sortable table table-bordered table-hover table-striped">
	<tr>
		<th width="5%">ID</th>
		<th width="55%">Название</th>
		<th width="40%">Параметры</th>
		<th><input type="checkbox" onchange="if (this.checked) $('.ids_action').attr('checked', 'checked'); else $('.ids_action').attr('checked', '');"/></th>
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
				<? $items = $l->GetParams(); ?>
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
			<td>
				<input class="ids_action ids_action_{$l->ID}" type="checkbox" name="ids_action[]" value="<?= $l->ID ?>"/>
			</td>
		</tr>
		<? } ?>
	<? } ?>
</table>
<div align="right"><nobr>
	<div class="form-group">
			<select name="action" id="action" class="form-control" style="max-width: 200px; display: inline-block;">
				<option value="filters_delete">Удалить элементы</option>
			</select>
			<input type="submit" value="OK" class="btn btn-primary btn-sm">
		</nobr>
	</div>
</div>
</form>