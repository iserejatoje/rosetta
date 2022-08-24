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
						$('.data-list #article_'+data.articleid+' a.visible img').attr({
							src: '/resources/images/admin/visibled.png',
							title: 'Скрыть'
						});
					}
					else
					{
						$('.data-list #article_'+data.articleid+' a.visible img').attr({
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
						$('.data-list #article_'+data.articleid+' a.main img').attr({
							src: '/resources/images/admin/visibled.png',
							title: 'Скрыть'
						});
					}
					else
					{
						$('.data-list #article_'+data.articleid+' a.main img').attr({
							src: '/resources/images/admin/hided.png',
							title: 'Показать'
						});
					}
				}
			});
		});
		
		$('.data-list a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить новость?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){			$('.ord-field').val('0');		});
	});
</script>

<p><a class="button-link" href="?section_id=<?=$vars['section_id']?>&action=new_article">Добавить новость</a></p>

<form method="GET" name="articlesform">
<input type="hidden" name="action" value="articles" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
<table class="data-list">
	<tr>
		<th width="1%">#</th>
		<th width="14%">Дата</th>
		<th width="14%">Превью</th>
		<th width="15%">Заголовок</th>
		<th width="65%">Часть статьи</th>
		<th width="3%">Видимость</th>
		<th width="3%">На главной</th>
		<th width="3%">Удалить</th>
	<tr>
	<? $i = 0; ?>
	<? foreach($vars['articles'] as $article){ ?>
	<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="article_<?=$article->ID?>">
		<td align="center"><?=$article->ID?></td>
		<td align="center">
			<? if ($article->Date == 0) { ?>-<? } else { ?>
			<?=date("d.m.Y", $article->Date)?><br/><?=date("H:i", $article->Date)?>
			<? } ?>
		</td>
		<td align="center">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_article&id=<?=$article->ID?>">
				<img src="<?=$article->Thumb['f']?>"/>
			</a>
		</td>
		<td align="center">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_article&id=<?=$article->ID?>">
				<?=$article->Title?>
			</a>
		</td>
		<td>
			<?=UString::Truncate(strip_tags($article->Text), 200)?>
		</td>		
		<td align="center">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_article_toggle_visible&id=<?=$article->ID?>" class="visible">
				<? if ($article->IsVisible === true) { ?>
				<img src="/resources/images/admin/visibled.png" title="Скрыть"/>
				<? } else { ?>
				<img src="/resources/images/admin/hided.png" title="Показать"/>
				<? } ?>
			</a>
		</td>
		<td align="center">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_article_toggle_main&id=<?=$article->ID?>" class="main">
				<? if ($article->IsMain === true) { ?>
				<img src="/resources/images/admin/visibled.png" title="Скрыть"/>
				<? } else { ?>
				<img src="/resources/images/admin/hided.png" title="Показать"/>
				<? } ?>
			</a>
		</td>
		<td align="center">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_article&id=<?=$article->ID?>"><img src="/resources/images/admin/delete.png" title="Удалить"/></a>
		</td>
	</tr>
	<? $i++; ?>
	<? } ?>
</table>

<?=STPL::Fetch("admin/modules/articles/pages", array(
	'pages' => $vars['pages']
))?>

<br/><br/><br/>

</form>
