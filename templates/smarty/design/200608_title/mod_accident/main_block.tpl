<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td colspan="2">
			<table class="t12" cellpadding="0" cellspacing="0" border="0">
				<tr><td class="block_caption_main" align="left" style="padding:1px;padding-left:10px;padding-right:10px;"><a href="/service/go/?url={"`$BLOCK.module_url`/"|escape:"url"}" target="_blank">Автокатастрофы</a></td></tr>
			</table>
		</td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="3">
	{foreach from=$BLOCK.list.list item=l}
		<tr> 
			<td valign=top align="left">
				<a href="/service/go/?url={"`$BLOCK.module_url`/show/`$l.id`.html"|escape:"url"}" target="_blank"><img src="{$l.img.file}" width="{$l.img.w}" height="{$l.img.h}" align="left" border="0" alt="{$l.name|strip_tags}" style="margin-right:3px;margin-bottom:3px;" /></a>
				<a href="/service/go/?url={"`$BLOCK.module_url`/show/`$l.id`.html"|escape:"url"}" class="zag1" target="_blank"><b>Фоторепортажи с мест ДТП</b></a><br/> Мы предлагаем вашему вниманию фоторепортажи с мест ДТП, произошедших в области в прошлом и текущем году. Размещая эти фотографии, мы хотим еще раз напомнить о том, к чему может привести неосторожное поведение ...
		                <br/><div align="right" class="otzyv"><a style="color:red;" href="/service/go/?url={"`$BLOCK.module_url`/addaccid/"|escape:"url"}" target="_blank">Добавить фоторепортаж</a></div>
			</td>
		</tr>
	{/foreach}
</table>