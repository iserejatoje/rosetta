<table class="table">
	<? foreach($vars['fields'] as $field => $value) { ?>
		<tr>
			<td>
				<?=$field?>
				<input type="hidden" name="fields[]" value="<?=$field?>">
			</td>
			<td>
				<? if(isset(PaymentMgr::$params[$field])) { ?>
					<?if(PaymentMgr::$params[$field]['type'] === 'multiple') { ?>
						<select name="field_vals[<?=$field?>][]" class="form-control" multiple="multiple">
							<? foreach(PaymentMgr::$params[$field]['values'] as $k => $v) { ?>
								<option value="<?=$k?>" <?if(in_array($k, $value)){?>selected="selected"<?}?>><?=$v?></option>
							<? } ?>
					<? } else { ?>
						<select name="field_vals[<?=$field?>]" class="form-control">
							<? foreach(PaymentMgr::$params[$field]['values'] as $k => $v) { ?>
								<option value="<?=$k?>" <?if($k==$value){?>selected="selected"<?}?>><?=$v?></option>
							<? } ?>
					<? } ?>
						</select>
				<? } else { ?>
					<input type="text" class="form-control" name="field_vals[<?=$field?>]" value="<?=$value?>">
				<? } ?>
			</td>
		</tr>
	<? } ?>
</table>