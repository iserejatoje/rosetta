{if count($BLOCK.res.list)>0}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td class="block_title"><span><a href="{if !empty($BLOCK.url)}{$BLOCK.url}{else}/{$BLOCK.section}{/if}/{if !empty($BLOCK.res.desc)}{$BLOCK.res.desc}/{/if}" class="zag4" target="_blank">{if !empty($BLOCK.res.antitle)}{$BLOCK.res.antitle}{else}Предложения компаний{/if}</a></span></td>
</tr> 
</table>
<br/>
{foreach from=$BLOCK.res.list item=l key=k name=logos}
{if !($k%2)}
<table width="100%" style="padding-bottom: 4px;"><tr>
{/if}
<td align="center">
<div style="width:100px;height:60px;">
	<div style="width: 100px; height:60px; background:url('{$l.img_path}{$l.img_small}')  no-repeat center;border: solid 1px #cccccc;" title="{$l.name|escape}">
		<a href="{if !empty($BLOCK.url)}{$BLOCK.url}{else}/{$BLOCK.section}{/if}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if !empty($l.desc)}{$l.desc}{else}{/if}/{$l.id}.html" target="_blank"><img src="/_img/x.gif" width="100" height="60" border="0" /></a>
	</div>
</div>
</td>
{if $k%2}
</tr></table>{if !$smarty.foreach.logos.last}<div>&nbsp;</div>{/if}
{/if}
{/foreach}
{if !($k%2)}
</tr></table>
{/if}
{/if}