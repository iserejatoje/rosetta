<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}
	.font-23 {
		font-size: 23px;
	}
	a .glyphicon-success {
		color: #5cb85c !important;
	}
	a .glyphicon-danger {
		color: #d9534f !important;
	}
	.ord-field {
		text-align: center;
	}
</style>

<? if($vars['product']->category->kind != CatalogMgr::CK_MONO) { ?>
<p><a href="?section_id=<?=$vars['section_id']?>&action=product_type_new&id=<?= $vars['product']->ID ?>" class="btn btn-primary btn-sm">
	<span class="glyphicon glyphicon-plus"></span>
	Добавить тип
</a></p>
<? } ?>
<script>
	function checkaction()
	{
		obj = document.getElementById("action");
		if(obj.options[obj.selectedIndex].value=='')
			return false;
		return true;
	}
	$(document).ready(function() {
		$("#searchTextType").bind("keyup change", function() {
			str = $(this).val();
			if(str == "") {
				$("#types-list tr").show();
			 } else {
				$("#types-list  tbody tr").hide();
				$("#types-list td:contains('"+str+"')").parent().show();
			 }
		 });


		$('.table a.visible').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					if (data.visible == 1)
					{
							$('.table #type_'+data.typeid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #type_'+data.typeid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-open')
							.removeClass('glyphicon-success')
							.addClass('glyphicon-eye-close')
							.addClass('glyphicon-danger');
					}
				}
			});
		});

		$('.table a.default').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					$('.table a.default .glyphicon')
						.removeClass('glyphicon-ok')
						.removeClass('glyphicon-success')
						.addClass('glyphicon-remove')
						.addClass('glyphicon-danger');

					$('.table #type_'+data.typeid+' a.default .glyphicon')
						.removeClass('glyphicon-remove')
						.removeClass('glyphicon-danger')
						.addClass('glyphicon-ok')
						.addClass('glyphicon-success');
				}
			});
		});
	 });

</script>


<? if ($vars['form']['ProductID'] > 0) { ?>
	<?= STPL::Display('admin/modules/catalog/_product_tabs', $vars); ?>
<? } ?>

<? /*<div class="form-group">
	Фильтровать <input type="text" id="searchTextType" class="form-control" style="max-width: 200px; display: inline-block;">
	<input type="button" value="Сбросить" onclick="$('#searchTextType').val('').change()" class="btn btn-primary btn-sm">
</div> */ ?>
<form method="post" onsubmit="return checkaction();">
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
	<input type="hidden" name="id" value="<?=$vars['form']['ProductID']?>" />
	<input type="hidden" name="type_id" value="<?=$vars['form']['TypeID']?>" />
<table width="100%" id="types-list" class="sortable table table-bordered table-hover table-striped">
	<tr>
		<th width="5%">ID</th>
		<th width="70%">Название</th>
		<th width="5%">Порядок</th>
		<th width="5%">По умолч.</th>
		<th width="5%">Видимость</th>
		<th width="5%">Состав</th>
		<th><input type="checkbox" onchange="if (this.checked) $('.ids_action').attr('checked', 'checked'); else $('.ids_action').attr('checked', '');"/></th>
	</tr>
	<? if (is_array($vars['types']) && sizeof($vars['types']) > 0) { ?>
		<? foreach ($vars['types'] as $type) { ?>
		<? $areaRefs = $type->GetTypeAreaRefs($vars['section_id']); ?>
		<tr id="type_<?= $type->ID ?>">
			<td align="center">
				<?= $type->ID ?>
			</td>

			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=product_type_edit&id=<?= $vars['product']->ID ?>&tid=<?= $type->ID ?>" name="type<?= $type->ID ?>"><?= $type->Name ?></a>
				<br/>
			</td>

			<td align="center">
				<input class="form-control input-sm input-ord ord-field" type="text" name="Ord[<?=$type->ID?>]" value="<?= $type->Ord ?>"/>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_product_type_toggle_default&tid=<?= $type->ID ?>&type_id=<?= $vars['form']['TypeID'] ?>&id=<?= $vars['form']['ProductID'] ?>" class="default btn btn-default btn-sm">
					<? if ($areaRefs['IsDefault']==1) { ?>
						<span class="glyphicon glyphicon-ok glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-remove glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_product_type_toggle_visible&tid=<?= $type->ID ?>&type_id=<?= $vars['form']['TypeID'] ?>&id=<?= $vars['form']['ProductID'] ?>" class="visible btn btn-default btn-sm">
					<? if ($areaRefs['IsVisible']==1) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_composition&type_id=<?= $vars['form']['TypeID'] ?>&id=<?= $vars['form']['ProductID'] ?>&tid=<?= $type->ID ?>" class="font-23"><span class="glyphicon glyphicon-list-alt"></span></a>
			</td>

			<td align="center">
				<input class="ids_action ids_action_<?= $type->ID ?>" type="checkbox" name="ids_action[]" value="<?= $type->ID ?>"/>
			</td>
		</tr>
		<? } ?>
	<? } ?>
</table>
<div align="right"><nobr>
	<div class="form-group">
		<select name="action" id="action" class="form-control" style="max-width: 200px; display: inline-block;">
			<option value="product_types_save">Сохранить</option>
			<option value="product_types_delete">Удалить</option>
		</select>
		<input type="submit" value="ОK" class="btn btn-primary btn-sm">
	</nobr>
</div>
</form>