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
							$('.table #item_'+data.groupid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #item_'+data.groupid+' a.visible .glyphicon')
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
			if (!confirm("Вы действительно хотите удалить галлерею?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<?=STPL::Fetch("admin/modules/osgallery/pages", array(
	'pages' => $vars['pages']
))?>

</form>

<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_group" role="button">Добавить галерею</a>
<br/><br/>
<form method="POST" name="groupsform">
	<input type="hidden" name="action" value="save_groups" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="1%">#</th>
			<th width="5%">Фото</th>
			<th width="50%">Название</th>
			<th width="3%">Порядок</th>
			<th width="1%">Фотографии</th>
			<th width="1%"></th>
			<th width="1%"></th>
		<tr>

		<? $i = 0; ?>
		<? foreach($vars['list'] as $item){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="item_<?=$item->ID?>">
			<td align="center"><?=$item->ID?></td>

			<td align="center">
				<img src="<?=$item->Thumb['f']?>"  style="width: 200px" alt="">
			</td>

			<td align="left">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_group&id=<?=$item->ID?>"><?=$item->Name?></a>
			</td>

			<td align="center">
				<input type="text" name="Ord[<?=$item->ID?>]" value="<?=$item->Ord?>" class="form-control"/>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=group_photos&groupid=<?=$item->id?>" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-list-alt"></span>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_group_toggle_visible&id=<?=$item->ID?>" class="visible btn btn-default btn-sm">
					<? if ($item->IsVisible === true) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=delete_group&id=<?=$item->ID?>" class="delete btn btn-default btn-sm">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>

	<input type="submit" class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_group" role="button" value="Сохранить">
</form>