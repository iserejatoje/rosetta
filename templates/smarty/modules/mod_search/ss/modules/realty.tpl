{if $doc.data.Photo}
	<a href="{$doc.url}#images"><img src="{$doc.data.Photo.file}" width="{$doc.data.Photo.w}" height="{$doc.data.Photo.h}" align="left" border="0" /></a>
{/if}
<a target="_blank" href="{$doc.url}"><span>{$doc.title}</span></a><br/>

{if $doc.data.index != 'realty_firms'}
<table cellpadding="2" cellspacing="0" border="0">
	<tr>
{php}
	$_ind = 0;

	foreach($this->_tpl_vars['doc']['data'] as $this->_tpl_vars['dk'] => $this->_tpl_vars['dv']) {
		if (!in_array($this->_tpl_vars['dk'], array('Area','RoomCount','BuildingArea','LandArea','BuildingType','Series','Floor','Floors')) )
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
</table>

{else}
	{foreach from=$doc.passages item=passage}{if $passage}<span>{$passage}</span><br>{/if}{/foreach}
{/if}

<small>
	<font color="#888888">{$doc.url|truncate:100:"..."}</font>
	{if $doc.pubDate}- {$doc.pubDate|date_format:"%d.%m.%Y"}{/if}
</small><br clear="both"/>