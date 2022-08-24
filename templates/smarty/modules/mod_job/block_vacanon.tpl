{* 
	:TODO:
	
	TRASH
	
	Переменные из модуля на прямую в смарти отдаваться не должны.
	Каждый логический блок должен генерироваться отдельным методом.
	
	Всё что идет ниже не верно!!!
*}
{if sizeof($vacanon.agvac)}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td class="t5gb" align="center">Вакансии&nbsp;агентств</td>
	</tr>
	<tr>
		<td>
			<table cellpadding=0 cellspacing="5" border="0">
			{foreach from=$vacanon.agvac item=l}
				<tr>
					<td {if trim($l.file_name)!=""}style="border: 1px solid rgb(187, 198, 193);" align="center"{else}align="left" {/if}> {if $l.file_name==""}<img src="/_img/design/200608_title/b3.gif" width="4" height="4" hspace="2" border="0">{/if}&#160;<a href="{if $l.link}http://{$l.link}{else}/{$CURRENT_ENV.section}/?cmd=firmvac&id={$l.fid}{/if}"  class="s1" target="_blank">{if $l.file_name !="" }<img src="{$l.file_name}" {$l.image_size}  alt="{$l.fname|escape} ({$l.cnt|number_format:"0":",":" "})" border="0">{else}{$l.fname} ({$l.cnt|number_format:"0":",":" "}){/if} </a> </td>
				</tr>
			{/foreach}
			</table>
		</td>
	</tr>
</table>
{/if}