{* 
	:TODO:
	
	TRASH
	
	Переменные из модуля на прямую в смарти отдаваться не должны.
	Каждый логический блок должен генерироваться отдельным методом.
	
	Всё что идет ниже не верно!!!
*}
{if sizeof($vacanon.compvac) }
<table cellpadding="0" cellspacing="5" border="0" width="100%">
	<tr>
		<td align="center" colspan="2"><a href="/{$CURRENT_ENV.section}/?cmd=firmvactable"><font class="t5gb"><u>Вакансии компаний</u></font></a><br/></td>
	</tr>
	<tr>
	{foreach from=$vacanon.compvac item=l key=_k name=vk}
		<td {if $l.file_name!=""}style="border: 1px solid rgb(187, 198, 193);" align="center"{else}align="left" {/if}>
		{if $l.file_name==""}<img src="/_img/design/200608_title/b3.gif" width="4" height="4" border="0">{/if} 
		<a href="{if $l.link}http://{$l.link}{else}/{$CURRENT_ENV.section}/?cmd=firmvac&id={$l.fid}{/if}" class="s1" target="_blank">{if $l.file_name!=""}<img src="{$l.file_name}" {$l.image_size} alt="{$l.fname|escape} ({$l.cnt})" border="0">{else}{$l.fname} ({$l.cnt}){/if}</a> </td>
              {if ($_k+1)%2==0 && !$smarty.foreach.last}</tr><tr>{/if}
	{/foreach}
	</tr>
</table>
{/if}