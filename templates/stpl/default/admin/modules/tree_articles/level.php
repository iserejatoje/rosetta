<ul class="tree-list<? if ($vars['first'] === true) { ?> first<? } ?>">
	<? foreach($vars['articles'] as $article){
		$cnt_childs = $article->GetCountChilds();
		$node = STreeMgr::GetNodeById($vars['section_id']);

		$url = "/".$node->Path."/".$article->GetURL();
	?>
	<li id="article-<?=$article->ID?>">
		<? if ($cnt_childs > 0) { ?>
		<div class="plusminus plus" id="plusminus-<?=$article->ID?>" onclick="get_childs(<?=$article->ID?>)"></div>
		<? } else { ?>
		<div class="plusminus"></div>
		<? } ?>
		<div class="tree-table-wrapper">
			<table class="tree-table-list" width="100%">
				<tr>
					<td width="90%">
						<? if ($article->Thumb['f'] != "") { ?>
						<img src="<?=$article->Thumb['f']?>" width="20px" style="float:left; margin:2px 5px 0 0;"/>
						<? } ?>
						<a href="?section_id=<?=$vars['section_id']?>&action=edit_article&id=<?=$article->ID?>">
							<?=$article->Title?> [<?=$article->ID?>]
						</a><br/><small style="color:#898989;"><?=$url?></small>
					</td>
					<td width="2%">
						<a href="?section_id=<?=$vars['section_id']?>&action=new_article&parent=<?=$article->ID?>">
							<img src="/resources/images/admin/add.png" title="Добавить"/>
						</a>
					</td>
					<td width="2%">
						<a href="?section_id=<?=$vars['section_id']?>&action=edit_article&id=<?=$article->ID?>">
							<img src="/resources/images/admin/edit.png" title="Редактировать"/>
						</a>
					</td>
					<td width="2%">
						<a href="<?=$url?>?preview=1" target="_blank">
							<img src="/resources/images/admin/view.png" title="Предпросмотр"/>
						</a>
					</td>
					<td width="2%">
						<a href="?section_id=<?=$vars['section_id']?>&action=ajax_article_toggle_visible&id=<?=$article->ID?>" class="visible" id="visible-<?=$article->ID?>">
							<? if ($article->IsVisible === true) { ?>
							<img src="/resources/images/admin/visibled.png" title="Скрыть"/>
							<? } else { ?>
							<img src="/resources/images/admin/hided.png" title="Показать"/>
							<? } ?>
						</a>
					</td>
					<td width="2%">
						<a href="?section_id=<?=$vars['section_id']?>&action=photos&articleid=<?=$article->ID?>"><img src="/resources/images/admin/photos.png" title="Фотографии к новости"/></a>
					</td>
					<td width="2%">
						<? if ($cnt_childs > 0) { ?>
						<img src="/resources/images/admin/stop.png" title="Нельзя удалить раздел, в котором есть подразделы"/>
						<? } else { ?>
						<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=ajax_delete_article&id=<?=$article->ID?>" class="delete">
							<img src="/resources/images/admin/delete.png" title="Удалить"/>
						</a>
						<? } ?>
					</td>
				</tr>
			</table>
		</div>

		<? if ($cnt_childs > 0) { ?>
		<div id="childs-<?=$article->ID?>"></div>
		<? } ?>
	</li>
	<? } ?>
</ul>