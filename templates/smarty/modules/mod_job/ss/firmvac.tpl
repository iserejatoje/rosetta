{capture name="rname"}ВАКАНСИИ - {$res.ftype} {$res.fname|escape}{/capture}
{include file="`$TEMPLATE.sectiontitle`" rtitle="`$smarty.capture.rname`"}
{if $res.dopsv!=""}
	{if $res.file_name!=""}
		<img src="{$res.file_name}" border="0" align="left" hspace="7" vspace="7">
	{/if}
	{$res.dopsv|screen_href|mailto_crypt}<br/><br/>
{/if}
{$res.city}{if $res.address!=""}, {$res.address}{/if}<br/>
{if $res.phone!=""}Тел: {$res.phone}.{/if} {if $res.fax!=""}Факс: {$res.fax}.{/if}<br/>
{if $res.email!=""}
	<a class="s7" href="mailto:{$res.email}">{$res.email}</a><br />
{/if}
{if $res.http!=""}
	<noindex><a class="s7" href="http://{$res.http}" target="_blank">{$res.http}</a></noindex><br />
{/if}
<br /><br /><br />
<center>
<table cellpadding="4" cellspacing="1" border="0" width="98%" >
    <tr bgcolor="#DEE7E7">
		<td class="t1" align="center">Дата</td>
		<td class="t1" align="center">Должность</td>
		<td class="t1" align="center">З/П</td>
		<td class="t1" align="center">Условия</td>
    </tr>
	{excycle values="#F3F8F8,#FFFFFF"}
	{foreach from=$res.list item=l}
	<tr bgcolor="{excycle}">
		<td class="t7" valign="top">{$l.date|date_format:"%e.%m.%Y"}</td>
		<td class="t7" valign="top"><a href="/{$CURRENT_ENV.section}/?cmd=showvac&id={$l.vid}&fid={$res.fid}&from_firmvac=1" class="s3">{$l.dol|escape}</a></td>
		<td class="t7" valign="top">{$l.paysum}</td>
		<td class="t7" valign="top">{$l.uslov|escape|truncate:40:"...":false}</td>
	</tr>
	{/foreach}
</table>
{if $res.isotz && $res.ft>0}
	<center>
		<a href="/{$CURRENT_ENV.section}/?cmd=questform&fid={$res.fid}" class="s1" target="_blank"><font color="red"><b>Задать вопрос</b></font></a>
	</center>
{/if}