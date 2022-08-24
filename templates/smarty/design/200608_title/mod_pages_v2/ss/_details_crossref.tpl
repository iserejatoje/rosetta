{if $res.count }
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td align="left">
	<table align=left cellpadding=0 cellspacing=0 border=0>
	<tr><td class="zag"><a name="crossref"></a>Ранее на эту тему:</td></tr>
	<tr><td height=4 bgcolor=#333333><img src="/_img/x.gif" width=1 height=4 border=0></td></tr>
	</table>
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td>

	<table width="100%" cellpadding="0" cellspacing="0" border="0">
	{foreach from=$res.list item=l key=k}
	<tr align="left" valign="top">
		<td>{$l.date|date_format:"%d.%m.%Y"}&nbsp;&nbsp;</td>
		<td width="100%">
		<a target="_blank" href="{$l.link}">
			{$l.name}
		</a> {$l.domain}
		</td>
	</tr>
	<tr><td colspan="2" height="3px"></td></tr>
	{/foreach}
	</table>

</td></tr>
<tr><td height="20px"></td></tr>
</table>
{/if} {* {if $res.count } *}
