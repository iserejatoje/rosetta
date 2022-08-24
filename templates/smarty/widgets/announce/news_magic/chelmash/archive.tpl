{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}

<table width="100%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td style="padding: 0px 0px 0px 0px" align="right" height="1" bgcolor="#A7A7A7"><img src="/_img/x.gif" width="1" height="1" alt="" /></td>
  </tr> 
  <tr bgcolor="#d5d4d4" align="center">
  	<td><b>{$res.title}</b></td>
  </tr>
  <tr>
    <td style="padding: 1px 0px 0px 0px" align="right" height="2" bgcolor="#F5F5F5"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
  </tr>
</table>

{foreach from=$res.l_y item=l_y key=k_y}
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr bgcolor="#F4F5F5" align="left">
	<td>
		<a href="/{$SITE_SECTION}/{$l_y.link}"><b>{$l_y.name}</b></a>
		&nbsp;&nbsp;<img onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
		 src="/_img/x.gif" width="10" height="10" border="0" alt="{if $k_y<3}Свернуть{else}Развернуть{/if}" title="{if $k_y<3}Свернуть{else}Развернуть{/if}" style="cursor:pointer; cursor:hand;" />
	</td>
</tr>
</table>
<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}">
	<table width="100%" border="0" cellpadding="3" cellspacing="1">
	{foreach from=$res.l_m.$k_y item=l_m}
	<tr bgcolor="#F5F5F5" align="left">
		<td>
			<font style="padding-left:10px;"><img src="/_img/x.gif" width="9" height="9" alt="" />&nbsp;<a
			 href="/{$SITE_SECTION}/{$l_m.link}">{$l_m.date|month_to_string:1}</a></font>
		</td>
	</tr>
	{/foreach}			
	</table>
</div>
{/foreach}			
<table width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
    <td style="padding: 0px 0px 0px 0px" align="right" height="1" bgcolor="#d5d4d4"><img src="/_img/x.gif" width="1" height="2" alt="" /></td>
  </tr>
</table>