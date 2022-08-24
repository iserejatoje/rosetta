{include file="design/200608_title/common/anontitle.tpl" anontitle="Курсы валют"}
<table width="100%" cellspacing="0" cellpadding="3">

<tr>
	<td bgcolor="#FFFFFF" align="center"> 
<a href="/exchange/">Лучшие курсы валют</a>
<table width="100%" >
<tr align="center">
	<td width="34%" class="copy">&nbsp;</td>
	<td width="33%" class="copy">продажа</td>
	<td width="33%" class="copy">покупка</td>
</tr>
{foreach from=$A_EXCHANGE.l1 item=l}
<tr align="center">
	<td bgColor="#ffcc00" class="copy"><font color="#ffffff"><b>{$l.name}</b></font></td>
	<td class="copy"><a href="/exchange/">{$l.min_sell}</a></td>
	<td class="copy"><a href="/exchange/">{$l.max_buy}</a></td>
</tr>
{/foreach}
</table>
	</td>
</tr>

<tr>
	<td style="text-align: center; background-color: #FFFFFF; padding-top: 5px;padding-bottom: 5px"> 
<a href="/exchange/cbrf.html">Курсы валют ЦБ РФ на {$A_EXCHANGE.l2.quotation_date} </a>

<table width="100%" class="copy">
<tr>
	<td colspan="3"><img src="/_img/x.gif" width="1" height="1" alt="" /></td>
</tr>
<tr align="center">
	<td width="34%" bgcolor="#ffcc00" class="copy"><font color="#ffffff"><b>USD</b></font></td> 
	<td width="33%" class="copy">{$A_EXCHANGE.l2.usd}</td>
	<td width="33%" class="copy">{$A_EXCHANGE.l2.usd_o}</td>
</tr>
<tr align="center">
	<td width="34%" bgcolor="#ffcc00" class="copy"><font color="#ffffff"><b>EUR</b></font></td> 
	<td width="33%" class="copy">{$A_EXCHANGE.l2.eur}</td>
	<td width="33%" class="copy">{$A_EXCHANGE.l2.eur_o}</td>
</tr>
</table>

	</td>
</tr>

<td style="background-color: #FFFFFF; padding-top: 5px;padding-bottom: 5px" align="center">

<table cellspacing="0" cellpadding="0" width="100%">
<tr><td width="34%" align="center"><a href="/exchange/stat.html"><img src="/img/design/ico-graf.gif" width="26" height="26" border="0"></a></td>
<td width="9%">&nbsp;</td>
<td align="left" width="57%"><a href="/exchange/stat.html">Динамика<br>курсов валют</a></td></tr>
</table>

</td>
</tr>
<tr>
	<td style="background-color: #FFFFFF; padding-top: 5px;padding-bottom: 5px" align="center">
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td width="34%" align="center"><a href="/exchange/exch.html"><img src="/img/design/ico-change.gif" width="26" height="26" border="0"></a></td>
			<td width="9%">&nbsp;</td>
			<td align="left" width="57%"><a href="/exchange/exch.html">Конвертор<br>валют</a></td>
		</tr>
		</table>
	</td>
</tr>

{*
{foreach from=$A_EXCHANGE.l3 item=l}
<tr>
	<td style="text-align: center; background-color: #FFFFFF; padding-top: 10px;padding-bottom: 10px">
		{$l}
	</td>
</tr>
{/foreach}
*}

</table>
