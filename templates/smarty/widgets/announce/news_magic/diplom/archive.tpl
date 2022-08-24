{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td width="40"><img src="/_img/design/200710_diplom/icoleft2.gif" width="40" height="41"></td>
	<td align="right" valign="top" background="/_img/design/200710_diplom/backleftzag.gif">
		<span style="font-family: verdana, arial, tahoma; font-size:10px; color:#ffffff; font-weight:bold;">{$res.title}</span>&nbsp;&nbsp;
	</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
	<tr><td align="left" class="news_block_archive"><div>
{foreach from=$res.l_y item=l_y key=k_y}
		<div onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
		 title="{if $k_y<3}Свернуть{else}Развернуть{/if}" class="news_block_archive_year">
		<img src="/_img/design/200710_diplom/bullspis.gif" width="12" height="11"><a href="/{$SITE_SECTION}/{$l_y.link}"><b>{$l_y.name}</b></a>
		</div>
		<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px" class="text11">
		{foreach from=$res.l_m.$k_y item=l_m}
			<img src="/_img/design/200710_diplom/bullspis.gif" width="12" height="11"><a href="/{$SITE_SECTION}/{$l_m.link}">{$l_m.date|month_to_string:1}</a>
			<br><img src="/_img/x.gif" width="1" height="2" borrder="0" alt="" ><br>
		{/foreach}			
		</div>
{/foreach}			
	</div></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td valign="top" bgcolor="#D0D0D0"><img src="/_img/design/200710_diplom/rast.gif" width="202" height="3"></td>
</tr>
</table>