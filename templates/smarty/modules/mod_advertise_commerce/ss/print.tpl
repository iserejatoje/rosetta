<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><table align="left" width="100%" cellpadding="6" cellspacing="1" border="0" bgcolor="#ffffff">
		<tr bgcolor="#E9EFEF" align="center">
			<td colspan="2" class="t1><b>Просмотр данных по объявлению {$page.adv.id}</b></td>
		</tr>
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Раздел:</td>
			<td>{$ENV._arrays.rubrics[$page.adv.rub]}</td>
		</tr>
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Дата:</td>
			<td>{"d-m-Y H:i"|date:$page.adv.date_start}</td>
		</tr>
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Тип недвижимости:</td>
			<td><b>{$ENV._arrays.objects[$page.adv.object].b}</b></td>
		</tr>
		{if is_array($ENV._arrays.types[$page.adv.object]) && $ENV._arrays.types[$page.adv.object][$page.adv.type]}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Тип здания:</td>
			<td><b>{$ENV._arrays.types[$page.adv.object][$page.adv.type]}</b></td>
		</tr>
		{/if}
		{if $page.adv.object != 10}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Состояние:</td>
			<td>{$ENV._arrays.status[$page.adv.status].b}</td>
		</tr>
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Отделка:</td>
			<td>{$ENV._arrays.decoration[$page.adv.decoration].b}</td>
		</tr>
		{/if}
		{if trim($page.adv.address) != ''}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Адрес:</td>
			<td>{$page.adv.address}</td>
		</tr>
		{/if}
{if $page.adv.area_build}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Площадь помещения:</td>
			<td>{if intval($page.adv.area_build) < floatval($page.adv.area_build)}
				{$page.adv.area_build|number_format:2:'.':' '}
			{else}
				{$page.adv.area_build|number_format:0:'':' '} 
			{/if} кв.м.</td>
		</tr>
{/if}
	<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Этажность:</td>
			<td>{if $page.adv.floor}{$page.adv.floor}{else}-{/if}/{if $page.adv.floors}{$page.adv.floors}{else}-{/if}</td>
		</tr>
		{if $ENV._arrays.phone[$page.adv.phone]}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Телефон:</td>
			<td>{$ENV._arrays.phone[$page.adv.phone]}</td>
		</tr>
		{/if}
{if $page.adv.area_site > 0 }
		<tr bgcolor="#FFFFFF" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Площадь участка:</td>
			<td>{if intval($page.adv.area_site) < floatval($page.adv.area_site)}
				{$page.adv.area_site|number_format:2:'.':' '} 
			{else}
				{$page.adv.area_site|number_format:0:'':' '} 
			{/if}
			{$ENV._arrays.site_unit[$page.adv.area_site_unit]}</td>
		</tr>
{/if}
{if $page.adv.description|trim}
		<tr bgcolor="#FFFFFF" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Доп. информация:</td>
			<td>{$page.adv.description}</td>
		</tr>
{/if}
{if $page.adv.price>0}
		<tr bgcolor="#FFFFFF" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Цена:</td>
			<td>
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
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Контакты:</td>
			<td>{$page.adv.contacts|strip_tags}</td>
		</tr>
{/if}
{if $page.adv.img1}
		<tr bgcolor="#ffffff" align="left">
			<td align="center" colspan="2"><img src="{$page.adv.img1.src}" width="{$page.adv.img1.w}" height="{$page.adv.img1.h}" alt="Фото" /></td>
		</tr>
{/if}
		</table>
	</td>
</tr>
</table>