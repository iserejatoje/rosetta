{if count($res.anonphoto)>0}
<table width="100%" cellpadding="0" cellspacing="3" border="0">
<tr align="right">
	<td class="block_title_obl"><span>НОВЫЕ ФОТО</span></td>
</tr>
</table>

<table align="center" cellpadding="0" cellspacing="3" border="0" width="100%" >
  <tr><td valign="top" colspan=3><img src="/_img/x.gif" width=1 height=5></td></tr>

{foreach from=$res.anonphoto item=l}
{capture name=today}{$l.date|simply_date}{/capture}
<tr valign=middle bgcolor="#F5F9FA"><td width=3><img src="/_img/x.gif" width=3 height=1></td>
<td align=center>
	<small>{if $smarty.capture.today=="сегодня" || $smarty.capture.today=="завтра"}{$smarty.capture.today}{else}{$l.date|date_format:"%e"} {$l.date|date_format:"%m"|month_to_string:2}{/if} в {$l.date|date_format:"%H:%M"}</small>
	<br />
	<a class="text11" href="{$CONFIG.files.get.gallery_details.string}?gid={$l.id}&id={$l.uid}&parentid={$l.parentid}">{$l.name|escape|truncate:30:"...":false}</a>
	<br>
	<a href="{$CONFIG.files.get.gallery_details.string}?id={$l.uid}&parentid={$l.parentid}&gid={$l.id}"><img src="{$l.img.url}" width="{$l.img.w}" height="{$l.img.h}" border=0 vspace="3"></a><br />
	<div align="center">
	<a class=text11 href="{$CONFIG.files.get.journals_record.string}?id={$l.uid}">{$l.uname|escape|truncate:15:"...":false}</a>
	</div>
</td>
<td width=3><img src="/_img/x.gif" width=3 height=6></td></tr>
<tr><td valign="top" colspan=3><img src="/_img/x.gif" width=1 height=10></td></tr>
{/foreach}

  <tr><td valign="top" colspan=3 height=1 bgcolor="#ffffff"><img src="/_img/x.gif" width=1 height=1></td></tr>
</table>
{/if}