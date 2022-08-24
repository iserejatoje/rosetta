{if $UERROR->GetErrorByIndex('global') != ''}
	<div style="text-align: center; color:red;">{$UERROR->GetErrorByIndex('global')}</div>
{else}

<form id="cancel">
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="node" value="{$parent}" />
{$SECTION_ID_FORM}
</form>

<p><b>
	{foreach from=$path item=p name=path}
		<a href="?{$SECTION_ID_URL}&action=catalog&node={$p->id}&treeid={$p->treeid}">{$p->Title}</a>
		{if !$smarty.foreach.path.last} &nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp; {/if}
	{/foreach}{if $place} &nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp; {$place->Name}{/if}</b>
</p>



<form name="firmform" method="post" enctype="multipart/form-data">
{$SECTION_ID_FORM}
<input type="hidden" name="treeid" value="{$treeid}" />
<input type="hidden" name="action" value="{$action}" />
<input type="hidden" name="parent" value="{$parent}" />
<input type="hidden" name="productid" value="{$product->ID}" />
<input type="hidden" name="photoid" value="{$form.PhotoID}" />

<table width="100%" cellspacing="1" cellpadding="2">
	{if $form.Created}
	<tr>
		<td bgcolor="#F0F0F0">Дата создания / редактирования</td>
		<td width="85%">{$form.Created} / {$form.LastUpdated}</td>
	</tr>
	{/if}	
	<tr>
		<td bgcolor="#F0F0F0">Показывать</td>
		<td width="85%"><input type="checkbox" name="IsVisible" value="1"{if $form.IsVisible==1} checked{/if}></td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('Name') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('Name')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0" width="150">Название</td>
		<td width="85%"><input type="text" name="Name" value="{$form.Name}" class="input_100"></td>
	</tr>
	
	{if $UERROR->GetErrorByIndex('photo_small') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('photo_small')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Фото маленькое</td>
		<td width="85%">
			{if !empty($form.PhotoSmall.f)}
			<br><img src="{$form.PhotoSmall.f}">
			<input type="checkbox" name="del_photosmall" value="1"/> удалить
			{/if}
			<input type="file" name="photosmall" value="" class="input_100">
		</td>
	</tr>

	{if $UERROR->GetErrorByIndex('photo_big') != ''}
	<tr>
		<td bgcolor="#F0F0F0"></td>
		<td width="85%" style="color:red;">{$UERROR->GetErrorByIndex('photo_big')}</td>
	</tr>
	{/if}
	<tr>
		<td bgcolor="#F0F0F0">Фото большое</td>
		<td width="85%">
			{if !empty($form.PhotoBig.f)}
			<br><img src="{$form.PhotoBig.f}">
			<input type="checkbox" name="del_logotypebig" value="1"/> удалить
			{/if}
			<input type="file" name="photobig" value="" class="input_100">
		</td>
	</tr>
	
</table>
<center><br><input type="submit" value="Сохранить" /> <input type="button" value="Назад" onclick="fcancel();"></center>
</form>
{/if}