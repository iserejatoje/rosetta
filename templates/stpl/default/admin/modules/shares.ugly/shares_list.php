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
						$('.data-list #share_'+data.shareid+' a.visible img').attr({
							src: '/resources/images/admin/visibled.png',
							title: 'Скрыть'
						});
					}
					else
					{
						$('.data-list #share_'+data.shareid+' a.visible img').attr({
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
						$('.data-list #share_'+data.shareid+' a.main img').attr({
							src: '/resources/images/admin/visibled.png',
							title: 'Скрыть'
						});
					}
					else
					{
						$('.data-list #share_'+data.shareid+' a.main img').attr({
							src: '/resources/images/admin/hided.png',
							title: 'Показать'
						});
					}
				}
			});
		});

		$('.data-list a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить акцию?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<p><a class="button-link" href="?section_id=<?=$vars['section_id']?>&action=new_share">Добавить акцию</a></p>

<form method="POST" name="sharesform">
<input type="hidden" name="action" value="save_shares" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
<table class="data-list">
	<tr>
		<th width="1%">#</th>
		<th width="25%">Картинка акции</th>
		<th width="68%">Текст акции (фрагмент)</th>
		<th width="3%">Порядок</th>
		<th width="3%">Видимость</th>
		<th width="3%">Удалить</th>
	</tr>
	<? $i = 0; ?>
	<? foreach($vars['shares'] as $share){ ?>
	<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="share_<?=$share->ID?>">
		<td align="center"><?=$share->ID?></td>
		<td align="center">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_share&id=<?=$share->ID?>">
				<img src="<?=$share->Thumb['f']?>"/>
			</a>
		</td>
		<td>
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_share&id=<?=$share->ID?>">
				<?=UString::Truncate(strip_tags($share->Text), 200)?>
			</a>
		</td>
		<td align="center">
			<input class="ord-field" type="text" name="Ord[<?=$share->ID?>]" value="<?=$share->Ord?>"/>
		</td>
		<td align="center">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_share_toggle_visible&id=<?=$share->ID?>" class="visible">
				<? if ($share->IsVisible === true) { ?>
				<img src="/resources/images/admin/visibled.png" title="Скрыть"/>
				<? } else { ?>
				<img src="/resources/images/admin/hided.png" title="Показать"/>
				<? } ?>
			</a>
		</td>
		<td align="center">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_share&id=<?=$share->ID?>"><img src="/resources/images/admin/delete.png" title="Удалить"/></a>
		</td>
	</tr>
	<? $i++; ?>
	<? } ?>
</table>

<?=STPL::Fetch("admin/modules/shares/pages", array(
	'pages' => $vars['pages']
))?>

<br/><br/><br/>
<br/><br/><br/>

	<div style="text-align:center">
		<input class="save-submit" type="submit" value="Сохранить"/>
	</div>
</form>
