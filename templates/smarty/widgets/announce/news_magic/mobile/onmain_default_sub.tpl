{php}
	$this->_tpl_vars['_dates'] = array(); 	
{/php}
<div class="marker_title"><a class="subtitle" href="/newsline/all/">{$res.Title}</a></div>

{foreach from=$res.mainNews item=l key=k}
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align="left" style="padding-top: 5px;padding-left:6px;padding-right: 6px;"><b>Главное: </b>
		<a href="{$l->url.absolute}" class="link">{$l->title|truncate:100:"..."} </a> 
		{if $l->AddMaterial == 1}
			<img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал">
		{elseif $l->AddMaterial == 2}
			<img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы">
		{/if}
		</td>
	</tr>
</table>
{/foreach}
			
<table width="100%" cellpadding="0" cellspacing="0" border="0">	
	
	{foreach from=$res.newsList item=l key=k}
		{if $k < 3}
		{if mktime(0,0,0) > $l->tsDate && !in_array(date("d M", $l->tsDate),$_dates)}
		<tr>
			<td  style="padding-top: 5px;padding-left:6px;padding-right: 6px;">
				{php}$this->_tpl_vars['_dates'][] = date("d M", $this->_tpl_vars['l']->tsDate);{/php}
				<div><b>{$l->tsDate|date_format:"%d"} {$l->tsDate|month_to_string:2}</b></div>
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
		{/if}
	{/foreach}	
</table>