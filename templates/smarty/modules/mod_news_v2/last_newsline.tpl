<style>{literal}
.news_block_last_item {text-align: left; padding-left:4px;}
.news_block_archive {padding-top:3px;padding-left:4px;}
.news_block_archive_year {cursor:pointer; cursor:hand; width:100%;}
{/literal}</style>

{*<table width="100%" cellspacing="0" cellpadding="0" border="0">
<tr align="right"><td class="block_title"><span>последние новости</span></td></tr>
</table>*}

<table width="100%" class="block_left" cellspacing="0" cellpadding="0" >
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{if date("Ymd",$date) != date("Ymd",$l.date)}
{assign var="date" value=$l.date}
{if $opened==true}
{assign var="opened" value=false}
	</td></tr>
{/if}
	{assign var="opened" value=true}
	<tr align="right"><th><span>{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</span></th></tr>
	<tr valign="bottom"><td>
{/if}
	<div><span class="bl_date">{$l.date|date_format:"%H:%M"}</span> <span class="bl_title"><a href="/{$ENV.section}/{$l.date|date_format:"%Y"}/{$l.date|date_format:"%m"}/{$l.date|date_format:"%d"}/#{$l.id}">{$l.name}</a></span></div>
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>
	{if $CURRENT_ENV.site.domain=="72.ru"}
		<br/><center><noindex><a href="http://86.ru/newsline/" class="text11" rel="nofollow" target="_blank" style="color:red;"><b>Новости ХМАО</b></a>
		<br/><a href="http://89.ru/newsline/" rel="nofollow" class="text11" target="_blank" style="color:red;"><b>Новости ЯНАО</b></a>
		</noindex></center><br/>
	{/if}
	{if $CURRENT_ENV.site.domain=="86.ru"}
		<br/><center><noindex><a href="http://72.ru/newsline/" class="text11" rel="nofollow" target="_blank" style="color:red;"><b>Новости Тюмени</b></a>
		<br/><a href="http://89.ru/newsline/" rel="nofollow" class="text11" target="_blank" style="color:red;"><b>Новости ЯНАО</b></a>
		</noindex></center><br/>
	{/if}	
	{if $CURRENT_ENV.site.domain=="89.ru"}
		<br/><center><noindex><a href="http://72.ru/newsline/" class="text11" rel="nofollow" target="_blank" style="color:red;"<b>Новости Тюмени</b></a>
		<br/><a href="http://86.ru/newsline/" rel="nofollow" class="text11" target="_blank" style="color:red;"><b>Новости ХМАО</b></a>
		</noindex></center><br/>
	{/if}