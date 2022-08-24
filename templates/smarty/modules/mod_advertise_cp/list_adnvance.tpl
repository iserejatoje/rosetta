<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td align="left" class="t1">
<a href="/{$ENV.section}/" class="t1">Вернуться в личный кабинет</a>&nbsp;|&nbsp;
<a href="/{$ENV.section}/add.html" class="t1">Добавить объявление</a>
</td></tr></table>
{*$page.list*}
        {if isset($BLOCKS.mod_advertise_control_panel_blocks) && is_array($BLOCKS.mod_advertise_control_panel_blocks)}
                {foreach from=$BLOCKS.mod_advertise_control_panel_blocks item=block}
                        {$block}
                {/foreach}
        {/if}

