{capture name=pageslink}
{if $page.pageslink.btn}
  <table align="left" cellpadding="0" cellspacing="0" border="0">
  <tr valign="middle">
    <td style="font-size:11px"><img src="/_img/x.gif" width="1" height="14" border="0" alt="" /></td>
    {if $page.pageslink.back!="" }<td style="font-size:11px"><a href="{$page.pageslink.back}">&lt;&lt;&lt;</a></td>{/if}
    <td style="font-size:11px">
		{foreach from=$page.pageslink.btn item=l}
			{if !$l.active}
				&nbsp;<a href="{$l.link}" class="s5b">{$l.text}</a>&nbsp;
			{else}
				&nbsp;[{$l.text}]&nbsp;
			{/if}
		{/foreach}
    </td>
    {if $page.pageslink.next!="" }<td style="font-size:11px"><a href="{$page.pageslink.next}">&gt;&gt;&gt;</a></td>{/if}
  </tr>
  </table>
{/if}
{/capture}

{if $smarty.capture.pageslink}
	{$smarty.capture.pageslink}<br/><br/>
{/if}

{* Detail list *}
<table align=center width="100%" cellpadding="0" cellspacing="0" border="0">
{foreach from=$page.list item=l key=_k} 
	<tr>
		<td>
			{* Table of data for each rows *}
			<table align="left" width="100%" cellpadding="2" cellspacing="2" border="0" bgcolor="#FFFFFF">
				<tr bgcolor="#E9EFEF" align="center">
					<td colspan="2" class="t1"><b>{$ENV._arrays.rubrics[$l.rub]}</b></td>
				</tr>
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Дата:</td>
					{*<td>{"d-m-Y H:i"|date:$l.date_start}</td>*}
					<td class="ssyl">{$l.date_start|simply_date:"%f %H:%M":"%d-%m-%Y %H:%M"}</td>
				</tr>
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Тип недвижимости:</td>
					<td><b>{$ENV._arrays.objects[$l.object].b}</b></td>
				</tr>
				{if is_array($ENV._arrays.types[$l.object]) && $ENV._arrays.types[$l.object][$l.type]}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Тип здания:</td>
					<td><b>{$ENV._arrays.types[$l.object][$l.type]}</b></td>
				</tr>
				{/if}
				{if $l.object != 2}
				{if $ENV._arrays.status[$l.status].b}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Состояние:</td>
					<td>{$ENV._arrays.status[$l.status].b}</td>
				</tr>
				{/if}
				{if $ENV._arrays.decoration[$l.decoration].b}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Отделка:</td>
					<td>{$ENV._arrays.decoration[$l.decoration].b}</td>
				</tr>
				{/if}
				{/if}
				{if $l.address|trim}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Адрес:</td>
					<td>{$l.address}{if !empty($l.img1)}&nbsp;<a href="/{$ENV.section}/details.html?id={$l.id}#photo"><img src="/_img/design/200608_title/common/photo_blue.gif" width="14" height="10" alt="Есть фото" title="Есть фото" border="0"></a>{/if}</td>
				</tr>
				{/if}
				{if $l.area_build > 0}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Площадь помещения:</td>
					<td>{if intval($l.area_build) < floatval($l.area_build)}
				{$l.area_build|number_format:2:'.':' '}
			{else}
				{$l.area_build|number_format:0:'':' '} 
			{/if} кв.м.</td>
				</tr>
				{/if}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Этажность:</td>
					<td>{if $l.floor}{$l.floor}{else}-{/if}/{if $l.floors}{$l.floors}{else}-{/if}</td>
				</tr>
				{if $ENV._arrays.phone[$l.phone]}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Телефон:</td>
					<td>{$ENV._arrays.phone[$l.phone]}</td>
				</tr>
				{/if}
				{if $l.area_site > 0 }
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Площадь участка:</td>
					<td>
					{if intval($l.area_site) < floatval($l.area_site)}
				{$l.area_site|number_format:2:'.':' '}
			{else}
				{$l.area_site|number_format:0:'':' '} 
			{/if}
			{$ENV._arrays.site_unit[$l.area_site_unit]}</td>
				</tr>
				{/if}
				{if $l.description|trim}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Доп. информация:</td>
					<td>{$l.description}</td>
				</tr>
				{/if}
				{if $l.price>0}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Цена:</td>
					<td>
						{if intval($l.price) < floatval($l.price)}
							{$l.price|number_format:2:'.':' '} 
						{else}
							{$l.price|number_format:0:'':' '} 
						{/if}
						тыс. руб. <font class="small">({$ENV._arrays.price_unit[$l.price_unit].b})</font>
					</td>
				</tr>
				{/if}
				{if $l.contacts|trim != ''}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="right" width="150" class="t1" bgcolor="#F3F8F8">Контакты:</td>
					<td>{$l.contacts|strip_tags|trim}
					{* if $l.uid==81185 || $l.uid==86282 || $l.uid==86283 || $l.uid==86285 || $l.uid==86287 || $l.uid==103658}
						<img src="/img/misc/kvadrat.gif" width="78" height="15" border="0" alt="НА КВАДРАТ">
					{/if *}
					{* if $l.uid==1785 || $l.uid==90167 || $l.uid==26539 || $l.uid==26554}
						<img src=/img/misc/makler.gif" width="73" height="11" border="0" alt="НА Маклер">
					{/if *}
					</td>
				</tr>
				{/if}
				{if $l.img1}
				<tr bgcolor="#FFFFFF" align="left">
					<td align="center" colspan="2">
						<a onclick="ImgZoom('{$l.img1.src}','adv_sale_{$l.id}',{$l.img1.w},{$l.img1.h});return false;" href="{$l.img1.src}">смотреть фото</a>
					</td>
				</tr>
				{/if}
			</table>
			{* END Table of data for each rows *}
		</td>
	</tr>
	<tr>
		<td height="15"></td>
	</tr>

{*	{if $_k ==  4}
	<tr>
		<td bgcolor="#FFFFFF" align=center>
			{banner_v2 id="433"}<br>&nbsp;
		</td>
	</tr>
	{/if}
	
	{if $_k ==  6}
	<tr>
		<td bgcolor="#FFFFFF" align="center">
			{banner_v2 id="344"}<br>&nbsp;
		</td>
	</tr>
	{/if}
	
	{if $_k ==  8}
		<tr>
			<td bgcolor="#FFFFFF" align=center>
				{banner_v2 id="388"}<br>&nbsp;
			</td>
		</tr>
	{/if}
	{if $_k ==  10}
		<tr><td bgcolor="#FFFFFF" align=center>{banner_v2 id="312"}<br>&nbsp;</td></tr>
	{/if} *}
{/foreach}
</table>
{* Detail list *}

{if $smarty.capture.pageslink}
	<br/>{$smarty.capture.pageslink}<br/><br/>
{/if}