<?
	$list = $vars['list'];
	$cnt = sizeof($list);
	$w = 1104;
	$third = floor($w/3);
	$half = floor($w/2);
	$normalize = array();

	$arrHalf = array();
	$arrThird = array();
	$i = 0;
	foreach($vars['list'] as $product)
	{
		++$i;
		if(sizeof($arrThird) == 3)
		{
			$normalize[] = $arrThird;
			$arrThird = array();
		}

		if(sizeof($arrHalf) == 2)
		{
			$normalize[] = $arrHalf;
			$arrHalf = array();
		}

		if($product->PhotoBig['w'] <= $third)
			$arrThird[] = $product;
		elseif($product->PhotoBig['w'] > $third)
			$arrHalf[] = $product;

		if($i == $cnt)
		{
			if(sizeof($arrThird) > 0)
				$normalize[] = $arrThird;

			if(sizeof($arrHalf) > 0)
				$normalize[] = $arrHalf;
		}

		// echo $product->areaRefs['Ord']."|| ".$product->Name.": ".$product->PhotoBig['w']."px || ".$third." | ".$half."<br>";
	}

	$sizes = array();
	foreach($normalize as $lineid => $line)
	{
		$max = array();
		foreach($line as $product)
		{
			$max[] = $product->PhotoBig['h'];
		}

		$sizes[$lineid] = max($max);
		$sizes[$lineid] = $sizes[$lineid] != 0 ? $sizes[$lineid] : 300;
	}
?>
<a href="<?=$vars['url']?>&actual=1">В актуальном размере</a>
<br><br>
<div class="container">
<div class="products panel panel-default">
	<div class="panel-heading">
		<div class="panel-heading">
			<h3 class="panel-title">Сортировка</h3>
		</div>
	</div>

	<div class="panel-body">
		<ul class="list-group">
			<li class="list-group-item">Для сортировки перетащить мышкой букет в желамое место.</li>
			<li class="list-group-item">Для сохранения нажать кнопку "Сохранить порядок"</li>
		</ul>
		<div class="grid-wrp">
			<form method="post">
				<input type="hidden" name="action" value="save_products_order">
				<input type="hidden" name="type_id" value="<?= $vars['type_id'] ?>">
				<br><br>
				<div class="btn-align">
					<button type="submit" class="btn btn-success btn-large">Сохранить порядок</button>
				</div>
				<br><br>
					<? foreach($normalize as $lineid => $line) {
						$cnt = sizeof($line);
					?>
					<div class="grid_ sortbox clearfix">
						<? foreach($line as $product) {
							$title = '';
							if($product->PhotoBig['h'] >= 500)
								$title = "высокие<br>";
							if($product->PhotoBig['w'] <= $third)
								$title .= "по 3 в ряд<br>";

							if($product->PhotoBig['w'] > $third)
								$title = "по 2 в ряд<br>";

							$height = round($sizes[$lineid]/3);

							?>
							<div class="item col_-1-<?=$cnt?> item-1-<?=$cnt?>" data-productid="<?=$product->ID?>">
								<div class="product-item" style="height: <?=$height?>px">
									<div class="num"><?=$product->areaRefs['Ord']?></div>
									<div class="name"><?=$product->Name?></div>
									<div class="lbl"><?=$title?></div>
									<div class="size"><?=$product->PhotoBig['w']?>x<?=$product->PhotoBig['h']?>px</div>
									<? if (!empty($product->PhotoBig)) { ?>
									<img src="<?=$product->PhotoBig['f']?>" height="<?=$height?>px" <?/*width="<?=round($product->PhotoBig['w']/3)?>px" height="<?=round($product->PhotoBig['h']/3)?>px"*/?> />
									<? } else { ?>
									<img src="<?=$product->PhotoSmall['f']?>" height="<?=$height?>px" >
									<? } ?>
									<input type="hidden" name="Ord[<?=$product->ID?>]" value="<?=$product->areaRefs['Ord']?>" id="prod-sort-<?=$product->ID?>"/>
								</div>
							</div>
						<? } ?>
					</div>
					<? } ?>
				<br><br>
				<div class="btn-align">
					<button type="submit" class="btn btn-success btn-large">Сохранить порядок</button>
				</div>
				<br><br>
			</form>
		</div>
		<div class="warehouse-wrp">
			<div class="warehouse sortbox" id="warehouse"></div>
		</div>
	</div>
</div>
</div>

<script>
	 $(function() {
		$( ".sortbox" ).sortable({
			connectWith: ".sortbox",
		});

		$( ".grid_" ).on("sortstop", function( event, ui ) {
			$(".grid_ .item").each(function(i, el) {
				var item = $(el);
				var index = i + 1;
				var pid = item.data('productid');

				$(el).find('.num').text(i+1);
				$("#prod-sort-"+pid).val(index);
			});
		});
	});
</script>