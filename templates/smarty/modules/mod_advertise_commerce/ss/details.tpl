	{$page.top}
	<br /><br />
	{if $page.errors !== null}
		<div align="center" style="color:red"><b>{$page.errors}</b></div>
	{else}
<table align="center" width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
	<td><table align="left" width="100%" cellpadding="6" cellspacing="1" border="0" bgcolor="#ffffff">
		<tr class="s_table">
			<td colspan="3">
			<table align="left" width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr><td width="50%" class="menu2"><b>Просмотр данных по объявлению {$page.adv.id}</b></td>
				<td width="50%" class="menu" style="color:#C3E6EA; font-weight:normal;" align="right">(просмотров:&nbsp;{if intval($page.adv.views) < floatval($page.adv.views)}{$page.adv.views|number_format:2:'.':' '}{else}{$page.adv.views|number_format:0:'':' '}{/if})</td>
			</tr>
			</table>
			</td>
		</tr>
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Раздел:</td>
			<td>{$ENV._arrays.rubrics[$page.adv.rub]}</td>
		</tr>
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Дата:</td>
			<td>{"d-m-Y H:i"|date:$page.adv.date_start}</td>
		</tr>
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Тип недвижимости:</td>
			<td><b>{$ENV._arrays.objects[$page.adv.object].b}</b></td>
		</tr>
		{if is_array($ENV._arrays.types[$page.adv.object]) && $ENV._arrays.types[$page.adv.object][$page.adv.type]}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Тип здания:</td>
			<td><b>{$ENV._arrays.types[$page.adv.object][$page.adv.type]}</b></td>
		</tr>
		{/if}
		{if $page.adv.object != 10}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Состояние:</td>
			<td>{$ENV._arrays.status[$page.adv.status].b}</td>
		</tr>
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Отделка:</td>
			<td>{$ENV._arrays.decoration[$page.adv.decoration].b}</td>
		</tr>
		{/if}
		{if trim($page.adv.address) != ''}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Адрес:</td>
			<td>{$page.adv.address}</td>
		</tr>
		{/if}
{if $page.adv.area_build}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Площадь помещения:</td>
			<td>{if intval($page.adv.area_build) < floatval($page.adv.area_build)}
				{$page.adv.area_build|number_format:2:'.':' '}
			{else}
				{$page.adv.area_build|number_format:0:'':' '} 
			{/if} кв.м.</td>
		</tr>
{/if}
	<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Этажность:</td>
			<td>{if $page.adv.floor}{$page.adv.floor}{else}-{/if}/{if $page.adv.floors}{$page.adv.floors}{else}-{/if}</td>
		</tr>
		{if $ENV._arrays.phone[$page.adv.phone]}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Телефон:</td>
			<td>{$ENV._arrays.phone[$page.adv.phone]}</td>
		</tr>
		{/if}
{if $page.adv.area_site > 0 }
		<tr bgcolor="#FFFFFF" align="left">
			<td align="right" width="150"  class="bg_color4">Площадь участка:</td>
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
			<td align="right" width="150"  class="bg_color4">Доп. информация:</td>
			<td>{$page.adv.description}</td>
		</tr>
{/if}
{if $page.adv.price>0}
		<tr bgcolor="#FFFFFF" align="left">
			<td align="right" width="150"  class="bg_color4">Цена:</td>
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
{if $page.adv.contacts|trim != ''}
		<tr bgcolor="#ffffff" align="left">
			<td align="right" width="150"  class="bg_color4">Контакты:</td>
			<td>{$page.adv.contacts|strip_tags|trim}</td>
		</tr>
{/if}
{if $page.adv.img1}
		<tr bgcolor="#ffffff" align="left">
			<td align="center" colspan="3" class="ssyl"><a name="photo"></a><img src="{$page.adv.img1.src}" width="{$page.adv.img1.w}" height="{$page.adv.img1.h}" alt="Фото" /></td>
		</tr>
{/if}
	
		<tr>
			<td align="left">
				<a class="ssyl" href="/{$ENV.section}/print.html?id={$page.adv.id}" target="print" onclick="window.open('about:blank', 'print','width=550,height=600,resizable=1,menubar=0,scrollbars=1').focus();">Версия для печати</a>
			</td>
			<td align="center">{if $USER->IsAuth() && !$page.adv.favorites}<a class="ssyl" href="#" id="ln{$page.adv.id}" onclick="mod_realty.toFavorites({$page.adv.id}); return false;">Добавить в избранное</a>{/if}</td>
			<td align="right">
				<a href="http://www.{$CURRENT_ENV.site.regdomain}/search/search.php?action=search&a_c={$CURRENT_ENV.site.search_code}&text={$page.adv.address|rawurlencode}" class="ssyl" target="_blank">Поиск "{$page.adv.address|truncate:40}"</a>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
<br/><br/><center><span class="txt_color1">Пожалуйста, сообщите продавцу, что вы нашли это объявление на сайте {$CURRENT_ENV.site.domain}!</span></center>
{/if}<br /><br />

						

			