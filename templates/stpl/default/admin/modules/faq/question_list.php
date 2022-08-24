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

					if (data.visible == 1)
					{
							$('.table #item_'+data.questionid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
							

					}
					else
					{
							$('.table #item_'+data.questionid+' a.visible .glyphicon')
							.removeClass('glyphicon-eye-open')
							.removeClass('glyphicon-success')
							.addClass('glyphicon-eye-close')
							.addClass('glyphicon-danger');
							
					}
				}
			});
		});

		$('.table a.answered').click(function(e){
			e.preventDefault();

			$.ajax({
				url: $(this).attr('href'),
				dataType: "json",
				type: "get",
				success: function(data){
					if (data.status == 'error')
						return false;

					if (data.answered == 1)
					{
							$('.table #item_'+data.questionid+' a.answered .glyphicon')
							.removeClass('glyphicon-remove')
							.addClass('glyphicon-ok');
							$('.table tr#item_'+data.questionid)
							.removeClass('warning')
							.addClass('success');
					}
					else
					{
							$('.table #item_'+data.questionid+' a.answered .glyphicon')
							.removeClass('glyphicon-ok')
							.addClass('glyphicon-remove');
							$('.table tr#item_'+data.questionid)
							.removeClass('success')
							.addClass('warning');
					}
				}
			});
		});


		$('.table a.delete').click(function(e){
			e.preventDefault();
			if (!confirm("Вы действительно хотите удалить вопрос?"))
				return false;

			document.location.href = $(this).attr("href");
		});

		$('.resetorder').click(function(e){
			$('.ord-field').val('0');
		});

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

        $('.is-answered').change(function() {
        	var selected = this.value;
        	$("#isanswered").val(selected);
		    $("#sortingform").submit();
		});

        
	});

	
</script>

<form method="get" enctype="multipart/form-data" id="sortingform">
    <input type="hidden" name="action" value="questions" />
    <input type="hidden" name="field" id="sorting-field" value="<?= $vars['field'] ?>">
    <input type="hidden" name="dir" id="sorting-dir" value="<?= $vars['dir'] ?>">
    <input type="hidden" name="isanswered" id="isanswered" value="<?= $vars['isanswered'] ?>">
</form>




<a class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_question" role="button">Добавить вопрос</a>

<div style="float: right">
    <select class="is-answered form-control">
    	<option value="-1" <?if($vars['isanswered'] == -1) echo 'selected'?>>Все</option>
    	<option value="0"  <?if($vars['isanswered'] == 0) echo 'selected'?>>Не отвеченные</option>
    	<option value="1"  <?if($vars['isanswered'] == 1) echo 'selected'?>>Отвеченные</option>
    </select>
</div>
<br/><br/>


<form method="POST" name="questionsform">
	<input type="hidden" name="action" value="save_questions" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="sortable table table-bordered table-hover table-striped">
		<tr>
			<th width="1%">#</th>
            <th width="10%">
                <a href="javascript:;" data-field="question" data-dir="" class="sorted-link">
                    Вопрос
                    <? if($vars['sorting']['field'] == 'question') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="10%">Ответ</th>
			<th width="3%">
                <a href="javascript:;" data-field="Created" data-dir="" class="sorted-link">
                    Дата добавления
                    <? if($vars['sorting']['field'] == 'Created') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="3%">
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
			<th width="1%">
                <a href="javascript:;" data-field="isvisible" data-dir="" class="sorted-link">
                    Видимость
                    <? if($vars['sorting']['field'] == 'isvisible') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
            <th width="1%">
                <a href="javascript:;" data-field="isanswered" data-dir="" class="sorted-link">
                    Просмотрено
                    <? if($vars['sorting']['field'] == 'isanswered') {
                        if($vars['sorting']['dir'] == 'asc')
                            $class = 'glyphicon-sort-by-attributes';
                        else
                            $class = 'glyphicon-sort-by-attributes-alt';
                        ?>
                        <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                    <? } ?>
                </a>
            </th>
			<th width="1%"></th>
		<tr>

		<? $i = 0; ?>
		<? foreach($vars['list'] as $item){ ?>

			<? $item->IsAnswered == 1?  $color = 'success' : $color = 'warning'; ?>
		
		<tr class="<? if ($i %2 == 0) { ?>odd<? } else { ?>notodd<? } ?> <?= $color ?>" id="item_<?=$item->ID?>">
			<td align="center"><?=$item->ID?></td>

			<td>
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_question&id=<?=$item->ID?>"><?=$item->Question?></a>
			</td>

            <td>
                <?=$item->Answer?>
            </td>

            <td>
            	<?= date('d.m.Y H:i:s', $item->Created) ?>
            </td>

			<td align="center">
				<input type="text" name="Ord[<?=$item->ID?>]" value="<?=$item->Ord?>" class="form-control"/>
			</td>

			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_question_toggle_visible&id=<?=$item->ID?>" class="visible btn btn-default btn-sm">
					<? if ($item->IsVisible === true) { ?>
						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
					<? } else { ?>
						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
					<? } ?>
				</a>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=ajax_question_toggle_answered&id=<?=$item->ID?>" class="answered btn btn-default btn-sm">
					<? if ($item->IsAnswered == 1) { ?>
						<span class="glyphicon  glyphicon-ok"></span>
					<? } else { ?>
						<span class="glyphicon  glyphicon-remove"></span>
					<? } ?>
				</a>
			</td>
			<td align="center">
				<a href="?section_id=<?=$vars['section_id']?>&action=delete_question&id=<?=$item->ID?>" class="delete btn btn-default btn-sm">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			</td>
		</tr>
		<? $i++; ?>
		<? } ?>
	</table>

	<input type="submit" class="btn btn-primary btn-sm" href="?section_id=<?=$vars['section_id']?>&action=new_question" role="button" value="Сохранить">
</form>