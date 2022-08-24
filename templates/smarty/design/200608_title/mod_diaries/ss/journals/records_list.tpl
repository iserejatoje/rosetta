{capture name=pageslink}
{if count($res.pageslink.btn)>0}
<span class="pageslink">Страницы:
	{if $res.pageslink.back!="" }<a href="{$page.list.pageslink.back}" style="text-decoration:none;">&larr;</a>&nbsp;{/if}
	{foreach from=$res.pageslink.btn item=l}
		{if !$l.active}
			<a href="{$l.link}">{$l.text}</a>&nbsp;
		{else}
			<span class="pageslink_active">{$l.text}</span>&nbsp;
		{/if}
	{/foreach}
	{if $res.pageslink.next!="" }<a href="{$page.list.pageslink.next}" style="text-decoration:none;">&rarr;</a>{/if}
</span>
{/if}
{/capture}

{if is_array($res.list) && sizeof($res.list)}
	<table width=100% cellpadding=3 cellspacing=1 border=0 class="table2">
		{foreach from=$res.list item=l}
		{capture name=today}{$l.date|simply_date}{/capture}
		<tr>
			<td class="block_title2">
				<a name="r{$l.id}"></a>
				<b>{$l.date|dayofweek:1}, {if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$l.date|date_format:"%e"} {$l.date|date_format:"%m"|month_to_string:2} {$l.date|date_format:"%Y"}{/if}</b> &nbsp;&nbsp;&nbsp;{$l.date|date_format:"%H:%M"}
			</td>
		</tr>
		<tr>
			<td bgcolor=#F5F9FA>
			{if $l.name}
				<font class=sin>{$l.name|escape}</font><br><img src="/_img/x.gif" height=5 border=0><br>
			{/if}
			{$l.text|nl2br|screen_href|mailto_crypt}<br/><img src="/_img/x.gif" height=5 border=0><br/>
			</td>
		</tr>

		{if count($l.attach)>0}
		<tr>
			<td bgcolor=#F5F9FA align="left">
				<table width=100% cellpadding=2 cellspacing=0 border=0>
					<tr>
						{foreach from=$l.attach item=lat key=k}
							{if !$l.hideimages}
								{if $lat.prop == "img"}
									<img src="{$lat.url}" width="{$lat.w}" height="{$lat.h}" border="0" alt="">
								{else}
									<a target="_blank" href="{$CONFIG.files.get.imgzoom.string}?img={$lat.original.url}"
									onclick="javascript:ImgZoom('{$CONFIG.files.get.imgzoom.string}?img={$lat.original.url}','imgr{$l.id}_{$k}',{$lat.original.w+20},{$lat.original.h+40}); return false;"><img src="{$lat.url}" width="{$lat.w}" height="{$lat.h}" border="0" alt="Кликни для увеличения"></a>
								{/if}
							{else}Аттач{$k}{/if}
						{/foreach}
					</tr>
				</table>
			</td>
		</tr>
		{/if}

		{if !$l.nocomment}
			<tr>
				<td bgcolor=#F5F9FA align="left">
				{if $l.cnt_comment > 0}
					<a href="{$CONFIG.files.get.journals_comment.string}?id={$l.uid}&rid={$l.id}" class="text11">Комментарии [<b>{$l.cnt_comment}</b>]</a>
				{else}
					<a href="{$CONFIG.files.get.journals_comment.string}?id={$l.uid}&rid={$l.id}#addcomment" class="text11">Комментировать</a>
				{/if}
				</td>
			</tr>
		{/if}

		{if $USER->ID==$smarty.get.id}
<tr><td bgcolor=#F5F9FA align="right" nowrap>
	<a href="{$CONFIG.files.get.journals_record_edit.string}?id={$l.uid}&rid={$l.id}{if $smarty.get.p}&p={$smarty.get.p}{/if}" class="text11">Редактировать</a>
	&nbsp;&nbsp;&nbsp;
	<a href="{$CONFIG.files.get.journals_record_del.string}?id={$l.uid}&rid={$l.id}{if $smarty.get.p}&p={$smarty.get.p}{/if}" class="text11">Удалить</a>
     </td>
</tr>
{/if}
 <tr><td><img src="/_img/x.gif" width=0 height=5 border=0></td></tr>
{/foreach}
 {if $smarty.capture.pageslink!="" }
 <tr align="center">
	<td>
	{$smarty.capture.pageslink}
	</td>
 </tr>
 {/if}
</table>
{else}<br/><br/><br/>
	<center>Нет записей.</center>
{/if}
