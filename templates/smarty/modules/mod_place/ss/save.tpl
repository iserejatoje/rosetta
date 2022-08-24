
{if $page.form.place_id === null}
<div class="title" style="padding:5px;">Добавить компанию</div>
{else}
<div class="title" style="padding:5px;">Редактировать компанию</div>
{/if}

<form method="post" action="" name="{$page.form.action}" enctype="multipart/form-data">
{if $page.form.place_id !== null}
<input type="hidden" name="place" value="{$page.form.place_id}" />
{/if}
<input type="hidden" name="action" value="save_place" />

<table cellpadding="0" cellspacing="2" border="0" width="550" class="table2" align="center">
{if isset($UERROR->ERRORS.sections)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.sections}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">Раздел:</td>
		<td class="bg_color4 text11">

		<script>
			var p = new TV_MultiSelect('/{$ENV.section}/', {literal}
			{max_elements: {/literal}{$page.form.max_sections_ref}{literal},
			prefix: {
			link: 'sa_',
			element: 'se_'
		},
		hold: {
			ui_list: 'ui_sections',
			list: 'sections'
		}
			}{/literal});
			p.render_sections({$page.form.sections});
			p.get_sections({$page.form.root});
			</script>
		</td>
	</tr>

{if isset($UERROR->ERRORS.logotypesmall)}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->ERRORS.logotypesmall}</span></td>
	</tr>
{/if}
{if $page.form.logotypesmall.file != ''}
	<tr>
		<td align="right" class="bg_color2" width="150">&nbsp;</td>
		<td class="bg_color4">
			<img src="{$page.form.logotypesmall.file}" width="{$page.form.logotypesmall.w}" height="{$page.form.logotypesmall.h}" /><br>
			<input type="checkbox" name="del_logotypesmall" id="del_logotypesmall" value="1"> <label for="del_logotypesmall">удалить логотип</label>
		</td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Маленький логотип:</td>
		<td class="bg_color4">
			<input type="file" name="logotypesmall" /><br />
			<span class="tip">Размер логотипа не должен превышать {math equation="size/1024" size=$CONFIG.logotypesmall.file_size}Кб, фотография будет уменьшена до размера {$CONFIG.logotypesmall.img_size.max_width}x{$CONFIG.logotypesmall.img_size.max_height} пикселов.</span>
		</td>
	</tr>
{if isset($UERROR->ERRORS.logotypebig)}
	<tr>
		<td>&nbsp;</td>
		<td class="error"><span>{$UERROR->ERRORS.logotypebig}</span></td>
	</tr>
{/if}
{if $page.form.logotypebig.file != ''}
	<tr>
		<td align="right" class="bg_color2">&nbsp;</td>
		<td class="bg_color4">
			<img src="{$page.form.logotypebig.file}" width="{$page.form.logotypebig.w}" height="{$page.form.logotypebig.h}" /><br>
			<input type="checkbox" name="del_logotypebig" id="del_logotypebig" value="1"> <label for="del_logotypebig">удалить логотип</label>
		</td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2" width="150">Большой логотип:</td>
		<td class="bg_color4">
			<input type="file" name="logotypebig" /><br />
			<span class="tip">Размер логотипа не должен превышать {math equation="size/1024" size=$CONFIG.logotypebig.file_size}Кб, фотография будет уменьшена до размера {$CONFIG.logotypebig.img_size.max_width}x{$CONFIG.logotypebig.img_size.max_height} пикселов.</span>
		</td>
	</tr>

{if isset($UERROR->ERRORS.legaltype)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.legaltype}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">Форма собсвенности:</td>
		<td class="bg_color4">
			<select name="legaltype" style="width:100%;">
{foreach from=$page.form.legaltype_arr item=l key=k}
				<option value="{$k}"{if $l==$page.form.legaltype} selected="selected"{/if}>{$l}</option>
{/foreach}
			</select>
		</td>
	</tr>

{if isset($UERROR->ERRORS.name)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.name}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">Название:</td>
		<td class="bg_color4"><input type="text" name="name" value="{$page.form.name}" maxlength="200" style="width:100%" /></td>
	</tr>

	<tr>
		<td class="bg_color2" align="right" width="130">Руководитель:</td>
		<td class="bg_color4"><input type="text" name="director" value="{$page.form.director}" maxlength="200" style="width:100%" /></td>
	</tr>
	<tr>
		<td class="bg_color2" align="right" width="130">Контактное лицо:</td>
		<td class="bg_color4"><input type="text" name="contact_info_name" value="{$page.form.contact_info_name}" maxlength="250" style="width:100%"/></td>
	</tr>
{if isset($UERROR->ERRORS.contact_info_phone)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.contact_info_phone}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">Телефон:</td>
		<td class="bg_color4"><input type="text" name="contact_info_phone" value="{$page.form.contact_info_phone}" maxlength="100" style="width:100%"/></td>
	</tr>
{if isset($UERROR->ERRORS.contact_info_fax)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.contact_info_fax}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">Факс:</td>
		<td class="bg_color4"><input type="text" name="contact_info_fax" value="{$page.form.contact_info_fax}" maxlength="100" style="width:100%"/></td>
	</tr>
{if isset($UERROR->ERRORS.contact_info_email)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.contact_info_email}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">E-Mail:</td>
		<td class="bg_color4"><input type="text" name="contact_info_email" value="{$page.form.contact_info_email}" maxlength="100" style="width:100%"/></td>
	</tr>
{if isset($UERROR->ERRORS.contact_info_url)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.contact_info_url}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">HTTP:</td>
		<td class="bg_color4"><input type="text" name="contact_info_url" value="{$page.form.contact_info_url}" maxlength="100" style="width:100%"/></td>
	</tr>
{if isset($UERROR->ERRORS.address)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.address}</span></td>
	</tr>
{/if}
	<tr>
		<td align="right" class="bg_color2">Страна:</td>
		<td class="bg_color4">
			<select name="country" onchange="mod_place.change_country(this, 'region', 'city');" style="width:100%;">
				<option value="0">Не указано</option>
{foreach from=$page.form.country_arr item=l key=k}
				<option value="{$k}"{if $k==$page.form.country} selected="selected"{/if}>{$l.name}</option>
{/foreach}
			</select>
		</td>
	</tr>

	<tr>
		<td align="right" class="bg_color2">Область:</td>
		<td class="bg_color4">
			<select name="region" id="region" onchange="mod_place.change_region(this, 'city', 'city_text');" style="width:100%;">
				<option value="0">Не указано</option>
{foreach from=$page.form.region_arr item=l key=k}
				<option value="{$k}"{if $k==$page.form.region} selected="selected"{/if}>{$l.name}</option>
{/foreach}
			</select>
		</td>
	</tr>

	<tr>
		<td align="right" class="bg_color2">Город:</td>
		<td class="bg_color4">
			<select name="city" id="city" onchange="mod_place.change_city(this, 'city_text');" style="width:100%;">
				<option value="0">Не указано</option>
{foreach from=$page.form.city_arr item=l key=k}
				<option value="{$k}"{if $k==$page.form.city} selected="selected"{/if}>{$l.name}</option>
{/foreach}
				<option value="-1"{if -1==$page.form.city} selected="selected"{/if}>Другой</option>
			</select>
		</td>
	</tr>

{if isset($UERROR->ERRORS.city_text)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.city_text}</span></td>
	</tr>
{/if}
	<tr id="city_text_r" {if empty($page.form.city_text) && !isset($UERROR->ERRORS.city_text)} style="display:none" {/if}>
		<td align="right" class="bg_color2">Другой город:</td>
		<td class="bg_color4"><input type="text" id="city_text" name="city_text" value="{$page.form.city_text}" style="width:100%;" /></td>
	</tr>

	<tr>
		<td class="bg_color2" align="right" width="130">Улица:</td>
		<td class="bg_color4"><input type="text" name="street" value="{$page.form.street}" maxlength="100" style="width:100%"/></td>
	</tr>

{if isset($UERROR->ERRORS.house)}
	<tr>
		<td class="bg_color2"></td>
		<td class="error bg_color4"><span>{$UERROR->ERRORS.house}</span></td>
	</tr>
{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">Дом:</td>
		<td class="bg_color4"><input type="text" name="house" value="{$page.form.house}" maxlength="8" /> -
		<input name="house_index" type="text" style="width:23px" value="{$page.form.house_index}" maxlength="2">
		<small>Пример: 37, 29-Б</small></td>
	</tr>

	{if $page.form.address_text}

	<tr>
		<td class="bg_color2" align="right" width="130">Адрес:</td>
		<td class="bg_color4"><input type="text" name="address_text" value="{$page.form.address_text}" maxlength="250" style="width:100%"/></td>
	</tr>

	{/if}
	<tr>
		<td class="bg_color2" align="right" width="130">Дополнительная информация:</td>
		<td class="bg_color4"><textarea name="info" style="width: 100%;height: 200px" />{$page.form.info}</textarea></td>
	</tr>
	<tr>
		<br/><br/><td colspan="2" align="center"><input type="submit" value="Сохранить" />&#160;&#160;<input type="reset" value="Очистить" />&#160;&#160;</td>
	</tr>
</table>
</form><br/><br/>


