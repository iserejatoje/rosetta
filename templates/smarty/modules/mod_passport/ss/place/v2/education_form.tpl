{if $res.placeinfo.type == constant('PlaceSimpleMgr::PT_HIGHER_EDUCATION')}
<div style="margin-top:20px">
	<table border="0" cellpadding="3" cellspacing="2" width="550">
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
				<select id="country{$res.placeinfo.fix}" name="place[{$res.placeinfo.type}][country][]" onchange="Address.ChangeCountry('country{$res.placeinfo.fix}', 'city{$res.placeinfo.fix}');" style="width:100%;">
					<option value="0"> - Выберите страну - </option>
					{foreach from=$res.country_arr item=w
						}<option value="{$w.Code}"{if $w.Code==$res.placeinfo.countrycode} selected="selected"{/if}>{$w.Name}</option>{
					/foreach}
					<option value="-1"> - Полный список - </option>
				</select>
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Город</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][city][]" id="city{$res.placeinfo.fix}"
				onchange="$('#suggest{$res.placeinfo.fix}').setOptions{literal}({
					extraParams: {code: this.value,action: 'search_place', type: {/literal}{$res.placeinfo.type}{literal}}});{/literal}Address.ChangeCity('country{$res.placeinfo.fix}', 'city{$res.placeinfo.fix}')" style="width:100%;">
					<option value="0"> - Выберите город - </option>
					{foreach from=$res.city_arr item=w key=k
						}<option value="{$w.Code}"{if $w.Code==$res.placeinfo.citycode} selected="selected"{/if}>{$w.Name}</option>{
					/foreach}
					<option value="-1"> - Другой - </option>
				</select>
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Вуз</td>
			<td class="bg_color4">
				<input id="place{$res.placeinfo.fix}" type="hidden" name="place[{$res.placeinfo.type}][id][]" value="{$res.placeinfo.placeid}" />
				{if $res.placeinfo.placeid}
					<input type="hidden" name="place[{$res.placeinfo.type}][name][]" value="" />
				{/if}
				<input id="suggest{$res.placeinfo.fix}" type="text" value="{$res.placeinfo.name}" {if $res.placeinfo.placeid} disabled="disabled" readonly="readonly" {else} name="place[{$res.placeinfo.type}][name][]" {/if} style="width:100%;" />

				{if $res.with_suggest === true}<script>
											<!--
											{literal}
									$(document).ready(function() {

			$('#suggest{/literal}{$res.placeinfo.fix}{literal}').autocomplete("/service/source/db.place",{
			extraParams: {
				action: 'search_place',
				type: '{/literal}{$res.placeinfo.type}{literal}',
				code: '{/literal}{$res.placeinfo.city}{literal}'
			},
			dataType: 'json',
			parse: function(json) {
				var parsed = [];

				if ( !json || !json.length )
					return parsed;

				for (var i in json)
					parsed[parsed.length] = {
						data: json[i].Name,
						value: json[i].PlaceID,
						result: json[i].Name
					};

				return parsed;
			},
			formatItem: function(text, i, max, value) {
				return text;
			},
			max: 20
		}).result(
			function(event, Name, Code) {
				$('#place{/literal}{$res.placeinfo.fix}{literal}').val(Code);
				$('#faculty_suggest{/literal}{$res.placeinfo.fix}{literal}').val('');
				$('#faculty{/literal}{$res.placeinfo.fix}{literal}').val('');

				$('#chair{/literal}{$res.placeinfo.fix}{literal}').val('');
				$('#chair_suggest{/literal}{$res.placeinfo.fix}{literal}').val('');

				$('#faculty_suggest{/literal}{$res.placeinfo.fix}{literal}').setOptions({
					extraParams: {
						action: 'search_faculty_json',
						place: Code
					}
				});

				$('#chair_suggest{/literal}{$res.placeinfo.fix}{literal}').setOptions({
					extraParams: {
						action: 'search_chair_json',
						place: Code
					}
				});
			}
		);

		});
		{/literal}

				 //--></script>{/if}
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Факультет</td>
			<td class="bg_color4">
				<input id="faculty{$res.placeinfo.fix}" type="hidden" name="faculty[{$res.placeinfo.type}][id][]" value="{$res.placeinfo.facultyid}" />
				<input type="text" id="faculty_suggest{$res.placeinfo.fix}" name="place[{$res.placeinfo.type}][faculty][]" value="{$res.placeinfo.faculty}" style="width:100%;"  maxlength="255" />
				{if $res.with_suggest === true}<script>
				<!--
				{literal}
									$(document).ready(function() {

			$('#faculty_suggest{/literal}{$res.placeinfo.fix}{literal}').autocomplete("/service/source/db.place",{
			extraParams: {
				action: 'search_faculty_json',
				place: '{/literal}{$res.placeinfo.placeid}{literal}'
			},
			dataType: 'json',
			parse: function(json) {
				var parsed = [];

				if ( !json || !json.length )
					return parsed;

				for (var i in json)
					parsed[parsed.length] = {
						data: json[i].Name,
						value: json[i].FacultyID,
						result: json[i].Name
					};

				return parsed;
			},
			formatItem: function(text, i, max, value) {
				return text;
			},
			max: 20
		}).result(
			function(event, Name, Code) {

				$('#faculty{/literal}{$res.placeinfo.fix}{literal}').val(Code);
				$('#chair{/literal}{$res.placeinfo.fix}{literal}').val('');
				$('#chair_suggest{/literal}{$res.placeinfo.fix}{literal}').val('');

				$('#chair_suggest{/literal}{$res.placeinfo.fix}{literal}').setOptions({
					extraParams: {
						action: 'search_chair_json',
						faculty: Code,
						place: $('#place{/literal}{$res.placeinfo.fix}{literal}').val()
					}
				});
			}
		);

		});
		{/literal}

				 //--></script>{/if}
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Кафедра</td>
			<td class="bg_color4">
				<input id="chair{$res.placeinfo.fix}" type="hidden" name="chair[{$res.placeinfo.type}][id][]" value="{$res.placeinfo.chairid}" />
				<input type="text" name="place[{$res.placeinfo.type}][chair][]" id="chair_suggest{$res.placeinfo.fix}" value="{$res.placeinfo.chair}" style="width:100%;"  maxlength="255" />
				{if $res.with_suggest === true}<script>
				<!--
				{literal}
				$(document).ready(function() {

				$('#chair_suggest{/literal}{$res.placeinfo.fix}{literal}').autocomplete("/service/source/db.place",{
			extraParams: {
				action: 'search_chair_json',
				place: '{/literal}{$res.placeinfo.placeid}{literal}',
				faculty: '{/literal}{$res.placeinfo.facultyid}{literal}'
			},
			dataType: 'json',
			parse: function(json) {
				var parsed = [];

				if ( !json || !json.length )
					return parsed;

				for (var i in json)
					parsed[parsed.length] = {
						data: json[i].Name,
						value: json[i].KafedraID,
						result: json[i].Name
					};

				return parsed;
			},
			formatItem: function(text, i, max, value) {
				return text;
			},
			max: 20
		}).result(
			function(event, Name, Code) {
				$('#chair{/literal}{$res.placeinfo.fix}{literal}').val(Code);
			}
		);

				 });{/literal}
				 //--></script>{/if}
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Форма обучения</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][course][]" style="width:100%;">
					<option value="0">- Выберите форму обучения -</option>
					{foreach from=$res.course_form_arr item=w key=k
						}<option value="{$k}"{if $k==$res.placeinfo.course} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Текущий статус</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][status][]" style="width:100%;">
					<option value="0">- Выберите статус -</option>
					{foreach from=$res.status_arr item=w key=k
						}<option value="{$k}"{if $k==$res.placeinfo.status} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Год начала обучения</td>
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
			<td align="right" class="bg_color2">Год окончания обучения</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][y_end][]" style="width:100%;">
					<option value="0">- Выберите год -</option>
					<option value="0"{if $res.placeinfo.y_end == 0} selected="selected"{/if}>По настоящее время</option>
					{foreach from=$res.grad_years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.y_end} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
			</td>
		</tr>

	</table>
</div>
	{elseif $res.placeinfo.type == constant('PlaceSimpleMgr::PT_SECONDARY_EDUCATION')}
<div style="margin-top:20px">
	<table border="0" cellpadding="3" cellspacing="2" width="550">
		<tr>
			<td class="bg_color2" colspan="3" align="right"><a href="javascript:void(0)"
onclick="{if $res.placeinfo.placeid && $res.with_suggest}mod_passport.removePlace({$res.placeinfo.placeid}, {$res.placeinfo.type});{/if}$(this.parentNode.parentNode.parentNode.parentNode.parentNode).remove();" class="text11">Удалить</a></td>
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
				<select id="country{$res.placeinfo.fix}" name="place[{$res.placeinfo.type}][country][]" onchange="Address.ChangeCountry('country{$res.placeinfo.fix}', 'city{$res.placeinfo.fix}');" style="width:100%;">
					<option value="0"> - Выберите страну - </option>
					{foreach from=$res.country_arr item=w
						}<option value="{$w.Code}"{if $w.Code==$res.placeinfo.countrycode} selected="selected"{/if}>{$w.Name}</option>{
					/foreach}
					<option value="-1"> - Полный список - </option>
				</select>
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Город</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][city][]" id="city{$res.placeinfo.fix}"
				onchange="$('#suggest{$res.placeinfo.fix}').setOptions{literal}({
					extraParams: {code: this.value,action: 'search_place', type: {/literal}{$res.placeinfo.type}{literal}}});{/literal}Address.ChangeCity('country{$res.placeinfo.fix}', 'city{$res.placeinfo.fix}')" style="width:100%;">
					<option value="0"> - Выберите город - </option>
					{foreach from=$res.city_arr item=w key=k
						}<option value="{$w.Code}"{if $w.Code==$res.placeinfo.citycode} selected="selected"{/if}>{$w.Name}</option>{
					/foreach}
					<option value="-1"> - Другой - </option>
				</select>
			</td>
		</tr>
		<tr>
			<td align="right" class="bg_color2">Школа</td>
			<td class="bg_color4">
				<input id="place{$res.placeinfo.fix}" type="hidden" name="place[{$res.placeinfo.type}][id][]" value="{$res.placeinfo.placeid}" />
				{if $res.placeinfo.placeid}
					<input type="hidden" name="place[{$res.placeinfo.type}][name][]" value="" />
				{/if}
				<input id="suggest{$res.placeinfo.fix}" type="text" {if $res.placeinfo.placeid} disabled="disabled" readonly="readonly" {else} name="place[{$res.placeinfo.type}][name][]" {/if} value="{$res.placeinfo.name}" style="width:100%;" />

				{if $res.with_suggest === true}<script>
											<!--{literal}
									$(document).ready(function() {

			$('#suggest{/literal}{$res.placeinfo.fix}{literal}').autocomplete("/service/source/db.place",{
			extraParams: {
				action: 'search_place',
				type: {/literal}{$res.placeinfo.type}{literal},
				code: {/literal}'{$res.placeinfo.city}'{literal}
			},
			dataType: 'json',
			parse: function(json) {
				var parsed = [];

				if ( !json || !json.length )
					return parsed;

				for (var i in json)
					parsed[parsed.length] = {
						data: json[i].Name,
						value: json[i].PlaceID,
						result: json[i].Name
					};

				return parsed;
			},
			formatItem: function(text, i, max, value) {
				return text;
			},
			max: 20
		}).result(
			function(event, Name, Code) {
				$('#place{/literal}{$res.placeinfo.fix}{literal}').val(Code);
				$('#spec{/literal}{$res.placeinfo.fix}{literal}').val('');
				$('#chair_suggest{/literal}{$res.placeinfo.fix}{literal}').val('');
				
				$('#spec_suggest{/literal}{$res.placeinfo.fix}{literal}').setOptions({
					extraParams: {
						action: 'search_spec_json',
						place: Code
					}
				});
			}
		);

		});
		{/literal}

				 //--></script>{/if}
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Год начала обучения</td>
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
			<td align="right" class="bg_color2">Год окончания обучения</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][y_end][]" style="width:100%;">
					<option value="0">- Выберите год -</option>
					<option value="0"{if $res.placeinfo.y_end == 0} selected="selected"{/if}>По настоящее время</option>
					{foreach from=$res.grad_years_arr item=w}<option value="{$w}"{if $w==$res.placeinfo.y_end} selected="selected"{/if}>{$w}</option>{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Класс (а, б..)</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][class][]" style="width:100%;">
					<option value="0">- Выберите класс -</option>
					{foreach from=$res.class_arr item=w key=k
						}<option value="{$k}"{if $w==$res.placeinfo.class} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td align="right" class="bg_color2">Специализация</td>
			<td class="bg_color4">
				<input id="spec{$res.placeinfo.fix}" type="hidden" name="spec[{$res.placeinfo.type}][id][]" value="{$res.placeinfo.chairid}" />
				<input type="text" id="spec_suggest{$res.placeinfo.fix}" name="place[{$res.placeinfo.type}][chair][]" value="{$res.placeinfo.chair}" style="width:100%;" maxlength="255" />

				{if $res.with_suggest === true}<script>
				<!--
				{literal}
				$(document).ready(function() {

				$('#spec_suggest{/literal}{$res.placeinfo.fix}{literal}').autocomplete("/service/source/db.place",{
			extraParams: {
				action: 'search_spec_json',
				place: '{/literal}{$res.placeinfo.placeid}{literal}'
			},
			dataType: 'json',
			parse: function(json) {
				var parsed = [];

				if ( !json || !json.length )
					return parsed;

				for (var i in json)
					parsed[parsed.length] = {
						data: json[i].Name,
						value: json[i].ChairID,
						result: json[i].Name
					};

				return parsed;
			},
			formatItem: function(text, i, max, value) {
				return text;
			},
			max: 20
		}).result(
			function(event, Name, Code) {
				
				
			}
		);

				 });{/literal}
				 //--></script>{/if}
			</td>
		</tr>

	</table>
</div>
{/if}