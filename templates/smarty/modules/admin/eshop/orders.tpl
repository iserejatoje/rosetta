<script>{literal}
	function OrderProcessed(orderid)
	{
		$.ajax({
			url: '.',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'order_processed',
				section_id: {/literal}{$SECTION_ID}{literal},
				id: orderid
			},
			success: function(data){
				if (data.status == 'ok')
				{
					alert('Заказ обработан');
					$('#order-'+orderid).fadeOut('slow', function(){
						$(this).remove();
					});
				}
			},
			error: function(){
			
			}
		});
	}
	
	function OrderRejected(orderid)
	{
		$.ajax({
			url: '.',
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'order_rejected',
				section_id: {/literal}{$SECTION_ID}{literal},
				id: orderid
			},
			success: function(data){
				if (data.status == 'ok')
				{
					alert('Заказ отклонён');
					$('#order-'+orderid).fadeOut('slow', function(){
						$(this).remove();
					});
				}
			},
			error: function(){
			
			}
		});
	}
{/literal}
</script>

	{if is_array($orders) && sizeof($orders) > 0}
		{foreach from=$orders item=l key=orderid}
		<div style="margin: 20px 50px 20px 50px; padding: 20px; background-color: #e9fbd1;" id="order-{$orderid}">
			<span style="font-size: 16px;font-weight: bold;">Заказ #{$orderid}</span><br/>
			Пользователь: <b>{$l.user->Profile.general.ShowName}</b><br/>
			Дата: <b>{$l.Created}</b><br/><br/>
			Адрес доставки:<br/>
			<table cellspacing="3" cellpadding="3">
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
				<tr>
					<td>&nbsp;&nbsp;&nbsp;Телефон:</td>
					<td><b>{$l.user->Profile.general.Phone}</b></td>
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
					<td align="center">{$p->RealPrice} руб.</td>
					
				</tr>
				{/foreach}
				<tr>
					<td align="right" colspan="2">Итого:</td>
					<td align="center"><b>{$l.TotalCount} шт.</b></td>
					<td align="center"><b>{$l.TotalPrice} руб.</b></td>
					
				</tr>
			</table>
			<br/>
			<div style="float:left">
				<a href="javascript:void(0);" onclick="OrderProcessed({$orderid})" style="font-weight: bold;font-size: 20px;color: #1CBDE9;">Заказ обработан</a>	
			</div>
			<div style="float:right; padding-right: 20px;">
				<a href="javascript:void(0);" onclick="OrderRejected({$orderid})" style="font-weight: bold;font-size: 15px;">Заказ отклонен</a>	
			</div>
			<br clear="both"/>
		</div>
		<br/><br/>
		{/foreach}
		
	{else}
		<div style="text-align:center">Новые заказы отсутствуют</div>
	{/if}