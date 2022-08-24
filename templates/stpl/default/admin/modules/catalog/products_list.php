<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.ord-field {
		text-align: center;
	}
	a .glyphicon-success {
		color: #5cb85c !important;
	}
	a .glyphicon-danger {
		color: #d9534f !important;
	}
	.product-name {
		font-size: 16px;
	}
	.font-23 {
		font-size: 23px;
	}
	.font-20 {
		font-size: 20px;
	}

	.pagination {
		margin: 0;
	}
</style>

<script>

	$(document).ready(function(){
        $('.sorted-link').click(function() {
            var sort_field = $(this).data('field');
            var sort_dir = $(this).find('.glyphicon').data('dir');

            if(sort_dir == 'desc' || sort_dir == '')
                var dir = 'asc';
            else
                var dir = 'desc'

            $("#sorting-field").val(sort_field);
            $("#sorting-dir").val(dir);
            $("#sortingform").submit();
        });

		// $('.table a.visible').click(function(e){
		// 	e.preventDefault();

		// 	$.ajax({
		// 		url: $(this).attr('href'),
		// 		dataType: "json",
		// 		type: "get",
		// 		success: function(data){
		// 			if (data.status == 'error')
		// 				return false;

		// 			if (data.visible == 1)
		// 			{
		// 					$('.table #product_'+data.productid+' a.visible .glyphicon')
		// 					.removeClass('glyphicon-eye-close')
		// 					.removeClass('glyphicon-danger')
		// 					.addClass('glyphicon-eye-open')
		// 					.addClass('glyphicon-success');
		// 			}
		// 			else
		// 			{
		// 					$('.table #product_'+data.productid+' a.visible .glyphicon')
		// 					.removeClass('glyphicon-eye-open')
		// 					.removeClass('glyphicon-success')
		// 					.addClass('glyphicon-eye-close')
		// 					.addClass('glyphicon-danger');
		// 			}
		// 		}
		// 	});
		// });

		// $('.table a.main').click(function(e){
		// 	e.preventDefault();

		// 	$.ajax({
		// 		url: $(this).attr('href'),
		// 		dataType: "json",
		// 		type: "get",
		// 		success: function(data){
		// 			if (data.status == 'error')
		// 				return false;

		// 			if (data.main == 1)
		// 			{
		// 					$('.table #product_'+data.productid+' a.main .glyphicon')
		// 					.removeClass('glyphicon-remove')
		// 					.removeClass('glyphicon-danger')
		// 					.addClass('glyphicon-ok')
		// 					.addClass('glyphicon-success');
		// 			}
		// 			else
		// 			{
		// 					$('.table #product_'+data.productid+' a.main .glyphicon')
		// 					.removeClass('glyphicon-ok')
		// 					.removeClass('glyphicon-success')
		// 					.addClass('glyphicon-remove')
		// 					.addClass('glyphicon-danger');
		// 			}
		// 		}
		// 	});
		// });

		$('.table a.available').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					if (data.available == 1)
					{
							$('.table #product_'+data.productid+' a.available .glyphicon')
							.removeClass('glyphicon-remove')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-ok')
							.addClass('glyphicon-success');
					}
					else
					{
							$('.table #product_'+data.productid+' a.available .glyphicon')
							.removeClass('glyphicon-ok')
							.removeClass('glyphicon-success')
							.addClass('glyphicon-remove')
							.addClass('glyphicon-danger');
					}
				}
			});
		});

		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить товар?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});

</script>

<?php if($vars['parentId']): ?>
<div>
	<a href="/admin/site/<?= $_SERVER['HTTP_HOST'] ?>/catalog/.module/?section_id=<?=$vars['section_id']?>&action=products&type_id=12" class="btn btn-success">Папки</a>
</div>
<?php endif;?>

<? if(App::$User->IsInRole('u_bouquet_editor') || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
	<?php 
	$url = [
		'section_id' => $vars['section_id'],
		'action' => 'new_product',
		'type_id' => $vars['type_id'],
	]; 

	if($vars['parentId']) {
		$url['parent_id'] = $vars['parentId'];
		$url['type_id'] = $vars['bouquetCategoryId'];
	}

	$url = http_build_query($url);
	?>

	<p><a class="btn btn-primary btn-sm" href="?<?= $url ?>">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить товар
	</a></p>
<? } ?>

<form method="get" enctype="multipart/form-data" id="sortingform">
	<input type="hidden" name="action" value="products" />
	<input type="hidden" name="type_id" value="<?=$vars['type_id']?>" />
	<input type="hidden" name="page" value="<?=$vars['page']?>" />
	<input type="hidden" name="field" id="sorting-field" value="<?=$vars['sorting']['field']?>">
    <input type="hidden" name="dir" id="sorting-dir" value="<?=$vars['sorting']['dir']?>">
    <input type="hidden" name="parent_id" value="<?=$vars['parentId']?>">
    <input type="hidden" name="is_filter" value="1">

	<div class="pull-right">
		<?=STPL::Fetch('admin/modules/catalog/pages', ['pages' => $vars['pages']])?>
	</div>

	<table>
		<tr>
			<td>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Артикул..." name="filter_code" value="<?= $vars['filterCode'] ?>">
				</div>
			</td>
			<td>
			<div class="form-group">
					<input type="text" class="form-control" placeholder="Название..." name="filter_name" value="<?= $vars['filterName'] ?>">
				</div>
			</td>
			<td>
				<div class="form-group">
					<select name="isavailable" class="form-control">
						<option value="-1"<? if ($vars['isavailable'] == -1) { ?> selected="selected"<? } ?>>Показывать все</option>
						<option value="1"<? if ($vars['isavailable'] == 1) { ?> selected="selected"<? } ?>>В наличии</option>
						<option value="0"<? if ($vars['isavailable'] == 0) { ?> selected="selected"<? } ?>>Нет в наличии</option>
					</select>
				</div>
			</td>
			<td>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="фильтровать"/>
				</div>
			</td>
			<td>
				<div class="form-group">
					<a href="?section_id=<?=$vars['section_id']?>&action=products&type_id=<?= $vars['type_id'] ?>&parent_id=<?= $vars['parentId']?>" class="btn btn-danger">Сбросить все фильтры</a>
				</div>
			</td>
		</tr>
	</table>
</form>

<form method="POST" name="productform">
	<input type="hidden" name="action" value="save_products_order" />
	<input type="hidden" name="action_type" value="products" />
	<input type="hidden" name="action_type" value="products" />
	<input type="hidden" name="type_id" value="<?=$vars['type_id']?>" />
	<input type="hidden" name="parent_id" value="<?=$vars['parentId']?>">
	<table class="sortable table table-bordered table-hover table-striped" id="products-list">
        <thead>
    		<tr>
    			<th width="5%">
                    <a href="javascript:;" data-field="article" class="sorted-link">
                        Артикул
                        <? if($vars['sorting']['field'] == 'article') {
                            if($vars['sorting']['dir'] == 'asc')
                                $class = 'glyphicon-sort-by-attributes';
                            else
                                $class = 'glyphicon-sort-by-attributes-alt';
                            ?>
                            <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                        <? } ?>
                    </a>
                </th>
    			<?/*
    			<th width="7%">Порядок</th>
    			*/?>
    			<th width="8%">Фото</th>
    			<th width="40%">
                    <a href="javascript:;" data-field="name" data-dir="" class="sorted-link">
                        Название
                        <? if($vars['sorting']['field'] == 'name') {
                            if($vars['sorting']['dir'] == 'asc')
                                $class = 'glyphicon-sort-by-attributes';
                            else
                                $class = 'glyphicon-sort-by-attributes-alt';
                            ?>
                            <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                        <? } ?>
                    </a>
                </th>
                <? if(App::$User->IsInRole('u_bouquet_editor') || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>

					<?php if($vars['isFolder']): ?>
						<th>&nbsp;</th>
					<?php endif; ?>

					<?php if($vars['parentId']): ?>
						<th>
							<a href="javascript:;" data-field="ord" data-dir="" class="sorted-link">
								Порядок
								<? if($vars['sorting']['field'] == 'ord') {
									if($vars['sorting']['dir'] == 'asc')
										$class = 'glyphicon-sort-by-attributes';
									else
										$class = 'glyphicon-sort-by-attributes-alt';
									?>
									<span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
								<? } ?>
							</a>
						</th>
					<?php endif; ?>

	    			<th width="6%">
	                    <a href="javascript:;" data-field="isavailable" data-dir="" class="sorted-link">
	                        В наличии
	                        <? if($vars['sorting']['field'] == 'isavailable') {
	                            if($vars['sorting']['dir'] == 'asc')
	                                $class = 'glyphicon-sort-by-attributes';
	                            else
	                                $class = 'glyphicon-sort-by-attributes-alt';
	                            ?>
	                            <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
	                        <? } ?>
	                    </a>
	                </th>
	    			<th width="5%">Галерея</th>
	    			<th width="3%">Удалить</th>
	    		<? } ?>
    		</tr>
        </thead>
        <tbody>
    		<? $i = 0; ?>
    		<? foreach($vars['products'] as $item){ ?>
    		<? $areaRefs = $item->GetAreaRefs($vars['section_id']); ?>
    		<tr id="product_<?=$item->ID?>">
    			<td align="center"><?=$item->article?></td>

    			<?/*
    			<td align="center">
    				<?= $areaRefs['Ord'] ?>
    			</td>
    			*/?>

    			<td align="center">
    				<a href="?section_id=<?=$vars['section_id']?>&action=edit_product&type_id=<?=$vars['type_id']?>&id=<?=$item->ID?>">
    					<img src="<?=$item->PhotoSmall['f']?>" style = "height: 100px"/>
    				</a>
    			</td>
    			<td>
    				<a href="?section_id=<?=$vars['section_id']?>&action=edit_product&type_id=<?=$vars['type_id']?>&id=<?=$item->ID?>" class="product-name">
    					<?=$item->Name?>
    				</a>
    			</td>

				<?php if($vars['isFolder']): ?>
					<td align="center">
						<?php 
						$url = [
							'section_id' => $vars['section_id'],
							'action' => 'products',
							'type_id' => $vars['bouquetCategoryId'],
							'parent_id' => $item->ProductID,
						]; 

						$url = explode('?', $_SERVER['REQUEST_URI'], 2)[0] . '?' . http_build_query($url);
						?>

						<a href="<?= $url ?>">Товары папки</a>
					</td>
				<?php endif; ?>

				<? if(App::$User->IsInRole('u_bouquet_editor') || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>

                    <?php /*

    	    			<td align="center">
    	    				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_product_toggle_visible&id=<?=$item->ID?>" class="visible btn btn-default btn-sm">
    	    					<? if ($areaRefs['IsVisible'] == 1) { ?>
    	    						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
    	    					<? } else { ?>
    	    						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
    	    					<? } ?>
    	    				</a>
    	    			</td>

                    */ ?>
	    			<?/*
	    			<td align="center">
	    				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_product_toggle_main&id=<?=$item->ID?>" class="main btn btn-default btn-sm">
	    					<? if ($areaRefs['IsMain'] == 1) { ?>
	    						<span class="glyphicon glyphicon-ok glyphicon-success"></span>
	    					<? } else { ?>
	    						<span class="glyphicon glyphicon-remove glyphicon-danger"></span>
	    					<? } ?>
	    				</a>
	    			</td>
	    			*/?>

					<?php if($vars["parentId"]): ?>
						<td align="center">
							<input type="number" name="Ord[<?= $item->ProductID ?>]" value="<?= $areaRefs['Ord'] ?>" class="form-control">
						</td>
					<?php endif; ?>

	    			<td align="center">
	    				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_product_toggle_available&id=<?=$item->ID?>" class="available btn btn-default btn-sm">
	    					<? if ($areaRefs['IsAvailable'] == 1) { ?>
	    						<span class="glyphicon glyphicon-ok glyphicon-success"></span>
	    					<? } else { ?>
	    						<span class="glyphicon glyphicon-remove glyphicon-danger"></span>
	    					<? } ?>
	    				</a>
	    			</td>

	    			<td align="center">
	    				<a href="?section_id=<?=$vars['section_id']?>&action=photos&type_id=<?=$vars['type_id']?>&id=<?=$item->ID?>" class="font-23"><span class="glyphicon glyphicon-picture"></span></a>
	    			</td>

	    			<td align="center">
	    				<a class="delete font-20" href="?section_id=<?=$vars['section_id']?>&action=delete_product&type_id=<?=$vars['type_id']?>&id=<?=$item->ID?>">
	    					<span class="glyphicon glyphicon-trash"></span>
	    				</a>
	    			</td>
	    		<? } ?>
    		</tr>
    		<? $i++; ?>
    		<? } ?>
        </tbody>
	</table>

	<div class="pull-right">
		<?=STPL::Fetch('admin/modules/catalog/pages', ['pages' => $vars['pages']])?>
		<br>
		<br>
	</div>

	<!-- <br/>
	<div style="text-align:center">
		<button type="submit" class="btn btn-success btn-large">Сохранить</button>
	</div> -->
</form>