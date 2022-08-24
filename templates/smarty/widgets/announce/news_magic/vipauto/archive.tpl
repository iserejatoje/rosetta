{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}

<table cellpadding="3" cellspacing="0" border="0" class="ltext" width=180>  
<tr><td bgcolor="#414141" class="cantitle" align="left">{$res.title}</td></tr>
<tr><td align="left"><img src="/_img/x.gif" width="100" height="2"></td></tr>
<tr align="left">
		<td style="padding: 0px 5px 5px 5px" class="ltext">
{foreach from=$res.l_y item=l_y key=k_y}
	<a class="ltext" href="/{$SITE_SECTION}/{$l_y.link}"><b>{$l_y.name}</b></a>
	&nbsp;&nbsp;<img onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
	 src="/_img/design/200710_vipauto/str.gif" width="7" height="7" border="0" alt="{if $k_y<3}Свернуть{else}Развернуть{/if}" title="{if $k_y<3}Свернуть{else}Развернуть{/if}" style="cursor:pointer; cursor:hand;" />
	<br>
	<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px" class="small">
	{foreach from=$res.l_m.$k_y item=l_m}
		<a href="/{$SITE_SECTION}/{$l_m.link}" class="ltext">{$l_m.date|month_to_string:1}</a>
		<br>
	{/foreach}			
	</div>
{/foreach}			
		</td>
	</tr>
</table>  
