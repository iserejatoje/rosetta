<table border="0" cellspacing="0" cellpadding="0" bgcolor="#AABA15">
          <tr>
            <td>&nbsp;&nbsp;<font class=menu>{$ENV.site.title[$ENV.section]}</font>&nbsp;&nbsp;</td>
            <td align="right" valign="bottom"><img src="/_img/design/200710_auto/bull-zag2.gif" width="18" height="13"></td>
          </tr>
</table>
<table width=100% border=0 cellspacing=0 cellpadding=3>
	{foreach from=$res.list item=l key=y}
		<tr> 
			<td valign=top align="left">
			{if $l.img1.file }
				<a href="http://{$ENV.site.domain}/{$ENV.section}/{$res.group}{$l.id}.html"><img src="{$l.img1.file}" width="{$l.img1.w}" height="{$l.img1.h}" border="0" alt="{$l.name|strip_tags}" align="left" style="margin-right:3px;margin-bottom:3px;" /></a>
			{/if}
			
			{if $l.type==2}
				<a href="http://{$ENV.site.domain}/{$ENV.section}/{$res.group}{$l.id}.html" class="zag1"><b>{if $l.type==2}{$l.name_arr.name}</b></a>, {$l.name_arr.position}:<br><b>{$l.name_arr.text}</b>{/if}
			{else}
				<a href="http://{$ENV.site.domain}/{$ENV.section}/{$res.group}{$l.id}.html" class="zag1"><b>{$l.name}</b></a>
			{/if}{if $l.AddMaterial==1} <img src="/_img/design/200608_title/common/photo_blue.gif" title="Содержит фотоматериалы" alt="Содержит фотоматериал" width="14" height="10" />{elseif $l.AddMaterial==2} <img src="/_img/design/200608_title/common/video_blue.gif" title="Содержит видеоматериалы" alt="Содержит видеоматериалы" width="14" height="12" />{/if}<br />
			{if $res.withtext==1}
				{foreach from=$l.anon item=anon key=k}
					{if $k<3}{$anon|truncate:100:"..."}{/if}
				{/foreach}
			{/if}
		</td>
		</tr>
		{if $l.otz.count}
		<tr><td>	
				<div align="left" class="dop3">
				{foreach from=$l.otz.list item=o}
					<b><font class="dop2">{$o.name}, {$o.date|date_format:"%e.%m"}:</font></b>
					&nbsp;{$o.otziv|truncate:40:"...":false}&nbsp;<a href="{$o.url}"><img src="/_img/design/200710_auto/bull-spis.gif" width="9" height="7" border="0" align="middle" alt="читать далее" /></a>
					<br /><img src="/_img/x.gif" width="1" height="3" border="0"><br />
				{/foreach}
				</div>
			</td>
		</tr>
		{/if}
	{/foreach}
</table>
