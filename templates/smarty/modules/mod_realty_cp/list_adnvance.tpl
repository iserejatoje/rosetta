{php}

if ( isset($this->_tpl_vars['BLOCKS']['mod_advertise_control_panel_blocks']) && is_array($this->_tpl_vars['BLOCKS']['mod_advertise_control_panel_blocks']) )
	$this->_tpl_vars['section'] = key($this->_tpl_vars['BLOCKS']['mod_advertise_control_panel_blocks']);

{/php}

<table width="100%" cellspacing="0" border="0" class="table2">
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td>
{if $smarty.get.id}
<a href="/{$ENV.section}/{$smarty.get.id}.html">Вернуться на страницу организации</a>
{else}
<a href="/{$ENV.section}/">Вернуться в личный кабинет</a>{if !empty($section)}&nbsp;|&nbsp;
<a href="/{$section}/add.html">Добавить объявление</a>{/if}
{/if}
</td></tr></table><br/><br/>

{*$page.list*}
        {if isset($BLOCKS.mod_advertise_control_panel_blocks) && is_array($BLOCKS.mod_advertise_control_panel_blocks)}
                {foreach from=$BLOCKS.mod_advertise_control_panel_blocks item=block}
                        {$block}
                {/foreach}
	{/if}
