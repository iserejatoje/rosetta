<div id="widgetContainer{$id}" class="widgetContainer">
	<table width="100%">
		<tr>
			<td style="background-color:red;color:white;">{$title}</td>
		</tr>
		{if $config.is_closable}
		<tr>
			<td style="background-color:red;color:white;" class="widgetButtonClose">закрыть/открыть</td>
		</tr>
		{/if}
		{if $config.is_configurable}
		<tr>
			<td style="background-color:red;color:white;" class="widgetButtonConfigure">настрйки</td>
		</tr>
		{/if}
		<tr>
			<td>
				<div class="widgetConfigure" style="display:none"></div>
				<div class="widgetContent">
					{$page}
				</div>
			</td>
		</tr>
	</table>
</div>
<hr>