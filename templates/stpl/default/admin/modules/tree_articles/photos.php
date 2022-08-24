<p><a class="button-link" href="?section_id=<?=$vars['section_id']?>&action=new_photo&articleid=<?=$vars['article']->ID?>">Добавить фотографию</a></p>

<form name="feature_article_form" method="post" enctype="multipart/form-data">
	<input type="hidden" name="action" value="save_photos" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<input type="hidden" name="articleid" value="<?=$vars['article']->ID?>" />
	
	<table class="data-list">
		<tr>
			<th width="5%">#</th>
			<th width="15%">Фотография</th>
			<th width="55%">Название</th>
			<th width="5%">Видимость</th>
			<th width="5%">Позиция</th>
			<th width="5%"></th>
		<tr>
		<? $i = 0; ?>
		<? foreach($vars['photos'] as $photo){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>">
			<td align="center"><?=$photo->ID?></td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_photo&articleid=<?=$vars['article']->ID?>&id=<?=$photo->ID?>" class="visible">
					<img src="<?=$photo->PhotoSmall['f']?>" />
				</a>
			</td>		
			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_photo&articleid=<?=$vars['article']->ID?>&id=<?=$photo->ID?>" class="visible">
					<?=$photo->Name?>
				</a>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=photo_toggle_visible&articleid=<?=$vars['article']->ID?>&id=<?=$photo->ID?>">
					<? if ($photo->IsVisible === true) { ?>
					<img src="/resources/images/admin/visibled.png" title="Скрыть"/>
					<? } else { ?>
					<img src="/resources/images/admin/hided.png" title="Показать"/>
					<? } ?>
				</a>
			</td>
			<td align="center">
				<input class="ord-field" type="text" name="Ord[<?=$photo->ID?>]" value="<?=$photo->Ord?>"/>
			</td>
			<td align="center">
				<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_photo&articleid=<?=$vars['article']->ID?>&id=<?=$photo->ID?>" onclick="return confirm('Вы действительно хотите удалить фотографию?')"><img src="/resources/images/admin/delete.png" title="Удалить"/></a>
			</td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>
	
<br/><br/><br/>
		<div style="text-align:center">
		<input class="save-submit" type="submit" value="Сохранить"/>
	</div>
</form>
<?=STPL::Fetch("admin/modules/articles/pages", array(
		'pages' => $vars['pages']
	))?>
	