<?php
$catalogMgr = CatalogMgr::GetInstance();
?>
<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}

	.radio label + label,
	.checkbox label + label {
		margin: 0 0 10px 20px;
	}
</style>

<script>

	$(document).ready(function() {


		$('body').on('change', '[name="Elements[]"]', function() {
			
			var value = $(this).val(),
				tr = $(this).closest('tr');

			$(tr).find('[name="IsEditable"]').val(value);

		});
	});

	function addMember()
	{
		var trobj = $("#etalon tr");
		var tr = trobj.clone();
		$("#flower_constructor tbody").append("<tr>"+tr.html()+"</tr>");
	}

	function removeMember(el) {
		$(el).closest("tr").remove();
	}
</script>

<? if (($err = UserError::GetErrorByIndex('global')) != '' )
{?>
	<h3><?=$err?></h3><br/>
<? }
else
{ ?>

<? if ($vars['form']['ProductID'] > 0) { ?>
	<?= STPL::Display('admin/modules/catalog/_product_tabs', $vars); ?>
<? } ?>

<table id="etalon" style="display:none">
	<tr>
		<? if($vars['category']->kind == CatalogMgr::CK_MONO) { ?>
		<td>
			<input type="radio" class="form-control" name="IsEditable" value="">
		</td>
		<? } ?>
		<td>
			<select class="form-control" name="Elements[]">
				<option value="">- Выберите элемент -</option>
				<? foreach ($vars['members'] as $member) {
					$areaRefs = $member->GetAreaRefs($vars['section_id']);
					?>
					<option value="<?=$member->MemberID ?>"><?=$member->Name ?> - [<?=$areaRefs['Price'] ?>руб.]</option>
				<? } ?>
			</select>
		</td>
		<td>
			<input name="ElCount[]" type="text" value="1" class="form-control">
		</td>
		<? /*<td style="text-align:center">
			<input type="checkbox" class="visible" value="1" checked="checked" />
		</td> */ ?>
		<td>
			<a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="removeMember(this)" title="Удалить элемент">Удалить</a>
		</td>
	</tr>
</table>

<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['ProductID']?>" />
	<input type="hidden" name="type_id" value="<?=$vars['form']['TypeID']?>" />
	<input type="hidden" name="tid" value="<?=$vars['form']['tid']?>" />

	<p>
		<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="addMember()" title="Добавить элемент" class="btn btn-primary btn-sm">
			<span class="glyphicon glyphicon-plus"></span>
			Добавить&#160;элемент
		</a>

		<span><?=$vars['type']->GetPrice($vars['section_id'])?></span>руб.
	</p>


	<table id="flower_constructor" class="table table-striped">
		<tr>
			<? if($vars['category']->kind == CatalogMgr::CK_MONO) { ?>
				<th>Изменяемый элемент</th>
			<? } ?>
			<th>Элемент</th>
			<th width="15%">Кол-во</th>
			<th></th>
		</tr>

		<? /*if($vars['category']->kind == CatalogMgr::CK_MONO) { ?>
			<tr data-line='<?=$i?>'>
				<td>
					<select class="form-control" name="Elements[]">
					<? foreach ($vars['members'] as $member) {
							$areaRefs = $member->GetAreaRefs($vars['section_id']);
						?>
						<option value="<?= $member->MemberID ?>" <? if ($element['ElementID'] == $member->ID) { ?>selected="selected"<? } ?>><?=$member->Name ?> - [<?=$areaRefs['Price'] ?>руб.]</option>
					<? } ?>
					</select>
				</td>
				<td><input type="text" name="ElCount[]" class="form-control" value="<?=$vars['elements'][0]['Count'] ?>"/></td>
				<td></td>
			</tr>
		<? } else { */?>
			<? $i = 0 ?>
			<? foreach ($vars['elements'] as $element) { ?>
				<? $i++; ?>
			<tr data-line='<?= $i  ?>'>
				<? if($vars['category']->kind == CatalogMgr::CK_MONO) { ?>
				<td>
					<input type="radio" class="form-control" name="IsEditable" value="<?= $element['ElementID'] ?>"  <?if($element['IsEditable']){?> checked="checked" <? } ?>>
				</td>
				<? } ?>
				<td>
					<input type="hidden" name="Elements[]" value="<?= $element['ElementID'] ?>">
					<div>
						<?php
							$member = $catalogMgr->GetMember($element['ElementID']);
							$areaRefs = $member->GetAreaRefs($vars['section_id']);
							$price = $member->isVisibleElement($vars['section_id'])? $areaRefs['Price'] : 'нет в наличии';
							echo $member->Name . ' [' . $price . ' руб.]';
						?>
					</div>
					<?php /*
					<select class="form-control" name="Elements[]">
					<? foreach ($vars['members'] as $member) {
							$areaRefs = $member->GetAreaRefs($vars['section_id']);
						?>
						<option value="<?= $member->MemberID ?>" <? if ($element['ElementID'] == $member->ID) { ?>selected="selected"<? } ?>>
							<?=$member->Name ?> - [<? if($member->isVisibleElement($vars['section_id']) == 1) {?><?=$areaRefs['Price'] ?>руб.<?} else {?>нет в наличии<?}?>]
						</option>
					<? } ?>
					</select>
					*/ ?>
				</td>
				<td><input type="text" name="ElCount[]" class="form-control" value="<?= $element['Count'] ?>"/></td>
				<? /*<td style="text-align:center"><input type="checkbox" name="IsVisibleEl[<?= $i ?>]" <? if ($element['IsVisibleEl']) { ?>checked=checked<? } ?> class="isvisibleel" value="1"/></td>*/ ?>
				<td><a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="removeMember(this)" title="Удалить элемент">Удалить</a></td>
			</tr>
			<? /* } */?>
		<? } ?>
	</table>

	<br/>
	<center><button type="submit" class="btn btn-success btn-large">Сохранить</button></center>
</form>

<? } ?>