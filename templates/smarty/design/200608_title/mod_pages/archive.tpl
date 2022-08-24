<table border=0 cellpadding=3 cellspacing=0 width=100%>
  <tr><td class="dop2" bgcolor="#999999">архив</td></tr>
</table>
<table width=100% cellpadding=0 cellspacing=0 border=0>
<tr><td align="left">
<img src="/_img/x.gif" width="1" height="3" border="0" alt="" ><br>
{foreach from=$archive.l_y item=l_y key=k_y}
	<div onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
	 title="{if $k_y<3}Свернуть{else}Развернуть{/if}" style="cursor:pointer; cursor:hand; width:100%;">
	<a href="/{$SITE_SECTION}/{$archive.group}{$l_y.link}"><b>{$l_y.name}</b></a>
	</div>
	<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px" class="small">
	{foreach from=$archive.l_m.$k_y item=l_m}
		<a href="/{$SITE_SECTION}/{$archive.group}{$l_m.link}">{$l_m.date|month_to_string:1}</a>
		<br><img src="/_img/x.gif" width="1" height="2" borrder="0" alt="" ><br>
	{/foreach}			
	</div>
{/foreach}			
</td></tr>
</table>