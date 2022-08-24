<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td bgcolor="#92b3c7"><img src="/_img/x.gif" height="3" width="1"></td>
</tr>
<tr>
	<td bgcolor="#f1f6f9">
	<table border="0" cellpadding="0" cellspacing="0" class="block_main_news">
	<tr>
		<th>
		&nbsp;&nbsp;&nbsp;&nbsp;<span>{$ENV.site.title[$ENV.section]}</span>&nbsp;&nbsp;&nbsp;&nbsp;
		</th>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td valign="top"><img src="/_img/x.gif" height="5" width="1"></td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="3" width="100%" class="block_main_news">
{assign var="date" value=0}
{assign var="opened" value=false}
{foreach from=$res.list item=l key=y}
{assign var="date" value=$l.date}
{if $opened==true}
{assign var="opened" value=false}
	</td></tr>
{/if}
	{assign var="opened" value=true}
	<tr align="center">
		<td>
			{if $l.img1.file }
				<a href="/{$ENV.section}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			<a href="/{$ENV.section}/{$res.group}{$l.id}.html" class="anon"><span class="anon_name">{if $l.type==2}{$l.name_arr.name},</span> <span class="anon_position">{$l.name_arr.position}: <b>{$l.name_arr.text}</b>{else}{$l.name}{/if}</span></a><br/>
			<span class="bl_text">
				{$l.anon|truncate:160:"..."}
			</span>
		</td>
	</tr>
	<tr>
		<td>
			{if $l.otz.count}
			<div class="comment_descr">
				{foreach from=$l.otz.list item=o}
					<span class="comment_name">{$o.name|truncate:20:"..."},</span> <span class="comment_time"> {$o.date|date_format:"%H:%M"}:</span>
					{$o.otziv|truncate:40:"...":false}
					<a href="{$o.url}"><img src="/_img/design/200710_afisha/str.gif" alt="читать далее" align="middle" border="0" height="9" width="9"></a>
				{/foreach}
			</div>
			{/if}
		</td>
	</tr>
	<tr valign="bottom"><td>
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>