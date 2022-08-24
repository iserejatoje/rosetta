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
				<?php /* если пришел массив, это страница сортировки главного каталога. Для него не нужно возвращать типы, они прописаны в экшене по-умолчанию */ ?>
				<?php if(!is_array($vars['type_id'])): ?>
					<input type="hidden" name="type_id" value="<?= $vars['type_id'] ?>">
				<?php endif; ?>
                <input type="hidden" name="action_type" value="<?=$vars['action_type']?>">
				<br><br>
				<div class="btn-align">
					<button type="submit" class="btn btn-success btn-large">Сохранить порядок</button>
				</div>
				<br>
				<br>
				<div class="grid_ sortbox clearfix" id="grid-container">
					<?=STPL::Fetch('admin/modules/catalog/_general_sorting_products', [
						'products' => $vars['list'],
						'section_id' => $vars['section_id'],
					]) ?>
				</div>
				<br>
				<br>
				<div class="btn-align">
					<button type="submit" class="btn btn-success btn-large">Сохранить порядок</button>
				</div>
				<br><br>
			</form>
		</div>
		<div class="warehouse-wrp">
			<div class="grid_ warehouse sortbox" id="warehouse"></div>
		</div>
	</div>
</div>
</div>

<script>
	$(function() {
		$( ".sortbox" ).sortable({
			connectWith: ".sortbox",
		});
    	$("#sortbox").disableSelection();

		$( ".grid_" ).on("sortstop", function( event, ui ) {
			$(".grid_ .item").each(function(i, el) {
				var item = $(el);
				// var index = i + 1;
				// var pid = item.data('productid');

				$(el).find('.num').text(i+1);
				// $("#prod-sort-"+pid).val(index);
			});
		});
	});
</script>

<?php if($vars['is_all']) { ?>
    <?= STPL::Fetch('admin/modules/catalog/_general_sorting_loadmore_script', [
        'section_id' => $vars['section_id'],
        'type_id' => $vars['type_id'],
        'actual' => 0,
    ]) ?>
<?php } ?>
