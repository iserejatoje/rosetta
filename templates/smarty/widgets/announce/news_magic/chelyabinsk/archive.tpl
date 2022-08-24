{literal}
<style>
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
</style>

{/literal}

<table border="0" cellpadding="0" cellspacing="0" width="100%" class="block_left">
	<tr><th align="left"><span>{$res.title}</span></th></tr>
	<tr><td align="left" class="news_block_archive"><div>
{foreach from=$res.l_y item=l_y key=k_y}
		<div onclick="ShowHideElement('archive_{$k_y}'); this.alt=(this.alt=='Развернуть'?'Свернуть':'Развернуть'); this.title=this.alt;"
		 title="{if $k_y<3}Свернуть{else}Развернуть{/if}" class="news_block_archive_year">
		<a href="/{$SITE_SECTION}/{$l_y.link}"><b>{$l_y.name}</b></a>
		</div>
		<div id="archive_{$k_y}" style="display:{if $k_y<3}block{else}none{/if}; padding-left:10px" class="text11">
		{foreach from=$res.l_m.$k_y item=l_m}
			<a href="/{$SITE_SECTION}/{$l_m.link}">{$l_m.date|month_to_string:1}</a>
			<br><img src="/_img/x.gif" width="1" height="2" borrder="0" alt="" ><br>
		{/foreach}			
		</div>
{/foreach}			
	</div></td></tr>
</table>