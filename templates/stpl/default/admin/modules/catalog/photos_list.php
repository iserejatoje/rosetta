<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.ord-field {
		text-align: center;
	}
	a .glyphicon-success {
		color: #5cb85c !important;
	}
	a .glyphicon-danger {
		color: #d9534f !important;
	}
	.product-name {
		font-size: 16px;
	}
</style>

<script>

	$(document).ready(function(){
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
							$('.table #photo_'+data.photoid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #photo_'+data.photoid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-open')
							.removeClass('glyphicon-success')
							.addClass('glyphicon-eye-close')
							.addClass('glyphicon-danger');
					}
				}
			});
		});

        $('.sorted-link').click(function() {
            var sort_field = $(this).data('field');
            var sort_dir = $(this).find('.glyphicon').data('dir');

            if(sort_dir == 'desc' || sort_dir == '')
                var dir = 'asc';
            else
                var dir = 'desc'

            $("#sorting-field").val(sort_field);
            $("#sorting-dir").val(dir);
            $("#sortingform").submit();
        });
	});

	function checkaction()
	{
		obj = document.getElementById("action");
		if(obj.options[obj.selectedIndex].value=='')
			return false;
		return true;
	 }
</script>

<? if (UserError::GetErrorByIndex('global') != '') { ?>
	<div style="text-align: center; color:red;"><?= UserError::GetErrorByIndex('global') ?></div>
<? } else { ?>

<? if ($vars['form']['ProductID'] > 0) { ?>
	<?= STPL::Display('admin/modules/catalog/_product_tabs', $vars); ?>
<? } ?>

	<p>
	<a href="?section_id=<?=$vars['section_id']?>&action=new_photo&productid=<?= $vars['product']->ID ?>" class="btn btn-primary btn-sm">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить фото
	</a></p>

<form method="get" id="sortingform">
    <input type="hidden" name="action" value="photos"/>
    <input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">
    <input type="hidden" name="type_id" value="<?=$vars['form']['TypeID']?>" />
    <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
    <input type="hidden" name="id" value="<?=$vars['product']->id?>" />
</form>

<form method="post" onsubmit="return checkaction();">
	<input type="hidden" name="action" value="<?=$vars['action'] ?>" />
	<input type="hidden" name="type_id" value="<?=$vars['form']['TypeID']?>" />
    <input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="10%">Фото</th>
			<th width="70%">Название</th>
			<th width="6%">Видимость</th>
			<th width="7%">
                 <a href="javascript:;" data-field="ord" data-dir="" class="sorted-link">
                    Порядок
                    <? if($vars['sorting']['field'] == 'ord') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="1"></th>
		</tr>

		<? if (is_array($vars['list']) && sizeof($vars['list']) > 0) { ?>
			<? foreach ($vars['list'] as $l) { ?>
			<tr id="photo_<?= $l->ID ?>">
				<td align="center">
					<? if ($l->Photo !== null) { ?>
						<a href="?section_id=<?=$vars['section_id']?>&action=edit_photo&type_id=<?= $vars['form']['TypeID'] ?>&productid=<?= $vars['form']['ProductID'] ?>&photoid=<?= $l->ID ?>">
							<img src="<?= $l->Photo['f'] ?>" style="border:none; height: 100px;"/>
						</a>
					<? } ?>
				</td>

				<td>
					<a href="?section_id=<?=$vars['section_id']?>&action=edit_photo&type_id=<?= $vars['form']['TypeID'] ?>&productid=<?= $vars['form']['ProductID'] ?>&photoid=<?= $l->ID ?>"><? if ($l->Name) { ?><?= $l->Name ?><? } else { ?>н/з<? } ?></a>
				</td>

				<td align="center">
					<a href="?section_id=<?=$vars['section_id']?>&action=toggle_photo_visible&type_id=<?= $vars['form']['TypeID'] ?>&id=<?= $l->ID ?>" class="visible btn btn-default btn-sm"><? if ($l->IsVisible==1) { ?><span class="glyphicon glyphicon-eye-open glyphicon-success"></span><? } else { ?><span class="glyphicon glyphicon-eye-close glyphicon-danger"></span><? } ?></a>
				</td>
				<td align="center">
					<input type="text" name="ord[<?= $l->ID ?>]" value="<?= $l->Ord ?>" class="form-control" style="width:50px;text-align:center">
				</td>
				<td>
					<input type="checkbox" name="ids_action[]" value="<?= $l->ID ?>"/>
				</td>
			</tr>
			<? } ?>
		<? } ?>

	</table><br />

	<div align="right"><nobr>
		<select name="action" id="action" class="form-control" style="max-width: 200px; display: inline-block;">
			<option value="photos_update">Обновить порядок фотографии</option>
			<option value="photos_delete">Удалить фотографии</option>
		</select>
		<input type="submit" value="OK" class="btn btn-primary btn-sm">
		</nobr>
	</div>
</form>

<? } ?>

