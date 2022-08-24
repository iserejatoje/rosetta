<html>

<head>
	{$TITLE->Head}
	{literal}
	<style>
		* {
			background-color:transparent;
			margin:0; padding:0px;
			font-family: Arial;			
		}
		iframe {
			display: none;
		}
		table {
			border-collapse: collapse;
		}
		table tr {
			vertical-align: top;
		}	
		
		table tr td{
			padding-top: 3px;			
			vertical-align: middle;
			font-size: 0.82em;
		}		
		
		table tr td.zag{
			font-weight: bold;			
		}
		
		table tr td.zag1{
			font-weight: bold;
			color: #a3a4a2;			
		}		
				
		table tr td.great{
			border-width: 1px; 
			background-color: #d7dff3;			
			border-left-color: #ffffff;
			border-right-color: #ffffff;
			border-top-color: #d7d7d7;
			border-bottom-color: #d7d7d7;
			border-style: solid;
		}
		
		table tr td.cell {
			border-width: 1px; 			
			border-left-color: #ffffff;
			border-right-color: #ffffff;
			border-top-color: #d7d7d7;
			border-bottom-color: #d7d7d7;
			border-style: solid;
			color: #656565;
			
		}	

		table tr td.cell div{				
			position: relative;
		}
		table tr td.cell div div{
		  position: absolute; overflow: hidden; white-space: nowrap; width: 100%; top:-10px;
		}
		
		a, a:link, a:visited{			
			color:#1a3dc1;
		}
		a:hover{color: #ff0000;}
		
		
		
	</style>
	
	<script type="text/javascript">
		$(document).ready(function() {
			widget.setIFrameHeight($('#w-y-exchange').height());
		});
	</script>
	{/literal}
</head>

<body onload="widget.adjustIFrameHeight()">

	<table id="w-y-exchange" width="100%">
		<tr>
			<td colspan="4" cellpadding="2" class="zag" align="right">{$res.date}</td>
		</tr>		
		<tr>
			<td colspan="2" class="zag1" style="border-bottom-width:1px;border-bottom-style:solid; border-bottom-color:#d7d7d7;">Банк</td>
			<td class="zag" style="border-bottom-width:1px;border-bottom-style:solid; border-bottom-color:#d7d7d7;">покуп.</td>
			<td class="zag" style="border-bottom-width:1px;border-bottom-style:solid; border-bottom-color:#d7d7d7;">прод.</td>			
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" class="zag1">USD</td>			
		</tr>	
		
		{foreach from=$res.result item=bank}			
			{if ($bank.cost.1.max_buy == $bank.list.list.cost_1.buy  || $bank.cost.1.min_sell == $bank.list.list.cost_1.sell )}			
			<tr>				
				<td class="cell" style="" colspan="2"><a class="namebank" target="_blank" href="{$res.link}exchange.html"><div><div>{$bank.list.list.bankname}</div></div></a></td>
				<td style="width: 15%" class="cell {if $bank.cost != null}{if $bank.cost.1.max_buy == $bank.list.list.cost_1.buy}great{/if}{/if}">{$bank.list.list.cost_1.buy}{if $bank.list.list.cost_1.buy > $bank.prev_cost.1.buy}<img src="/_img/widgets/exchange/str-green.gif"/>{else}{if $bank.list.cost_1.buy < $bank.prev_cost.1.buy && !empty($bank.prev_cost.1.buy)}<img src="/_img/widgets/exchange/str-red.gif"/>{/if}{/if}</td>
				<td style="width: 15%" class="cell {if $bank.cost != null}{if $bank.cost.1.min_sell == $bank.list.list.cost_1.sell}great{/if}{/if}">{$bank.list.list.cost_1.sell}{if $bank.list.list.cost_1.sell > $bank.prev_cost.1.sell}<img src="/_img/widgets/exchange/str-green.gif"/>{else}{if $bank.list.cost_1.sell < $bank.prev_cost.1.buy && !empty($bank.prev_cost.1.sell)}<img src="/_img/widgets/exchange/str-red.gif"/>{/if}{/if}</td>								
			</tr>
			{/if}
		{/foreach}
		
		{foreach from=$res.rnd_usd item=bank}
		<tr>				
				<td class="cell" style="" colspan="2"><a class="namebank" target="_blank" href="{$res.link}exchange.html"><div><div>{$bank.list.list.bankname}</div></div></a></td>
				<td style="width: 15%" class="cell">{$bank.list.list.cost_1.buy}{if $bank.list.list.cost_1.buy > $bank.prev_cost.buy}<img src="/_img/widgets/exchange/str-green.gif"/>{elseif $bank.list.list.cost_1.buy < $bank.prev_cost.buy }<img src="/_img/widgets/exchange/str-red.gif"/>{/if}</td>
				<td style="width: 15%" class="cell">{$bank.list.list.cost_1.sell}{if $bank.list.list.cost_1.sell > $bank.prev_cost.sell}<img src="/_img/widgets/exchange/str-green.gif"/>{elseif $bank.list.list.cost_1.sell < $bank.prev_cost.sell }<img src="/_img/widgets/exchange/str-red.gif"/>{/if}</td>								
		</tr>
		{/foreach}
		<tr>
			<td>&nbsp;</td>
			<td colspan="3" class="zag1">EUR</td>			
		</tr>	
		{foreach from=$res.result item=bank}			
			{if ($bank.cost.3.max_buy == $bank.list.list.cost_3.buy  || $bank.cost.3.min_sell == $bank.list.list.cost_3.sell )}
			<tr>
				<td class="cell" style="" colspan="2"><a class="namebank" target="_blank" href="{$res.link}exchange.html"><div><div>{$bank.list.list.bankname}</div></div></a></td>
				<td style="width: 15%" class="cell {if $bank.cost != null}{if $bank.cost.3.max_buy == $bank.list.list.cost_3.buy}great{/if}{/if}">{$bank.list.list.cost_3.buy}{if $bank.list.list.cost_3.buy > $bank.prev_cost.3.buy}<img src="/_img/widgets/exchange/str-green.gif"/>{else}{if $bank.list.list.cost_3.buy < $bank.prev_cost.3.buy && !empty($bank.prev_cost.3.buy)}<img src="/_img/widgets/exchange/str-red.gif"/>{/if}{/if}</td>
				<td style="width: 15%" class="cell {if $bank.cost != null}{if $bank.cost.3.min_sell == $bank.list.list.cost_3.sell}great{/if}{/if}">{$bank.list.list.cost_3.sell}{if $bank.list.list.cost_3.sell > $bank.prev_cost.3.sell}<img src="/_img/widgets/exchange/str-green.gif"/>{else}{if $bank.list.list.cost_3.sell < $bank.prev_cost.3.buy && !empty($bank.prev_cost.3.sell)}<img src="/_img/widgets/exchange/str-red.gif"/>{/if}{/if}</td>								
			</tr>
			{/if}
		{/foreach}
		
		{foreach from=$res.rnd_eur item=bank}
		<tr>				
				<td class="cell" style="" colspan="2"><a class="namebank" target="_blank" href="{$res.link}exchange.html"><div><div>{$bank.list.list.bankname}</div></div></a></td>
				<td style="width: 15%" class="cell">{$bank.list.list.cost_3.buy}{if $bank.list.list.cost_3.buy > $bank.prev_cost.buy}<img src="/_img/widgets/exchange/str-green.gif"/>{elseif $bank.list.list.cost_3.buy < $bank.prev_cost.buy }<img src="/_img/widgets/exchange/str-red.gif"/>{/if}</td>
				<td style="width: 15%" class="cell">{$bank.list.list.cost_3.sell}{if $bank.list.list.cost_3.sell > $bank.prev_cost.sell}<img src="/_img/widgets/exchange/str-green.gif"/>{elseif $bank.list.list.cost_3.sell < $bank.prev_cost.sell }<img src="/_img/widgets/exchange/str-red.gif"/>{/if}</td>								
		</tr>
		{/foreach}
		<tr>
			<td colspan="6" style="padding-top: 8px; border-top-width:1px;border-top-style:solid; border-top-color:#d7d7d7;"><a href="{$res.link}exchange.html" target="_blank">Курсы валют всех банков</a></td>
		</tr>
		
	</table>
	
</body>
</html>