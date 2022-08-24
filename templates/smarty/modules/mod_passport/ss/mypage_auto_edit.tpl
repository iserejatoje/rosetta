<script type="text/javascript" language="javascript" src="/_scripts/modules/passport/auto.js"></script>

<form style="margin:0px" method="POST" enctype="multipart/form-data">
<input type="hidden" name="action" value="{$page.action}" />
{if $page.action=='mypage_auto_edit'}<input type="hidden" name="id" value="{$page.id}" />{/if}
<div class="title">{if $page.action=='mypage_auto_add'}Добавление автомобиля{else}Редактирование автомобиля{/if}</div>

<table border="0" cellpadding="3" cellspacing="2" width="550" class="table">
<tr>
	<td class="bg_color2" align="right">Марка</td>
	<td class="bg_color4">
		<select id="marka" name="MarkaID" value="{$page.car.MarkaID}" style="width:100%" onchange="mod_passport_auto.requestModels();" />
			{if $page.action=='mypage_auto_add'}<option value="-1">-- Выберите марку --</option>{/if}
			{foreach from=$page.tree item=l}				
				{if $l.has_children}
					<optgroup label="{$l.name}">
				{else}
					<option value="{$l.id}"{if $page.car.MarkaID==$l.id} selected{/if}>{$l.name}</option>
				{/if}
				{foreach from=$l.marka item=m}
					<option value="{$m.id}"{if $page.car.MarkaID==$m.id} selected{/if}>{$m.name}</option>
				{/foreach}
				{if $l.has_children}
					</optgroup>
				{/if}
			{/foreach}
		</select>
	</td>
	<td width="20"></td>
</tr>
<tr>
	<td class="bg_color2" align="right">Модель</td>
	<td class="bg_color4">
		<div id="model_container" style="width:100%">
			<select id="model" name="ModelID" style="width:100%; {if $page.car.ModelID==0 && $page.action=='mypage_auto_edit'}display:none{/if}" onchange="mod_passport_auto.showOther();" {if count($page.models) <= 0} disabled="disabled"{/if}>
				<option value="-1">-- Выберите модель --</option>
				{foreach from=$page.models item=l}
					<option value="{$l.id}"{if $page.car.ModelID == $l.id} selected="selected"{/if}>{$l.name}</option>
				{/foreach}
			</select>
		</div>
		<div id="model_text_container">
			<input id="model_text" type="text" name="ModelName" value="{$page.car.ModelName}" style="margin-top:2px;width:100%;{if $page.car.ModelID>0 && $page.models[$page.car.ModelID].name!='Другие'}display:none{/if}" />
		</div>
	</td>
	<td>
		<div style="display:none" id="wait"><img src="/_img/themes/frameworks/jquery/ajax/loader-small.gif" /></div>
	</td>
</tr>
{if $UERROR->GetErrorByIndex('markamodel') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('markamodel')}</span></td>
	</tr>
{/if}






<tr>
	<td class="bg_color2" align="right">Год выпуска</td>
	<td class="bg_color4">
		<select name="Year">
			<option value="0">- задайте год выпуска-</option>
		{foreach from=$page.years item=year}
			<option value="{$year}"{if $page.car.Year==$year} selected="selected"{/if}>{$year}</option>
		{/foreach}
		</select>
	</td>
</tr>
{if $UERROR->GetErrorByIndex('year') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('year')}</span></td>
	</tr>
{/if}
<tr>
	<td class="bg_color2" align="right">Объем двигателя</td>
	<td class="bg_color4">
		<input type="text" id="volume" name="Volume" value="{if $page.car.Volume>0}{$page.car.Volume}{/if}" style="width:100%" /><br/>
		<span class="tip">Объем двигателя см<sup>3</sup></span>
	</td>
	<td></td>
</tr>
{if $UERROR->GetErrorByIndex('volume') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('volume')}</span></td>
	</tr>
{/if}
<tr>
	<td class="bg_color2" align="right">Тип руля</td>
	<td class="bg_color4">
		<input type="radio" id="wheeltype0" name="WheelType" value="0"{if $page.car.WheelType==0} checked="checked"{/if} /> <label for="wheeltype0">Левый</label>&nbsp;&nbsp;
		<input type="radio" id="wheeltype1" name="WheelType" value="1"{if $page.car.WheelType==1} checked="checked"{/if} /> <label for="wheeltype1">Правый</label>
	</td>
	<td></td>
</tr>
{if $UERROR->GetErrorByIndex('wheeltype') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('wheeltype')}</span></td>
	</tr>
{/if}

{if !empty($page.car.small_photo.url)}
<tr>
	<td class="bg_color2" align="right"></td>
	<td class="bg_color4">
		<img src="{$page.car.small_photo.url}" border="0" width="{$page.car.small_photo.w}" height="{$page.car.small_photo.h}"/>
		{if $page.action=='mypage_auto_edit'}
		<br/><input type="checkbox" name="del_photo" id="del_photo" value="1" /> <label for="del_photo">Удалить фото</label>
		{/if}
	</td>
	<td></td>
</tr>
{/if}
<tr>
	<td class="bg_color2" align="right">Фото</td>
	<td class="bg_color4">
		<input type="file" name="Photo"/><br/>
		<span class="tip">Размер фотографии не должен превышать 1Mb<br/>Фотография будет уменьшена до размера {$CONFIG.auto_photo.large.params.resize.w}x{$CONFIG.auto_photo.large.params.resize.h} пикселов.</span>
	</td>
	<td></td>
</tr>
{if $UERROR->GetErrorByIndex('photo') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('photo')}</span></td>
	</tr>
{/if}




<tr>
	<td class="bg_color2" align="right">Вместимость</td>
	<td class="bg_color4">
		<input type="text" id="capacity" name="Capacity" value="{$page.car.Capacity}" style="width:100%" /><br/>
		<span class="tip">Количество пассажирских мест в автомобиле</span>
	</td>
	<td></td>
</tr>
{if $UERROR->GetErrorByIndex('capacity') != ''}
	<tr>
		<td>&nbsp;</td>
		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('capacity')}</span></td>
	</tr>
{/if}
</table>

<br/>
<div align="center"><input type="submit" value="Сохранить" /> <input type="button" value="Отмена" onclick="window.history.go(-1);" /></div>
<br/>
</form>

