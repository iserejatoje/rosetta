<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
    <td>
		<table cellspacing="0" cellpadding="0" border="0" width="100%"> 
		    <tr>
		        <td valign="top">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
						<tr>
							<td width="13" valign="top"><img height="23" width="13" src="/_img/design/200710_fin/zag2.gif"/></td>
							<td rowspan="2" bgcolor="#85a0b2"><font class="menu4">&nbsp;&nbsp;{$res.title}</font></td>
							<td rowspan="2" align="right" width="10" valign="bottom" bgcolor="#85a0b2"><img height="23" width="10" src="/_img/design/200710_fin/zag2ugol.gif"/></td>
						</tr>
						<tr>					
							<td background="/_img/design/200710_fin/zag2back.gif"><img width="1" height="5" src="/_img/x.gif"/></td>
						</tr>
			        </table>
				</td>
		    </tr>
		</table>
	</td>
</tr>
<tr valign="bottom" bgcolor="#E3ECF2">
	<td colspan="3" class="block_right_news">
		<table width="100%" cellspacing="0" cellpadding="0" >
		{foreach from=$res.list item=l}
			<tr><td><span>{$l.Date|simply_date}</span></td></tr>
			{if $l.photo.visible}
			<tr><td><a href="{$l.url}"><img src="{$l.photo.thumb.url}" border="0" width="{$l.photo.thumb.width}" height="{$l.photo.thumb.height}" alt="{$l.photo.title}" title="{$l.photo.title}" /></a></td>
			{/if}
			<tr><td style="padding-bottom:10px"><a href="{$l.url}"><span class="anon_name">{$l.Name}</span></a></td></tr>
		{/foreach}
		</table>
	</td>
</tr>
</table>
