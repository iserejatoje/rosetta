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
							$('.table #item_'+data.shareid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #item_'+data.shareid+' a.visible .glyphicon')
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
			if (!confirm("Вы действительно хотите удалить товар?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<?=STPL::Fetch("admin/modules/shares/pages", array(
	'pages' => $vars['pages']
))?>

</form>

<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_share" role="button">Добавить акцию</a>
<br/><br/>
<form method="POST" name="sharesform">
	<input type="hidden" name="action" value="save_shares" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="1%">#</th>
			<th width="10%">Картинка акции</th>
			<th width="10%">Заголовок</th>
			<th width="50%">Текст акции (фрагмент)</th>
			<th width="3%">Порядок</th>
			<th width="1%"></th>
			<th width="1%"></th>
		<tr>

		<? $i = 0; ?>
		<? foreach($vars['shares'] as $item){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="item_<?=$item->ID?>">
			<td align="center"><?=$item->ID?></td>

			<td align="center">
				<? if($item->Thumb['f']) { ?>
					<img src="<?=$item->Thumb['f']?>" alt="" style="max-width: 150px; max-height:150px;"><br/>
					<small><?=$item->Thumb['w']?>x<?=$item->Thumb['h']?>px</small>
				<? } else { ?>
					<small>Нет изображения</small>
				<? } ?>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_share&id=<?=$item->ID?>"><?=$item->Title?></a>
			</td>

			<td align="left"><?=UString::Truncate(strip_tags($item->Text), 500)?></td>

			<td align="center">
				<input type="text" name="Ord[<?=$item->ID?>]" value="<?=$item->Ord?>" class="form-control"/>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_share_toggle_visible&id=<?=$item->ID?>" class="visible btn btn-default btn-sm">
					<? if ($item->IsVisible === true) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=delete_share&id=<?=$item->ID?>" class="delete btn btn-default btn-sm">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>

	<input type="submit" class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_share" role="button" value="Сохранить">
</form>