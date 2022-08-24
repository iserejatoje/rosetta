{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}

<table cellpadding="3" cellspacing="0" border="0" width="100%">
<tr>
	<td bgcolor="#D1E6F0" class=title style="white-space: nowrap"><EM><IMG 
            src="/_img/design/200710_2074/title_marker.gif" alt="" width="3" height="17">&nbsp;&nbsp;{$res.title}</EM>
	</td>
</tr>
</table>
<table class="menu-klass" cellpadding="3" cellspacing="1" width="100%" >
{foreach from=$res.l_y item=l_y key=k_y}
<tr bgcolor="#FFFFFF">
	<td style="padding-left:10px;">
	<a href="/{$SITE_SECTION}/{$l_y.link}"><b>{$l_y.name}</b></a>
	&nbsp;&nbsp;<img onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
		 title="{if $k_y<3}Свернуть{else}Развернуть{/if}"
	src="/_img/design/200710_2074/list_marker.gif" width="7" height="7" border="0" alt="{if $k_y<3}Свернуть{else}Развернуть{/if}" title="{if $k_y<3}Свернуть{else}Развернуть{/if}" style="cursor:pointer; cursor:hand;" />
	<br>
	<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px" class="small">
	{foreach from=$res.l_m.$k_y item=l_m}
		<a href="/{$SITE_SECTION}/{$l_m.link}">{$l_m.date|month_to_string:1}</a>
		<br>
	{/foreach}			
	</div>
	</td> 
</tr>
{/foreach}			
</table>  
