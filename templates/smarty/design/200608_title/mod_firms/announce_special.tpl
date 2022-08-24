{if count($BLOCK.res.list)>0}
<table border="0" style="margin-top: 10px;" cellspacing="0" cellpadding="0" bgcolor="#d2f0f0" width="100%">
          <tr>
            <td class="zag1" style="padding: 2px 0px 5px 5px;"><a href="/{$BLOCK.section}/special.html" class="zag4">{if !empty($BLOCK.res.antitle)}{$BLOCK.res.antitle}{else}Предложения компаний{/if}</a>&nbsp;&nbsp;</td>
          </tr>
</table>

<br/>
{foreach from=$BLOCK.res.list item=l key=k name=logos}
{if $k%4 == 0}
<table width="100%" style="padding-bottom: 4px;"><tr>
{/if}
<td align="center">
<div style="width:100px;height:40px;">
	<div style="width: 100px; height:40px; background:url('{$l.img_path}{$l.img_small}')  no-repeat center;border: solid 1px #cccccc;" title="{$l.name|escape}">
		<a href="/{$BLOCK.section}/{if $smarty.session.group!=''}{$smarty.session.group}/{/if}{if !empty($l.desc)}{$l.desc}{else}{/if}/{$l.id}.html"><img src="/_img/x.gif" width="100" height="40" border="0" /></a>
	</div>
</div>
</td>
{if $k%4 == 3}
</tr></table>{if !$smarty.foreach.logos.last}<div>&nbsp;</div>{/if}
{/if}
{/foreach}
{if $k%4 != 3}
</tr></table>
{/if}
{/if}