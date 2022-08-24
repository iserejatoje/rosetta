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

<? if (($err = UserError::GetErrorByIndex('global')) != '' )
{?>
	<h3><?=$err?></h3><br/>
<? }
else
{ ?>

<? if ($vars['form']['GroupID'] > 0) { ?>
	<?= STPL::Display('admin/modules/service/_group_tabs', $vars); ?>
<? } ?>

<form name="new_object_form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="id" value="<?=$vars['form']['GroupID']?>" />

	<table class="table table-striped">
	<tr><td>
	<? foreach ($vars['filters'] as $filter) { ?>
	<div class="checkbox well well-sm">
		<div class="form-group">
			<label class="control-label" for="product-productfilterref">Выберите <?=$filter->Name ?></label>
			<input type="hidden" name="Filters[<?= $filter->ID ?>]">
			<div class="checkbox" id="product-productfilterref">
				<? foreach ($filter->Params as $k => $v) { ?>
					<label><input type="checkbox" name="Filters[<?= $filter->ID ?>][]" value="<?= $v['ParamID'] ?>"<? if (isset($vars['fParams'][$filter->ID][$v['ParamID']])) { ?> checked<? } ?>> <?= $v['Name'] ?></label>
				<? } ?>
			</div>

			<p class="help-block help-block-error"></p>
		</div>
	</div>
	<? } ?>
	</td></tr>
	</table>

	<br/>
	<center><button type="submit" class="btn btn-success btn-large">Сохранить</button></center>
</form>

<? } ?>