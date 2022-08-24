{if !empty($res.list)}
<table width="100%" cellspacing="0" cellpadding="0" bgcolor="#aaba15">
<tr>
	<th align="left" valign="bottom" width="18"><img src="/_img/design/200710_auto/bul-zag.gif" width="18" height="13"></th>
	<th align="left"><font class="menu">&nbsp;&nbsp;{$CURRENT_ENV.site.title[$ENV.section]}</font></th>
</tr>
</table>
{/if}
<table width="100%" class="block_right_news" cellspacing="3" cellpadding="0">
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
	<tr><td><span>{$l.date|date_format:"%e"} {$l.date|month_to_string:2}</span></td></tr>
	<tr>
		<td>
			{if $l.img1.file }
				<a href="/{$ENV.section}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			{if $res.withtext==1}
			<span class="bl_text">
				{foreach from=$l.anon item=anon key=k}
					{if $k<3}{$anon|truncate:100:"..."}{/if}
				{/foreach}<br/>
			</span>
			{/if}
		</td>
	</tr>
	<tr><td><a href="/{$ENV.section}/{$res.group}{$l.id}.html" class="zag1"><b>{if $l.type==2}{$l.name_arr.name}, {$l.name_arr.position}{else}{$l.name}{/if}</b></a>
		{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}
		</td></tr>
	{if $l.otz.count}
	<tr>
		<td>
			<div class="comment_descr">
				{foreach from=$l.otz.list item=o}
					<span class="comment_name_news">{$o.name|truncate:20:"..."},</span> <span class="comment_time_news">{$o.date|date_format:"%e.%m"}:</span> {$o.otziv|truncate:40:"...":false}
					<a href="{$o.url}"><img src="/_img/design/200710_auto/bull-spis.gif" alt="читать далее" align="middle" border="0" height="7" width="9"></a>
				{/foreach}
			</div>
		</td>
	</tr>
	{/if}
{/if}
{/foreach}
{if $opened==true}
	</td></tr>
{/if}
</table>
