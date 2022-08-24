<br/>
<!-- begin content -->
<table align="left" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td>
			<font class="t5">{$res.userInfo.LastName} {$res.userInfo.FirstName} {$res.userInfo.MidName}</font>
		</td>
	</tr>
</table>
<br/><br/><br/>
<table cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		{if !empty($res.userInfo.Photo)}
		<td style="padding-right:10px">
			<img src="{$res.userInfo.Photo.Url}" width="$res.userInfo.Photo.Width" height="$res.userInfo.Photo.Height" border="0" alt="{$res.userInfo.LastName|escape} {$res.userInfo.FirstName|escape} {$res.userInfo.MidName|escape}" />
		</td>
		{/if}
		<td align="left">
			{if !empty($res.userInfo.Position)}{$res.userInfo.Position}<br/>{/if}
			{if !empty($res.userInfo.Info)}{$res.userInfo.Info}{/if}
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
</table>
<!-- end content -->
