{foreach from=$res.list item=l}
<img src="/img/kriz/bullet-left3.gif" width="4" height="4" border="0" align="absmiddle" alt="" />&nbsp;<a href="/service/go/?url={"`$l.url`"|escape:"url"}" target="_blank" class="white2">
			{if $l.type==2}
				<font style='font-size:18px;'>{$l.name_arr.name}</font>,<br/>{$l.name_arr.position}{if $l.name_arr.text}: <b>{$l.name_arr.text}</b>{/if}
			{else}
				{$l.name}
			{/if}
</a><br/>
<img src="/_img/x.gif" width="10" height="8" border="0" alt="" /><br/>
{/foreach}