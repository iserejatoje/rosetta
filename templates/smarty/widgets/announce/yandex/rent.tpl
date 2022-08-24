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
			widget.setIFrameHeight($('#w-y-rent').height());
		});
	</script>
	{/literal}
</head>

<body onload="widget.adjustIFrameHeight()">
	<table id="w-y-rent">
		{foreach from=$res.list item=v name=i}
		<tr>
			<td{if  $smarty.foreach.i.first} class="f"{/if}>
				<span class="date">{php}
				if (date('y-m-d', $this->_tpl_vars['v']['date_start']) === date('y-m-d'))
					echo date('H:i', $this->_tpl_vars['v']['date_start']);
				else
					echo date('m.d', $this->_tpl_vars['v']['date_start']);
				{/php}</span>
				<a href="{$res.link}details.html?id={$v.id}" target="_blank">{$res.realty_objects[$v.object][0]} {$v.address}</a> 
				<em>{$v.price|number_format:0:'':' '} тыс. руб.<em>
			</td>
		</tr>
		{/foreach}
	</table>
</body>
</html>