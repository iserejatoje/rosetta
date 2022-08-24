	{if is_array($orders) && sizeof($orders) > 0}
	{capture name=pages}
		{if count($pages.btn) > 0}
		{if !empty($pages.back)}<a href="{$pages.back}">&lt;&lt;</a>&nbsp;{/if}
		{foreach from=$pages.btn item=l}
		{if $l.active==0}<a href="{$l.link}">{else}<b>{/if}{$l.text}{if $l.active==0}</a>{else}</b>{/if}&nbsp;
		{/foreach}
		{if !empty($pages.next)}<a href="{$pages.next}">&gt;&gt;</a>{/if}
		{/if}
	{/capture}
	
	<center>{$smarty.capture.pages}</center><br />
	
		{foreach from=$orders item=l key=orderid}
		<div style="margin: 20px 50px 20px 50px; padding: 20px; border: solid 2px #898989;">
			<span style="font-size: 16px;font-weight: bold;">Заказ #{$orderid}</span><br/>
			Пользователь: <b>{$l.user->Profile.general.ShowName}</b><br/>
			Дата: <b>{$l.Created}</b><br/><br/>
			Адрес доставки:<br/>
			<table cellspacing="3" cellpadding="3">
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Почтовый индекс:</td>
					<td><b>{$l.user->Profile.general.PostCode}</b></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Область:</td>
					<td><b>{$l.user->Profile.general.Area}</b></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Район:</td>
					<td><b>{$l.user->Profile.general.District}</b></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Город:</td>
					<td><b>{$l.user->Profile.general.City}</b></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Улица:</td>
					<td><b>{$l.user->Profile.general.Street}</b></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Дом:</td>
					<td><b>{$l.user->Profile.general.House}</b></td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Квартира:</td>
					<td><b>{$l.user->Profile.general.Apartment}</b></td>
				</tr>
			</table>
			
			
			
			<br/><br/>
			
			Товары:
			<table width="100%">
				<tr>
					<td width="10%" align="center"><b>Артикул</b></td>
					<td width="60%" align="center"><b>Наимнование</b></td>
					<td width="15%" align="center"><b>Количество / На складе</b></td>
					<td width="15%" align="center"><b>Цена</b></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				{foreach from=$l.products item=p}
				<tr>
					<td align="center">{$p->Code}</td>
					<td>
						<img src="{$p->LogotypeSmall.f}"style="float:left; padding: 10px;"/>
						{$p->Name}, {$p->Manufacturer}
					</td>
					<td align="center">{php} echo $this->_tpl_vars['l']['counts'][$this->_tpl_vars['p']->ID]{/php} шт. / {$p->Quantity}</td>
					<td align="center">{$p->Price} руб.</td>
					
				</tr>
				{/foreach}
				<tr>
					<td align="right" colspan="2">Итого:</td>
					<td align="center"><b>{$l.TotalCount} шт.</b></td>
					<td align="center"><b>{$l.TotalPrice} руб.</b></td>
					
				</tr>
			</table>
		</div>
		<br/><br/>
		{/foreach}
		
		<center>{$smarty.capture.pages}</center><br />
	{/if}