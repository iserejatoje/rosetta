<a href="/catalog/cart/" class="cart-minified clearfix">
	<div class="cart-text">
		<div class="cart-label">В КОРЗИНЕ</div>
		<div class="cart-products">
			<span class="cart-count"><?=$vars['total_count']?></span> <?=UString::word4number($vars['total_count'], 'товар', 'товара', 'товаров')?>
		</div>
	</div>
	<div class="cart-total">
		<?=number_format($vars['total_price']+$vars['delivery'], 0, "", " ")?>р
	</div>
	<div class="cart-order">
		ЗАКАЗАТЬ
	</div>
</a>
<div class="cart-unfolded">
	<div class="cart-title">В КОРЗИНЕ</div>
	<ul class="cart-products">
		<? foreach($vars['list'] as $k => $product) {
			if ($vars['add_info'][$k]['priceinfo'] !== null)
				{
					$pi = $vars['add_info'][$k]['priceinfo'];
					$name = $product->Name." (".EShopMgr::$DIAMETERS[$pi['Diameter']].")";
					$price = $pi['Price'];
					$weight = $pi['Weight'];
					$priceid = $pi['PriceID'];
				} else {
					$name = $product->Name;
					$price = $product->Price;
					$weight = $product->Weight;
					$priceid = 0;
				}
			?>
			<li><?=$name?></li>
		<? } ?>
	</ul>
	<div class="cart-total clearfix">
		<div class="cart-total-label">Итого:</div>
		<div class="cart-total-price"><?=number_format($vars['total_price']+$vars['delivery'], 0, "", " ")?>р</div>
	</div>
	<a href="/catalog/cart/" class="cart-order">ЗАКАЗАТЬ</a>
</div>