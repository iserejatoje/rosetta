<div class="title2_news">{$page.Name}</div>
<br/>

<table cellspacing="1" cellpadding="4" width="100%">
<tr>
	<td class="bg_color2" align="right" width="80">Контакты:</td></td>
	<td align="left" width="100%">{$page.Contacts}</td>
</tr>
{if $page.FirmUrl}
<tr>
	<td width="80"></td>
	<td align="left" width="100%"><a href="{$page.FirmUrl}">Подробнее о компании-продавце</a></td>
</tr>
{/if}
</table>
<br/>

{$page.list}
