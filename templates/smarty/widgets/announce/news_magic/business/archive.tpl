{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<th align="right" width="100%"><span style="FONT-WEIGHT: bold; FONT-SIZE: 16px; COLOR: #f06000; FONT-FAMILY: arial, verdana, tahoma">{$res.title}</span></th>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
<tr><td align="right" class="news_block_archive" style="border: none">
			<div>
{foreach from=$res.l_y item=l_y key=k_y}
				<div style="cursor:pointer; cursor:hand;" align="right" class="news_block_archive_year">
				<a href="/{$SITE_SECTION}/{$l_y.link}"><b>{$l_y.name}</b></a>
				<img onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
					title="{if $k_y<3}Свернуть{else}Развернуть{/if}" src="/_img/design/200710_business/bullet2.gif" width="16" height="10" border="0" alt="{if $k_y<3}Свернуть{else}Развернуть{/if}">
				</div>
				<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px" align="right" class="text11">
	{foreach from=$res.l_m.$k_y item=l_m}
					<a href="/{$SITE_SECTION}/{$l_m.link}">{$l_m.date|month_to_string:1}</a>
					&nbsp;|&nbsp;
	{/foreach}			
				</div>
{/foreach}			
			</div>
	</td>
</tr>
</table>


