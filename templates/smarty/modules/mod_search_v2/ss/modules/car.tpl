<div {if $doc.data.Photo.h}style="height:{$doc.data.Photo.h}px"{/if}>{if $doc.data.Photo}
	<div style="float:left">
		<a href="{$doc.url}#images"><img src="{$doc.data.Photo.url}" hspace="5" border="0" /></a>
	</div>
{/if}
<a class="result_ref" target="_blank" href="{$doc.url}"><span style="line-height: 17px;">{$doc.title}</span></a><br/>

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
	<font color="#888888">{$doc.small_url}</font>
	{if $doc.pubDate}- {$doc.pubDate|date_format:"%d.%m.%Y"}{/if}
</small>
</div>