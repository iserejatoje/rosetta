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
							$('.table #item_'+data.clientid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #item_'+data.clientid+' a.visible .glyphicon')
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
			if (!confirm("Вы действительно хотите удалить клиента?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
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
</script>

<?=STPL::Fetch("admin/modules/clients/pages", array(
	'pages' => $vars['pages']
))?>

<form method="get" enctype="multipart/form-data" id="sortingform">
	<input type="hidden" name="action" value="clients" />
	<input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">	
</form>


<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_client" role="button">Добавить клиента</a>
<br/><br/>
<form method="POST" name="newsform">
	<input type="hidden" name="action" value="save_client" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="1%">#</th>
            <th width="10%">Фото</th>
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
			<th width="5%">
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
			<th width="1%"></th>
			<th width="1%"></th>
            <th></th>
		<tr>

		<? $i = 0; ?>
		<? foreach($vars['list'] as $item){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="item_<?=$item->ID?>">
			<td align="center"><?=$item->ID?></td>

			<td align="center">
                <? if($item->photosmall['f']) { ?>
                    <img src="<?=$item->photosmall['f']?>" alt="">
                <? } ?>
            </td>

            <td align="left">
                <a href="?section_id=<?=$vars['section_id']?>&action=edit_client&id=<?=$item->ID?>"><?=$item->title?></a>
            </td>

			<td align="center">
				<input type="text" name="Ord[<?=$item->ID?>]" value="<?=$item->Ord?>" class="form-control"/>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_client_toggle_visible&id=<?=$item->ID?>" class="visible btn btn-default btn-sm">
					<? if ($item->IsVisible === true) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=delete_client&id=<?=$item->ID?>" class="delete btn btn-default btn-sm">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>

            <td></td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>

	<input type="submit" class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_client" role="button" value="Сохранить">
</form>