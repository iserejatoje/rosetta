<style>
    .container {
        width: 1170px;
    }
</style>

<a href="<?=$vars['url']?>&actual=0">В маленьком размере</a>
<br><br>
<div class="container">
	<ul class="list-group">
		<li class="list-group-item">Для сортировки перетащить мышкой букет в желамое место.</li>
		<li class="list-group-item">Для сохранения нажать кнопку "Сохранить порядок"</li>
	</ul>
	<div class="grid-wrp" style="width: 1170px;">
		<form method="post">
			<input type="hidden" name="action" value="save_products_order">
			<input type="hidden" name="type_id" value="<?= $vars['type_id'] ?>">
			<br><br>
			<div class="btn-align">
				<button type="submit" class="btn btn-success btn-large">Сохранить порядок</button>
			</div>
			<br><br>
				<div class="grid_ sortbox clearfix" id="grid-container">
					<?= STPL::Fetch('admin/modules/catalog/_general_sorting_products_preview', [
						'products' => $vars['list'],
						'section_id' => $vars['section_id'],
					]) ?>
				</div>
			<br><br>
			<div class="btn-align">
				<button type="submit" class="btn btn-success btn-large">Сохранить порядок</button>
			</div>
			<br><br>
		</form>
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

<?= STPL::Fetch('admin/modules/catalog/_general_sorting_loadmore_script', [
	'section_id' => $vars['section_id'],
	'type_id' => $vars['type_id'],
	'actual' => 1,
]) ?>