{include file="`$TEMPLATE.sectiontitle`" rtitle="`$GLOBAL.title.job`: Вакансии и резюме по рубрикам"}
<table cellpadding="0" cellspacing="0" border="0" bgcolor="#FFFFFF" width="100%">
	<tr>
		<td>
			<table cellpadding="4" cellspacing="4" border="0" width="100%">
				<tr bgcolor="#ffffff">
					<th class="t1" bgcolor="#DEE7E7"><a href="/{$CURRENT_ENV.section}/?cmd=vaclst" class="s3">Вакансии [{$allvac|number_format:"0":",":" "}]</th>
					<th class="t1" bgcolor="#DEE7E7"><a href="/{$CURRENT_ENV.section}/?cmd=reslst" class="s3">Резюме [{$allres|number_format:"0":",":" "}]</th>
				</tr>
				{excycle values="#F3F8F8,#FFFFFF"}
			{foreach from=$razdel item=l name=razdel}
					{capture name="link"}/{$CURRENT_ENV.section}/{/capture}
					{capture name="target"}{/capture}
				<tr bgcolor="{excycle}">
					<td class="t1">&nbsp;&nbsp;<a class="s1" href="{$smarty.capture.link}?cmd=vaclst&rid={$l.rid}&p=1" {$smarty.capture.target}>
						{if $l.rid==22 || $l.rid==23}<font color="red">{/if}{$l.rname} [{$l.vcount|number_format:"0":",":" "}]{if $l.rid==22 || $l.rid==23}</font>{/if}</a>
					</td>
					<td class="t1">&nbsp;&nbsp;<a class="s1" href="{$smarty.capture.link}?cmd=reslst&rid={$l.rid}&p=1" {$smarty.capture.target}>{if $l.rid==22 || $l.rid==23}<font color="red">{/if}{$l.rname} [{$l.rcount|number_format:"0":",":" "}]{if $l.rid==22 || $l.rid==23}</font>{/if}</a></td>
				</tr>
				{if $smarty.foreach.razdel.iteration == 7}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.midbanner`"}</td>
				</tr>
				{elseif $smarty.foreach.razdel.iteration == 14}
				<tr>
					<td colspan="2" align="center">{include file="`$TEMPLATE.nizbanner`"}</td>
				</tr>
				{/if}
			{/foreach}
			</table>
		</td>
	</tr>
</table>

{include file="`$TEMPLATE.nizbanner`"}