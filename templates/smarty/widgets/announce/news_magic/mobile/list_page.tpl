{php}
	$this->_tpl_vars['_dates'] = array(); 	
{/php}
			
<table width="100%" cellpadding="0" cellspacing="0" border="0">	
	
	{foreach from=$res.newsList item=l key=k}

		{if mktime(0,0,0) > $l->tsDate && !in_array(date("d M", $l->tsDate),$_dates)}
		<tr>
			<td  style="padding-top: 5px;">
				{php}$this->_tpl_vars['_dates'][] = date("d M", $this->_tpl_vars['l']->tsDate);{/php}				
				<div class="marker_title">Новости от {$l->tsDate|date_format:"%d"} {$l->tsDate|month_to_string:2}</div>
			</td>
		</tr>
		{/if}
		
		<tr>
			<td  style="padding-top: 5px;padding-left:6px;padding-right: 6px;">
			{$l->Date|date_format:"%H:%M"}&nbsp;
			
				<a href="{$l->url.absolute}" class="link">{$l->title|truncate:100:"..."}</a>
			
			{if $l->AddMaterial == 1}
				<img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">
			{elseif $l->AddMaterial == 2}
				<img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы">
			{/if}                        
			</td>
		</tr>

	{/foreach}	
</table>