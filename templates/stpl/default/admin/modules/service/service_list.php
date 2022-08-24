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
							$('.table #item_'+data.serviceid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #item_'+data.serviceid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-open')
							.removeClass('glyphicon-success')
							.addClass('glyphicon-eye-close')
							.addClass('glyphicon-danger');
					}
				}
			});
		});


		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить услугу?"))
				return false;

			document.location.href = $(this).attr("href");
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

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<form method="get" enctype="multipart/form-data" id="sortingform">
    <input type="hidden" name="action" value="services" />
    <input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">
</form>


<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_service" role="button">Добавить услугу</a>
<br/><br/>
<form method="POST" name="servicesform">
	<input type="hidden" name="action" value="save_services" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="1%">#</th>
			<th width="50%">
                <a href="javascript:;" data-field="title" data-dir="" class="sorted-link">
                    Название
                    <? if($vars['sorting']['field'] == 'title') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="5%">Галереи</th>
			<th width="5%">Фильтры</th>
			<th width="5%">
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
			<th width="5%"></th>
		<tr>

		<? $i = 0; ?>
		<? foreach($vars['list'] as $item){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="item_<?=$item->ID?>">
			<td align="center"><?=$item->ID?></td>

			<td align="left">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_service&id=<?=$item->ID?>"><?=$item->title?></a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=service_groups&serviceid=<?=$item->id?>" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-list-alt"></span>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=filters&serviceid=<?=$item->id?>" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-list"></span>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_service_toggle_visible&id=<?=$item->id?>" class="visible btn btn-default btn-sm">
					<? if ($item->IsVisible === true) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=delete_service&id=<?=$item->id?>" class="delete btn btn-default btn-sm">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>

	<input type="submit" class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_service" role="button" value="Сохранить">
</form>