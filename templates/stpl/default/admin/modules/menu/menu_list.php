<script>

	$(document).ready(function(){
		$('.data-list a.visible').click(function(e){
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
						$('.data-list #menu_'+data.menuid+' a.visible img').attr({
							src: '/resources/images/admin/visibled.png',
							title: 'Скрыть'
						});
					}
					else
					{
						$('.data-list #menu_'+data.menuid+' a.visible img').attr({
							src: '/resources/images/admin/hided.png',
							title: 'Показать'
						});
					}
				}
			});
		});

		$('.data-list a.main').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					if (data.main == 1)
					{
						$('.data-list #menu_'+data.menuid+' a.main img').attr({
							src: '/resources/images/admin/visibled.png',
							title: 'Скрыть'
						});
					}
					else
					{
						$('.data-list #menu_'+data.menuid+' a.main img').attr({
							src: '/resources/images/admin/hided.png',
							title: 'Показать'
						});
					}
				}
			});
		});

		$('.data-list a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить пункт меню?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>
<p><a class="button-link" href="?section_id=<?=$vars['section_id']?>&action=new_menu&parent_id=<?=$vars['parent_id']?>">Добавить пункт меню</a></p>

<form method="get" enctype="multipart/form-data">
	<input type="hidden" name="action" value="menu" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="parent_id" value="<?=$vars['parent_id']?>" />
	<input type="hidden" name="page" value="<?=$vars['page']?>" />
	<table>
		<tr>
			<td>
				<select name="isvisible">
					<option value="-1"<? if ($vars['isvisible'] == -1) { ?> selected="selected"<? } ?>>Показывать все</option>	
					<option value="1"<? if ($vars['isvisible'] == 1) { ?> selected="selected"<? } ?>>Только видимые</option>
					<option value="0"<? if ($vars['isvisible'] == 0) { ?> selected="selected"<? } ?>>Только скрытые</option>
				</select>
			</td>
			<td>
				<input type="submit" value="фильтровать"/>
			</td>
		</tr>
	</table>
</form>

<form method="POST" name="menuform">
	<input type="hidden" name="action" value="save_menu_items" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="parent_id" value="<?=$vars['parent_id']?>" />
	<table class="data-list">
		<tr>
			<th width="1%">#</th>
			<th width="30%">Название</th>
			<th width="30%">Ссылка</th>
			<th width="3%">Видимость</th>
			<th width="10%">Порядок</th>
			<th width="20%">Подменю</th>
			<th width="3%">Удалить</th>
		</tr>
		<? $i = 0; ?>
		<? foreach($vars['menu'] as $item){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="menu_<?=$item->ID?>">
			<td align="center"><?=$item->ID?></td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_menu&id=<?=$item->ID?>">
					<h3><?=$item->Name?></h3>
				</a>
			</td>
			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_menu&id=<?=$item->ID?>">
					<?=UString::Truncate(strip_tags($item->Link), 200)?>
				</a>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_menu_toggle_visible&id=<?=$item->ID?>" class="visible">
					<? if ($item->IsVisible === true) { ?>
						<img src="/resources/images/admin/visibled.png" title="Скрыть"/>
					<? } else { ?>
						<img src="/resources/images/admin/hided.png" title="Показать"/>
					<? } ?>
				</a>
			</td>
			<td align="center">
				<input class="ord-field" type="text" name="Ord[<?=$item->ID?>]" value="<?=$item->Ord?>"/>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=menu&parent_id=<?=$item->ID?>"><img src="/resources/images/admin/subshares.png" title="Подменю"/></a>
			</td>
			<td align="center">
				<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_menu&id=<?=$item->ID?>"><img src="/resources/images/admin/delete.png" title="Удалить"/></a>
			</td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>

	<?=STPL::Fetch("admin/modules/menu/pages", array(
		'pages' => $vars['pages']
	))?>

	<br/><br/><br/>
	<div style="text-align:center">
		<input class="save-submit" type="submit" value="Сохранить"/>
	</div>
</form>
