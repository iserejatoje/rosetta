{if $page.errors !== null}
	<br/>
	<div align="center" style="color:red"><b>{$page.errors}</b></div>
{else}

{if $page.user.img_big.file != ""}
	<img src="{$page.user.img_big.file}" border="0" align="left" width="{$page.user.img_big.w}" height="{$page.user.img_big.h}" style="margin: 7px 10px 7px 0px">
{/if}

{if $page.user.firm}
<p class="title">{$page.user.firm}</p>
{elseif $page.user.name}
<p class="title">{$page.user.name}</p>
{/if}
{if $page.user.about}
{$page.user.about}
<br/>
<br/>
{/if}

{if $page.user.contacts}
{*<span class="zag2">Контактные сведения</span>*}
<div style="margin-top: 5px">
{$page.user.contacts|nl2br}
</div>
{/if}
{if $page.user.name}
<div style="margin-top: 5px">
{$page.user.name}
</div>
{/if}

<br/>

{php}

if ( isset($this->_tpl_vars['BLOCKS']['mod_advertise_control_panel_blocks']) && is_array($this->_tpl_vars['BLOCKS']['mod_advertise_control_panel_blocks']) )
	$this->_tpl_vars['section'] = key($this->_tpl_vars['BLOCKS']['mod_advertise_control_panel_blocks']);

{/php}

<br/>

{if isset($BLOCKS.mod_advertise_control_panel_blocks) && is_array($BLOCKS.mod_advertise_control_panel_blocks)}
	{foreach from=$BLOCKS.mod_advertise_control_panel_blocks item=block}
		{$block}
	{/foreach}
{/if}

{/if}