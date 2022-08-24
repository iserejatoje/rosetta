{if $smarty.get.debug > 10}
{debug}
{/if}
{include file="`$TEMPLATE.uheader`"}
<table cellpadding=5 cellspacing=1 border=0 width=100%>
	<tr><td><b>Папки</b></td><td><b>Контактов</b></td><td><b>Сообщений</b></td></tr>
{foreach from=$res.folders item=l key=k}
	<tr bgcolor="#{if $res.fid == $k}C9F2EE{else}F5F5F5{/if}">
	<td width=70%><img border=0 src="/img/love/ic{$l.folder}.gif"> <a href="/{$ENV.section}/folder/{$k}.html">{$l.name}</a> {*if $l.folder==3}<a class="lit1" href="/{$ENV.section}/emptymsg.html">очистить</a>{/if*}</td>
	<td align=center>{$l.contacts}</td><td align=center>{$l.messages}</td>
	</tr>
{/foreach}
</table><br>
<table cellpadding=0 cellspacing=0 border=0 width=100%>
	<tr><td><b><font color="#444444">{$res.folders[$res.fid].name}: {$res.folders[$res.fid].contacts} {word_for_number number=$res.folders[$res.fid].contacts first="контакт" second="контакта" third="контактов"} (Всего новых сообщений: {$res.allnew})</font></b></td>
	<td align=right nowrap>
		{if $res.time=="all"}Все{else}<a href="/{$SITE_SECTION}/folder/{$res.fid}.html?time=all">Все</a>{/if}&nbsp;|&nbsp;
		{if $res.time=="online"}Кто на сайте{else}<a href="/{$SITE_SECTION}/folder/{$res.fid}.html?time=online">Кто на сайте</a>{/if}
	</td></tr>
</table><br>
<table cellpadding=3 cellspacing=1 border=0 width=100%>
	<form method="post" action="move_cid.html">
	<input type="hidden" name="fid" value="{$res.fid}">
	<tr><td colspan=3><b>Контакты</b></td><td nowrap align=center><b>Новых</b></td><td align=center nowrap><b>Всего</b></td></tr>
{foreach from=$res.contacts item=l}
	<tr bgcolor="{cycle values="#F0F0F0,#F9F9F9"}"><td><input type="checkbox" name="contacts[]" value="{$l.cid}"></td>
	<td width=55>
	{if !empty($l.image)}
		<a href="/{$SITE_SECTION}/user/{$l.uid}"><img vspace=5 hspace=5 src="{$l.image}" style="border: #2297C6 solid 1px"></a>
	{else}
		<img src="/img/love/nofoto.gif" hspace=5 vspace=5 style="border: #2297C6 solid 1px">
	{/if}</td>
	<td width=90%><a href="/{$SITE_SECTION}/user/{$l.uid}.html"><b>{$l.name}</b></a> <img src={if $l.gender==2}"/img/love/women.gif" alt="Девушка"{else}"/img/love/men.gif" alt="Парень"{/if}>, {$l.age}, {$l.city}<br>
		<font class=lit1>Был{if $l.gender==2}a{/if} {$l.what_lasttime}</font></td>
	<td nowrap align=center>{if $l.mnew!=0}<a target="_blank" href="/{$SITE_SECTION}/messages/{$l.id}.html"><b>{$l.mnew}</b></a>{else}0{/if}</td><td align=center><a target="_blank" href="/{$SITE_SECTION}/messages/{$l.uid}.html">{$l.mall}</a></td>
	</tr>
{/foreach}
	<tr><td colspan=3><br>Переместить отмеченные в <select name="moveto">
		<option value=\"\">Выберите папку...</option>
{foreach from=$res.folders item=l}
		<option value="{$l.fid}">{$l.name}</option>
{/foreach}
	</select>&#160;&#160;<input type="submit" value=" ОК "><br></td></tr>
	</form>
</table>