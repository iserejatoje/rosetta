{if $page.no_folder}
{* Нет такой папки *}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="100px"></td>
</tr>
</table>
<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr><td class="block_title2"><span>Ошибка</span></td></tr>
<tr>
	<td>
{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_NO_FOLDER)}
	</td>
</tr>
</table>

{elseif $page.folder_is_empty}
{* папка пуста *}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>{$page.folder.name}</span></td>
		</tr>
		</table>
	
	</td>
</tr>
</table>

<table class="table" align="center" width="400" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td>
<b>{$UERROR->GetError($smarty.const.ERR_M_MAIL_MESSAGES_FOLDER_IS_EMPTY)}</b>
	</td>
</tr>
</table>

{else}
{* Показываем фложение *}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr height="65px" valign="middle">
	<td>

		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td class="place_title"><span>{$page.folder.name}</span></td>
		</tr>
		</table>

	</td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td height="50px"></td>
</tr>
</table>
	


{if count($page.error.err)>0}	
{include  file="`$TEMPLATE.errors`" errors_list=$page.error.err}
{/if}

<br />


{/if}
