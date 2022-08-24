<html>

<head>
	{$TITLE->Head}
	{literal}
	<style>
		* {
			background-color:transparent;
			margin:0; padding:0px;
			font:100% Arial,Helvetica,sans-serif;
			font-style:normal;
		}
		table {
			border-collapse: collapse;
		}
		table tr {
			vertical-align: top;
		}
		
		table tr td.f{
			padding-top: 0px;
		}
		
		table tr td{
			padding-top: 6px;
		}
		
		table tr td em,
		table tr td span.date{
			font-size: 70%;
			color:#666666;
		}
		
		table tr td span.date{
			color:#000;
		}
		
		a{font-size: 80%;}
		a:link{color:#1A3DC1}
	</style>

	<script type="text/javascript">
		$(document).ready(function() {
			widget.setIFrameHeight($('#w-y-realty').height());
		});
	</script>
	{/literal}
</head>

<body onload="widget.adjustIFrameHeight()">
	<table id="w-y-realty">
		{foreach from=$res.list item=v name=i}
		<tr>
			<td{if  $smarty.foreach.i.first} class="f"{/if}>
				<span class="date">{php}
				if (date('y-m-d', $this->_tpl_vars['v']['DateUpdate']) === date('y-m-d'))
					echo date('H:i', $this->_tpl_vars['v']['DateUpdate']);
				else
					echo date('m.d', $this->_tpl_vars['v']['DateUpdate']);
				{/php}</span>
				<a href="{$v.url}" target="_blank">{if $v.RoomCount}{$v.RoomCount} {/if}{$v.opt_Address}</a> 
				<em>{if $v.Price == 9999999999999}договор.{else}{$v.Price|number_format:0:'':' '}{if $res.deal=='sell' || $res.deal=='buy'} тыс.{/if}  руб. ({if $res.deal == 'sell' || $res.deal == 'buy' || $res.rubric != 'residential' }{if $v.PriceUnit==1}общая{else}за метр{/if}{else}{if $v.PriceUnit==1}за месяц{else}за сутки{/if}{/if}){/if}</em>
			</td>
		</tr>
		{/foreach}
	</table>
</body>
</html>