<br/>
<!-- begin content -->
<table align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<font style="FONT-SIZE: 16px"><b>{$res.consult.rub_name}</b></font>
		</td>
	</tr>
</table>
<br/><br/><br/>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2">
			<font class="moder">Консультант раздела: </font><a href="/{$ENV.section}/firm/{$res.firm.id}.html" ><b>{$res.firm.name}{if !empty($res.firm.io)} {$res.firm.io}{/if}</b></a><br/>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr valign="top">

		{if !empty($res.firm.s_photo)}
		<td style="padding-right:10px">
			<a href="/{$ENV.section}/firm/{$res.firm.id}.html"><img src="{$res.firm.s_photo}" border="0" alt="{$res.firm.name|escape}" /></a>
		</td>
		{/if}
		<td style="width: 100%">
			{if !empty($res.firm.employment)}{$res.firm.employment}<br/>{/if}
			{if !empty($res.firm.anonce)}{$res.firm.anonce|screen_href|mailto_crypt}{/if}
			<a href="/{$ENV.section}/firm/{$res.firm.id}.html" class="ssyl">подробнее о компании</a><br/><br/>
			{if empty($res.consult.readonly)}
				{*<a href="/{$ENV.section}/{$res.consult.rub_path}/{$res.consult.cid}.html#question" class="dop1">задать вопрос</a>*}
				<a href="#question" class="s1">задать вопрос</a>
			{/if}
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>

<!-- end content -->