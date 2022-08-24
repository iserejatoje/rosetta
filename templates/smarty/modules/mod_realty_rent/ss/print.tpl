<div class="title" style="padding:5px;">Просмотр данных по объявлению {$page.adv.id} {if $page.adv.agent}&nbsp;<img src="/_img/modules/realty/icon_{if $page.adv.agent==1}s{else}a{/if}.png" alt="от {$ENV._arrays.agent[$page.adv.agent].b}" title="от {$ENV._arrays.agent[$page.adv.agent].b}"><font class="menu" style="color:#C3E6EA; font-weight:normal;"> <nobr>от {$ENV._arrays.agent[$page.adv.agent].b}</nobr></font>{/if}</div>

	<table width="100%" cellspacing="1" border="0" class="table2">
		<tr>
			<td align="right" width="150" class="bg_color2">Раздел:</td>
			<td colspan="2" class="bg_color4">{$ENV._arrays.rubrics[$page.adv.rub]}</td>
		</tr>
		<tr>
			<td align="right" width="150" class="bg_color2">Дата:</td>
			{* <td colspan="2" class="bg_color4">{"d-m-Y H:i"|date:$page.adv.date_start}</td> *}
			<td colspan="2" class="bg_color4">{$page.adv.date_start|date_format:"%d.%m.%Y %H:%M"}</td>
		</tr>
		<tr>
			<td align="right" width="150" class="bg_color2">Тип жилья:</td>
			<td colspan="2" class="bg_color4"><b>{$ENV._arrays.objects[$page.adv.object].b}</b></td>
		</tr>
		<tr>
			<td align="right" width="150" class="bg_color2">Район:</td>
			<td colspan="2" class="bg_color4">{$ENV._arrays.regions[$page.adv.region].b}</td>
		</tr>
		<tr>
			<td align="right" width="150" class="bg_color2">Серия:</td>
			<td colspan="2" class="bg_color4">{$ENV._arrays.series[$page.adv.series].b}</td>
		</tr>
		<tr>
			<td align="right" width="150" class="bg_color2">Тип дома:</td>
			<td colspan="2" class="bg_color4">{$ENV._arrays.build_type[$page.adv.build_type].b}</td>
		</tr>
		{if $page.adv.object != 10}
		<tr>
			<td align="right" width="150" class="bg_color2">Состояние:</td>
			<td colspan="2" class="bg_color4">{$ENV._arrays.status[$page.adv.status].b}</td>
		</tr>
		<tr>
			<td align="right" width="150" class="bg_color2">Отделка:</td>
			<td colspan="2" class="bg_color4">{$ENV._arrays.decoration[$page.adv.decoration].b}</td>
		</tr>
		{/if}
		{if trim($page.adv.address) != ''}
		<tr>
			<td align="right" width="150" class="bg_color2">Адрес:</td>
			<td colspan="2" class="bg_color4">{$page.adv.address}</td>
		</tr>
		{/if}
{if $page.adv.area_build}
		<tr>
			<td align="right" width="150" class="bg_color2">Площадь помещения:</td>
			<td colspan="2" class="bg_color4">{if intval($page.adv.area_build) < floatval($page.adv.area_build)}
				{$page.adv.area_build|number_format:2:'.':' '}
			{else}
				{$page.adv.area_build|number_format:0:'':' '}
			{/if} кв.м.</td>
		</tr>
{/if}
	<tr>
			<td align="right" width="150" class="bg_color2">Этажность:</td>
			<td colspan="2" class="bg_color4">{if $page.adv.floor}{$page.adv.floor}{else}-{/if}/{if $page.adv.floors}{$page.adv.floors}{else}-{/if}</td>
		</tr>
		{if $page.adv.phone == 1}
		<tr>
			<td align="right" width="150" class="bg_color2">Телефон:</td>
			<td colspan="2" class="bg_color4">{$ENV._arrays.phone[$page.adv.phone]}</td>
		</tr>
		{/if}
{if $page.adv.area_site > 0 }
		<tr>
			<td align="right" width="150" class="bg_color2">Площадь участка:</td>
			<td colspan="2" class="bg_color4">{if intval($page.adv.area_site) < floatval($page.adv.area_site)}
				{$page.adv.area_site|number_format:2:'.':' '}
			{else}
				{$page.adv.area_site|number_format:0:'':' '}
			{/if}
			{$ENV._arrays.site_unit[$page.adv.area_site_unit]}</td>
		</tr>
{/if}
		<tr>
			<td align="right" width="150" class="bg_color2">Доп. информация:</td>
			<td colspan="2" class="bg_color4">{$page.adv.description}</td>
		</tr>
{if $page.adv.price>0}
		<tr>
			<td align="right" width="150" class="bg_color2">Цена:</td>
			<td colspan="2" class="bg_color4">
				{if intval($page.adv.price) < floatval($page.adv.price)}
					{$page.adv.price|number_format:2:'.':' '}
				{else}
					{$page.adv.price|number_format:0:'':' '}
				{/if}
				тыс. руб. <font class="small">({$ENV._arrays.price_unit[$page.adv.price_unit].b})</font>
			</td>
		</tr>
{/if}
{if $page.adv.contacts}
		<tr>
			<td align="right" width="150" class="bg_color2">Контакты:</td>
			<td colspan="2" class="bg_color4">{$page.adv.contacts}</td>
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
	</td>
</tr>
</table>