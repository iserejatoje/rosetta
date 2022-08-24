<script>

	$(document).ready(function(){
		$('.table a.default').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					if (data.default == 1)
					{
						$(".table a.default .glyphicon")
							.removeClass('glyphicon-ok')
							.addClass('glyphicon-remove');

						$(".table #city_"+data.cityid+" a.default .glyphicon")
							.removeClass('glyphicon-remove')
							.addClass('glyphicon-ok')
							.css({color: '#0f0'});
						}
					else
					{

						$(".table a.default .glyphicon")
						.removeClass('glyphicon-remove')
						.addClass('glyphicon-ok');

						$(".table #city_"+data.cityid+" a.default .glyphicon")
							.removeClass('glyphicon-ok')
							.addClass('glyphicon-remove')
							.css({color: '#f00'});
					}
				}
			});
		});

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
						$(".table #city_"+data.cityid+" a.visible .glyphicon")
							.removeClass('glyphicon-remove')
							.addClass('glyphicon-ok')
							.css({color: '#0f0'});
					}
					else
					{
						$(".table #city_"+data.cityid+" a.visible .glyphicon")
							.removeClass('glyphicon-ok')
							.addClass('glyphicon-remove')
							.css({color: '#f00'});
					}
				}
			});
		});

		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить город?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<p><a class="button-link" href="?section_id=<?=$vars['section_id']?>&action=new_city">Добавить город</a></p>

<form method="GET" name="citiesform">
<input type="hidden" name="action" value="cities" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

<table class="dsortable table table-bordered table-hover">
	<tr>
		<th width="1%">#</th>
		<th width="50%">Название</th>
		<th width="3%">Видимость</th>
		<th width="1%">По-умолч.</th>
		<th width="1%">Адреса</th>
		<th width="1%">Удалить</th>
	<tr>
	<? $i = 0; ?>
	<? foreach($vars['cities'] as $city){ ?>
	<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="city_<?=$city->ID?>">
		<td align="center" class="vert-align"><?=$city->ID?></td>
		<td class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_city&id=<?=$city->ID?>">
				<?=$city->Name?>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_city_toggle_visible&id=<?=$city->ID?>" class="visible">
				<? if ($city->IsVisible === true) { ?>
				<span class="glyphicon glyphicon-ok"></span>
				<? } else { ?>
				<span class="glyphicon glyphicon-remove"></span>
				<? } ?>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_city_toggle_default&id=<?=$city->ID?>" class="default">
				<? if ($city->IsDefault === true) { ?>
				<span class="glyphicon glyphicon-ok"></span>
				<? } else { ?>
				<span class="glyphicon glyphicon-remove"></span>
				<? } ?>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=city_address&id=<?=$city->ID?>">
				<span class="glyphicon glyphicon-map-marker" title="Адреса"></span>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_city&id=<?=$city->ID?>">
				<span class="glyphicon glyphicon-trash" title="Удалить"></span>
			</a>
		</td>
	</tr>
	<? $i++; ?>
	<? } ?>
</table>

	<?=STPL::Fetch("admin/modules/cities/pages", array(
		'pages' => $vars['pages']
	))?>

<br/><br/><br/>

</form>
