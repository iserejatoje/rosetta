<script>

	$(document).ready(function(){
		$('.data-list-table a.available').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					if (data.available == 1)
					{
						// $('.data-list-table #delivery_'+data.deliveryid+' a.available img').attr({
						// 	src: '/resources/images/admin/visibled.png',
						// 	title: 'Скрыть'
						// });
						$(".table #delivery_"+data.deliveryid+" a.available .glyphicon")
							.removeClass('glyphicon-remove')
							.addClass('glyphicon-ok')
							.css({color: '#0f0'});
					}
					else
					{
						$(".table #delivery_"+data.deliveryid+" a.available .glyphicon")
							.removeClass('glyphicon-ok')
							.addClass('glyphicon-remove')
							.css({color: '#f00'});
						// $('.data-list-table #delivery_'+data.deliveryid+' a.available img').attr({
						// 	src: '/resources/images/admin/hided.png',
						// 	title: 'Показать'
						// });
					}
				}
			});
		});

		$('.data-list-table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить город доставки?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<p>
	<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_delivery&cityid=<?=$vars['cityid']?>">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить город
	</a>
</p>

<form method="GET" name="citiesform">
<input type="hidden" name="action" value="delivery_list" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
<table class="data-list-table table table-bordered table-hover">
	<tr>
		<th width="1%">#</th>
		<th width="50%">Город</th>
		<th width="1%">Доступен</th>
		<th width="1%">Районы</th>
		<th width="1%">Магазины</th>
		<th width="1%">Удалить</th>
	<tr>
	<? $i = 0; ?>
	<? foreach($vars['delivery'] as $item){ ?>
	<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="delivery_<?=$item->ID?>">
		<td align="center vert-align"><?=$item->ID?></td>
		<td class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_delivery&id=<?=$item->ID?>">
				<?=$item->Name?>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_city_toggle_available&id=<?=$item->ID?>" class="available">
				<? if ($item->IsAvailable === true) { ?>
				<span class="glyphicon glyphicon-ok"></span>
				<?/*<img src="/resources/images/admin/visibled.png" title="Скрыть"/>*/?>
				<? } else { ?>
				<span class="glyphicon glyphicon-remove"></span>
				<?/*<img src="/resources/images/admin/hided.png" title="Показать"/>*/?>
				<? } ?>
			</a>
		</td>

		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=districts&deliveryid=<?=$item->ID?>">
				<?/*<img src="/resources/images/admin/delivery.png" title="Районы"/>*/?>
				<span class="glyphicon glyphicon-th" title="Районы доставки"></span>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=stores&deliveryid=<?=$item->ID?>">
				<?/*<img src="/resources/images/admin/store.png" title="Магазины"/>*/?>
				<span class="glyphicon glyphicon-home" title="Магазины"></span>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_delivery&id=<?=$item->ID?>&cityid=<?=$item->CityID?>">
				<?/*<img src="/resources/images/admin/delete.png" title="Удалить"/>*/?>
				<span class="glyphicon glyphicon-trash" title="Удалить"></span>
			</a>
		</td>
	</tr>
	<? $i++; ?>
	<? } ?>
</table>

<br/><br/><br/>

</form>
