<? foreach($vars['fields'] as $field => $value) { ?>
	<div class="form-group form-group-sm field-group">
		<div class="col-sm-2">
			<?=$field?>
			<input type="hidden" name="fields[]" value="<?=$field?>">
		</div>
		<div class="col-sm-2">
			<input type="password" class="form-control" name="field_vals[]" value="<?=$value?>">
		</div>
	</div>
<? } ?>