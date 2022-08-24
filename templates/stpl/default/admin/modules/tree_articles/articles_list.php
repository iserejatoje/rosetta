<script>
	$(document).ready(function(){
		$('.tree_articles a.visible').live('click', function(e){
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
						$('.tree_articles a.visible#visible-'+data.articleid+' img').attr({
							src: '/resources/images/admin/visibled.png',
							title: 'Скрыть'
						});
					}
					else
					{
						$('.tree_articles a.visible#visible-'+data.articleid+' img').attr({
							src: '/resources/images/admin/hided.png',
							title: 'Показать'
						});
					}
				}
			});
		});
		
		$('.tree_articles a.delete').live('click', function(e){
			e.preventDefault();
			if (!confirm("Удалить статью?"))
				return;

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					var parent = $('#article-'+data.parent).parent();
					var parent_html = data.parent_html;
					$('#article-'+data.articleid).slideUp('slow', function(){
						$(this).remove();
						parent.replaceWith($(parent_html));
					});
				}
			});
		});
	});
	function get_childs(parent)
	{
		if ($('#childs-'+parent).html() != "")
		{
			if ($('#plusminus-'+parent).hasClass('minus'))
			{
				$('#plusminus-'+parent).removeClass('minus').addClass('plus');
				$('#childs-'+parent).hide();
			}
			else
			{
				$('#plusminus-'+parent).removeClass('plus').addClass('minus');
				$('#childs-'+parent).show();
			}
			return;
		}
		$.ajax({
			url: ".",
			type: "GET",
			dataType: "json",
			data: {
				section_id: <?=$vars['section_id']?>,
				action: 'childs_articles',
				parent: parent
			},
			success: function(data){
				if (data.status != 'ok')
					return;
				$('#childs-'+parent).html(data.html);
				
				$('#plusminus-'+parent).removeClass('plus').addClass('minus');
			}
		});
	}
</script>
<style>
	.plusminus {
		float: left;
		width: 13px;
		height: 13px;
		margin-top: 11px;
		cursor: pointer;
	}
	
	.plusminus.plus {
		background: url(/resources/images/admin/plus.png);
	}
	.plusminus.minus {
		background: url(/resources/images/admin/minus.png);
	}
</style>
<p><a class="button-link" href="?section_id=<?=$vars['section_id']?>&action=new_article">Добавить статью</a></p>

<form method="GET" name="articlesform">
<input type="hidden" name="action" value="articles" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	

<div style="padding-right:20px;" class="tree_articles">
	<table class="tree-table-list" width="100%">
		<tr>
			<td align="left" width="90%"><b>Название</b></td>
			<td width="2%"></td>
			<td width="2%"></td>
			<td width="2%"></td>
			<td width="2%"></td>
			<td width="2%"></td>
		</tr>
	</table>
<?=STPL::Fetch('admin/modules/tree_articles/level', array('articles' => $vars['articles'], 'section_id' => $vars['section_id'], 'first' => true))?>
</div>

</form>
