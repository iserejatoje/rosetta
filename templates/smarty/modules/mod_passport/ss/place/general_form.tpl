<div align="center" style="margin-top:20px">
	<table align="center" border="0" cellpadding="3" cellspacing="2" width="550">
		<tr>
			<td class="bg_color2" colspan="3" align="right"><a href="javascript:void(0)" 
onclick="$(this.parentNode.parentNode.parentNode.parentNode.parentNode).remove();" class="text11">Удалить</a></td>
		</tr>
		{php}if ( !empty($this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['type'].'_'.$this->_tpl_vars['res']['position'].'_place']) ) {{/php}
			<tr>
				<td class="bg_color2">&nbsp;</td>
				<td class="bg_color4 error"><span>{php}
					echo $this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['type'].'_'.$this->_tpl_vars['res']['position'].'_place'];
				{/php}</span></td>
			</tr>
		{php} } {/php}
		{php}if ( !empty($this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['type'].'_'.$this->_tpl_vars['res']['position'].'_address']) ) {{/php}
			<tr>
				<td class="bg_color2">&nbsp;</td>
				<td class="bg_color4 error"><span>{php}
					echo $this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['type'].'_'.$this->_tpl_vars['res']['position'].'_address'];
				{/php}</span></td>
			</tr>
		{php} } {/php}
		<tr>
			<td align="right" class="bg_color2" width="150">Страна</td>
			<td class="bg_color4" width="400">
				<select name="place[{$res.placeinfo.type}][country][]" onchange="mod_passport.change_country(this, 'region{$res.placeinfo.fix}', 'city{$res.placeinfo.fix}');" style="width:100%;">
					<option value="0">Не указано</option>
					{foreach from=$res.country_arr item=w key=k
						}<option value="{$k}"{if $k==$res.placeinfo.country} selected="selected"{/if}>{$w.name}</option>{
					/foreach}
				</select>
			</td>
		</tr>
		
		<tr>
			<td align="right" class="bg_color2">Область</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][region][]" id="region{$res.placeinfo.fix}" onchange="mod_passport.change_region(this, 'city{$res.placeinfo.fix}', 'city_text{$res.placeinfo.fix}');" style="width:100%;">
					<option value="0">Не указано</option>
					{foreach from=$res.region_arr item=w key=k
						}<option value="{$k}"{if $k==$res.placeinfo.region} selected="selected"{/if}>{$w.name}</option>{
					/foreach}
				</select>
			</td>
		</tr>
		
		<tr>
			<td align="right" class="bg_color2">Город</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][city][]" id="city{$res.placeinfo.fix}" onchange="mod_passport.change_city(this, 'city_text{$res.placeinfo.fix}');" style="width:100%;">
					<option value="0">Не указано</option>
					{foreach from=$res.city_arr item=w key=k
						}<option value="{$k}"{if $k==$res.placeinfo.city} selected="selected"{/if}>{$w.name}</option>{
					/foreach}
					<option value="-1"{if $res.placeinfo.city <= 0 && $res.placeinfo.citytext} selected="selected"{/if}>Другой</option>
				</select>
			</td>
		</tr>
		
		<tr id="city_text{$res.placeinfo.fix}_r" {if empty($res.placeinfo.citytext)} style="display:none" {/if}>
			<td align="right" class="bg_color2">Другой город</td>
			<td class="bg_color4"><input type="text" id="city_text{$res.placeinfo.fix}" name="place[{$res.placeinfo.type}][city_text][]" value="{$res.placeinfo.citytext}" style="width:100%;" /></td>
		</tr>
		
		<tr>
			<td align="right" class="bg_color2">Место работы</td>
			<td class="bg_color4">
				<input id="place{$res.placeinfo.fix}" type="hidden" name="place[{$res.placeinfo.type}][id][]" value="{$res.placeinfo.placeid}" />
				{if $res.placeinfo.placeid}
					<input type="hidden" name="place[{$res.placeinfo.type}][name][]" value="" />
				{/if}
				<input id="suggest{$res.placeinfo.fix}" type="text" {if $res.placeinfo.placeid} disabled="disabled" readonly="readonly" {else} name="place[{$res.placeinfo.type}][name][]"{/if} value="{$res.placeinfo.name}" style="width:100%;" />
				
				{if $res.with_suggest === true}<script>
											<!--
											{literal}
											$(document).ready(function() {

				$('#suggest{/literal}{$res.placeinfo.fix}{literal}').suggest("/service/source/db.place", {
						maxCacheSize: -1,
						minchars: 2,
						action: 'search',
						delay: 450,
						onSelect: function(value, key) { 
							var $value = $('#place{/literal}{$res.placeinfo.fix}{literal}').get(0).value;
							if ( $value && key != $value ) {
								mod_passport.removePlace($value, {/literal}{$res.placeinfo.type}{literal});
							}
							$('#place{/literal}{$res.placeinfo.fix}{literal}').get(0).value = key;
						},
						onSuggest: function() { 
							var city = $('#city{/literal}{$res.placeinfo.fix}{literal}').get(0);
							var city_text = $('#city_text{/literal}{$res.placeinfo.fix}{literal}');
						
							city = city.options[city.selectedIndex].value > 0 ? city.options[city.selectedIndex].text : city_text.val();
							this.data.city = '';
							this.data.type = {/literal}{$res.placeinfo.type}{literal};
							
							if ( city != '' )
								this.data.city = city;
							else
								alert('Пожалуйста укажите город!');
						}
					}
				);
				
				 });{/literal}

				//-->
				</script>{/if}
			</td>
		</tr>
		
		<tr>
			<td align="right" class="bg_color2">Должность</td>
			<td class="bg_color4">
				<input type="text" name="place[{$res.placeinfo.type}][position][]" value="{$res.placeinfo.position}" style="width:100%;" />
			</td>
		</tr>
		
		<tr>
			<td align="right" class="bg_color2">Год начала работы</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][y_start][]" style="width:100%;">
					<option value="0">- Выберите год -</option>
					{foreach from=$res.years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.y_start} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
			</td>
		</tr>
		{php}if ( !empty($this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['type'].'_'.$this->_tpl_vars['res']['position'].'_yearend']) ) {{/php}
			<tr>
				<td class="bg_color2">&nbsp;</td>
				<td class="bg_color4 error"><span>{php}
					echo $this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['type'].'_'.$this->_tpl_vars['res']['position'].'_yearend'];
				{/php}</span></td>
			</tr>
		{php} } {/php}
		<tr>
			<td align="right" class="bg_color2">Год окончания работы</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][y_end][]" style="width:100%;">
					<option value="0">- Выберите год -</option>
					<option value="0"{if $res.placeinfo.y_end == 0} selected="selected"{/if}>По настоящее время</option>
					{foreach from=$res.years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.y_end} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
			</td>
		</tr>
	</table>
	
</div>