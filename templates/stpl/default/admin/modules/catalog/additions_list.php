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
							$('.table #addition_'+data.additionid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #addition_'+data.additionid+' a.visible .glyphicon')
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

		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить доп. товар?"))
				return false;

			document.location.href = $(this).attr("href");
		});
	});
</script>

<p>
	<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_addition">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить доп.
	</a>
</p>

<form method="get" id="sortingform">
    <input type="hidden" name="action" value="additions"/>
    <input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">
</form>

<form method="POST" name="additionsform">
	<input type="hidden" name="action" value="save_additions" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
            <th width="2%">#</th>
			<th width="6%">
                <a href="javascript:;" data-field="article" class="sorted-link">
                    Артикул
                    <? if($vars['sorting']['field'] == 'article') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="10%">Фото</th>
			<th width="40%">
                <a href="javascript:;" data-field="name" data-dir="" class="sorted-link">
                    Название
                    <? if($vars['sorting']['field'] == 'name') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="10%">
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
			<th width="10%">
                <a href="javascript:;" data-field="isvisible" data-dir="" class="sorted-link">
                    Видимость
                    <? if($vars['sorting']['field'] == 'isvisible') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="10%"></th>
		</tr>
		<? $i = 0; ?>
		<? foreach($vars['additions'] as $item){ ?>
			<? $areaRefs = $item->GetAreaRefs($vars['section_id']); ?>
		<tr id="addition_<?=$item->id?>">
			<td align="center"><?=++$i?></td>

            <td align="center"><?=$item->article?></td>

			<td align="center"><img src="<?=$item->PhotoSmall['f']?>" alt="" style="width: 120px;"></td>

			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_addition&id=<?=$item->id?>">
					<?=$item->name?>
				</a>
			</td>

			<td align="center">
				<input class="form-control" name="orders[<?=$item->id?>]" value="<?=$areaRefs['Ord']?>">
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_addition_toggle_visible&id=<?=$item->id?>" class="visible btn btn-default btn-sm">
					<? if ($areaRefs['IsVisible'] == 1) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<a class="delete font-20 btn btn-default btn-sm" href="?section_id=<?=$vars['section_id']?>&action=delete_addition&id=<?=$item->id?>">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>

		</tr>
		<? } ?>
	</table>


	<br/><br/><br/>
	<div style="text-align:center">
		<button type="submit" class="btn btn-success btn-large"><span class="glyphicon glyphicon-save"></span> Сохранить</button>
	</div>
</form>
