
{if is_array($res.place_list) && sizeof($res.place_list)}

{capture name=pageslink}
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

<!-- PlaceList [BEGIN] -->
{if $smarty.capture.pageslink!="" }<div class="text11" style="float:left">{$smarty.capture.pageslink}</div>{/if}
<div class="text11"  style="float:right">Всего компаний: {$res.place_count}</div>
<br/><br/>

<table cellpadding="0" cellspacing="2" border="0" width="100%" class="table2">
	<tr>
		<th>Название компании</th>
		<th>Адрес</th>
		<th>Размещено</th>
		<th>Отредактировано</th>
		<th>Телефон</th>
	</tr>
{excycle values=" ,bg_color4"}
{foreach from=$res.place_list item=l}
	<tr class="{excycle}" valign="top">		
		<td align="center">
			<a href="/{$ENV.section}/edit/{$l.PlaceID}/">{$l.Name}</a>
		</td>
		<td align="center">{if $l.Address->Text}{$l.Address->Text}{else}{$l.Address->CityAsText}{if $l.Address->StreetText}, {$l.Address->StreetText}{/if}{if $l.Address->HouseText}, {$l.Address->HouseText}{/if}{/if}</td>
		<td align="center">{$l.Created}</td>
		<td align="center">{$l.LastUpdated}</td>
		<td align="center">
			{if $l.ContactPhone}{$l.ContactPhone}{else}–{/if}
		</td>
	</tr>
{/foreach}
</table>

<br/>
{if $smarty.capture.pageslink!="" }<div class="text11" style="float:left">{$smarty.capture.pageslink}</div>{/if}
<div class="text11"  style="float:right">Всего компаний: {$res.place_count}</div>

<!-- PlaceList [END] -->
{else}
	<br/><br/><div align="center" class="error"><span><b>Список компаний пуст.</b></span>
{/if}