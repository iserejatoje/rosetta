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
		
		table tr td em{
			font-size: 70%;
			color:#666666;
		}
		
		a{font-size: 80%;}
		a:link{color:#1A3DC1}
	</style>

	<script type="text/javascript">
		$(document).ready(function() {
			widget.setIFrameHeight($('#w-y-afisha').height());
		});
	</script>
	{/literal}
</head>

<body onload="widget.adjustIFrameHeight()">
	<table id="w-y-afisha">
		{foreach from=$res.list item=v name=i}
		<tr>
			<td{if  $smarty.foreach.i.first} class="f"{/if}>
				<a href="{$res.link}event/{$v.event_id}.php" target="_blank">{$v.title}</a> 
				<em>{$v.genre}<em>
			</td>
		</tr>
		{/foreach}
	</table>
</body>
</html>