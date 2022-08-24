<div class="title" style="padding:5px;">Просмотр данных по объявлению {$page.adv.id}</div>

	<table width="100%" cellspacing="1" border="0" class="table2">
	<tr>
		<td><table align="left" width="100%" cellpadding="6" cellspacing="1" border="0" bgcolor="#ffffff">
			<tr>
				<td align="right" width="150" class="bg_color2">Раздел:</td>
				<td class="bg_color4">{$ENV._arrays.rubrics[$page.adv.rub]}</td>
			</tr>
			<tr>
				<td align="right" width="150" class="bg_color2">Дата:</td>
				{* <td class="bg_color4">{"d-m-Y H:i"|date:$page.adv.date_start}</td> *}
				<td colspan="2" class="bg_color4">{$page.adv.date_start|date_format:"%d.%m.%Y %H:%M"}</td>
			</tr>
			{if $page.adv.scheme}
			<tr>
				<td align="right" width="150" class="bg_color2">Схема обмена:</td>
				<td class="bg_color4">{$page.adv.scheme}</td>
			</tr>
			{/if}
			{if $page.adv.have}
			<tr>
				<td align="right" width="150" class="bg_color2">Имеется:</td>
				<td class="bg_color4">{$page.adv.have}</td>
			</tr>
			{/if}
			{if $page.adv.need}
			<tr>
				<td align="right" width="150" class="bg_color2">Требуется:</td>
				<td class="bg_color4">{$page.adv.need}</td>
			</tr>
			{/if}
	{if $page.adv.description|trim}
			<tr>
				<td align="right" width="150" class="bg_color2">Доп. информация:</td>
				<td class="bg_color4">{$page.adv.description}</td>
			</tr>
	{/if}
	{if $page.adv.contacts}
			<tr>
				<td align="right" width="150" class="bg_color2">Контакты:</td>
				<td class="bg_color4">{$page.adv.contacts|strip_tags}</td>
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
			</table>

</div>