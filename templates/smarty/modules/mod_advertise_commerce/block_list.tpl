{capture name=pageslink}
{if $BLOCK.res.pageslink.btn}
  <table align="left" cellpadding="0" cellspacing="0" border="0">
  <tr valign="middle">
    <td style="font-size:11px"><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $BLOCK.res.pageslink.back!="" }<td style="font-size:11px"><a href="{$BLOCK.res.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td style="font-size:11px">
		{foreach from=$BLOCK.res.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<a class="s5b" href="{$l.link}">[{$l.text}]</a>&nbsp;
			{else}
				&nbsp;[{$l.text}]&nbsp;
			{/if}
		{/foreach}
    </td>
    {if $BLOCK.res.pageslink.next!="" }<td style="font-size:11px"><a href="{$BLOCK.res.pageslink.next}">&gt;&gt;&gt;</a></td>{/if}
  </tr>
  </table>
{/if}
{/capture}

<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr>
	<td align="left" bgcolor="#E9EFEF" style="padding:3px;padding-left:8px;"><font class="t1">{$BLOCK.title}</font></td>
</tr>
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
{if $smarty.capture.pageslink}<tr><td>
	{$smarty.capture.pageslink}</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
{/if}
<tr><td align="left">
<form name="frm" method="post">
{if !$BLOCK.favorites}
<INPUT type="hidden" name="action" value="update">
{else}
<INPUT type="hidden" name="action" value="update_favorites">
{/if}
	<table width="100%" align="center" cellpadding="2" cellspacing="1" border="0" bgcolor=#FFFFFF>
	<tr align=center valign=middle bgcolor="#E9EFEF">
	<th width=80 class="t1">Дата:</th>
		<th width=80 class="t1">Рубрика:</th>
		<th width=180 class="t1">Тип недвижимости:</th>
		<th class="t1">Адрес:</th>
		<th width=70 class="t1">&nbsp;</th>
		{if $BLOCK.res.user.update_access}<th width=70 class="t1">Обновить</th>{/if}
		<th width=70 class="t1">Удалить</th>
	</tr>
	{foreach from=$BLOCK.res.list item=row key=key}
				<tr bgcolor="{if $key % 2}#FFFFFF{else}#F3F8F8{/if}" align=left>
					<td align="center">
						<font class="s3" color="red">{"d-m"|date:$row.date_start}</font><br />{"H:i"|date:$row.date_start}
					</td>
					<td align="center">{if $row.rub}{$row.rub}{else}-{/if}</td>
					<td align="center">{if $row.object}{$row.object}{else}-{/if}</td>
					<td align="center">{if $row.address}{$row.address}{else}-{/if}</td>
					{if !$BLOCK.favorites}
						<td align=center class="t1"><a href="/{$BLOCK.section}/edit.html?id={$row.id}">изменить</a></td>
					{else}
						<td align=center class="t1"><a href="/{$BLOCK.section}/details.html?id={$row.id}" target="_blank">показать</a></td>
					{/if}
					{if $BLOCK.res.user.update_access}<td align=center><input type=checkbox name="upd[]" {if $row.updated}disabled="disabled"{/if} value="{$row.id}" ></td>{/if}
					<td align=center><input type=checkbox name="del[]" value="{$row.id}" ></td>
				</tr>
				{/foreach}
	</table></form>
</td></tr>
<tr><td><img src="/_img/x.gif" width="1" height="5" border="0" alt="" /></td></tr>
<tr><td align="right">
<input class="button" onclick="document.forms.frm.submit();" type="button" value="{if $BLOCK.res.user.update_access}Обновить{else}Удалить{/if}" style="width:100px;">
</td></tr>
{if $smarty.capture.pageslink}<tr><td><img src="/_img/x.gif" width="1" height="10" border="0" alt="" /></td></tr>
<tr><td>
	{$smarty.capture.pageslink}</td></tr>
{/if}

<tr><td><img src="/_img/x.gif" width="1" height="20" border="0" alt="" /></td></tr>
</table>
<br /><br />