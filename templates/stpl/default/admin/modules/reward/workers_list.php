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
		if (!confirm("Вы действительно хотите удалить работника?")) {
			return false;
		}

		$.ajax({
            url: $(this).attr('href'),
            dataType: "json",
            type: "get",
            success: function(data){
                if (data.status == 'error') {
                	var message = data.message;
                	if(data.more) {
                		message += "\n" + data.more.join("\n");
                	}
                	alert(message);
                    return false;
                } else if(data.status == 'ok') {
                	document.location.href = document.location.href;
                }
            }
        });
		
	});

	$('.resetorder').click(function(e){
		$('.ord-field').val('0');
	});
});
</script>

<p>
	<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=<?=$vars['action']?>">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить работника
	</a>
</p>

<form method="POST" name="citiesform">
<input type="hidden" name="action" value="save_workers" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
<table class="--sortable table table-bordered table-hover">
	<thead>
		<tr>
			<th width="1%">#</th>
			<th width="10%">Фото</th>
			<th width="20%">Имя</th>
			<th width="20%">Должность</th>
			<th width="1%">Удалить</th>
		<tr>
	</thead>
	<tbody>
	<?php $i = 0; ?>
	<?php foreach($vars['workers'] as $item){ ?>
	<tr class="<?php if ($i %2 == 0) { ?>odd<?php } else { ?>notodd<?php } ?>" id="worker_<?= $item->id?>" data-id="<?=$item->id?>">

		<td class="vert-align"><?=$item->id?></td>
		
		<td>
			<?php if (!empty($item->thumb['f'])) { ?>
                <img src="<?=$item->thumb['f']?>" class="img-responsive">
            <?php } ?>	
		</td>

		<td class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_worker&id=<?=$item->id?>">
				<?= $item->name?>
			</a>
		</td>
		<td class="vert-align">
			<?= $item->position?>
		</td>

		<td align="center" class="vert-align">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_worker&id=<?=$item->id?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<?php $i++; ?>
	<?php  } ?>
	</tbody>
</table>

</form>
