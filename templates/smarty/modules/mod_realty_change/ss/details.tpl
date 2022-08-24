	{$page.top}
	<br /><br />
	{if $page.errors !== null}
		<div align="center" style="color:red"><b>{$page.errors}</b></div>
	{else}

	<div class="title" style="padding:5px;">Просмотр данных по объявлению {$page.adv.id}</div>
	<div style="padding:5px;text-align:right" class="text11">(просмотров:&nbsp;{if intval($page.adv.views) < floatval($page.adv.views)}{$page.adv.views|number_format:2:'.':' '}{else}{$page.adv.views|number_format:0:'':' '}{/if})</div>

	<table width="100%" cellspacing="1" class="table2">
		<tr>
			<td align="right" width="150" class="bg_color2">Раздел:</td>
			<td colspan="2" class="bg_color4">{$ENV._arrays.rubrics[$page.adv.rub]}</td>
		</tr>
		<tr>
			<td align="right" width="150" class="bg_color2">Дата:</td>
			{* <td colspan="2" class="bg_color4">{"d-m-Y H:i"|date:$page.adv.date_start}</td> *}
			<td colspan="2" class="bg_color4">{$page.adv.date_start|date_format:"%d.%m.%Y %H:%M"}</td>
		</tr>
		{if $page.adv.scheme}
		<tr>
			<td align="right" width="150" class="bg_color2">Схема обмена:</td>
			<td colspan="2" class="bg_color4">{$page.adv.scheme}</td>
		</tr>
		{/if}
		{if $page.adv.have}
		<tr>
			<td align="right" width="150" class="bg_color2">Имеется:</td>
			<td colspan="2" class="bg_color4">{$page.adv.have}</td>
		</tr>
		{/if}
		{if $page.adv.need}
		<tr>
			<td align="right" width="150" class="bg_color2">Требуется:</td>
			<td colspan="2" class="bg_color4">{$page.adv.need}</td>
		</tr>
		{/if}
{if $page.adv.description|trim}
		<tr>
			<td align="right" width="150" class="bg_color2">Доп. информация:</td>
			<td colspan="2" class="bg_color4">{$page.adv.description}</td>
		</tr>
{/if}
{if $page.adv.contacts|trim != ''}
		<tr>
			<td align="right" width="150" class="bg_color2">Контакты:</td>
			<td colspan="2" class="bg_color4">{$page.adv.contacts|strip_tags|trim}
{*if !empty($res.data.replyjs)}
			<br><a href="#" onclick="{$res.data.replyjs};return false;">Отправить личное сообщение.</a>
{elseif !$USER->IsAuth() && $page.adv.uid>0}
			<br><span style="font-size: 11px;">Чтобы отправить личное сообщение, <a href="/passport/login.php?url={$smarty.server.REQUEST_URI|escape:'url'}">авторизуйтесь</a>. <a href="/passport/register.php?url={$smarty.server.REQUEST_URI|escape:'url'}">Зарегистрироваться</a>.</span>
{/if*}
			</td>
		</tr>
{/if}
{if count($page.adv.img)>0}
<a name="photo"></a>
{foreach from=$page.adv.img item=l key=k}
{if $l.src}
		<tr>
			<td align="center" colspan="3" class="ssyl"><img src="{$l.src}" width="{$l.w}" height="{$l.h}" alt="Фото {$k}" /></td>
		</tr>
{/if}
{/foreach}
{/if}
		<tr>
			<td align="left">
				<a class="ssyl" href="/{$ENV.section}/print.html?id={$page.adv.id}" target="print" onclick="window.open('about:blank', 'print','width=550,height=600,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a>
			</td>
			{if trim($page.adv.address) != ''}
			<td align="center">{if $USER->IsAuth() && !$page.adv.favorites}<a class="ssyl" href="#" id="ln{$page.adv.id}" onclick="mod_realty.toFavorites({$page.adv.id}); return false;">Добавить объявление в избранное</a>{/if}</td>
			<td align="right">
				{if trim($page.adv.address) != ''}<a href="/search/search.php?action=search&a_c={$CURRENT_ENV.site.search_code}&text={$page.adv.address|rawurlencode}" class="ssyl" target="_blank">Поиск "{$page.adv.address|truncate:40}"</a>{else}&nbsp;{/if}
			</td>
			{else}
			<td></td>
			<td align="right">{if $USER->IsAuth() && !$page.adv.favorites}<a class="ssyl" href="#" id="ln{$page.adv.id}" onclick="mod_realty.toFavorites({$page.adv.id}); return false;">Добавить объявление в избранное</a>{/if}</td>
			{/if}
		</tr>
	</table>
{/if}