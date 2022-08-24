
{if empty($res.section_list) && empty($res.place_list) }

	<br/><br/><div align="center" class="error"><span><b>Запрошенный вами раздел не найден.</b></span>
	<br/><br/>
	<a href="/{$ENV.section}/list/">К списку разделов</a>
	</div>

{else}

<br/>
<table class="table2" width="100%">
	<tr>
		<td class="text11" align="center">
			<b>{foreach from=$TITLE->Path item=url name=path}{
				if !$smarty.foreach.path.first}&nbsp;/&nbsp;{/if
				}{if !$smarty.foreach.path.last || !empty($url.link)
					}<a href="/{$ENV.section}/{$url.link}">{$url.name}</a>{
				else
					}{$url.name}{
				/if}{/foreach}</b>
		</td>
	</tr>
	<tr>
		<td height="3"><img src="/_img/x.gif" width="1" height="3"></td>
	</tr>
</table>

{if is_array($res.section_list) && sizeof($res.section_list)}
<!-- SectionList [BEGIN] -->

<table cellpadding="0" cellspacing="7" align="center">
	<tr> 
		<td height="1" bgcolor="#ECECEC"><img src="/_img/x.gif" width="1" height="1"></td> 
	</tr>
{foreach from=$res.section_list item=l}
	<tr>
		<td>
			<a href="/{$ENV.section}/list/{$l.id}/" >{$l.name}</a> ({$l.count})
		</td>
	</tr>
	<tr> 
		<td height="1" bgcolor="#ECECEC"><img src="/_img/x.gif" width="1" height="1"></td> 
	</tr>
{/foreach}
</table>
<!-- SectionList [END] -->
<br/><br/>
{/if}

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
		<th>Телефон</th>
	</tr>
{excycle values=" ,bg_color4"}
{foreach from=$res.place_list item=l}
	<tr class="{excycle}" valign="top">		
		<td align="center">
			{if $l.LogotypeSmall.file}
				<a href="/{$ENV.section}/details/{$res.section}/{$l.PlaceID}/"><img src="{$l.LogotypeSmall.file}" width="{$l.LogotypeSmall.w}" height="{$l.LogotypeSmall.h}" border="0"/></a><br/>
				<img src="/_img/x.gif" width="1" height="5"><br/>
			{/if}
			<a href="/{$ENV.section}/details/{$res.section}/{$l.PlaceID}/">{$l.Name}</a>
		</td>
		<td align="center">{if $l.Address->Text}{$l.Address->Text}{else}{$l.Address->CityAsText}{if $l.Address->StreetText}, {$l.Address->StreetText}{/if}{if $l.Address->HouseText}, {$l.Address->HouseText}{/if}{/if}</td>
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

{/if}
{/if}
<br/><br/>