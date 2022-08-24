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
							$('.table #place_'+data.placeid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #place_'+data.placeid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-open')
							.removeClass('glyphicon-success')
							.addClass('glyphicon-eye-close')
							.addClass('glyphicon-danger');
					}
				}
			});
		});


		$('.data-list a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить баннерное место?"))
				return false;

			document.location.href = $(this).attr("href");
		});

	});
</script>


<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_place" role="button">Добавить баннерное место</a>
<br/><br/>
<form method="GET" name="bannersform">
	<input type="hidden" name="action" value="banners" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="1%">#</th>
			<th width="50%">
				Название
			</th>
			<th width="5%">
				Кол-во баннеров на месте
			</th>

			<th width="1%"></th>
			<th width="1%"></th>
		</tr>

		<? $i = 0; ?>
		<? foreach($vars['places'] as $place){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="place_<?=$place->ID?>">
			<td align="center"><?=$place->ID?></td>

			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_place&id=<?=$place->ID?>"><?=$place->Name?></a>
			</td>

			<td align="center">
				<?=$place->Banners?>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_place_toggle_visible&id=<?=$place->ID?>" class="visible btn btn-default btn-sm">
					<? if ($place->IsVisible === true) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<? if ($place->Banners == 0) { ?>
					<a href="?section_id=<?=$vars['section_id']?>&action=delete_place&id=<?=$place->ID?>" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				<? } else { ?>
					<span class="glyphicon glyphicon-ban-circle" title="Удалять место нельзя, к нему привязаны баннеры"></span>
				<? } ?>
			</td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>
</form>


<?=STPL::Fetch("admin/modules/banners/pages", array(
	'pages' => $vars['pages']
))?>

<br/><br/><br/>
