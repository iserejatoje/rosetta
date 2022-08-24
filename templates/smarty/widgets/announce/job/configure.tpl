<div>
	<input type="checkbox" id="jobfavoritesvacancy_{$id}" class="widgetFieldToSave" name="jobfavoritesvacancy" value="1"{if $res.favoritesvacancy!=0} checked{/if} />
	<label for="jobfavoritesvacancy_{$id}"> Избранные вакансии</label>
</div>
<div>
	<input type="checkbox" id="jobfavoritesresume_{$id}" class="widgetFieldToSave" name="jobfavoritesresume" value="1"{if $res.favoritesresume!=0} checked{/if} />
	<label for="jobfavoritesresume_{$id}"> Избранные резюме</label>
</div>
<div style="padding-top:8px;">
	<div class="widgetTitle">новые</div>
	<table width="100%" cellspacing="0" cellpadding="4">
		<tr>
			<td width="50%" id="jobvactab_{$id}" style="background-color:#F7F4D4;" onmouseover="$('#jobvactab_{$id}').css('background-color', '#F7F4D4');$('#jobrestab_{$id}').css('background-color', '#FFFFFF');$('#joblvac_{$id}').show();$('#joblres_{$id}').hide();">
				<input type="checkbox" class="widgetFieldToSave" name="joblastvacancy" value="1"{if $res.lastvacancy!=0} checked{/if} />
				вакансии
			</td>
			<td width="50%" id="jobrestab_{$id}" onmouseover="$('#jobvactab_{$id}').css('background-color', '#FFFFFF');$('#jobrestab_{$id}').css('background-color', '#EDF7F7');$('#joblvac_{$id}').hide();$('#joblres_{$id}').show();">
				<input type="checkbox" class="widgetFieldToSave" name="joblastresume" value="1"{if $res.lastresume!=0} checked{/if} />
				резюме
			</td>
		</tr>
	</table>
</div>
<div style="height:200px;overflow:auto;background-color:#F7F4D4" id="joblvac_{$id}" class="widgetList">
{foreach from=$res.sections item=l}
<input type="checkbox" id="jobvacfavsec_{$id}_{$l.id}" name="jobvacfavsec[]" value="{$l.id}" class="widgetCheckBox widgetFieldToSave"{if in_array($l.id, $res.vacfavsec)} checked="checked"{/if}><label for="jobvacfavsec_{$id}_{$l.id}"> {$l.name}</label><br>
{/foreach}
</div>
<div style="height:200px;overflow:auto;display:none;background-color:#EDF7F7" id="joblres_{$id}" class="widgetList">
{foreach from=$res.sections item=l}
<input type="checkbox" id="jobresfavsec_{$id}_{$l.id}" name="jobresfavsec[]" value="{$l.id}" class="widgetCheckBox widgetFieldToSave"{if in_array($l.id, $res.resfavsec)} checked="checked"{/if}><label for="jobresfavsec_{$id}_{$l.id}"> {$l.name}</label><br>
{/foreach}
</div>
<div><input type="button" class="widgetButtonConfigureApply" value="сохранить" /></div>