{if in_array($CURRENT_ENV.site.domain, array("72.ru","63.ru","161.ru","ufa1.ru","116.ru","v1.ru","45.ru","29.ru","93.ru","kbs.ru","76.ru","48.ru","26.ru","86.ru","89.ru","164.ru","56.ru","mgorsk.ru","ekat.ru","62.ru","tolyatty.ru","sterlitamak1.ru","51.ru","sochi1.ru","178.ru","38.ru","70.ru","42.ru","71.ru","43.ru","35.ru","omsk1.ru","53.ru","75.ru","14.ru","68.ru","provoronezh.ru","60.ru","154.ru")) && !in_array($CURRENT_ENV.section, array('newsline_fin','tech','skills','news_fin','newscomp_fin','fin_analytic','predict','newsline_auto','news_auto','autostop','pdd','accident','instructor','photoreport','autostory','newsline_dom','news_dom','articles','hints','expert','design','weekfilm','wedding','starspeak','travel','inspect'))}
	{banner_v2 id="1479"}<br/>
{/if}

{capture name=pageslink}
	{if $res.pageslink.back!="" }<a href="{$res.pageslink.back}">&lt;&lt;</a>{/if}{
	foreach from=$res.pageslink.btn item=l}
		{if !$l.active
			}&nbsp;<span class="pageslink"> <a href="{$l.link}">{$l.text}</a> </span>{
		else
			}&nbsp;<span class="pageslink_active"> {$l.text} </span>{
		/if}
	{/foreach
	}{if $res.pageslink.next!="" }&nbsp;<a href="{$res.pageslink.next}">&gt;&gt;</a>{/if}
{/capture}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td>
			{if sizeof($res.list)}
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			{foreach from=$res.list item=l key=i}
			{if $smarty.foreach.atr.iteration != 1}
				<tr>
					<td><img src="/_img/x.gif" width="1" height="15" border="0" alt="" /></td>
				</tr>
			{/if}
				<tr>
					<td>
						{if is_array($l.Tags) && sizeof($l.Tags)}
						<div class="tag-item-list">
							<strong>Метки: </strong>
							{foreach from=$l.Tags item=tag name=tags}
								<a href="/tags/{$tag.Name|urlencode}/">{$tag.Name}</a>{if !$smarty.foreach.tags.last}, {/if}
							{/foreach}
						</div>
						{/if}
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td>
									<span class="title">{if date('Ymd') != date('Ymd', $l.Date)}{$l.Date|date_format:"%e.%m.%Y"}{/if} {$l.Date|date_format:"%H:%M"}</span>
									<span class="title2" {if $l.isMarked>0}style="color:red;"{/if}><a name="{$l.NewsID}"></a>{$l.Title}</span>{if $l.AddMaterial == 1} <img src="/_img/modules/news/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">{/if}
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td><img src="/_img/x.gif" width="1" height="3" border="0"></td>
				</tr>
				<tr>
					<td>
			{if !$res.hideLinks}
				{$l.Text}
			{else}
				{$l.Text|screen_href|mailto_crypt}
			{/if}
					</td>
				</tr>
	
				{if $l.AddMaterial == 1}
				<tr>
					<td class="tip"><br/><a href="/{$CURRENT_ENV.section}/{$l.NewsID}.html#gallery">Смотреть фото</a></td>
				</tr>
				{/if}
	
				{if $l.AuthorName}
				<tr>
					<td align="right"><span class="txt_color1"><b>{if $l.AuthorEmail }<a href="mailto:{$l.AuthorEmail}">{$l.AuthorName}</a>{else}{$l.AuthorName}{/if},</b> <i>специально для {$CURRENT_ENV.site.domain|ucfirst}</i></span>
					{if $l.isAdvert} <img src="/_img/design/common/rr.gif" width="11" height="11" alt="На правах рекламы" title="На правах рекламы" border="0" />{/if}
					</td>
				</tr>
				{/if}
				
				{if $l.PhotographerName}
				<tr>
					<td align="right"><span class="txt_color1">{$l.PhotographerName}</span></td>
				</tr>
				{/if}
	
				<tr>
					<td align="right"><noindex><a class="descr" href="/{$CURRENT_ENV.section}/{$l.NewsID}.html">постоянный адрес новости</a></noindex></td>
				</tr>
				
				{if $l.isComments && empty($l.Comment)}
				<tr>
					<td><br/><a class="descr" href="/{$CURRENT_ENV.section}/{$l.NewsID}.html#comments">Комментировать</a></td>
				</tr>
				{elseif !empty($l.Comment)}
				<tr>
					<td align="left" style="padding-bottom:2px" class="small">
						<br/><font color="#F78729"><b>{if $l.Comment.UserID && $l.Comment.User.Name}{$l.Comment.User.Name|truncate:20:"...":false}{else}{$l.Comment.Name|truncate:20:"...":false}{/if}:</b></font> {$l.Comment.Text|truncate:80:"...":false}
						<a href='/{$CURRENT_ENV.section}/{$l.NewsID}.html#comment{$l.Comment.CommentID}'><small>&gt;&gt;</small></a>
					</td>
				</tr>
				{/if}
	
				<tr>
					<td><br /></td>
				</tr>
			{/foreach}
			</table>
			{else}
				<div align="center">По запрошенной Вами дате записи не найдены<br />
				<a href="/{$CURRENT_ENV.section}/">Последние статьи</a></div>
			{/if}
		</td>
	</tr>
	{if $smarty.capture.pageslink!="" }
	<tr>
		<td height="10px"></td>
	</tr>
	<tr>
		<td align="right">{$smarty.capture.pageslink}</td>
	</tr>
	{/if}
	
	<tr>
		<td height="10px"><font style="font-size:8px;color:#ffffff;">{$smarty.now|date_format:"%Y-%m-%d %T"}</font></td>
	</tr>
</table>