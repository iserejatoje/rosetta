<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr align="left">
	<td class="block_title" style="text-align: left;padding-left: 18px"><span>Мои форумы</span></td>
</tr>
</table>
<div align="right" class="tip"><a href="/passport/announce/forum.php"><font color="#999999">настройка</font><img src="/_img/modules/passport/settings.gif" height="10" width="10" border="0" title="настройка" style="vertical-align:middle;margin-left:4px;" /></a></div>
{if is_array($res.selected) && count($res.selected) > 0}
<div class="t11_grey" style="text-align:center;font-weight:bold;padding:4px;">избранные темы</div>
<table width="100%" cellpadding="0" cellspacing="2" border="0" >
{foreach from=$res.selected item=l}
<tr>
	<td class="tip"><a href="{$l.url}">{$l.name}</a></td>
</tr>
<tr>
	<td class="tip" style="padding-bottom:4px;">Ответов({$l.messages}): <a href="{$l.url_last}">{$l.last_date|simply_date}</a></td>
</tr>
{/foreach}
</table>
{/if}
{if is_array($res.owner) && count($res.owner) > 0}
<div class="t11_grey" align="center"{if is_array($res.selected) && count($res.selected) > 0} style="padding:4px;padding-top:8px;"{else} style="padding:4px;"{/if}><b>собственные темы</b></div>
<table width="100%" cellpadding="0" cellspacing="2" border="0" >
{foreach from=$res.owner item=l}
<tr>
	<td class="tip"><a href="{$l.url}">{$l.name}</a></td>
</tr>
<tr>
	<td class="tip" style="padding-bottom:4px;">Ответов({$l.messages}): <a href="{$l.url_last}">{$l.last_date|simply_date}</a></td>
</tr>
{/foreach}
</table>
{/if}