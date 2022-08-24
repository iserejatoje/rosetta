{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}


<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td style="width: 20px; background: url(/_img/design/200710_auto/backleft.gif)" valign="top">
		<img src="/_img/design/200710_auto/left-arh.gif" width="20">
	</td>
	<td valign="top" width="100%">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
		<tr><td align="right" class="news_block_archive">
			<div>
{foreach from=$res.l_y item=l_y key=k_y}
				<div align="right" class="news_block_archive_year">
				<a href="/{$SITE_SECTION}/{$l_y.link}"><b>{$l_y.name}</b></a>
				<img onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
					title="{if $k_y<3}Свернуть{else}Развернуть{/if}" src="/_img/design/200710_auto/bull-spis.gif" width="12" height="12" border="0" alt="{if $k_y<3}Свернуть{else}Развернуть{/if}">
				</div>
				<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px" align="right" class="text11">
	{foreach from=$res.l_m.$k_y item=l_m}
					<a href="/{$SITE_SECTION}/{$l_m.link}">{$l_m.date|month_to_string:1}</a>
					<img src="/_img/x.gif" width="1" height="2" border="0" alt="" >|<img src="/_img/x.gif" width="1" height="2" border="0" alt="" >
	{/foreach}			
				</div>
{/foreach}			
			</div>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

