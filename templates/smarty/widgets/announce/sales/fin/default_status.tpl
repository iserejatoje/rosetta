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
	<td colspan="3">
		<table width="100%" cellspacing="0" cellpadding="4" >
		{foreach from=$res.list item=ls}
		<tr><td class="menu-klass"><b><span>{$ls.name}</span></b></td></tr>
		{foreach from=$ls.list item=l}
			<tr><td align="left" class="menu-klass"><a href="{$l.url}" class="zag2"><b>{$l.Name}</b></a></td></tr>
		{/foreach}
		{/foreach}
		</table>
	</td>
</tr>
<tr bgcolor="#E3ECF2"><td><div style="text-align: right; padding: 0px 7px 2px 0px;" class="dop2"><a href="{$res.url}" class="dop2">Все предложения</a> (<b>{$res.count}</b>)</div></td></tr>
</table>
