<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
</style>


<p><a href="?section_id=<?=$vars['section_id']?>&action=new_decor" class="btn btn-primary btn-sm">
	<span class="glyphicon glyphicon-plus"></span>
	Добавить оформление
</a></p>
<script>
	function checkaction()
	{ 
		obj = document.getElementById("action");
		if(obj.options[obj.selectedIndex].value=='')
			return false;
		return true;
	 }
	</script>
<form method="post" onsubmit="return checkaction();">
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
<table class="sortable table table-bordered table-hover table-striped">
	<tr>
		<th width="5%">ID</th>
		<th width="55%">Название</th>
		<th width="40%">Стоимости</th>
		<th><input type="checkbox" onchange="if (this.checked) $('.ids_action').attr('checked', 'checked'); else $('.ids_action').attr('checked', '');"/></th>
	</tr>
	<? if (is_array($vars['decors']) && sizeof($vars['decors']) > 0) { ?>
		<? foreach ($vars['decors'] as $l) { ?>
		<tr>
			<td align="center">
				<?= $l['DecorID'] ?>
			</td>
			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_decor&id=<?= $l['DecorID'] ?>"><?= $l['Name'] ?></a>
			</td>
			<td>
				<? if (is_array($l['Ranges']) && sizeof($l['Ranges']) > 0) { ?>
					<? foreach ($l['Ranges'] as $ll) { ?>
					<?= $ll['from'] ?>-<?= $ll['to'] ?> шт: <b><?= $ll['price'] ?> руб.</b><br/>
					<? } ?>
				<? } else { ?>
				&nbsp;
				<? } ?>
			</td>
			<td>
				<input class="ids_action ids_action_<?= $l['DecorID'] ?>" type="checkbox" name="ids_action[]" value="<?= $l['DecorID'] ?>"/>
			</td>
		</tr>
		<? } ?>
	<? } ?>
</table>
<div align="right"><nobr>
	<div class="form-group">
		<select name="action" id="action" class="form-control" style="max-width: 200px; display: inline-block;">
			<option value="decor_delete">Удалить элементы</option>
		</select>
		<input type="submit" value="ОK" class="btn btn-primary btn-sm" />
		</nobr>
	</div>
</div>
</form>