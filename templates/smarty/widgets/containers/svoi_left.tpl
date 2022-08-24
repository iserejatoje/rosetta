<div align="right" class="block_title" style="text-align: right; padding-right: 6px; padding-left:0px; position:relative; ">
{strip}<div align="left"><div style="position:absolute;left:4px;top:4px;width:69px;height:10px; text-align:left;float:left;">
	{if $config.is_closable}
		<div class="{if $config.is_showed}widgetButtonCloseOpenedImg{else}widgetButtonCloseClosedImg{/if} widgetButtonCloseObj widgetButtonClose widgetButtonTitle" title="свернуть / развернуть" style="float:left;"> </div>
	{/if}	
	{if $config.is_configurable}
		<div class="widgetButtonConfigureImg widgetButtonConfigure widgetButtonTitle" title="настройка" style="padding-left:2px;"><div style="margin-top: -3px; text-decoration:underline; margin-left:5px; font-size: 10px; color: #efefef; text-align: left;float:left;">настр.</div></div>
	{/if}	
	</div></div>{/strip}
	<span>{$title}</span>
</div>
<div class="widgetConfigure" style="display:none"></div>
<div class="widgetContent">{$page}</div>
