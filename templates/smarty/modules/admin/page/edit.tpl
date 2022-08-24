{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align:center;padding: 10px;">{$UERROR->GetErrorByIndex('global')}</div>
{else}

<script language="javascript" type="text/javascript">{literal}
	function fcancel()
	{
		document.getElementById('cancel').submit();
	}
{/literal}</script>
<form id="cancel">
{$SECTION_ID_FORM}
</form>

<form method="post" enctype="multipart/form-data">
	{$SECTION_ID_FORM}
	<input type="hidden" name="action" value="{$form.action}" />
	{if $id}<input type="hidden" name="id" value="{$id}" />{/if}

	<table width="100%" cellspacing="1" class="dTable">
		<tr>
			<td bgcolor="#F0F0F0" nowrap="nowrap">Показывать статью</td>
			<td width="100%">
				<input type="checkbox" name="IsVisible" value="1"{if $form.IsVisible==1} checked{/if}>
			</td>
		</tr>
		{if $UERROR->GetErrorByIndex('Name') != ''}
		<tr>
			<td bgcolor="#F0F0F0"></td>
			<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Name')}</td>
		</tr>
		{/if}
		<tr>
			<td bgcolor="#F0F0F0">Название</td>
			<td><input type="text" name="Name" value="{$form.Name}" class="input_100"></td>
		</tr>
		{if $UERROR->GetErrorByIndex('AnnounceText') != ''}
		<tr>
			<td bgcolor="#F0F0F0"></td>
			<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('AnnounceText')}</td>
		</tr>
		{/if}
		<tr>
			<td bgcolor="#F0F0F0">Анонс</td>
			<td><textarea name="AnnounceText" style="height:150px;" class="input_100">{$form.AnnounceText}</textarea></td>
		</tr>
		<tr>
			<td colspan="2">
				<textarea name="Text" class="mceEditor" style="width: 100%;height:550px;">{$form.Text}</textarea>
			</td>
		</tr>
	</table>

	<center>
		<input type="submit" value="Сохранить" />
		<input type="reset" value="Очистить" />
		<input type="button" value="Назад" onclick="fcancel();">
	</center>
</form>

{/if}