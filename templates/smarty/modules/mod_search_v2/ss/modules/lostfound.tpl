{php}trace::vardump("vardump");{/php}
{if $doc.data.Photo}
	<a href="{$doc.url}#images"><img src="{$doc.data.Photo.file}" width="{$doc.data.Photo.w}" height="{$doc.data.Photo.h}" align="left" border="0" /></a>
{/if}
<a class="result_ref" target="_blank" href="{$doc.url}"><span style="line-height: 17px;">{$doc.title}</span></a><br/>

<table cellpadding="2" cellspacing="0" border="0">
	<tr>
{php}
	$_ind = 0;

	foreach($this->_tpl_vars['doc']['data'] as $this->_tpl_vars['dk'] => $this->_tpl_vars['dv']) {
		if (!in_array($this->_tpl_vars['dk'], array('Breed','Color','OnName','Number','Brand','Model','Size','Other', 'Detail')) )
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