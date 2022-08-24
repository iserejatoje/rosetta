<div class="title2_news">{$res.status}</div>
<br/>
<br/>
{if count($res.list)}

	{capture name=pages}
	{if count($res.pages.btn) > 0}
		Страницы:&#160;
		{if !empty($res.pages.back)}<a href="{$res.pages.back}" title="Предыдущая страница">&lt;&lt;&lt;</a>{/if}{
		foreach from=$res.pages.btn item=l}
			{if !$l.active
				}<a href="{$l.link}">[{$l.text}]</a>&nbsp;{
			else
				}[{$l.text}]&nbsp;{
			/if}{
		/foreach}{
		if !empty($res.pages.next)}<a href="{$res.pages.next}" title="Следующая страница">&gt;&gt;&gt;</a>{/if}
	{/if}
	{/capture}

	{$smarty.capture.pages}

	<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
	<tr bgcolor="#B3C9D7">
	    <th class="menu4" width="50">№</th>
	    <th class="menu4" width="50">Дата</th>
	    <th class="menu4">Наименование продаваемого объекта</th>
		<th class="menu4">Статус имущества</th>
		<th class="menu4" width="100">Цена, руб.</th>
	    {if !$res.hide_company}<th class="menu4" width="200">Компания-продавец</th>{/if}
	</tr>

	{excycle values=",bg_color4"}

	{foreach from=$res.list item=l}
	<tr class="{excycle}"> 
		<td align="center">{$l.ObjectID}</td>
		<td align="center"><small><span class="dop4">{$l.Time}</span><br/>{$l.Date}</small></td>
		<td><a href="/{$ENV.section}/detail/{$l.ObjectID}.php">{$l.Name}</a></td>
		<td align="center">{if !empty($l.StatusName)}{$l.StatusName}{else}-{/if}</td>
		<td align="center">{if !empty($l.Price) && $l.Price!='0,00'}{$l.Price|replace:".":","}{else}-{/if}</td>		
		{if !$res.hide_company}<td><a href="/{$ENV.section}/firm/{$l.FirmID}/1.php">{$l.Company}</a></td>{/if}
		
	</tr>
	{/foreach}

	</table>

	{$smarty.capture.pages}

{else}
	<div align="center">
		<b>Нет объявлений с данным статусом</b>
	</div>
{/if}