<br/>
<!-- begin content -->
<table align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<font style="FONT-WEIGHT: bold; FONT-SIZE: 14px">{$res.rubric.name}</font>
		</td>
	</tr>
</table>
<br/><br/><br/>

{foreach from=$res.data item=l}
{if empty($l.readonly)}
<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		{if !empty($l.firm.s_photo)}
		<td style="padding-right:10px">
			<a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html"><img src="{$l.firm.s_photo}" border="0" alt="{$l.firm.name}" /></a>
		</td>
		{/if}
		<td style="width: 100%">
			<a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html"><font style="FONT-WEIGHT: bold; FONT-SIZE: 14px">{$l.firm.name}{if !empty($l.firm.io)} {$l.firm.io}{/if}</font></a><br/>
			{if !empty($l.firm.employment)}{$l.firm.employment}<br/>{/if}
			{if !empty($l.firm.anonce)}{$l.firm.anonce|screen_href|mailto_crypt}{/if}
			<a href="/{$ENV.section}/firm/{$l.firm.id}.html" class="ssyl">подробнее о компании</a><br/>
			<a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html#question" class="s1">задать вопрос</a>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
{if !empty($l.quest)}
<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		<td class="ssyl">
			<font class="small"><b>{$l.quest.name}</b>: </font><font class="s1">{$l.quest.otziv|truncate:40:"...":false}</font> <a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html#{$l.quest.id}" class="s1">далее</a><br/>
		</td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="right">
			<a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html"class="s1">все вопросы</a>
		</td>
	</tr>
</table>
{/if}
<br/><br/><br/>
{/if}
{/foreach}

{capture name=archive}
<table align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<font style="FONT-WEIGHT: bold; FONT-SIZE: 14px">Архив раздела &laquo;{$res.rubric.name}&raquo;</font>
		</td>
	</tr>
</table>
<br/><br/><br/>
{assign var=_archive value=false}
{foreach from=$res.data item=l}
{if !empty($l.readonly)}
{assign var=_archive value=true}
<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
		{if !empty($l.firm.s_photo)}
		<td style="padding-right:10px">
			<a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html"><img src="{$l.firm.s_photo}" border="0" alt="{$l.firm.name}" /></a>
		</td>
		{/if}
		<td style="width: 100%">
			<a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html"><font style="FONT-WEIGHT: bold; FONT-SIZE: 14px">{$l.firm.name}{if !empty($l.firm.io)} {$l.firm.io}{/if}</font></a><br/>
			{if !empty($l.firm.employment)}{$l.firm.employment}<br/>{/if}
			{if !empty($l.firm.anonce)}{$l.firm.anonce}{/if}
			<a href="/{$ENV.section}/firm/{$l.firm.id}.html" class="ssyl">подробнее о компании</a><br/>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
{if !empty($l.quest)}
<table width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
		<font class="small"><b>{$l.quest.name}</b>: </font><font class="s1">{$l.quest.otziv|truncate:40:"...":false}</font> <a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html#{$l.quest.id}"  class="s1">далее</a><br/>
	</td>
	</tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="right">
			<a href="/{$ENV.section}/{$res.rubric.path}/{$l.cid}.html" class="s1">все вопросы</a>
		</td>
	</tr>
</table>
{/if}

<br/><br/><br/>
{/if}
{/foreach}
{/capture}

{if $_archive === true}
	{$smarty.capture.archive}
{/if}

<!-- end content -->