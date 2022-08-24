<html>

<head>
	{$TITLE->Head}
	{literal}
	<style>
		* {
			background-color:transparent;
			margin:0; padding:0px;
			font-family: Arial;			
			font-size: 10pt;			
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
		a, a:link, a:visited{			
			color:#1a3dc1;
		}
		a:hover{color: #ff0000;}
		
		.namebank{
			white-space: nowrap;
			
		}
		
	</style>

	<script type="text/javascript">
		
		var $resize = function() {
			widget.setIFrameHeight($('#w-y-exchange').height());
		}
		
		$(document).ready(function() {
			$resize();
			
			$(window).bind('resize', $resize);
		});
	</script>
	{/literal}
</head>

<body onload="widget.adjustIFrameHeight()">

	<table id="w-y-exchange" width="100%">
		<tr>
			<td colspan="6" cellpadding="2" class="zag" align="right">{$res.date}</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
			<td colspan="2" class="zag1">USD</td>
			<td colspan="2" class="zag1">EUR</td>
		</tr>
		<tr>
			<td colspan="2" class="zag1" style="border-bottom-width:1px;border-bottom-style:solid; border-bottom-color:#d7d7d7;">Банк</td>
			<td class="zag" style="border-bottom-width:1px;border-bottom-style:solid; border-bottom-color:#d7d7d7;">покуп.</td>
			<td class="zag" style="border-bottom-width:1px;border-bottom-style:solid; border-bottom-color:#d7d7d7;">прод.</td>
			<td class="zag" style="border-bottom-width:1px;border-bottom-style:solid; border-bottom-color:#d7d7d7;">покуп.</td>
			<td class="zag" style="border-bottom-width:1px;border-bottom-style:solid; border-bottom-color:#d7d7d7;">прод.</td>
		</tr>
		{foreach from=$res.data item=bank}
			<tr>
				<td class="cell" style="max-width: 40; overflow: hidden;" colspan="2"><a class="namebank" target="_blank" href="{$res.link}exchange.html">{$bank.list.bankname}</a></td>
				<td style="width: 15%" class="cell {if $bank.cost != null}{if $bank.cost.1.max_buy == $bank.list.cost_1.buy}great{/if}{/if}">{$bank.list.cost_1.buy}&nbsp;{if !empty($bank.prev_cost.1.buy)}{if $bank.list.cost_1.buy > $bank.prev_cost.1.buy}<img src="/_img/widgets/exchange/str-green.gif"/>{else}{if $bank.list.cost_1.buy < $bank.prev_cost.1.buy && !empty($bank.prev_cost.1.buy)}<img src="/_img/widgets/exchange/str-red.gif"/>{/if}{/if}{/if}</td>
				<td style="width: 15%" class="cell {if $bank.cost != null}{if $bank.cost.1.min_sell == $bank.list.cost_1.sell}great{/if}{/if}">{$bank.list.cost_1.sell}&nbsp;{if !empty($bank.prev_cost.1.sell)}{if $bank.list.cost_1.sell > $bank.prev_cost.1.sell}<img src="/_img/widgets/exchange/str-green.gif"/>{else}{if $bank.list.cost_1.sell < $bank.list.prev_cost.1.sell}<img src="/_img/widgets/exchange/str-red.gif"/>{/if}{/if}{/if}</td>
				<td style="width: 15%" class="cell {if $bank.cost != null}{if $bank.cost.3.max_buy == $bank.list.cost_3.buy}great{/if}{/if}">{$bank.list.cost_3.buy}&nbsp;{if !empty($bank.prev_cost.3.buy)}{if $bank.list.cost_3.buy > $bank.prev_cost.3.buy}<img src="/_img/widgets/exchange/str-green.gif"/>{else}{if $bank.list.cost_3.buy < $bank.prev_cost.3.buy}<img src="/_img/widgets/exchange/str-red.gif"/>{/if}{/if}{/if}</td>
				<td style="width: 15%" class="cell {if $bank.cost != null}{if $bank.cost.3.min_sell == $bank.list.cost_3.sell}great{/if}{/if}">{$bank.list.cost_3.sell}&nbsp;{if !empty($bank.prev_cost.3.sell)}{if $bank.list.cost_3.sell > $bank.prev_cost.3.sell}<img src="/_img/widgets/exchange/str-green.gif"/>{else}{if $bank.list.cost_3.sell < $bank.list.prev_cost.3.sell}<img src="/_img/widgets/exchange/str-red.gif"/>{/if}{/if}{/if}</td>
			</tr>
		{/foreach}		
		<tr>
			<td colspan="6" style="padding-top: 8px; border-top-width:1px;border-top-style:solid; border-top-color:#d7d7d7;"><a href="{$res.link}exchange.html" target="_blank">Курсы валют всех банков</a></td>
		</tr>
		
	</table>
	
</body>
</html>