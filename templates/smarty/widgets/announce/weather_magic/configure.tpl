<div style="padding-top:0px;width:320px">
	<input type="checkbox" id="wheathershow_{$id}" class="widgetFieldToSave" name="wheathershow" value="1"{if $res.show!=0} checked{/if} />
	<label for="wheathershow_{$id}"> Показывать погоду</label>
</div>
<div>
	<input type="checkbox" id="wheathercshow_{$id}" class="widgetFieldToSave" name="wheathercshow" value="1"{if $res.cshow!=0} checked{/if} />
	<label for="wheathercshow_{$id}"> Показывать текущую погоду</label>
</div>
<div style="padding-bottom:8px">
	Город 
	<select name="wheathercity" class="widgetFieldToSave">
	{foreach from=$res.cities item=l key=k}
		<option value="{$l.Code}"{if $l.Code==$res.city} selected="selected"{/if}>{$l.Name}</option>
	{/foreach}
	</select>
	<input type="button" class="widgetButtonConfigureApply" value="сохранить" />
</div>