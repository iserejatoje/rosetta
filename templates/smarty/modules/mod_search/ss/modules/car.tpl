{if $doc.data.Photo}
	<a href="{$doc.url}#images"><img src="{$doc.data.Photo.file}" align="left" border="0" /></a>
{/if}
<a target="_blank" href="{$doc.url}"><span>{$doc.title}</span></a><br/>

<table cellpadding="2" cellspacing="0" border="0">
	<tr>
{php}
	$_ind = 0;

	foreach($this->_tpl_vars['doc']['data'] as $this->_tpl_vars['dk'] => $this->_tpl_vars['dv']) {
		if (!in_array($this->_tpl_vars['dk'], array('Year','Mileage','GearBox','EngineCapacity','Color','Price')) )
			continue ;

		if ( $_ind % 2 == 0 ) {
			{/php}
			</tr><tr>
			{php}
		}
		
		{/php}<td style="padding-right: 10px">{$dv}</td>{php}
			
		$_ind++;
	}
{/php}
	</tr>
	{*if $doc.data.Details}
		<tr><td colspan="2">{$doc.data.Details}</td></tr>
	{/if*}
</table>

<small>
	<font color="#888888">{$doc.url|truncate:100:"..."}</font>
	{if $doc.pubDate}- {$doc.pubDate|date_format:"%d.%m.%Y"}{/if}
</small><br clear="both"/>