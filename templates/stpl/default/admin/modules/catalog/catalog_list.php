
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
							$('.table #category_'+data.categoryid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #category_'+data.categoryid+' a.visible .glyphicon')
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

	});
</script>

<? if(App::$User->IsInRole('e_adm_execute_cp') && App::$User->IsInRole('e_adm_execute_users')) { ?>
	<p>
		<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_category">
			<span class="glyphicon glyphicon-plus"></span>
			Добавить раздел
		</a>
	</p>
<? } ?>

<form method="POST" name="catalogform">
	<input type="hidden" name="action" value="save_catalog_sections" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="2%">#</th>
			<th width="40%">Название</th>
			<th width="15%">Имя ссылки</th>
			<th width="10%">Товары</th>
			<?/*
			<th width="10%">Порядок</th>
			*/?>
			<? if(App::$User->IsInRole('e_adm_execute_cp') && App::$User->IsInRole('e_adm_execute_users')) { ?>
				<th width="10%">Настройки для раздела</th>
				<?/*
				<th width="10%">Сортировка</th>
				*/?>
                <th width="15%">Дополнительно</th>
				<th width="15%"></th>
				<th width="10%"></th>
			<? } ?>
		</tr>
		<? $i = 0; ?>
		<? foreach($vars['catalog'] as $item){ ?>
		<tr id="category_<?=$item['id']?>">
			<td align="center"><?=++$i?></td>
			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_category&id=<?=$item['id']?>">
					<?=$item['name']?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=products&type_id=<?=$item['id']?>">
					<?=$item['url']?>
				</a>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=products&type_id=<?=$item['id']?>"><span class="glyphicon glyphicon-shopping-cart"></span> Товары</a>
			</td>

			<? if(App::$User->IsInRole('e_adm_execute_cp') && App::$User->IsInRole('e_adm_execute_users')) { ?>
				<td align="center">
					<input class="form-control" name="orders[<?=$item['id']?>]" value="<?=$item['ord']?>">
				</td>

				<? /*
				<td align="center">
					<a href="?section_id=<?=$vars['section_id']?>&action=section_settings&type_id=<?=$item['id']?>"><span class="glyphicon glyphicon-cog"></span> Настройки</a>
				</td>
				*/?>

                <td align="center">
                    <? if($item['kind'] == CatalogMgr::CK_WEDDING) { ?>
                        <a href="?section_id=<?=$vars['section_id']?>&action=sorting&type_id=<?=$item['id']?>"><span class="glyphicon glyphicon-cog"></span> Сортировка</a><br>
                        <a href="?section_id=<?=$vars['section_id']?>&action=edit_wedding_text&type_id=<?=$item['id']?>"><span class="glyphicon glyphicon-pencil"></span> Редактировать</a>
                    <? } ?>
                </td>

				<td align="center">
					<a href="?section_id=<?=$vars['section_id']?>&action=ajax_category_toggle_visible&id=<?=$item['id']?>" class="visible btn btn-default btn-sm">
						<? if ($item['isvisible'] == 1) { ?>
							<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
						<? } else { ?>
							<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
						<? } ?>
					</a>
				</td>

				<td align="center">
					<a class="delete font-20 btn btn-default btn-sm"" href="?section_id=<?=$vars['section_id']?>&action=delete_category&id=<?=$item['id']?>">
						<span class="glyphicon glyphicon-trash"></span>
					</a>
				</td>
			<? } ?>
		</tr>
		<? } ?>
	</table>


	<? if(App::$User->IsInRole('e_adm_execute_cp') && App::$User->IsInRole('e_adm_execute_users')) { ?>
		<br/><br/><br/>
		<div style="text-align:center">
			<button type="submit" class="btn btn-success btn-large"><span class="glyphicon glyphicon-save"></span> Сохранить</button>
		</div>
	<? } ?>
</form>
