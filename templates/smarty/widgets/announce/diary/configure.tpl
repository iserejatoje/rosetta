<div>
	<input type="checkbox" id="diarymy_{$id}" class="widgetFieldToSave" name="diarymy" value="1"{if $res.my!=0} checked{/if} />
	<label for="diarymy_{$id}"> Показывать мои дневники</label>
</div>
<div>
	<input type="checkbox" id="diarymycomments_{$id}" class="widgetFieldToSave" name="diarymycomments" value="1"{if $res.mycomments!=0} checked{/if} />
	<label for="diarymycomments_{$id}"> Показывать мои комментарии</label>
</div>
<div>
	<input type="checkbox" id="diarylast_{$id}" class="widgetFieldToSave" name="diarylast" value="1"{if $res.last!=0} checked{/if} />
	<label for="diarylast_{$id}"> Показывать последние</label>
</div>

<div><input type="button" class="widgetButtonConfigureApply" value="сохранить" /></div>