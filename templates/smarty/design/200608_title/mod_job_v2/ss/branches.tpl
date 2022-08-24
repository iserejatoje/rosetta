<ul style="list-style-type:none;padding-left:3px;margin-left:0px;">

{foreach from=$res.selected_branches item=positions key=BranchID}				
	<li style="padding-bottom:5px;">
		<b>{$res.sections.razdel[$BranchID].rname}</b>
		<ul style="list-style-type:disc;margin-left:7px;">								
		{foreach from=$positions item=ll key=pos name=pos}
			{if isset($res.speciality_list_arr[$BranchID][$pos]) && !$res.speciality_list_arr[$BranchID][$pos].User}
				<li>
					{$res.speciality_list_arr[$BranchID][$pos].Name}
					{if is_array($ll)}											
					<ul style="list-style-type:none;">											
					{foreach from=$ll item=lll key=spec}
						<li>{$res.speciality_list_arr[$BranchID][$pos].Specialities[$spec]}</li>
					{/foreach}	
					</ul>
					{/if}
				</li>
			{/if}
		{/foreach}
	
		{if isset($res.other_position[$BranchID])}
			<li>{$res.other_position[$BranchID]}</li>
			{php}
				unset($this->_tpl_vars['res']['other_position'][$this->_tpl_vars['BranchID']]);
			{/php}
		{/if}								
		</ul>
		
	</li>
{/foreach}

{foreach from=$res.other_position item=positions key=BranchID}	
	<li style="padding-bottom:5px;">
		<b>{$res.sections.razdel[$BranchID].rname}</b>
		<ul style="list-style-type:disc;margin-left:7px;">	
			<li>{$positions}</li>
		</ul>
	</li>
{/foreach}

</ul>
