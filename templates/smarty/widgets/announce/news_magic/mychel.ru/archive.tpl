{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}

<table cellpadding="0" cellspacing="0" width="100%">
<tr bgcolor="#FFFFFF" >
	<td height="2"><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
<tr bgcolor="#CCCCCC" >
	<td height="4"><img src="/_img/x.gif" width="1" height="4"></td>
</tr>
<tr>
	<td style="background: #87B30A url('/_img/design/200805_afisha/green_search_bg.gif') repeat-x; padding-left: 10px" class="zag1" align="left">
		<br/>{$res.title}
	</td>
</tr>
<tr>
	<td style="padding-left:10px;"  align="left">

{foreach from=$res.l_y item=l_y key=k_y}
	<a href="/{$SITE_SECTION}/{$l_y.link}" class="weis_big"><b>{$l_y.name}</b></a>
	&nbsp;&nbsp;<img onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
		 title="{if $k_y<3}Свернуть{else}Развернуть{/if}"
	src="/_img/design/200805_afisha/bull2.gif" width="12" height="14" border="0" alt="{if $k_y<3}Свернуть{else}Развернуть{/if}" title="{if $k_y<3}Свернуть{else}Развернуть{/if}" style="cursor:pointer; cursor:hand;" />
	<br>
	<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px">
	{foreach from=$res.l_m.$k_y item=l_m}
		<a href="/{$SITE_SECTION}/{$l_m.link}" class="dop10">{$l_m.date|month_to_string:1}</a>
		<br>
	{/foreach}			
	</div>
	<img src="/_img/x.gif" wudth=1 height="2" border="0" ><br>
{/foreach}			
	</td> 
</tr>
<tr>
	<td height="2" align="right"><img src="/_img/design/200805_afisha/search_korner.gif" width="16" height="16"></td>
</tr>
<tr bgcolor="#FFFFFF" >
	<td height="2"><img src="/_img/x.gif" width="1" height="2"></td>
</tr>
</table>  