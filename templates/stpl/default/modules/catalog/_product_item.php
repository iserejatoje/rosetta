<?
	$product = $vars['product'];
	$item    = $vars['item'];
	$priceid = intval($vars['priceid']);
	$price   = intval($vars['price']);
	$count   = $vars['count'];
?>
<div class="product-cart-item" id="product-item-<?=$product->ID?>-<?=$priceid?>" data-productid="<?=$product->ID?>" data-priceid="<?=$priceid?>" data-pirce="<?=$price?>">
	<?=$product->Name?>
	<span class="product-count"><?=$count?></span>
	<?=$price?>
	<a href="javascript:;" class="add-in-cart">+</a>
	<a href="javascript:;" class="remove-from-cart">-</a>
</div>