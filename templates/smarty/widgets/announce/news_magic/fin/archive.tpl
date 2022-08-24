{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}

<table width="100%" border="0" cellspacing="0" cellpadding="0"> 
      <tr>
        <td width="13" valign="top" background="/_img/design/200710_fin/zag1back.gif"><img src="/_img/design/200710_fin/zag1.gif" width="13" height="13"></td>
        <td bgcolor="#B3C9D7"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><font class=menu4>{$res.title}</font></td>
              <td width="10" align="right" valign="bottom"><img src="/_img/design/200710_fin/zag1ugol.gif" width="10" height="23"></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td width="13"><img src="/_img/design/200710_fin/x.gif" width="1" height="5"></td>
        <td><img src="/_img/design/200710_fin/x.gif" width="1" height="5"></td>
      </tr>
</table>  
{foreach from=$res.l_y item=l_y key=k_y}
<table width="100%" border="0" class="menu-klass" cellpadding="3" cellspacing="1">
<tr bgcolor="#FFFFFF" align="left">
	<td class="menu-klass">
		<a href="/{$SITE_SECTION}/{$l_y.link}"><b>{$l_y.name}</b></a>
		&nbsp;&nbsp;<img onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
		 src="/_img/design/200710_fin/bullspis.gif" width="9" height="9" border="0" alt="{if $k_y<3}Свернуть{else}Развернуть{/if}" title="{if $k_y<3}Свернуть{else}Развернуть{/if}" style="cursor:pointer; cursor:hand;" />
	</td>
</tr>
</table>
<div id="archive_{$k_y}" style="display:{if $k_y<2}block{else}none{/if}">
	<table width="100%" border="0" class="menu-klass" cellpadding="2" cellspacing="0">
	{foreach from=$res.l_m.$k_y item=l_m}
	<tr align="left">
		<td class="menu-klass">
			<font style="padding-left:10px;" class="small"><img src="/_img/design/200710_fin/bullspis.gif" width="9" height="9" alt="" />&nbsp;<a
			 href="/{$SITE_SECTION}/{$l_m.link}">{$l_m.date|month_to_string:1}</a></font>
		</td>
	</tr>
	{/foreach}			
	</table>
</div>
{/foreach}			
