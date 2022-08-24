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
			border: 0px;
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
		
		table tr td.icon{
			padding-right: 2px;
			width: 45px;
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
			widget.setIFrameHeight($('#w-y-auto').height());
		});
	</script>
	{/literal}
</head>

<body>
	<table id="w-y-auto">
		{foreach from=$res.list item=v name=i}
		<tr>
			<td class="icon">
				<a href="{$res.link}detail/{$v.id}.html" target="_blank"><img width="45" src="{$v.thumb.file}" /></a>
			</td>
			<td{if  $smarty.foreach.i.first} class="f"{/if}>	
				<span class="date">{php}
					if (date('y-m-d', $this->_tpl_vars['v']['created']) === date('y-m-d'))
						echo date('H:i', $this->_tpl_vars['v']['created']);
					else
						echo date('m.d', $this->_tpl_vars['v']['created']);
					{/php}</span>
				<a href="{$res.link}detail/{$v.id}.html" target="_blank">{if !empty($v.model_name)}{$v.model_name}{else}{foreach from=$v.model item=l2 name=f}{if $l2.data.type!=0}{if $smarty.foreach.f.iteration != 1} {/if}{$l2.data.name}{/if}{/foreach}{/if}</a> 
				<em>{$v.cost|number_format:0:'':' '} руб.</em>
			</td>
		</tr>
		{/foreach}
	</table>
</body>
</html>


{*
<html>

<head>
	{$TITLE->Head}
	{literal}
	<style>
		body {
			background-color:transparent;
			margin:0;padding:0px;
		}
		iframe {
			display: none;
		}
		.w-y-auto *{padding:0px;margin:0;border:0;font:100% Arial,Helvetica,sans-serif;position:relative;}
		.w-y-auto {font:100% Arial,Helvetica,sans-serif;position:relative;}
		.w-y-auto table {
			margin:-0.15em 0 .4em;
			padding:0;
			width: 100%;
		}
		.w-y-auto table td{
			padding:0 0.2em 0.1em 0;
			line-height:1.2em;
		}
		.w-y-auto table td a{font-size: 80%;}
		.w-y-auto table td a:link{color:#1A3DC1}
		.w-y-auto table em,.w-y-auto table span{font-size: 70%; color:#000;font-style:normal}
		.w-y-auto table em{position:relative;}
		.w-y-auto table td .p{color:#666666}
	</style>	
	{/literal}
	
	<script type="text/javascript" src="http://img.yandex.net/webwidgets/1/WidgetApi.js"></script>
</head>

<body onload="widget.adjustIFrameHeight()">
	<div class="w-y-auto" id="auto">
		<table cellpadding="0" cellspacing="0">
			{foreach from=$res.list item=v name=v}
			<tr valign="top">
				<td width="45">
					<a href="{$res.link}detail/{$v.id}.html" target="_blank"><img width="45" src="{$v.thumb.file}" /></a><br/>
				</td>
				<td>
					<em>{php}
					if (date('y-m-d', $this->_tpl_vars['v']['created']) === date('y-m-d'))
						echo date('H:i', $this->_tpl_vars['v']['created']);
					else
						echo date('m.d', $this->_tpl_vars['v']['created']);
					{/php}</em>
					<a href="{$res.link}detail/{$v.id}.html" target="_blank">{if !empty($v.model_name)}{$v.model_name}{else}{foreach from=$v.model item=l2 name=f}{if $l2.data.type!=0}{if $smarty.foreach.f.iteration != 1} {/if}{$l2.data.name}{/if}{/foreach}{/if}</a> 
					<span class="p">{$v.cost|number_format:0:'':' '} руб.</span>
				</td>
			</tr>
			{/foreach}
		</table>
		
	</div>
</body>
</html>*}