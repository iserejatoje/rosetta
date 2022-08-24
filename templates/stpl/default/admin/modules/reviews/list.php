<?
	session_start();
?>
<br>

<ul class="nav nav-tabs">
	<li role="presentation"<? if ($vars['action'] == 'hided_list') { ?> class="active"<? } ?>><a href="?section_id=<?=$vars['section_id']?>&action=hided_list">На модерации</a></li>
	<li role="presentation"<? if ($vars['action'] == 'visible_list') { ?> class="active"<? } ?>><a href="?section_id=<?=$vars['section_id']?>&action=visible_list">Видимые</a></li>
</ul><br>
<? $message = $_SESSION['user_message']['message'] ?>
<? if (!empty($message)) { ?>
	<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<strong>Успешно!</strong> <?=$message ?></div>
	<? unset($_SESSION['user_message']); ?>
<? } ?>


<script>

	$(document).ready(function(){
		$('.table a.visible').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					$("#review_"+data.reviewid).remove();
					// if (data.visible == 1)
					// {
					// 		$('.table #product_'+data.productid+' a.visible .glyphicon')
					// 		.removeClass('glyphicon-eye-close')
					// 		.removeClass('glyphicon-danger')
					// 		.addClass('glyphicon-eye-open')
					// 		.addClass('glyphicon-success');
					// }
					// else
					// {
					// 		$('.table #product_'+data.productid+' a.visible .glyphicon')
					// 		.removeClass('glyphicon-eye-open')
					// 		.removeClass('glyphicon-success')
					// 		.addClass('glyphicon-eye-close')
					// 		.addClass('glyphicon-danger');
					// }
				}
			});
		});

		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить товар?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.sorted-link').click(function() {
            var sort_field = $(this).data('field');
            var sort_dir = $(this).find('.glyphicon').data('dir');
            console.log(sort_field);
            console.log(sort_dir);

            if(sort_dir == 'DESC' || sort_dir == '')
                var dir = 'ASC';
            else
                var dir = 'DESC'

            $("#sorting-field").val(sort_field);
            $("#sorting-dir").val(dir);
            $("#sortingform").submit();
        });


	});
</script>


<form method="get" enctype="multipart/form-data" id="sortingform">
    <input type="hidden" name="action" value="reviews" />
    <input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">
    <input type="hidden" name="visible" value="<?=$vars['visible']?>"/>
</form>




<form method="POST" name="productform">
	
	<input type="hidden" name="visible" value="<?=$vars['visible']?>"/>
	<?/* <input type="hidden" name="action" value="<?=$vars['action']?>">
	<input type="hidden" name="action" value="save_products_order" /> */?>
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="10%">
                <a href="javascript:;" data-field="Created" data-dir="" class="sorted-link">
                    Дата
                    <? if($vars['sorting']['field'] == 'Created') {
                        if($vars['sorting']['dir'] == 'ASC')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="20%">
                <a href="javascript:;" data-field="Username" data-dir="" class="sorted-link">
                    Автор
                    <? if($vars['sorting']['field'] == 'Username') {
                        if($vars['sorting']['dir'] == 'ASC')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="25%">
                <a href="javascript:;" data-field="Text" data-dir="" class="sorted-link">
                    Текст
                    <? if($vars['sorting']['field'] == 'Text') {
                        if($vars['sorting']['dir'] == 'ASC')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="25%">
                <a href="javascript:;" data-field="AnswerText" data-dir="" class="sorted-link">
                    Ответ
                    <? if($vars['sorting']['field'] == 'AnswerText') {
                        if($vars['sorting']['dir'] == 'ASC')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th></th>
			<th></th>
		</tr>
		<? $i = 0; ?>
		<? foreach($vars['list'] as $item){ ?>
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?>" id="review_<?=$item->ID?>">
			<td align="center"><?=date('d.m.Y H:i:s', strtotime($item->Created))?></td>

			<td align="center">
				<input class="form-control input-sm input-ord ord-field" type="text" name="Username[<?=$item->ID?>]" value="<?=$item->Username?>"/>
			</td>

			<td align="center">
				<textarea class="form-control" rows="3" name="Text[<?=$item->ID?>]"><?=$item->Text?></textarea>
			</td>

			<td align="center">
				<textarea class="form-control" rows="3" name="AnswerText[<?=$item->ID?>]"><?=$item->AnswerText?></textarea>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=toggle_visible&id=<?=$item->ID?>" class="visible btn btn-default btn-sm">
					<? if ($item->IsVisible == 1) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>

			<td align="center">
				<input type="checkbox" name="ids_action[]" value="<?=$item->ID?>">
			</td>
		</tr>
		<? } ?>
	</table>

	<div class="row">
		<div class="col-md-9"></div>
		<div class="col-md-2">
			<select name="action" id="action" class="form-control">
				<option value="">Выберите действие</option>
				<option value="save">Сохранить</option>
				<option value="visible">Показать</option>
				<option value="hide">Скрыть</option>
				<option value="delete">Удалить</option>
			</select>
		</div>
		<div class="col-md-1">
			<input class="btn btn-default" type="submit" value="Ok">
		</div>


	</div>
</form>
