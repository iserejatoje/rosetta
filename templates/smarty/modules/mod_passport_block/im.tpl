<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr align="left">
	<td class="block_title" style="text-align: left;padding-left: 18px"><span>Мои сообщения</span></td>
</tr>
</table>
<table width="100%" cellspacing="4" cellpadding="0" border="0" style="background-color: #F3F8F8">
	{if $res.newmessages_count > 0}
	<tr>
		<td class="tip" align="center"><a href="{$res.folders.incoming.url}">Новых сообщений: {if $res.newmessages_count>0}<b>{$res.newmessages_count}</b>{else}0{/if}</a></td>
	</tr>
	{else}
	<tr>
		<td class="tip" align="center"><a href="{$res.folders.incoming.url}">Входящие</a>&nbsp;&nbsp;&nbsp;<a href="{$res.folders.outcoming.url}">Исходящие</a><br/><br/></td>
	</tr>
	<tr>
		<td align="center">Новых сообщений нет<br/></td>
	</tr>
	{/if}
	{if is_array($res.lastmessage)}
	<tr>
		<td class="tip" align="center">{$res.lastmessage.Created|simply_date}</td>
	</tr>
	<tr>
		<td class="tip" align="center"><b><a href="{$res.userinfo->Profile.general.InfoUrl}">{$res.lastmessage.NickNameFrom}</a></b></td>
	</tr>
	{if $res.userinfo->ID != 0}
	<tr>
		<td align="center">
			<a class="pcomment" target="_blank" href="{$res.userinfo->Profile.general.InfoUrl}">
				<img border="0" src="{$res.userinfo->Profile.general.AvatarUrl}" width="{$res.userinfo->Profile.general.AvatarWidth}" height="{$res.userinfo->Profile.general.AvatarHeight}">
			</a>
		</td>
	</tr>
	{/if}	
	<tr>
		<td>
			<div style="padding-bottom:4px;" class="dop" align="center">{if !empty($res.lastmessage.Type)}<b>{$res.lastmessage.DType}{if !empty($res.lastmessage.RefererTitle)}:{/if}</b>{/if} {if !empty($res.lastmessage.RefererTitle)}{if !empty($res.lastmessage.RefererUrl)}<a href="{$res.lastmessage.RefererUrl}">{/if}{$res.lastmessage.RefererTitle}{if !empty($res.lastmessage.RefererUrl)}</a>{/if}{/if}</div>
			<div align="center" style="padding-bottom:4px;">{$res.lastmessage.Text|nl2br|truncate:60}</div>
			<div align="center">
				<input type="button" onclick="{$res.replyjs}return false;" value="ответить" />
				<input type="button" onclick="{$res.makereadjs}return false;" value="закрыть" />
			</div>
		</td>
	</tr>
	{/if}
</table>
