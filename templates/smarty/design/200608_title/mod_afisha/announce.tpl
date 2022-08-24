<table border="0" cellspacing="2" cellpadding="0" width="100%" style="padding-left:2px;">
	<tr><td><img src="/_img/x.gif" width="5" height="1" border="0" alt="" /></td></tr>
{if !empty($BLOCK.url)}
	{assign var=res_url value=$BLOCK.url}
{else}
	{assign var=res_url value=""}
{/if}
	<tr><td><a href="/service/go/?url={"`$res_url`/afisha/"|escape:"url"}" target="_blank" class="a16b"><img src="/img/icon_afisha.gif" width="16" height="16" border="0"></a> <a href="/service/go/?url={"`$res_url`/afisha/"|escape:"url"}" target="_blank" class="a16b">Афиша:</a></td></tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="0">
<tr>
	<td align="left" style="padding-left: 8px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="2">
	{if $BLOCK.today.show}
		<tr><td><a href="/service/go/?url={"`$res_url`/afisha/?cmd=list&range=today"|escape:"url"}" target="_blank" style="color:red">На сегодня</a> <font class="txt_blue">(<font style="font-size: 11px; font-weight: bold;">{$BLOCK.today.cnt}</font>)</td></tr>
	{/if}
	{foreach from=$BLOCK.list item=l}
		<tr> 
		<td> 
			<a href="/service/go/?url={"`$res_url`/afisha/afisha.php?cmd=list&type=`$l.id`"|escape:"url"}" target="_blank"{if $l.id == 3 && $CURRENT_ENV.regid == '02'} style="color:red"{/if}>{$l.name}</a> <font class="txt_blue">(<font style="font-size: 11px; font-weight: bold;">{$l.cnt}</font>)
		</td>
		</tr>
	{/foreach}
	</table>
	</td>
</tr>
<tr> 
	<td><img src="/_img/x.gif" width="1" height="6"></td>
</tr>
</table>