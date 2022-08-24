{if !empty($res.antitle)}
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr><td class="title2">{$res.antitle}</td></tr>
</table>
{/if}
{if is_array($res.list) && count($res.list) > 0}
{foreach from=$res.list item=l key=k name=logos}
{if $k%2 == 0}
<table width="100%"><tr>
{/if}
<td align="center">

<div style="float:center;width:150px;height:100px;overflow:hidden;padding:10px;">
	<div style="width: 150px; height:80px; background:url('{$l.img_path}{$l.img}')  no-repeat center;border: solid 1px #cccccc;" title="{$l.name|escape}">
		<a href="/{$CURRENT_ENV.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if !empty($l.desc)}{$l.desc}{else}{/if}/{$l.id}.html"><img src="/_img/x.gif" width="150" height="80" border="0" /></a>
	</div>
	<div><a href="/{$CURRENT_ENV.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if !empty($l.desc)}{$l.desc}{else}{/if}/{$l.id}.html">{$l.name}</a></div>
</div>
</td>
{if $k%2 == 1}
</tr></table>{if !$smarty.foreach.logos.last}<div>&nbsp;</div>{/if}
{/if}
{/foreach}
{if $k%2 != 1}
</tr></table>
{/if}
{/if}