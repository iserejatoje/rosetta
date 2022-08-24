{* исключительная ситуация для 116doctor.ru *}
{if $page.sectionid == 1488 }
	<select id="BranchID_{$number}" name="BranchID_{$number}" class="branches" size="1" style="width:{if $number>0}95%{else}100%{/if}" onchange="mod_job.change_branch(this.value, {$number}, {if !empty($multi)}{$multi}{else}false{/if}, '{if $CONFIG.selected_position==1 && count($page.selected_branches[$number].branch[$BranchID]) <= 1}radio{else}checkbox{/if}')">
	{foreach from=$page.Branch_arr.razdel item=v}
		{* Показывать только раздел "Медицина и фармация" *}
		{if $v.rid == 13 }
		<option selected="selected" value="{$v.rid}">{$v.rname}</option>
		{/if}
	{/foreach}
	</select>
	<script language="javascript">
		{literal}
		$(document).ready(function(){
			mod_job.change_branch(13, 0, true, 'radio');	
		});
		{/literal}
	</script>
{else}
	<select name="BranchID_{$number}" class="branches" size="1" style="width:{if $number>0}95%{else}100%{/if}" onchange="mod_job.change_branch(this.value, {$number}, {if !empty($multi)}{$multi}{else}false{/if}, '{if $CONFIG.selected_position==1 && count($page.selected_branches[$number].branch[$BranchID]) <= 1}radio{else}checkbox{/if}')">
	<option value="-1">{if !empty($search) && $search == 1}Любая{else}-- Выберите раздел --{/if}</option>
	{foreach from=$page.Branch_arr.razdel item=v}
		{if $page.selected_branches === false && is_array($page.other_position)}
		<option value="{$v.rid}" {if isset($page.other_position[$v.rid])} selected="selected"{/if}>{$v.rname}</option>
		{else}
		<option value="{$v.rid}" {if isset($page.selected_branches[$number].branch[$v.rid])} selected="selected"{/if}>{$v.rname}</option>
		{/if}
	{/foreach}
	</select>
{/if}

{if $number>0}<a href="javascript:void(0)" title="Удалить отрасль" id="minus_{$number}" onclick="removeBranchField(null, {$number})"><img vspace="3" hspace="4" border="0" src="/_img/design/200608_title/bullet_delete.gif" alt="Удалить отрасль"/></a>
{/if}
<br/>

<div id="positions_{$number}" class="positions">
{if ($page.selected_branches != false && count($page.selected_branches) > 0) || is_array($page.other_position)}
	{*Для удобства запищем id-шник отрасли в переменную *}
	{php} 	
	if (isset($this->_tpl_vars['page']['selected_branches'][$this->_tpl_vars['number']]) 
		&& is_array($this->_tpl_vars['page']['selected_branches'][$this->_tpl_vars['number']]['branch'])
	)
		$this->_tpl_vars['BranchID'] = key($this->_tpl_vars['page']['selected_branches'][$this->_tpl_vars['number']]['branch']);
	else
		$this->_tpl_vars['BranchID'] = 0;
	
	if (empty($this->_tpl_vars['BranchID']) && isset($this->_tpl_vars['page']['other_position']))
		$this->_tpl_vars['BranchID'] = key($this->_tpl_vars['page']['other_position']);
	
	$this->_tpl_vars['mirrored'] = count($this->_tpl_vars['page']['speciality_list_arr']['mirror'][ $this->_tpl_vars['BranchID'] ]) > 0;
	
	if ($this->_tpl_vars['mirrored'])
	{
		$this->_tpl_vars['each'] = $this->_tpl_vars['page']['speciality_list_arr']['mirror'][ $this->_tpl_vars['BranchID'] ];
		
		$this->_tpl_vars['m_number'] = $this->_tpl_vars['number']."_1";
		
	}
	else
	{
		$this->_tpl_vars['each'] = $this->_tpl_vars['page']['speciality_list_arr'][ $this->_tpl_vars['BranchID'] ];
		
		$this->_tpl_vars['m_number'] = $this->_tpl_vars['number']."_0";
	}
	
	{/php}
	<table cellspacing="0" cellpadding="0" style="width:100%">		
	{assign var="i" value="0"}   
	{foreach from=$each item=position key=PositionID name=pos}	
		
		{if $mirrored}
		
			{if $i == 0}<tr>{/if}
				<td style="vertical-align:top;width:50%;padding:2px;">
					<input type="{if $CONFIG.selected_position==1 && count($page.selected_branches[$number].branch[$BranchID]) <= 1}radio{else}checkbox{/if}" name="position[{$m_number}][{$BranchID}][{$position}]" 
							id="position_{$m_number}_{$BranchID}_{$position}" 
							class="position_{$m_number}_{$BranchID}"
							onclick="mod_job.change_position(null, '{$m_number}', {$BranchID}, {$position}, '{if $CONFIG.selected_position==1 && count($page.selected_branches[$number].branch[$BranchID]) <= 1}radio{else}checkbox{/if}')"
								{if isset($page.selected_branches[$number].branch[$BranchID][$position])}
								 checked="checked"
								{/if}
							/>
					<label for="position_{$m_number}_{$BranchID}_{$position}" class="text11">							
								{$page.Branch_arr.razdel[$position].rname}							
					</label>					
				</td>			
			{php}$this->_tpl_vars['i']++;{/php}		
			{if $i == 2}</tr>{assign var="i" value="0"}{/if}
			
		{elseif $position.User == false}
		
			{if $i == 0}<tr>{/if}
				<td style="vertical-align:top;width:50%;padding:2px;">
					<input type="{if $CONFIG.selected_position==1 && count($page.selected_branches[$number].branch[$BranchID]) <= 1}radio{else}checkbox{/if}" name="position[{$m_number}][{$BranchID}][{$PositionID}]" 
							id="position_{$m_number}_{$BranchID}_{$PositionID}" 
							class="position_{$m_number}_{$BranchID}"
							onclick="mod_job.change_position(null, '{$m_number}', {$BranchID}, {$PositionID}, '{if $CONFIG.selected_position==1 && count($page.selected_branches[$number].branch[$BranchID]) <= 1}radio{else}checkbox{/if}')"							
							{if isset($page.selected_branches[$number].branch[$BranchID][$PositionID])}
							 checked="checked"
							{/if}
							/>
					<label for="position_{$m_number}_{$BranchID}_{$PositionID}" class="text11">							
							{$position.Name}							
					</label>
					
					{if isset($position.Specialities) && !$mirrored}
					<div id="specialities_{$m_number}_{$BranchID}_{$PositionID}" style="padding-left: 10px;">
					{foreach from=$position.Specialities item=speciality key=SpecialityID}
						<input type="checkbox" 
								name="position[{$m_number}][{$BranchID}][{$PositionID}][{$SpecialityID}]" 
								id="position_{$m_number}_{$BranchID}_{$PositionID}_{$SpecialityID}"
								{if isset($page.selected_branches[$number].branch[$BranchID][$PositionID][$SpecialityID])} checked="checked"{/if}
						/>
						<label for="position_{$m_number}_{$BranchID}_{$PositionID}_{$SpecialityID}" class="text11">{$speciality}</label><br/>
					{/foreach}
					</div>
					{/if}
				</td>			
			{php}$this->_tpl_vars['i']++;{/php}		
			{if $i == 2}</tr>{assign var="i" value="0"}{/if}
			
		{/if}
	{/foreach}
	</table>
	
	{if !$mirrored}
	<div style="text-align: left; padding-left: 6px; margin-bottom: 5px;" class="text11">
	
	{if isset($page.other_position[$BranchID]) && $page.other_position[$BranchID] != null}	
		Другая должность: <input type="text" id="other_position_{$m_number}_{$BranchID}" name="other_position[{$m_number}][{$BranchID}]" value="{php}echo $this->_tpl_vars['page']['other_position'][$this->_tpl_vars[BranchID]];{/php}" style="width: 50%; vertical-align: sub;"/>	
	{else}
	<a href="javascript:void(0);" onclick="mod_job.add_other_position(null, '{$m_number}', {$BranchID})" id="other_position_{$BranchID}" class="text11">Другая должность</a>
	{/if}
	</div>
	{/if}

{/if}

</div>
