{if $res.dopsv != ""}
	{if $res.img_big.file != ""}
		<img src="{$res.img_big.file}" border="0" align="left" hspace="7" vspace="7">
	{/if}
	{$res.dopsv|nl2br}<br/><br/>
{/if}
{if $res.city != "" }{$res.city}, {/if}{if $res.address!=""}{$res.address}{/if}<br/>
{if $res.phone!=""}Тел: {$res.phone}.{/if} {if $res.fax!=""}Факс: {$res.fax}.{/if}<br/>
{php}
	if ($this->_tpl_vars['res']['email'] != '') {
		$this->_tpl_vars['res']['email'] = explode(',',$this->_tpl_vars['res']['email']);
		foreach($this->_tpl_vars['res']['email'] as &$m)
			$m = '<a href="mailto:'.trim($m).'"/>'.trim($m).'</a>';
		$this->_tpl_vars['res']['email'] = implode(', ',$this->_tpl_vars['res']['email']);
	}
{/php}
{if $res.email!=""}
	<span class="s7">{*$res.email|mailto_crypt*}{$res.email}</span><br />
{/if}
{if $res.http!=""}
	<noindex><a href="http://{$res.http|url:false}" target="_blank">{$res.http|url:false}</a></noindex><br />
{/if}