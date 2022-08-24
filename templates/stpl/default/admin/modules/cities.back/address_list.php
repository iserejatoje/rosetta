<script>

	$(document).ready(function(){
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
						$(".table #address_"+data.addressid+" a.available .glyphicon")
							.removeClass('glyphicon-remove')
							.addClass('glyphicon-ok')
							.css({color: '#0f0'});
					}
					else
					{
						$(".table #address_"+data.addressid+" a.available .glyphicon")
							.removeClass('glyphicon-ok')
							.addClass('glyphicon-remove')
							.css({color: '#f00'});
					}
				}
			});
		});

		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить адрес?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});
	});
</script>

<p><a class="button-link" href="?section_id=<?=$vars['section_id']?>&action=new_address&cityid=<?=$vars['cityid']?>">Добавить адрес</a></p>

<form method="GET" name="citiesform">
<input type="hidden" name="action" value="address_save" />
<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

<table class="dsortable table table-bordered table-hover">
	<tr>
		<th width="1%">#</th>
		<th width="50%">Адрес</th>
		<th width="3%"></th>
		<th width="1%">Удалить</th>
	<tr>
	<? $i = 0; ?>
	<? foreach($vars['list'] as $address){ ?>
	<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="address_<?=$address->ID?>">
		<td align="center" class="vert-align"><?=$address->ID?></td>
		<td class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=edit_address&id=<?=$address->ID?>&cityid=<?=$vars['cityid']?>">
				<?=$address->Address?>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_address_toggle_available&id=<?=$address->ID?>" class="available">
				<? if ($address->IsAvailable === true) { ?>
				<span class="glyphicon glyphicon-ok"></span>
				<? } else { ?>
				<span class="glyphicon glyphicon-remove"></span>
				<? } ?>
			</a>
		</td>

		<td align="center" class="vert-align">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_address&id=<?=$address->ID?>">
				<span class="glyphicon glyphicon-trash" title="Удалить"></span>
			</a>
		</td>
	</tr>
	<? $i++; ?>
	<? } ?>
</table>

	<?=STPL::Fetch("admin/modules/cities/pages", array(
		'pages' => $vars['pages']
	))?>

<br/><br/><br/>

</form>
