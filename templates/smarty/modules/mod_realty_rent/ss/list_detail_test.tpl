{capture name=pageslink}
{if $page.pageslink.btn}
  <table align="left" cellpadding="0" cellspacing="0" border="0">
  <tr valign="middle">
    <td {if $l.imp>0} style="color:red"{/if}style="font-size:11px"><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $page.pageslink.back!="" }<td {if $l.imp>0} style="color:red"{/if}style="font-size:11px"><a href="{$page.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td {if $l.imp>0} style="color:red"{/if}style="font-size:11px">
		{foreach from=$page.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<a href="{$l.link}" class="s5b">[{$l.text}]</a>&nbsp;
			{else}
				&nbsp;[{$l.text}]&nbsp;
			{/if}
		{/foreach}
    </td>
    {if $page.pageslink.next!="" }<td {if $l.imp>0} style="color:red"{/if}style="font-size:11px"><a href="{$page.pageslink.next}">&gt;&gt;&gt;</a></td>{/if}
  </tr>
  </table>
{/if}
{/capture}

{if $smarty.capture.pageslink}
	{$smarty.capture.pageslink}<br/><br/>
{/if}

{* Detail list *}

{foreach from=$page.list item=l key=_k}
			{* Table of data for each rows *}
			<table width="100%" cellspacing="1" border="0" class="table2">
				<tr>
					<th colspan="2">{$ENV._arrays.rubrics[$l.rub]}</h>
				</tr>
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Дата:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$l.date_start|simply_date}</td>
				</tr>
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Тип недвижимости:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4"><b>{$ENV._arrays.objects[$l.object].b}</b></td>
				</tr>
				{if $ENV._arrays.regions[$l.region].b}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Район:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$ENV._arrays.regions[$l.region].b}</td>
				</tr>
				{/if}
				{if $ENV._arrays.series[$l.series].b}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Серия:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$ENV._arrays.series[$l.series].b}</td>
				</tr>
				{/if}
				{if $ENV._arrays.build_type[$l.build_type].b}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Тип дома:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$ENV._arrays.build_type[$l.build_type].b}</td>
				</tr>
				{/if}
				{if $l.object != 10}
				{if $ENV._arrays.status[$l.status].b}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Состояние:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$ENV._arrays.status[$l.status].b}</td>
				</tr>
				{/if}
				{if $ENV._arrays.decoration[$l.decoration].b}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Отделка:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$ENV._arrays.decoration[$l.decoration].b}</td>
				</tr>
				{/if}
				{/if}
				{if $l.address|trim}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Адрес:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$l.address}&nbsp;{if $l.agent}&nbsp;<img src="/_img/modules/realty/icon_{if $l.agent==1}s{else}a{/if}.png" alt="От {$ENV._arrays.agent[$l.agent].b}" title="От {$ENV._arrays.agent[$l.agent].b}">{/if}{if !empty($l.img1) || !empty($l.img2) || !empty($l.img3)}&nbsp;<a href="/{$ENV.section}/details.html?id={$l.id}#photo"><img src="/_img/design/200608_title/common/photo_blue.gif" width="14" height="10" alt="Есть фото" title="Есть фото" border="0"></a>{/if}</td>
				</tr>
				{/if}
				{if $l.area_build > 0}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Площадь помещения:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{if intval($l.area_build) < floatval($l.area_build)}
				{$l.area_build|number_format:2:'.':' '}
			{else}
				{$l.area_build|number_format:0:'':' '}
			{/if} кв.м.</td>
				</tr>
				{/if}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Этажность:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{if $l.floor}{$l.floor}{else}-{/if}/{if $l.floors}{$l.floors}{else}-{/if}</td>
				</tr>
				{if $ENV._arrays.phone[$l.phone]}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Телефон:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$ENV._arrays.phone[$l.phone]}</td>
				</tr>
				{/if}
				{if $ENV._arrays.furnit[$l.furnit]}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Мебель:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$ENV._arrays.furnit[$l.furnit].b}</td>
				</tr>
				{/if}
				{if $l.area_site > 0 }
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Площадь участка:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">
					{if intval($l.area_site) < floatval($l.area_site)}
				{$l.area_site|number_format:2:'.':' '}
			{else}
				{$l.area_site|number_format:0:'':' '}
			{/if}
			{$ENV._arrays.site_unit[$l.area_site_unit]}</td>
				</tr>
				{/if}
				{if $l.description|trim}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Доп. информация:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$l.description}</td>
				</tr>
				{/if}
				{if $l.price>0}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Цена:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">
						{if intval($l.price) < floatval($l.price)}
							{$l.price|number_format:2:'.':' '}
						{else}
							{$l.price|number_format:0:'':' '}
						{/if}
						тыс. руб. <font class="small">({$ENV._arrays.price_unit[$l.price_unit].b})</font>
					</td>
				</tr>
				{/if}
				{if $l.contacts}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="right" width="150" class="bg_color2">Контакты:</td>
					<td {if $l.imp>0} style="color:red"{/if}class="bg_color4">{$l.contacts|strip_tags}
					{* if $l.uid==81185 || $l.uid==86282 || $l.uid==86283 || $l.uid==86285 || $l.uid==86287 || $l.uid==103658}
						<img src="/img/misc/kvadrat.gif" width="78" height="15" border="0" alt="АН КВАДРАТ">
					{/if *}
					{* if $l.uid==1785 || $l.uid==90167 || $l.uid==26539 || $l.uid==26554}
						<img src=/img/misc/makler.gif" width="73" height="11" border="0" alt="АН Маклер">
					{/if *}
					</td>
				</tr>
				{/if}
				{if $l.img1}
				<tr>
					<td {if $l.imp>0} style="color:red"{/if}align="center" colspan="2">
						<a onclick="ImgZoom('{$l.img1.src}','adv_sale_{$l.id}',{$l.img1.w},{$l.img1.h});return false;" href="{$l.img1.src}">смотреть фото</a>
					</td>
				</tr>
				{/if}
			</table>
			{* END Table of data for each rows *}
 <br/>
{/foreach}
{* Detail list *}

{if $smarty.capture.pageslink}
	<br/>{$smarty.capture.pageslink}<br/><br/>
{/if}
<br/><br/>