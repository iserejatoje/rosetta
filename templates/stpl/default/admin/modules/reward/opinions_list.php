<script>

	$(document).ready(function(){
		$(".sortable tbody" ).sortable({
			helper: function(e, tr)
			  {
			    var $originals = tr.children();
			    var $helper = tr.clone();
			    $helper.children().each(function(index)
			    {
			      // Set helper cell sizes to match the original sizes
			      $(this).width($originals.eq(index).width());
			    });
			    return $helper;
			  },
			connectWith: ".sortable tbody",
		});

		$(".sortable tbody").on("sortstop", function( event, ui ) {
			$(".sortable tbody tr").each(function(i, el) {
				var item = $(el);
				var index = i + 1;
				var pid = item.data('id');

				$("#ord-"+pid).val(index);
			});
		});

		
		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить отзыв?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});

		$('.table a.visible-toggler').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					if (data.is_visible == 1) {
						$('.table #opinion_'+data.id+' a.visible-toggler .glyphicon')
						.removeClass('glyphicon-remove')
						.removeClass('glyphicon-danger')
						.addClass('glyphicon-ok')
						.addClass('glyphicon-success');
					} else {
						$('.table #opinion_'+data.id+' a.visible-toggler .glyphicon')
						.removeClass('glyphicon-ok')
						.removeClass('glyphicon-success')
						.addClass('glyphicon-remove')
						.addClass('glyphicon-danger');
					}
				}
			});
		});
	});
</script>

<p>
	<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=<?=$vars['action']?>">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить отзыв
	</a>
</p>

<form method="POST" name="opinionsform">
<input type="hidden" name="action" value="save_opinion_orders" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
<table class="--sortable table table-bordered table-hover">
	<thead>
		<tr>
			<th width="1%">#</th>
			<th width="10%">Фото</th>
			<th width="20%">Имя</th>
			<th width="20%">Текст</th>
			<th width="2%">Порядок</th>
			<th width="6%">Видимость</th>
			<th width="1%">Удалить</th>
		<tr>
	</thead>
	<tbody>
	<?php $i = 0; ?>
	<?php foreach($vars['opinions'] as $item){ ?>
	<tr class="<?php if ($i %2 == 0) { ?>odd<?php } else { ?>notodd<?php } ?>" id="opinion_<?= $item->id?>" data-id="<?=$item->id?>">

		<td class="vert-align"><?=$item->id?></td>
		
		<td>
			<?php if (!empty($item->thumb['f'])) { ?>
                <img src="<?=$item->thumb['f']?>" class="img-responsive">
            <?php } ?>	
		</td>

		<td class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_opinion&id=<?=$item->id?>">
				<?= $item->name?>
			</a>
		</td>

		<td class="vert-align">
			<?= $item->text?>
		</td>

		<td>
			<input type="text" class="form-control" name="orders[<?= $item->id?>]" value="<?= $item->ord?>">
		</td>

		<td align="center">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_opinion_toggle_visibility&id=<?=$item->id?>" class="visible-toggler btn btn-default btn-sm">
				<?php if ($item->is_visible == 1) { ?>
					<span class="glyphicon glyphicon-ok glyphicon-success"></span>
				<?php } else { ?>
					<span class="glyphicon glyphicon-remove glyphicon-danger"></span>
				<?php } ?>
			</a>
		</td>

		<td align="center" class="vert-align">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_opinion&id=<?=$item->id?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php $i++; ?>
	<?php  } ?>
	</tbody>
</table>

<button type="submit" class="btn btn-primary">Сохранить порядок</button>
<br><br><br>
</form>
