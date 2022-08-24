{include file="`$TEMPLATE.sectiontitle`" rtitle="Работа: Вакансии и резюме по рубрикам"}
<center>
<table cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" width="100%">
	<tr>
		<td>
			<table cellpadding="4" cellspacing="2" border="0" width="100%">
				<tr bgcolor="#E3F6FF">
					<th class="dopp" align=center>
						{* <a href="?cmd=vaclst">Вакансии [{$allvac|number_format:"0":",":" "}] *}
						<b>Вакансии</b>
					</th>
					<th class="dopp" align="center">
						{* <a href="?cmd=reslst">Резюме [{$allres|number_format:"0":",":" "}] *}
						<b>Резюме</b>
					</th>
					</tr>


{excycle values="#F1F6F9,#FFFFFF"}
{foreach from=$page.razdel item=l}
{if $l.rid==1 || $l.rid==11 || $l.rid==21 || $l.rid==22}	
		<tr bgcolor="{excycle}">
	            <td class="t1">
        		      &nbsp;&nbsp;<a class="s1" href="/{$CURRENT_ENV.section}/vacancy/{$l.rid}/1.php">{if $l.rid==22 || $l.rid==23}<font color="red">{/if}{$l.rname} [{$l.vcount|number_format:"0":",":" "}]{if $l.rid==22 || $l.rid==23}</font>{/if}</a></td>
	            <td class="t1">
        		      &nbsp;&nbsp;<a class="s1" href="/{$CURRENT_ENV.section}/resume/{$l.rid}/1.php">{if $l.rid==22 || $l.rid==23}<font color="red">{/if}{$l.rname} [{$l.rcount|number_format:"0":",":" "}]{if $l.rid==22 || $l.rid==23}</font>{/if}</a></td>
	        </tr>
{/if}
{/foreach}
			</table>
		</td>
	</tr>
</table>
</center>

{* {include file="`$TEMPLATE.nizbanner`"} *}