<?

$fieldTypes = $vars['fieldTypes'];
$options = '';
foreach($fieldTypes as $k => $v) {
	$options .= '<option value="'.$k.'"">'.$v.'</option>';
}
 ?>

<tr>
	<td><input type="text" class="form-control" data-name="name" value="<?= $field['Name'] ?>"></td>
	<td><input type="text" class="form-control" data-name="title" value="<?= $field['Title'] ?>"></td>
	<td>
		<select class="form-control field-type" data-name="type"><?= str_replace("\n", "", $options) ?></select>
	</td>
	<td><textarea class="form-control field-options" data-name="options" placeholder="Перечислите опции через запятую" style="display: none;"></textarea></td>
	<td class="text-right">
		<div class="btn-group btn-group-sm" role="group">
			<a href="#" class="btn btn-default move-up" title="Move up"><span class="glyphicon glyphicon-arrow-up"></span></a>
			<a href="#" class="btn btn-default move-down" title="Move down"><span class="glyphicon glyphicon-arrow-down"></span></a>
			<a href="#" class="btn btn-default color-red delete-field" title="Delete item"><span class="glyphicon glyphicon-remove"></span></a>
		</div>
	</td>
</tr>