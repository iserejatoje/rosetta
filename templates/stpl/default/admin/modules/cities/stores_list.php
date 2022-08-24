<script>

	$(document).ready(function(){
		$(".sortable tbody" ).sortable({
			helper: function(e, tr)
			  {
			    var $originals = tr.children();
			    var $helper = tr.clone();
			    $helper.children().each(function(index)
			    {
			      // Set helper cell sizes to match the original sizes
			      $(this).width($originals.eq(index).width());
			    });
			    return $helper;
			  },
			connectWith: ".sortable tbody",
		});

		$(".sortable tbody").on("sortstop", function( event, ui ) {
			$(".sortable tbody tr").each(function(i, el) {
				var item = $(el);
				var index = i + 1;
				var pid = item.data('id');
				console.log(index, pid);

				$("#ord-"+pid).val(index);
			});
		});

		$('.table a.available').click(function(e){
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
						// $('.table #store_'+data.storeid+' a.available img').attr({
						// 	src: '/resources/images/admin/visibled.png',
						// 	title: 'Скрыть'
						// });
						$(".table #store_"+data.storeid+" a.available .glyphicon")
							.removeClass('glyphicon-remove')
							.addClass('glyphicon-ok')
							.css({color: '#0f0'});
					}
					else
					{
						$(".table #store_"+data.storeid+" a.available .glyphicon")
							.removeClass('glyphicon-ok')
							.addClass('glyphicon-remove')
							.css({color: '#f00'});
						// $('.table #store_'+data.storeid+' a.available img').attr({
						// 	src: '/resources/images/admin/hided.png',
						// 	title: 'Показать'
						// });
					}
				}
			});
		});

		$('.table a.haspickup').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					if (data.haspickup == 1)
					{
						$(".table #store_"+data.storeid+" a.haspickup .glyphicon")
							.removeClass('glyphicon-remove')
							.addClass('glyphicon-ok')
							.css({color: '#0f0'});
						// $('.table #store_'+data.storeid+' a.haspickup img').attr({
						// 	src: '/resources/images/admin/pickup_enabled.png',
						// 	title: 'Скрыть'
						// });
					}
					else
					{
						$(".table #store_"+data.storeid+" a.haspickup .glyphicon")
							.removeClass('glyphicon-ok')
							.addClass('glyphicon-remove')
							.css({color: '#f00'});
						// $('.table #store_'+data.storeid+' a.haspickup img').attr({
						// 	src: '/resources/images/admin/pickup_disabled.png',
						// 	title: 'Показать'
						// });
					}
				}
			});
		});

		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить район доставки?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<ol class="breadcrumb">
	<? foreach($vars['crumbs'] as $crumb) { ?>
  		<li><a href="<?=$crumb['url']?>"><?=$crumb['name']?></a></li>
  	<? } ?>
  <li class="active">Магазины (<?=$vars['city']->Name?>)</li>
</ol>

<p>
	<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=<?=$vars['action']?>&cityid=<?=$vars['cityid']?>">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить магазин
	</a>
</p>

<form method="POST" name="citiesform">
<input type="hidden" name="action" value="save_stores" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
<table class="sortable table table-bordered table-hover">
	<thead>
		<tr>
			<th width="1%">#</th>
			<th width="50%">Адрес</th>
			<th width="2%">Email</th>
            <th width="2%">Телефон</th>
			<th width="1%">Галерея</th>
			<th width="1%">Доступен</th>
			<th width="1%">Самовывоз</th>
			<th width="1%">Удалить</th>
		<tr>
	</thead>
	<tbody>
	<? $i = 0; ?>
	<? foreach($vars['stores'] as $item){ ?>
	<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="store_<?=$item->ID?>" data-id="<?=$item->ID?>">
		<td align="center" class="vert-align">
			<input type="text" name="Ord[<?=$item->ID?>]" value="<?=$item->Ord?>" style="width: 50px; text-align: center;" id="ord-<?=$item->ID?>"/>
		</td>
		<td class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_store&id=<?=$item->ID?>&cityid=<?=$item->CityID?>">
				<?=$item->Address?>
			</a>
		</td>
		<td class="vert-align"><?=$item->Email?></td>
		<td class="vert-align"><?=$item->Phone?></td>

        <td align="center">
            <a href="?section_id=<?=$vars['section_id']?>&action=store_photos&storeid=<?=$item->ID?>">
                <span class="glyphicon glyphicon-picture"></span>
            </a>
        </td>

		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_store_toggle_available&id=<?=$item->ID?>" class="available">
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
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_store_toggle_pickup&id=<?=$item->ID?>" class="haspickup">
				<? if ($item->HasPickup === true) { ?>
				<span class="glyphicon glyphicon-ok"></span>
				<?/*<img src="/resources/images/admin/visibled.png" title="Скрыть"/>*/?>
				<? } else { ?>
				<span class="glyphicon glyphicon-remove"></span>
				<?/*<img src="/resources/images/admin/hided.png" title="Показать"/>*/?>
				<? } ?>
			</a>
		</td>

		<td align="center" class="vert-align">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_store&id=<?=$item->ID?>&cityid=<?=$item->CityID?>">
				<?/*<img src="/resources/images/admin/delete.png" title="Удалить"/>*/?>
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<? $i++; ?>
	<? } ?>
	</tbody>
</table>


<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-save"></span>Сохранить</button>


</form>
