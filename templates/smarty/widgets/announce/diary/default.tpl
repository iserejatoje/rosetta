<div class="tip" style="padding-bottom:4px;">
	<a href="{$res.my_all_url}"><font color="#999999">мои записи: {$res.my_count}</font></a>&nbsp;&nbsp;&nbsp;
	<a href="{$res.add_url}"><font color="#999999">добавить</font></a>
</div>
{if count($res.my_messages) > 0}
<div class="t11_grey" style="padding: 4px; text-align: center; font-weight: bold;">мои дневники</div>
{foreach from=$res.my_messages item=l}
<div style="padding-bottom:4px;">
	<div class="tip"><a href="{$l.url}">{if empty($l.name)}без названия{else}{$l.name}{/if}</a></div>
	{if $l.messages>0}<div class="tip" style="padding-bottom:4px;padding-top:2px;">Ответов({$l.messages}): <a href="{$l.url}">{$l.last_date|simply_date}</a></div>
	{else}<div class="tip" style="padding-bottom:4px;padding-top:2px;">Ответов нет</div>{/if}
</div>
{/foreach}
{/if}
{if count($res.myc_messages) > 0}
<div class="t11_grey" style="padding: 4px; text-align: center; font-weight: bold;">мои комментарии</div>
{foreach from=$res.myc_messages item=l}
<div style="padding-bottom:4px;">
	<div class="tip"><a href="{$l.url}">{if empty($l.name)}без названия{else}{$l.name}{/if}</a></div>
	{if $l.messages>0}<div class="tip" style="padding-bottom:4px;padding-top:2px;">Ответов({$l.messages}): <a href="{$l.url}">{$l.last_date|simply_date}</a></div>
	{else}<div class="tip" style="padding-bottom:4px;padding-top:2px;">Ответов нет</div>{/if}
</div>
{/foreach}
{/if}
{if count($res.last_messages) > 0}
<div class="t11_grey" style="padding: 4px; text-align: center; font-weight: bold;">последние комментарии</div>
{foreach from=$res.last_messages item=l}
<div style="padding-bottom:4px;">
	<div class="tip"><a href="{$l.url}">{if empty($l.name)}без названия{else}{$l.name}{/if}</a></div>
	{if $l.messages>0}<div class="tip" style="padding-bottom:4px;padding-top:2px;">Ответов({$l.messages}): <a href="{$l.url}">{$l.last_date|simply_date}</a></div>
	{else}<div class="tip" style="padding-bottom:4px;padding-top:2px;">Ответов нет</div>{/if}
</div>
{/foreach}
{/if}