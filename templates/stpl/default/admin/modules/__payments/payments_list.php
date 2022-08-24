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
			if (!confirm("Вы действительно хотите удалить район доставки?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<ol class="breadcrumb">
	<? foreach($vars['crumbs'] as $crumb) { ?>
  		<li><a href="<?=$crumb['url']?>"><?=$crumb['name']?></a></li>
  	<? } ?>
  <li class="active">Платежные системы</li>
</ol>

<p>
	<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=<?=$vars['action']?>">
		<span class="glyphicon glyphicon-plus"></span>
		Добавить тип платежной системы
	</a>
</p>

<form method="POST" name="citiesform">
<input type="hidden" name="action" value="save_payments" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
<table class="sortable table table-bordered table-hover">
	<thead>
		<tr>
			<th width="1%">#</th>
			<th width="50%">Платежная система</th>
			<th width="2%">Класс</th>
			<th width="1%">Удалить</th>
		<tr>
	</thead>
	<tbody>
	<? $i = 0; ?>
	<? foreach($vars['payments'] as $item){ ?>
	<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="payment_<?=$item->ID?>" data-id="<?=$item->ID?>">
		<td class="vert-align"><?=$item->ID?></td>
		<td class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_payment&id=<?=$item->ID?>">
				<?=$item->Name?>
			</a>
		</td>
		<td class="vert-align" align="center">
			<?=$item->NameID?>
		</td>

		<td align="center" class="vert-align">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_payment&id=<?=$item->ID?>">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	<? $i++; ?>
	<? } ?>
	</tbody>
</table>

<?/*
<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-save"></span> Сохранить</button>
*/?>

</form>
