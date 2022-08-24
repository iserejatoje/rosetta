<div class="filters">
	<form>
		<? foreach($vars['composition'] as $item) { ?>
		<input type="checkbox" name="members[<?=$item->ID?>]" value="<?=$item->ID?>" <?if(isset($vars['members'][$item->ID])){?> checked="checked"<?}?> /> <?=$item->Name?>
		<? } ?>
		<input type="submit">
	</form>
</div>
<?
	$products = $vars['products'];
	foreach($products as $product) { ?>
		<?=$product->Name?><br/>
		<div class="product-item">

		<form action="." id="product-item-<?=$product->ID?>">
			<input type="hidden" name="action" value="ajax_add_to_cart">
			<input type="hidden" name="productid" value="<?=$product->ID?>">
			<input type="hidden" name="priceid" value="" class="priceid">
			<input type="hidden" name="price" value="<?=intval($product->Price)?>">

			<? if($product->prices) { ?>

				<ul class="prices">
				<? foreach($product->prices as $price)
				{
					echo $price->Name." ".$price->Value;
					?>
					<li data-priceid="<?=$price->ID?>" data-price="<?=$price->Value?>">Выбрать цену</li>

				<? } ?>
				</ul>
			<? } else { ?>
				<?=$product->Price?> руб.
			<? } ?>
			<a href="javascript:;" class="add-to-cart">В корзину</a><br/>
		</form>
		</div>
		<hr>
	<? } ?>