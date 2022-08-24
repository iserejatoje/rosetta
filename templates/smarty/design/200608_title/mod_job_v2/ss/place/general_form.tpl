	{*<table cellpadding="0" cellspacing="2" width="100%" class="table2" id="pl{$res.placeinfo.fix}">*}
	<tbody id="pl{$res.placeinfo.fix}">
		<tr>
			<td class="bg_color2" colspan="2" align="right">
				<div style="float:right;"><a href="javascript:void(0)" onclick="$('#pl{$res.placeinfo.fix}').remove();"><small>Удалить</small></a></div>
				<div style="float:right;"><a href="javascript:void(0)" onclick="$('#pl{$res.placeinfo.fix}').remove();"><img src="/_img/design/200608_title/bullet_delete.gif" border="0" alt="Удалить" vspace="3" hspace="4"/></a></div>
			</td>
		</tr>
		{php}if ( !empty($this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['TypeID'].'_'.$this->_tpl_vars['res']['position'].'_place']) ) {{/php}
			<tr>
				<td class="bg_color2">&nbsp;</td>
				<td class="bg_color4 error"><span>{php}
					echo $this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['TypeID'].'_'.$this->_tpl_vars['res']['position'].'_place'];
				{/php}</span></td>
			</tr>
		{php} } {/php}
		{php}if ( !empty($this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['TypeID'].'_'.$this->_tpl_vars['res']['position'].'_address']) ) {{/php}
			<tr>
				<td class="bg_color2">&nbsp;</td>
				<td class="bg_color4 error"><span>{php}
					echo $this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['TypeID'].'_'.$this->_tpl_vars['res']['position'].'_address'];
				{/php}</span></td>
			</tr>
		{php} } {/php}


		<tr>
			<td class="bg_color2" align="right" width="140"valign="top" style="padding-top:7px">Город</td>
			<td class="bg_color4">
				<input type="hidden" name="place[{$res.placeinfo.TypeID}][id][]">
				<input type="hidden" value="{$res.placeinfo.CountryCode}" id="country{$res.placeinfo.fix}" name="place[{$res.placeinfo.TypeID}][CountryCode][]" />

				<select name="place[{$res.placeinfo.TypeID}][CityCode][]" id="city{$res.placeinfo.fix}"
				onchange="$('#suggest{$res.placeinfo.fix}').setOptions{literal}({
					extraParams: {code: this.value, action: 'search_place', type: {/literal}{$res.placeinfo.TypeID}{literal}}});{/literal}Address.ChangeCity('country{$res.placeinfo.fix}', 'city{$res.placeinfo.fix}')" style="width:100%;">
					<option value="0"> - Выберите город - </option>
					{foreach from=$res.city_arr item=w key=k
						}<option value="{$w.Code}"{if $w.Code==$res.placeinfo.CityCode} selected="selected"{/if}>{$w.Name}</option>{
					/foreach}
					<option value="-1"> - Другой - </option>
				</select>
			</td>
		</tr>


		<tr>
			<td class="bg_color2" align="right" width="140"valign="top" style="padding-top:7px">Место работы</td>
			<td class="bg_color4">
				<input type="text" name="place[{$res.placeinfo.TypeID}][Name][]" value="{$res.placeinfo.Name}" style="width:100%;" />
			</td>
		</tr>
		
		{php}if ( !empty($this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['TypeID'].'_'.$this->_tpl_vars['res']['position'].'_yearend']) ) {{/php}
			<tr>
				<td class="bg_color2">&nbsp;</td>
				<td class="bg_color4 error"><span>{php}
					echo $this->_tpl_vars['UERROR']->ERRORS['place_'.$this->_tpl_vars['res']['placeinfo']['TypeID'].'_'.$this->_tpl_vars['res']['position'].'_yearend'];
				{/php}</span></td>
			</tr>
		{php} } {/php}
		
		<tr>
			<td class="bg_color2" align="right" width="140"valign="top" style="padding-top:7px">Период</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.TypeID}][YearStart][]" style="width:18%;">
					<option value="0">-год-</option>
					{foreach from=$res.years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.YearStart} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				<select name="place[{$res.placeinfo.TypeID}][MonthStart][]" style="width:24%;">
					<option value="0">-месяц-</option>
					{foreach from=$res.months_arr key=m item=w
						}<option value="{$m}"{if $m==$res.placeinfo.MonthStart} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				-
				<select name="place[{$res.placeinfo.TypeID}][YearEnd][]" style="width:28%;">
					<option value="0">-год-</option>
					<option value="0"{if $res.placeinfo.YearEnd == 0} selected="selected"{/if}>Наст. время</option>
					{foreach from=$res.years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.YearEnd} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				<select name="place[{$res.placeinfo.TypeID}][MonthEnd][]" style="width:24%;">
					<option value="0">-месяц-</option>
					{foreach from=$res.months_arr key=m item=w
						}<option value="{$m}"{if $m==$res.placeinfo.MonthEnd} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				<br/><small><span style="color:#808080">Если вы в настоящее время работаете на указанном месте, год и месяц окончания указывать не нужно.</span></small>
			</td>
		</tr>

		<tr>
			<td class="bg_color2" align="right" width="140"valign="top" style="padding-top:7px">Должность</td>
			<td class="bg_color4">
				<input type="text" name="place[{$res.placeinfo.TypeID}][Position][]" value="{$res.placeinfo.Position}" style="width:100%;" />
			</td>
		</tr>
		
		<tr>
			<td class="bg_color2" align="right" width="140"valign="top" style="padding-top:7px">Опыт работы</td>
			<td class="bg_color4">
				<textarea name="place[{$res.placeinfo.TypeID}][Comment][]" rows="3" style="width:100%">{$res.placeinfo.Comment}</textarea>
				<br/><small><span style="color:#808080">Перечислите коротко: должностные обязанности, значительные проекты, достижения.</span></small>
			</td>
		</tr>
	</tbody>
	{*</table>*}