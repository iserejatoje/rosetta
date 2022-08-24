<div align="left" class="block_title" style="text-align: left; padding-left: 6px; padding-right:0px; position:relative; position:relative;">
{strip}<div style="position:absolute;right:4px;top:4px;width:69px;height:10px;">
	{if $config.is_closable}
		<div class="{if $config.is_showed}widgetButtonCloseOpenedImg{else}widgetButtonCloseClosedImg{/if} widgetButtonCloseObj widgetButtonClose widgetButtonTitle" title="свернуть / развернуть"> </div>
	{/if}	
	{if $config.is_configurable}
		<div class="widgetButtonConfigureImg widgetButtonConfigure widgetButtonTitle" title="настройка" style="padding-right:2px;"><div style="margin-top: -3px; text-decoration: underline; font-size: 10px; color: #efefef; text-align: left;">настр.</div></div>
	{/if}	
	</div>{/strip}
	<span>{$title}</span>
</div>
<div class="widgetConfigure" style="display:none"></div>
<div class="widgetContent">{$page}</div>
