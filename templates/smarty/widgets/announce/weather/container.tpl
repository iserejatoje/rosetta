<div style="position:relative;text-align:left;width:300px;padding-left:10px;padding-right:10px;">
	<div style="float:left;padding-right:10px;">
		<div class="txt_color5" style="font-size:20px;margin-bottom:3px;">Погода</div>
		{if $config.is_configurable}
			<div class="widgetButtonConfigure widgetButtonTitle txt_color5" style="font-size:10px;text-decoration:underline;" title="настройка"><div style="margin-top: -2px;text-align:center;">настройки</div></div>
		{/if}
	</div>
	<div class="bg_color3" style="width:3px;height:64px;float:left;margin-top:3px;"></div>
	<div class="widgetConfigure bg_color2" style="display:none;position:absolute;top:0px;left:0px;text-align:left;z-index:999;width:320px;"></div>
	<div class="widgetContent" style="float: left; position: relative; width: 200px; padding-left:10px;">{$page}</div>
</div>