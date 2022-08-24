<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}
	.item-fields textarea {
		resize: none;
		overflow: hidden;
		height: 100px;
	}
</style>

<script>
	$(function(){
		var table = $('.item-fields > tbody');

		table.on('click', '.delete-field', function(){
			if($(this).closest('table').find('tr').length > 1) {
				$(this).closest('tr').remove();
			}
			return false;
		});

		table.on('click', '.move-up', function(){
			var current = $(this).closest('tr');
			var previos = current.prev();
			if(previos.get(0)){
				previos.before(current);
			}
			return false;
		});

		table.on('click', '.move-down', function(){
			var current = $(this).closest('tr');
			var next = current.next();
			if(next.get(0)){
				next.after(current);
			}
			return false;
		});

		table.on('change', '.field-type', function(){
			var $this = $(this);
			var type = $this.val();
			var options = $this.closest('tr').find('.field-options');

			if(optionsIsNeeded(type)){
				options.show();
			}else{
				options.hide();
			}
		});

		$('.add-field').on('click', function(e){
			e.preventDefault();

			var currentTable = $(this).closest('.panel').find('table');
			var fieldTemplate = currentTable.data('template');
			currentTable.find('> tbody').append(fieldTemplate);
		});

		$('form').on('submit', function(e) {
			var _form = $(this);
			var form = '';

			_form.find('.item-fields .hidden-fields').remove();

			_form.find('.item-fields').each(function(i, el) {
				var _table = $(el).closest('table');

				_table.find('tbody > tr').each(function(j, tr) {
					var _tr = $(tr);
					var data = {};
					_tr.find('.form-control').each(function(k, input) {
						var _input = $(input);
						data[_input.data('name')] = _input.val();
					});

						form += '<input type="hidden" class="hidden-fields" name="'+_table.data('attribute')+'[' + j + ']" value=\'' + JSON.stringify(data) + '\'>';
				});
			});
			$(form).appendTo(_form);
		});

		function optionsIsNeeded(type)
		{
			return type == 'select' || type == 'checkbox';
		}
	});
</script>

<?
	$fieldTypes = $vars['fieldTypes'];
	$fields = $vars['settings'];
	$fieldTemplate = $vars['template'];
?>

<div class="container">
<form method="post" enctype="multipart/form-data">
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">
<input type="hidden" name="action" value="<?= $vars['action'] ?>" />

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Настройки разделов каталога</h3>
		</div>

		<div class="panel-body">
			<div class="btn-group btn-group-sm" role="group">
				<a href="#" class="btn btn-primary btn-sm add-field">
					<span class="glyphicon glyphicon-plus font-12"></span>
					Добавить поле
				</a>
			</div>
		</div>

		<table class="table table-striped item-fields" data-attribute="Fields"<?if (!empty($fieldTemplate)) : ?> data-template="<?= htmlspecialchars($fieldTemplate) ?>"<? endif; ?>>
			<thead>
				<tr>
					<th>Name</th>
					<th>Title</th>
					<th>Type</th>
					<th>Options</th>
					<th width="150"></th>
				</tr>
			</thead>
		<tbody>
		<? foreach($fields as $field) { ?>
			<tr>
				<td><input type="text" data-name="name" class="form-control" value="<?= $field['name'] ?>"></td>
				<td><input type="text" data-name="title" class="form-control" value="<?= $field['title'] ?>"></td>
				<td>
					<select class="form-control field-type" data-name="type">
						<? foreach($fieldTypes as $k => $v) : ?>
							<option value="<?= $k ?>"<? if ($k == $field['type']) : ?> selected<? endif; ?>><?= $v ?></option>
						<? endforeach; ?>
					</select>
				</td>
				<td>
					<textarea class="form-control field-options" data-name="options" placeholder="Перечислите опции через запятую" <?= !$field['options'] ? 'style="display: none;"' : '' ?> ><?= is_array($field['options']) ? implode(',', $field['options']) : '' ?></textarea>
				</td>
				<td class="text-right">
					<div class="btn-group btn-group-sm" role="group">
						<a href="#" class="btn btn-default move-up" title="Move up"><span class="glyphicon glyphicon-arrow-up"></span></a>
						<a href="#" class="btn btn-default move-down" title="Move down"><span class="glyphicon glyphicon-arrow-down"></span></a>
						<a href="#" class="btn btn-default color-red delete-field" title="Delete item"><span class="glyphicon glyphicon-remove"></span></a>
					</div>
				</td>
			</tr>
		<? } ?>
		</tbody>
		</table>

	</div>

	<center><button type="submit" class="btn btn-success" name="save" value="1">Сохранить</button></center>
</form>
</div>