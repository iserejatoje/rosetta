{if $UERROR->GetErrorByIndex('global') != ''}
  <div align="center" style="color:red" class="error">{$UERROR->GetErrorByIndex('global')}</div>
{else}

{if $action == 'edit_photo'}
<script type="text/javascript" src="/_scripts/themes/frameworks/jquery/cropimage/cropimage.js"></script>

<script type="text/javascript">
{literal}
	$(document).ready(function() {

		$('#crop_photo_div').CropImageCreate(
			'{/literal}{$photo.url}{literal}', 
			{/literal}{$photo.width}{literal}, 
			{/literal}{$photo.height}{literal}, 
			{/literal}{if $photo.width > $photo.min_width}{$photo.min_width}{else}{$photo.width}{/if}{literal}, 
			{/literal}{if $photo.height > $photo.min_height}{$photo.min_height}{else}{$photo.height}{/if}{literal}, 
			1,
			{
				afterSetBox: function(box) {
			
					var obj = box.getCoords();
					
					$('#thumb_top').val(obj.top);
					$('#thumb_left').val(obj.left);
					$('#thumb_width').val(obj.width);
					$('#thumb_height').val(obj.height);					
				}
			});
	});
{/literal}
</script>
{/if}

<script language="javascript" type="text/javascript">{literal}
function fcancel()
{
	document.getElementById('cancel').submit();
}
{/literal}</script>
<form id="cancel">
<input type="hidden" name="action" value="gallery" />
{if $newsid}<input type="hidden" name="id" value="{$newsid}" />{/if}
{$SECTION_ID_FORM}
</form>
{*if sizeof($UERROR->ERRORS)}
	<div align="center" style="color:red"><b>{$UERROR->GetErrorsText()}</b></div><br/>
{/if*}

<form method="post" enctype="multipart/form-data">
	{$SECTION_ID_FORM}
	<input type="hidden" name="action" value="{$action}" />
	<input type="hidden" name="descr" value="" />
	{if $newsid}<input type="hidden" name="id" value="{$newsid}" />{/if}
	{if $albumid}<input type="hidden" name="albumid" value="{$albumid}" />{/if}
	{if $photoid}<input type="hidden" name="photoid" value="{$photoid}" />{/if}

	<table width="100%" cellspacing="1" class="dTable">
		<tr>
			<td bgcolor="#F0F0F0" width="150">Показывать фото</td>
			<td>
				<input type="checkbox" name="visible" value="1"{if $visible==1} checked{/if}>
			</td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Название</td>
			<td><input type="text" name="title" value="{$title}" class="input_100"></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Позиция</td>
			<td><input type="text" name="order" value="{$order}" class="input_100"></td>
		</tr>
		<tr>
			<td bgcolor="#F0F0F0">Анонс</td>
			<td><textarea name="descr" style="height:150px;" class="input_100">{$descr}</textarea></td>
		</tr>
		{if $action == 'new_photo'}
		<tr>
			<td bgcolor="#F0F0F0">Вставить логотип</td>
			<td><input type="checkbox" name="input_logo" value="1" checked></td>
		</tr>
		{/if}
		{if $UERROR->GetErrorByIndex('photo') != ''}
		<tr>
			<td bgcolor="#F0F0F0"></td>
			<td style="color:red;">{$UERROR->GetErrorByIndex('photo')}</td>
		</tr>
		{/if}
		{if $action == 'edit_photo'}
		<tr>
			<td bgcolor="#F0F0F0">Фото<br /></td>
			<td><img src="{$photo.url}" width="{$photo.width}" height="{$photo.height}"/></td>
		</tr>
		{/if}
		{if $action != 'edit_photo'}
		<tr>
			<td bgcolor="#F0F0F0">Фото<br /></td>
			<td><input type="file" name="photo" class="input_100"></td>
		</tr>
		{else}
		<tr>
			<td bgcolor="#F0F0F0">Обрезать изображение</td>
			<td><input type="checkbox" name="cropimage" onclick="this.checked ? $('#cropimg').css('display', '') : $('#cropimg').css('display', 'none')" value="1"></td>
		</tr>
		{/if}
	</table>

	{if $action == 'edit_photo'}
	<table width="100%" cellspacing="1" class="dTable" id="cropimg" style="display:none">
		<tr>
			<td bgcolor="#F0F0F0" align="center">Большое изображение</td>
			<td bgcolor="#F0F0F0" align="center">Уменьшеное изображение</td>
		</tr>
		<tr>
			<td align="center">
				{if $photo.width > $photo.min_width || $photo.height > $photo.min_height}
				<input type="hidden" id="thumb_top" name="thumb[top]" value="">
				<input type="hidden" id="thumb_left" name="thumb[left]" value="">
				<input type="hidden" id="thumb_width" name="thumb[width]" value="">
				<input type="hidden" id="thumb_height" name="thumb[height]" value="">
				<div id="crop_photo_div"></div>
				{else}
				<img src="{$photo.url}" width="{$photo.width}" height="{$photo.height}"/></td>
				{/if}
			<td valign="top" align="center"><img src="{$thumb.url}" width="{$thumb.width}" height="{$thumb.height}"/></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td width="100%"></td>
		</tr>
	</table>
	{/if}
	
	<center>
		<input type="submit" value="Сохранить" /> 
		<input type="reset" value="Очистить" /> 
		<input type="button" value="Назад" onclick="fcancel();">
	</center>
<script type="text/javascript" language="javascript">
  {$UERROR->SetFocusToError()}
</script>
</form>
{/if}