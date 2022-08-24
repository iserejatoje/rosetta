{foreach from=$res item=l}
<table width="100%" cellspacing="0" cellpadding="3" bgcolor="#F3F3F3" > 
<tr>
	<td bgcolor="#D1E6F0" class=title style="white-space: nowrap" colspan=2><EM><IMG 
            src="/_img/design/200710_2074/title_marker.gif" alt="" width="3" height="17">&nbsp;&nbsp;{$l.data.title}</EM>
	</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="3">
	<tr> 
		<td valign="top" align="center">
			{if $l.data.img.url}
				<a href="{$l.data.url}">
				<img src="{$l.data.img.url}" width="{$l.data.img.w}" height="{$l.data.img.h}" border="0" alt="{$l.data.name}" />
				</a><br>
			{/if}
			<a href="{$l.data.url}">{$l.data.name}</a>
			{if $l.comment.id}
				<div align="left"><img src="/_img/x.gif" width="1" height="2"><br/><font class="user">{if $l.comment.user}<a href="{$l.comment.user.url}" target="_blank">{$l.comment.user.name|truncate:30:"..."}</a>{else}{$l.comment.name|truncate:30:"..."}{/if}:</font> 
				&nbsp;{$l.comment.text|truncate:35:"..."}&nbsp;<a href="{$l.data.url}?act=last#comment{$l.comment.id}"><img src="/_img/design/200710_2074/list_marker.gif" width="7" height="7" border="0" align="absmiddle" /></a><br/>
				<img src="/_img/x.gif" width="1" height="5" alt="" /></div>
			{/if}
		</td>
	</tr>
</table>
{/foreach}