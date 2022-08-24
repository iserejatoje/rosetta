	{*<table cellpadding="0" cellspacing="2" width="100%" class="table2" id="pl{$res.placeinfo.fix}">*}
	<tbody id="pl{$res.placeinfo.fix}">
		<tr>
			<td class="bg_color4" colspan="2" align="right">
				<div style="float:right;"><a href="javascript:void(0)" onclick="$('#pl{$res.placeinfo.fix}').remove();"><small>Удалить</small></a></div>
				<div style="float:right;"><a href="javascript:void(0)" onclick="$('#pl{$res.placeinfo.fix}').remove();"><img src="/_img/design/200608_title/bullet_delete.gif" border="0" alt="Удалить" vspace="3" hspace="4"/></a></div>
			</td>
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
			<td class="bg_color2" align="right" width="140">Город</td>
			<td class="bg_color4">
				<input type="hidden" value="{$res.placeinfo.countrycode}" id="country{$res.placeinfo.fix}" name="place[{$res.placeinfo.type}][country][]" />
				<select {if $res.placeinfo.placeid} disabled="disabled"{/if} name="place[{$res.placeinfo.type}][city][]" id="city{$res.placeinfo.fix}"
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
			<td class="bg_color2" align="right" width="140">Место работы</td>
			<td class="bg_color4">
				<input id="place{$res.placeinfo.fix}" type="hidden" name="place[{$res.placeinfo.type}][id][]" value="{$res.placeinfo.placeid}" />
				{if $res.placeinfo.placeid}
					<input type="hidden" name="place[{$res.placeinfo.type}][name][]" value="" />
				{/if}
				<input id="suggest{$res.placeinfo.fix}" type="text" {if $res.placeinfo.placeid} disabled="disabled" readonly="readonly" {else} name="place[{$res.placeinfo.type}][name][]"{/if} value="{$res.placeinfo.name}" style="width:100%;" />

				{if $res.with_suggest === true}<script>
											<!--{literal}
									$(document).ready(function() {

			$('#suggest{/literal}{$res.placeinfo.fix}{literal}').autocomplete("/service/source/db.place",{
			extraParams: {
				action: 'search_place',
				type: '{/literal}{$res.placeinfo.type}{literal}',
				code: '{/literal}{$res.placeinfo.citycode}'{literal}
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
			}
		);

		});
		{/literal}


				//-->
				</script>{/if}
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
			<td class="bg_color2" align="right" width="140">Период</td>
			<td class="bg_color4">
				<select name="place[{$res.placeinfo.type}][y_start][]" style="width:16%;">
					<option value="0">-год-</option>
					{foreach from=$res.years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.y_start} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				<select name="place[{$res.placeinfo.type}][m_start][]" style="width:23%;">
					<option value="0">-месяц-</option>
					{foreach from=$res.months_arr key=m item=w
						}<option value="{$m}"{if $m==$res.placeinfo.m_start} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				По
				<select name="place[{$res.placeinfo.type}][y_end][]" style="width:28%;">
					<option value="0">-год-</option>
					<option value="0"{if $res.placeinfo.y_end == 0} selected="selected"{/if}>Наст. время</option>
					{foreach from=$res.years_arr item=w
						}<option value="{$w}"{if $w==$res.placeinfo.y_end} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				<select name="place[{$res.placeinfo.type}][m_end][]" style="width:23%;"{*if $res.placeinfo.m_end==0} disabled="true"{/if*}>
					<option value="0">-месяц-</option>
					{foreach from=$res.months_arr key=m item=w
						}<option value="{$m}"{if $m==$res.placeinfo.m_end} selected="selected"{/if}>{$w}</option>{
					/foreach}
				</select>
				<br/><small><span style="color:#808080">Если вы в настоящее время работаете на указанном месте, год и месяц окончания указывать не нужно.</span></small>
			</td>
		</tr>

		<tr>
			<td class="bg_color2" align="right" width="140">Должность</td>
			<td class="bg_color4">
				<input id="position_suggest{$res.placeinfo.fix}" type="text" name="place[{$res.placeinfo.type}][position][]" value="{$res.placeinfo.position}" style="width:100%;" />
				
				<script>
				<!--
				{literal}

					$(document).ready(function() {

				$('#position_suggest{/literal}{$res.placeinfo.fix}{literal}').autocomplete("/service/source/db.place",{
			extraParams: {
				action: 'search_place_position'
			},
			dataType: 'json',
			parse: function(json) {
				var parsed = [];

				if ( !json || !json.length )
					return parsed;

				for (var i in json)
					parsed[parsed.length] = {
						data: json[i].Text,
						value: '',
						result: json[i].Text
					};

				return parsed;
			},
			formatItem: function(text, i, max, value) {
				return text;
			},
			max: 20
		});

		});
					{/literal}

				 //--></script>
				
			</td>
		</tr>
		
		<tr>
			<td class="bg_color2" align="right" width="140">Опыт работы</td>
			<td class="bg_color4">
				<textarea name="place[{$res.placeinfo.type}][comment][]" rows="3" style="width:100%">{$res.placeinfo.comment}</textarea>
				<br/><small><span style="color:#808080">Перечислите коротко: должностные обязанности, значительные проекты, достижения.</span></small>
			</td>
		</tr>
	</tbody>
	{*</table>*}