<div class="total-price clearfix hidden-isEmpty total-price-of-cart" id="cart-result">
	<div class="row">
	    <div class="total-label">Доставка:</div>
	    <div class="total-value"><?=number_format($vars['delivery'], 0, "", "")?> Р</div>
	</div>
	<div class="row">
	    <div class="total-label">ИТОГО:</div>
	    <div class="total-value"><?=number_format($vars['total_price'] + $vars['delivery'], 0, "", "")?> Р</div>
	</div>
	<?/*
	<div class="delivery-price">Включая доставку</div>
	*/?>
</div>