<div class="title2_news">Мои объявления</div>
<br/>
<div align="right">Компания&nbsp;
	<select  name="FirmID" style="width:400px;" onchange="window.location.href='/{$ENV.section}/my/1.php?FirmID='+this.options[this.selectedIndex].value">		
		<option value="0" selected="selected">Все</option>
		{foreach from=$page.firms item=l}
			<option value="{$l.FirmID}" {if $l.FirmID==$page.FirmID}selected="selected"{/if}>{$l.Name}</option>
		{/foreach}
	</select>
</div>
<br/>
<br/>
{capture name=pages}
{if count($page.pages.btn) > 0}
	Страницы:&#160;
	{if !empty($page.pages.back)}<a href="{$page.pages.back}" title="Предыдущая страница">&lt;&lt;&lt;</a>{/if}{
	foreach from=$page.pages.btn item=l}
		{if !$l.active
			}<a href="{$l.link}">[{$l.text}]</a>&nbsp;{
		else
			}[{$l.text}]&nbsp;{
		/if}{
	/foreach}{
	if !empty($page.pages.next)}<a href="{$page.pages.next}" title="Следующая страница">&gt;&gt;&gt;</a>{/if}
{/if}
{/capture}

{$smarty.capture.pages}
{if sizeof($page.list)}
<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
<tr class="bg_color2">
    <th class="menu4" width="50">№</th>
    <th class="menu4">Наименование продаваемого объекта</th>
    {*<th class="menu4">Рубрика</th>*}
	<th class="menu4">Статус имущества</th>
	<th class="menu4" width="100">Цена, руб.</th>
    <th class="menu4">Фото</th>
    <th><input type="checkbox" onclick="$('.ids_actions').attr('checked',this.checked);" /></th>
</tr>

<form method="post">
<input type="hidden" name="action" value="delete" />

{excycle values=",bg_color4"}

{foreach from=$page.list item=l}
<tr class="{excycle}"> 
	<td align="center">{$l.ObjectID}</td>
	<td><a href="/{$ENV.section}/my/edit/{$l.ObjectID}.php">{$l.Name}</a></td>
	{*<td>{$l.Rubric}</td>*}
	<td align="center">{if !empty($l.StatusName)}{$l.StatusName}{else}-{/if}</td>
	<td align="center">{if !empty($l.Price) && $l.Price!='0,00'}{$l.Price|replace:".":","}{else}-{/if}</td>		
	<td align="center" width="18">{if $l.photos}<a href="/{$ENV.section}/my/gallery/{$l.ObjectID}.php"><img src="/_img/design/200710_fin/photo.gif" alt="фото" title="редактировать фото" border="0" width="18" height="12" />{/if}</td>
	<td align="center"><input type="checkbox" name="ids_delete[]" class="ids_actions" value="{$l.ObjectID}" /></td>
</tr>
{/foreach}

</table>

<div align="right"><br/>
	<input type="submit" value="Удалить объявления" />
</div>
</form>

{else}
	<br/><center>У Вас нет объявлений.</center>
{/if}

{$smarty.capture.pages}
