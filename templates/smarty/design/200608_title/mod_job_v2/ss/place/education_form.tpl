{if ($placeType && $placeType == $res.placeinfo.TypeID && ($res.placeinfo.TypeID == constant('PlaceSimpleMgr::PT_HIGHER_EDUCATION') || $res.placeinfo.TypeID == constant('PlaceSimpleMgr::PT_SECONDARY_SPECIAL_EDUCATION'))) || ( !$placeType && ($res.placeinfo.TypeID == constant('PlaceSimpleMgr::PT_HIGHER_EDUCATION') || $res.placeinfo.TypeID == constant('PlaceSimpleMgr::PT_SECONDARY_SPECIAL_EDUCATION')) )}
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
				<td class="bg_color4error"><span>{php}
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
			<td class="bg_color2" align="right" width="140">Город</td>
			<td>
				<input type="hidden" name="place[{$res.placeinfo.TypeID}][id][]">
				<input type="hidden" value="{$res.placeinfo.CountryCode}" id="country{$res.placeinfo.fix}" name="place[{$res.placeinfo.TypeID}][CountryCode][]" />

				<select name="place[{$res.placeinfo.TypeID}][CityCode][]" id="city{$res.placeinfo.fix}"
				onchange="$('#suggest{$res.placeinfo.fix}').setOptions{literal}({
					extraParams: {code: this.value,action: 'search_place', type: {/literal}{$res.placeinfo.TypeID}{literal}}});{/literal}Address.ChangeCity('country{$res.placeinfo.fix}', 'city{$res.placeinfo.fix}')" style="width:100%;">
					<option value="0"> - Выберите город - </option>
					{foreach from=$res.city_arr item=w key=k
						}<option value="{$w.Code}"{if $w.Code==$res.placeinfo.CityCode} selected="selected"{/if}>{$w.Name}</option>{
					/foreach}
					<option value="-1"> - Другой - </option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="bg_color2" align="right" width="140">
				{if $res.placeinfo.TypeID == constant('PlaceSimpleMgr::PT_HIGHER_EDUCATION')}
					ВУЗ
				{elseif $res.placeinfo.TypeID == constant('PlaceSimpleMgr::PT_SECONDARY_SPECIAL_EDUCATION')}
					Колледж или ПТУ
				{/if}
			</td>
			<td class="bg_color4">
				<input type="text" value="{$res.placeinfo.Name}" name="place[{$res.placeinfo.TypeID}][Name][]" style="width:100%;" />
			</td>
		</tr>

		<tr>
			<td class="bg_color2" align="right" width="140">Факультет</td>
			<td class="bg_color4">
				<input type="text" name="place[{$res.placeinfo.TypeID}][Faculty][]" value="{$res.placeinfo.Faculty.Name}" style="width:100%;"  maxlength="255" />
			</td>
		</tr>		
		<tr>
			<td class="bg_color2" align="right" width="140">Кафедра</td>
			<td class="bg_color4">
				<input type="text" name="place[{$res.placeinfo.TypeID}][Chair][]" value="{$res.placeinfo.Chair.Name}" style="width:100%;"  maxlength="255" />
			</td>
		</tr>		
		<tr>
			<td class="bg_color2" align="right" width="140">Форма обучения</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.TypeID}][Course][]" style="width:100%;">
					<option value="0">- Выберите форму обучения -</option>
					{foreach from=$res.course_form_arr item=w key=k}
					<option value="{$k}"{if $k==$res.placeinfo.Course} selected="selected"{/if}>{$w}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td class="bg_color2" align="right" width="140">Текущий статус</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.TypeID}][Status][]" style="width:100%;">
					<option value="0">- Выберите статус -</option>
					{foreach from=$res.status_arr item=w key=k
						}<option value="{$k}"{if $k==$res.placeinfo.Status} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
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
			<td class="bg_color2" align="right" width="140"valign="top" style="padding-top:7px">Период обучения</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.TypeID}][YearStart][]" style="width:18%;">
					<option value="0">-год-</option>
					{foreach from=$res.years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.YearStart} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				-
				<select name="place[{$res.placeinfo.TypeID}][YearEnd][]" style="width:28%;">
					<option value="0">-год-</option>
					<option value="0"{if $res.placeinfo.YearEnd == 0} selected="selected"{/if}>Наст. время</option>
					{foreach from=$res.grad_years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.YearEnd} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				<br/><small><span style="color:#808080">Если вы в настоящее время проходите обучение на указанном месте, год окончания указывать не нужно.</span></small>
			</td>
		</tr>
	</tbody>
{elseif ($placeType && $placeType == $res.placeinfo.TypeID && $res.placeinfo.TypeID == constant('PlaceSimpleMgr::PT_SECONDARY_EDUCATION')) || (!$placeType && $res.placeinfo.TypeID == constant('PlaceSimpleMgr::PT_SECONDARY_EDUCATION'))}
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
				<td class="bg_color4error"><span>{php}
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
			<td class="bg_color2" align="right" width="140">Город</td>
			<td>
                <input type="hidden" name="place[{$res.placeinfo.TypeID}][id][]">
				<input type="hidden" value="{$res.placeinfo.CountryCode}" id="country{$res.placeinfo.fix}" name="place[{$res.placeinfo.TypeID}][CountryCode][]" />
				<select name="place[{$res.placeinfo.TypeID}][CityCode][]" id="city{$res.placeinfo.fix}"
				onchange="$('#suggest{$res.placeinfo.fix}').setOptions{literal}({
					extraParams: {code: this.value,action: 'search_place', type: {/literal}{$res.placeinfo.TypeID}{literal}}});{/literal}Address.ChangeCity('country{$res.placeinfo.fix}', 'city{$res.placeinfo.fix}')" style="width:100%;">
					<option value="0"> - Выберите город - </option>
					{foreach from=$res.city_arr item=w key=k
						}<option value="{$w.Code}"{if $w.Code==$res.placeinfo.CityCode} selected="selected"{/if}>{$w.Name}</option>{
					/foreach}
					<option value="-1"> - Другой - </option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right" class="bg_color2">Школа</td>
			<td class="bg_color4">
				<input id="suggest{$res.placeinfo.fix}" type="text" name="place[{$res.placeinfo.TypeID}][Name][]" value="{$res.placeinfo.Name}" style="width:100%;" />
			</td>
		</tr>
		
		<tr>
			<td align="right" class="bg_color2">Год начала обучения</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.TypeID}][YearStart][]" style="width:100%;">
					<option value="0">- Выберите год -</option>
					{foreach from=$res.years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.YearStart} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
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
			<td align="right" class="bg_color2">Год окончания обучения</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.TypeID}][YearEnd][]" style="width:100%;">
					<option value="0">- Выберите год -</option>
					<option value="0"{if $res.placeinfo.YearEnd == 0} selected="selected"{/if}>По настоящее время</option>
					{foreach from=$res.grad_years_arr item=w}<option value="{$w}"{if $w==$res.placeinfo.YearEnd} selected="selected"{/if}>{$w}</option>{/foreach}
				</select>
			</td>
		</tr>
						
		<tr>
			<td align="right" class="bg_color2">Класс (а, б..)</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.TypeID}][Class][]" style="width:100%;">
					<option value="0">- Выберите класс -</option>
					{foreach from=$res.class_arr item=w key=k
						}<option value="{$k}"{if $w==$res.placeinfo.Class} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
			</td>
		</tr>
		
		<tr>
			<td align="right" class="bg_color2">Специализация</td>
			<td class="bg_color4">
				<input type="text" name="place[{$res.placeinfo.TypeID}][Chair][]" value="{$res.placeinfo.Chair.Name}" style="width:100%;" maxlength="255" />
			</td>
		</tr>
	</tbody>
{/if}