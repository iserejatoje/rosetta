<div{* class="video-a-block-container"*}>
	{foreach from=$res.site_list key=siteid item=count}
	{if $count > 0}
	<table class="video-a-block-content">
		<tr>
			<td colspan="2">
				<div class="video-a-block-title"><span>{$res.info[$siteid].name|ucfirst}</span> ({$count|number_format:0:'':' '})</div>
			</td>
		</tr>
		{foreach from=$res.section_list[$siteid] key=sectionid item=count}
		<tr>
			<td width="100%">
				<a href="/{$CURRENT_ENV.section}/{$sectionid}/">{$res.info[$sectionid].name}</a> 
			</td>
			<td>({$count|number_format:0:'':' '})</td>
		</tr>
		{/foreach}	
	</table>
	{/if}
	{/foreach}
</div>