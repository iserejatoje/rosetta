{if sizeof($res) }
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr class="block_title">
	<td style="padding: 2px 2px 2px 20px;" align="left"><span><a href="/{$ENV.section}/list/vacancy/firm.php">Вакансии компаний</a></span></td>
</tr> 
</table>
<table cellpadding="0" cellspacing="5" border="0" width="100%">
	<tr>
	{foreach from=$res item=l key=_k name=vk}
		<td {if $l.img_small.file!=""}style="border: 1px solid rgb(187, 198, 193);" align="center"{else}align="left" {/if}>{
		if $l.img_small.file==""}<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0">{/if
		}<a href="{if $l.link}http://{$l.link}{else}/{$ENV.section}/vacancy/firm/{$l.fid}.php{/if}" alt="{$l.fname|escape}{if !$l.link} ({$l.count}){/if}" title="{$l.fname|escape}{if !$l.link} ({$l.count}){/if}" {if $l.link}target="_blank"{/if}>{if $l.img_small.file!=""}<img src="{$l.img_small.file}" width="{$l.img_small.w}" height="{$l.img_small.h}" alt="{$l.fname|escape}{if !$l.link} ({$l.count}){/if}" border="0">{else}{$l.fname}{if !$l.link} ({$l.count}){/if}{/if}</a></td>
              {if ($_k+1)%2==0 && !$smarty.foreach.last}</tr><tr>{/if}
	{/foreach}
	</tr>
</table>
{/if}