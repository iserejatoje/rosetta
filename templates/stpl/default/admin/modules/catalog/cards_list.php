
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
							$('.table #card_'+data.cardid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #card_'+data.cardid+' a.visible .glyphicon')
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
			if (!confirm("Вы действительно хотите удалить открытку?"))
				return false;

			document.location.href = $(this).attr("href");
		});
	});
</script>

<p>
	<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_card">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить открытку
	</a>
</p>

<form method="POST" name="cardsform">
	<input type="hidden" name="action" value="save_lens" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="2%">#</th>
			<?/*
			<th width="10%">Фото</th>
			*/?>
			<th width="10%">Размер</th>
			<th width="10%">Цена</th>
			<th width="3%"></th>
			<th width="3%"></th>
			<th width="30%"></th>
		</tr>
		<? $i = 0; ?>
		<? foreach($vars['cards'] as $item){ ?>
		<tr id="card_<?=$item->id?>">

			<td align="center"><?=++$i?></td>
<?/*
			<td align="center">
				<img src="<?=$item->Icon['f']?>" alt="">
			</td>
*/?>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_card&id=<?=$item->ID?>">
					<?=$item->Name?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_card&id=<?=$item->ID?>">
					<?=$item->Price?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_card_toggle_visible&id=<?=$item->id?>" class="visible btn btn-default btn-sm">
					<? if ($item->isvisible == 1) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<a class="delete font-20 btn btn-default btn-sm" href="?section_id=<?=$vars['section_id']?>&action=delete_card&id=<?=$item->id?>">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>

			<td></td>
		</tr>
		<? } ?>
	</table>


	<br/><br/><br/>
	<div style="text-align:center">
		<button type="submit" class="btn btn-success btn-large"><span class="glyphicon glyphicon-save"></span> Сохранить</button>
	</div>
</form>
