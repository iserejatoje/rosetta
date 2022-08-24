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
							$('.table #item_'+data.blockid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #item_'+data.blockid+' a.visible .glyphicon')
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
			if (!confirm("Вы действительно хотите удалить блок?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<?=STPL::Fetch("admin/modules/blocks/pages", array(
	'pages' => $vars['pages']
))?>

</form>

<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_block" role="button">Добавить блок</a>
<br/><br/>
<form method="POST" name="blocksform">
	<input type="hidden" name="action" value="save_block" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="1%">#</th>
			<th width="10%">ID блока</th>
            <th width="10%">Название блока</th>
			<th width="5%">Порядок</th>
			<th width="1%"></th>
            <th width="1%"></th>
			<th></th>
		<tr>

		<? $i = 0; ?>
		<? foreach($vars['list'] as $item){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="item_<?=$item->ID?>">
			<td align="center"><?=$item->ID?></td>

			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_block&id=<?=$item->ID?>"><?=$item->nameid?></a>
			</td>

            <td>
                <a href="?section_id=<?=$vars['section_id']?>&action=edit_block&id=<?=$item->ID?>"><?=$item->name?></a>
            </td>

			<td align="center">
				<input type="text" name="Ord[<?=$item->ID?>]" value="<?=$item->Ord?>" class="form-control"/>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_block_toggle_visible&id=<?=$item->ID?>" class="visible btn btn-default btn-sm">
					<? if ($item->IsVisible === true) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=delete_block&id=<?=$item->ID?>" class="delete btn btn-default btn-sm">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
            <td></td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>

	<input type="submit" class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_block" role="button" value="Сохранить">
</form>