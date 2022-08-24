<script>
$(document).ready(function(){
    $('.table a.default').click(function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            dataType: "json",
            type: "get",
            success: function(data){
                if (data.status == 'error')
                    return false;

                // $('.table a.default img').attr({
                // 	src: '/resources/images/admin/hided.png',
                // 	title: 'Скрыть'
                // });


                if (data.default == 1)
                {
                    // $('.table #city_'+data.cityid+' a.default img').attr({
                    // 	src: '/resources/images/admin/visibled.png',
                    // 	title: 'Скрыть'
                    // });

                    $(".table a.default .glyphicon")
                        .removeClass('glyphicon-ok')
                        .addClass('glyphicon-remove');

                    $(".table #city_"+data.cityid+" a.default .glyphicon")
                        .removeClass('glyphicon-remove')
                        .addClass('glyphicon-ok')
                        .css({color: '#0f0'});
                    }
                else
                {

                    $(".table a.default .glyphicon")
                    .removeClass('glyphicon-remove')
                    .addClass('glyphicon-ok');

                    $(".table #city_"+data.cityid+" a.default .glyphicon")
                        .removeClass('glyphicon-ok')
                        .addClass('glyphicon-remove')
                        .css({color: '#f00'});
                    // $('.table #city_'+data.cityid+' a.default img').attr({
                    // 	src: '/resources/images/admin/hided.png',
                    // 	title: 'Показать'
                    // });
                }
            }
        });
    });

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
                    // $('.table #city_'+data.cityid+' a.visible img').attr({
                    // 	src: '/resources/images/admin/visibled.png',
                    // 	title: 'Скрыть'
                    // });
                    $(".table #city_"+data.cityid+" a.visible .glyphicon")
                        .removeClass('glyphicon-remove')
                        .addClass('glyphicon-ok')
                        .css({color: '#0f0'});
                }
                else
                {
                    $(".table #city_"+data.cityid+" a.visible .glyphicon")
                        .removeClass('glyphicon-ok')
                        .addClass('glyphicon-remove')
                        .css({color: '#f00'});
                    // $('.table #city_'+data.cityid+' a.visible img').attr({
                    // 	src: '/resources/images/admin/hided.png',
                    // 	title: 'Показать'
                    // });
                }
            }
        });
    });

    $('.table a.delete').click(function(e){
        e.preventDefault();
        if (!confirm("Вы действительно хотите удалить город?"))
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
});
</script>

<p><a class="button-link" href="?section_id=<?= $vars['section_id']?>&action=new_city">Добавить город</a></p>

<form method="get" id="sortingform">
    <input type="hidden" name="action" value="cities"/>
    <input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">
</form>

<form method="GET" name="citiesform">
<input type="hidden" name="action" value="cities" />
<input type="hidden" name="section_id" value="<?= $vars['section_id']?>" />
<table class="dsortable table table-bordered table-hover">
	<tr>
		<th width="1%">#</th>
		<th width="50%">
            <a href="javascript:;" data-field="name" data-dir="" class="sorted-link">
                Название
                <?php if($vars['sorting']['field'] == 'name') {
                    if($vars['sorting']['dir'] == 'asc') {
                        $class = 'glyphicon-sort-by-attributes';
                    } else {
                        $class = 'glyphicon-sort-by-attributes-alt';
                    }
                    ?>
                    <span class="glyphicon <?= $class?>" data-dir="<?= $vars['sorting']['dir']?>"></span>
                <?php } ?>
            </a>
        </th>
		<th width="5%">
            <a href="javascript:;" data-field="isvisible" data-dir="" class="sorted-link">
                Видимость
                <?php if($vars['sorting']['field'] == 'isvisible') {
                    if($vars['sorting']['dir'] == 'asc')
                        $class = 'glyphicon-sort-by-attributes';
                    else
                        $class = 'glyphicon-sort-by-attributes-alt';
                    ?>
                    <span class="glyphicon <?=$class?>" data-dir="<?=$vars['sorting']['dir']?>"></span>
                <?php } ?>
            </a>
        </th>
		<th width="1%">По-умолч.</th>
		<?php /*
		<th width="1%">Города</th>
		*/ ?>

		<th width="1%">Районы</th>
		<th width="1%">Магазины</th>
		<th width="1%">Удалить</th>
	<tr>
	<?php $i = 0; ?>
	<?php foreach($vars['cities'] as $city){ ?>
	<tr class="<?php if ($i %2 == 0) { ?>odd<?php } else { ?>notodd<?php } ?>" id="city_<?= $city->ID?>">
		<td align="center" class="vert-align"><?=$city->ID?></td>
		<td class="vert-align">
			<a href="?section_id=<?= $vars['section_id']?>&action=edit_city&id=<?= $city->ID?>">
				<?= $city->Name?>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_city_toggle_visible&id=<?=$city->ID?>" class="visible">
				<?php if ($city->IsVisible) { ?>
				<span class="glyphicon glyphicon-ok"></span>
				<?php /*<img src="/resources/images/admin/visibled.png" title="Скрыть"/>*/?>
				<?php } else { ?>
				<span class="glyphicon glyphicon-remove"></span>
				<?php /*<img src="/resources/images/admin/hided.png" title="Показать"/>*/?>
				<?php } ?>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=ajax_city_toggle_default&id=<?=$city->ID?>" class="default">
				<?php if ($city->IsDefault) { ?>
				<span class="glyphicon glyphicon-ok"></span>
				<?php /*<img src="/resources/images/admin/visibled.png" title="Скрыть"/>*/?>
				<?php } else { ?>
				<span class="glyphicon glyphicon-remove"></span>
				<?php /*<img src="/resources/images/admin/hided.png" title="Показать"/>*/?>
				<?php } ?>
			</a>
		</td>

		<?/*
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=delivery_cities&id=<?=$city->ID?>">
				<span class="glyphicon glyphicon-map-marker" title="Города"></span>
			</a>
		</td>
		*/?>

		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=districts&cityid=<?=$city->ID?>">
				<?/*<img src="/resources/images/admin/delivery.png" title="Районы"/>*/?>
				<span class="glyphicon glyphicon-th" title="Районы доставки"></span>
			</a>
		</td>
		<td align="center" class="vert-align">
			<a href="?section_id=<?=$vars['section_id']?>&action=stores&cityid=<?=$city->ID?>">
				<?/*<img src="/resources/images/admin/store.png" title="Магазины"/>*/?>
				<span class="glyphicon glyphicon-home" title="Магазины"></span>
			</a>
		</td>

		<td align="center" class="vert-align">
			<a class="delete" href="?section_id=<?=$vars['section_id']?>&action=delete_city&id=<?=$city->ID?>">
				<?/*<img src="/resources/images/admin/delete.png" title="Удалить"/>*/?>
				<span class="glyphicon glyphicon-trash" title="Удалить"></span>
			</a>
		</td>
	</tr>
	<?php $i++; ?>
	<?php } ?>
</table>

<?php /* =STPL::Fetch("admin/modules/cities/pages", array(
	'pages' => $vars['pages']
)) */ ?>

<br/><br/><br/>

</form>
