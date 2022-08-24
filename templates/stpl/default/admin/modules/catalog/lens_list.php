
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
							$('.table #len_'+data.lenid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #len_'+data.lenid+' a.visible .glyphicon')
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
			if (!confirm("Вы действительно хотите удалить доп. товар?"))
				return false;

			document.location.href = $(this).attr("href");
		});
	});
</script>


<?=STPL::Display('admin/modules/catalog/_product_tabs', $vars); ?>

<p>
	<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_productlen&productid=<?=$vars['product']->id?>">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить длину.
	</a>
</p>

<form method="POST" name="lensform">
	<input type="hidden" name="action" value="save_lens" />
	<input type="hidden" name="productid" value="<?=$vars['productid']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="2%">#</th>
			<th width="10%">Длина</th>
			<th width="10%">Компонент</th>
			<th width="10%">Порядок</th>
			<th width="3%"></th>
			<th width="3%"></th>
			<th width="30%"></th>
		</tr>
		<? $i = 0; ?>
		<? foreach($vars['lens'] as $item) {
			$price = 0;
			$member = $item->member;
			if($member !== null)
				$price = $member->GetPrice($vars['section_id']);
			?>
		<tr id="len_<?=$item->id?>">

			<td align="center"><?=++$i?></td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_productlen&id=<?=$item->id?>&productid=<?=$vars['productid']?>">
					<?=$item->Len?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_productlen&id=<?=$item->id?>&productid=<?=$vars['productid']?>">
					<? if($member) { ?>
						<?=$member->name?> [<?=$price?> руб.]
					<? } ?>
				</a>
			</td>

			<td align="center">
				<input class="form-control" name="orders[<?=$item->id?>]" value="<?=$item->ord?>">
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_productlen_toggle_visible&id=<?=$item->id?>" class="visible btn btn-default btn-sm">
					<? if ($item->isvisible == 1) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<a class="delete font-20 btn btn-default btn-sm" href="?section_id=<?=$vars['section_id']?>&action=delete_productlen&id=<?=$item->id?>&productid=<?=$vars['productid']?>">
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
