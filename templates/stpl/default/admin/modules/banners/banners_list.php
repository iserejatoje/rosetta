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
							$('.table #banner_'+data.bannerid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #banner_'+data.bannerid+' a.visible .glyphicon')
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

<?=STPL::Fetch("admin/modules/banners/pages", array(
	'pages' => $vars['pages']
))?>

</form>

<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_banner" role="button">Добавить баннер</a>
<br/><br/>
<form method="POST" name="bannersform">
	<input type="hidden" name="action" value="save_banners" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="3%">#</th>
			<th width="1%">
				Тип
				<?/*
				<select name="type" onchange="document.forms.bannersform.submit();">
					<option value="">- Тип -</option>
					<? foreach(BannerMgr::$TYPES as $k => $v) { ?>
					<option value="<?=$k?>"<? if ($k == $vars['Type']) { ?> selected="selected"<? } ?>><?=$v?></option>
					<? } ?>
				</select>
				*/?>
			</th>
			<th width="5%">
				Место
				<?/*
				<select name="placeid" onchange="document.forms.bannersform.submit();">
					<option value="">- Баннерное место -</option>
					<? foreach($vars['places'] as $place) { ?>
					<option value="<?=$place->ID?>"<? if ($place->ID == $vars['PlaceID']) { ?> selected="selected"<? } ?>><?=$place->Name?> [<?=$place->Interval?>]</option>
					<? } ?>
				</select>
				*/?>
			</th>
			<th width="30%">Файл</th>
			<th width="5%">Редактировать</th>
			<th width="5%">Размер</th>
			<th width="5%">Порядок</th>
			<th width="5%">
				Видимость
				<?/*
				<select name="isvisible" onchange="document.forms.bannersform.submit();">
					<option value="-1"<? if ($vars['IsVisible'] == -1) { ?> selected="selected"<? } ?>>Все</option>
					<option value="0"<? if ($vars['IsVisible'] == 0) { ?> selected="selected"<? } ?>>Только скрытые</option>
					<option value="1"<? if ($vars['IsVisible'] == 1) { ?> selected="selected"<? } ?>>Только видимые</option>
				</select>
				*/?>
			</th>
			<th width="5%"></th>
		<tr>

		<? $i = 0; ?>
		<? foreach($vars['banners'] as $banner){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="banner_<?=$banner->ID?>">
			<td align="center"><?=$banner->ID?></td>
			<td align="center">
				<?=BannerMgr::$TYPES[$banner->Type]?>
			</td>
			<td align="center">
				<?=$banner->Place->Name?>/<?=$banner->Place->Interval?> [<?=$banner->Place->ID?>]
			</td>
			<td>
				<?=STPL::Fetch('admin/modules/banners/banner_file', array('banner'=> $banner))?>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_banner&id=<?=$banner->ID?>" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-pencil"></span>
				</a>
			</td>
			<td align="center">
				<?=$banner->Width?>x<?=$banner->Height?>
			</td>

			<td>
				<input type="text" name="orders[<?=$banner->ID?>]" value="<?=$banner->Ord?>" />
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_banner_toggle_visible&id=<?=$banner->ID?>" class="visible btn btn-default btn-sm">
					<? if ($banner->IsVisible === true) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=delete_banner&id=<?=$banner->ID?>" class="btn btn-default btn-sm">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>

	<input class="btn btn-success" type="submit" value="Сохранить" />
</form>