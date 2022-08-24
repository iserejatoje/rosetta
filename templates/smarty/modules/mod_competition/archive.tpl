<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
<tr><th class="archive">Архив</th></tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#C1211D"><img src="/_img/x.gif" width="1" height="5" alt="" /></td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
	<tr><td align="left" class="news_block_archive"><div>
{foreach from=$res.l_y item=l_y key=k_y}
		<div class="news_block_archive_year">
		<a href="/{$ENV.section}/result/{$l_y.link}"><b>{$l_y.name}</b></a>&nbsp;
		<img src="/_img/design/200710_auto/bull-2.gif" width="12" height="12" border="0" onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
		alt="{if $k_y<3}Свернуть{else}Развернуть{/if}" title="{if $k_y<3}Свернуть{else}Развернуть{/if}" class="news_block_archive_year">
		</div>
		<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px" class="text11">
		{foreach from=$res.l_m.$k_y item=l_m}
			<a href="/{$ENV.section}/result/{$l_m.link}">{$l_m.date|month_to_string:1}</a>
			<br><img src="/_img/x.gif" width="1" height="2" borrder="0" alt="" ><br>
		{/foreach}			
		</div>
{/foreach}			
	</div></td></tr>
</table>