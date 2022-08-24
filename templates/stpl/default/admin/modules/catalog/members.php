<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<div class="panel panel-default">
  		<div class="panel-heading">
  			<h3 class="panel-title">Внимание</h3>
  		</div>
  		<div class="panel-body">
			<div class="alert alert-danger" role="alert"><?=$err?></div>
  		</div>
	</div>
<? } else { ?>

<style>
	.table > tbody > tr > td {
		vertical-align: middle;
	}
	.table.form > tbody > tr > td {
		text-shadow: none;
	}

	.not-used {
		display: none;
	}

</style>

<script>
	function checkaction()
	{
		obj = document.getElementById("action");
		if(obj.options[obj.selectedIndex].value=='')
			return false;
		return true;
	}
	$(document).ready(function() {

		var _parseUrl = function() {
			var urlParams;
			(window.onpopstate = function () {
				var match,
					pl     = /\+/g,  // Regex for replacing addition symbol with a space
					search = /([^&=]+)=?([^&]*)/g,
					decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
					query  = window.location.search.substring(1);

				urlParams = {};
				while (match = search.exec(query))
					urlParams[decode(match[1])] = decode(match[2]);
			})();
			return urlParams;
		}

		var _createUrl = function(obj) {
			var str = [];
			for(var p in obj) {
				if (obj.hasOwnProperty(p)) {
					str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
				}
			}

			return str.join("&");
		}

		$('.sorted-link').click(function() {
            var sort_field = $(this).data('field');
            var sort_dir = $(this).find('.glyphicon').data('dir');

            if(sort_dir == 'desc' || sort_dir == '')
                var dir = 'asc';
            else
				var dir = 'desc'
				
			var params = _parseUrl(location.href);
			params.dir = dir;
			params.field = sort_field;
			url = _createUrl(params);
			location.href = '?' + url;
        });

		$(".filter-field").on("change", function() {
			var url = location.href, params;
			params = _parseUrl(url);

			if(this.value) {
				params[this.getAttribute('name')] = this.value;
			} else {
				delete params[this.getAttribute('name')];
			}
			params.page = 1;
			url = _createUrl(params);
			location.href = '?' + url;
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
						$('.table #member_'+data.memberid+' .glyphicon')
							.removeClass('glyphicon-eye-close')
							.removeClass('glyphicon-danger')
							.addClass('glyphicon-eye-open')
							.addClass('glyphicon-success');
					}
					else
					{
						$('.table #member_'+data.memberid+' .glyphicon')
							.removeClass('glyphicon-eye-open')
							.removeClass('glyphicon-success')
							.addClass('glyphicon-eye-close')
							.addClass('glyphicon-danger');
					}
				}
			});
		});

		$('.input-price').on('change', function() {
			var value = $(this).val(),
				id = $(this).attr('name'),
				id = id.substring(6, id.length - 1),
				data = {
					'id': id,
					'value': value,
					'action': 'update_member_price',
					'catalog_id': <?= $vars['section_id']?>,
				};

			if(!isNaN(value * 1)) {
				value *= 1;
			}

			if(typeof value == 'number') {
				$.ajax({
					url: '',
					dataType: "json",
					type: "post",
					data: data,
					success: function(data){
						console.log(data);
					}
				});
			} else {
				alert('Значение некорректно. Изменения не сохранены!');

			}

		});

		$('#btn-display-not-used').on('click', function() {
			if($('.not-used').css('display') == 'none')  {
				$('.not-used').css('display', 'block');
				$('#btn-display-not-used-text').text('Скрыть неиспользованные артикли');
			} else {
				$('.not-used').css('display', 'none');
				$('#btn-display-not-used-text').text('Показать неиспользованные артикли');
			}
		});
	 });

</script>
<?
	if(isset(App::$Request->Get['updated'])) {
		$updated = App::$Request->Get['updated']->Value();
		$updated = json_decode($updated);
	}
?>


<form method="get" enctype="multipart/form-data" id="sortingform">
	<input type="hidden" name="action" value="compositions" />
	<input type="hidden" name="field" id="sorting-field">
    <input type="hidden" name="dir" id="sorting-dir">
</form>

<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">Обновление ингридиентов</div>
				<div class="panel-body">
			    	<form method="post" enctype="multipart/form-data">
						<input type="hidden" name="action" value="update_members">
						<table>
							<tr>
								<td>
									<input type="file" name="update_file" />
								</td>
								<td>
									<button class="btn btn-success btn-large" type="submit">
										<span class="glyphicon glyphicon-save"></span>Загрузить
									</button>
								</td>
							</tr>
						</table>
					</form>
			  	</div>
				<? $message = $_SESSION['user_message']['message'] ?>
				<? if (!empty($message)) { ?>
				<div class="panel-footer">
					<div class="alert alert-success" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<strong>Успешно!</strong> <?= $message ?>
					</div>
				</div>
				<? unset($_SESSION['user_message']); ?>
			</div>
			<? } ?>
		</div>
		<div class="col-md-offset-2 col-md-4">
			<?
				if(isset($_SESSION['not_used'])) {
					$not_used = json_decode($_SESSION['not_used']);
					?>
					<div id="btn-display-not-used" class="btn btn-primary" style="cursor: pointer">
						<span id="btn-display-not-used-text">Показать неиспользованные артикли</span>
					</div>
					<br>
					<br>
					<div class="not-used">
						<? foreach($not_used as $value) { ?>
							<span><?= $value ?>, </span>
						<? } ?>
					</div>
					<?
					unset($_SESSION['not_used']);
				}
			?>
		</div>
	</div>
</div>

<br/>

<? if(App::$User->IsInRole('e_adm_execute_cp') && App::$User->IsInRole('e_adm_execute_users')) { ?>
	<p>
		<a href="?section_id=<?=$vars['section_id']?>&action=new_member" class="btn btn-primary btn-sm">
			<span class="glyphicon glyphicon-plus"></span>
			Добавить элемент
		</a>
	</p>
	<br/>
<? } ?>

<form method="post" onsubmit="return checkaction();">
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>">

    <div align="center">
        <nobr>
            <div class="form-group">
            <? if(App::$User->IsInRole('u_bouquet_editor')
                || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
                <select name="action" id="action" class="form-control" style="max-width: 200px; display: inline-block;">
                    <?/*
                        <option value="">Выбрать действие</option>
                        <option value="members_save">Сохранить изменения</option>
                    */?>
                    <option value="members_delete">Удалить элементы</option>

                </select>
            <? } ?>
            <? if(App::$User->IsInRole('u_bouquet_editor')
                || App::$User->IsInRole('u_price_changer')
                || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
                <input type="submit" value="ОK" class="btn btn-primary btn-sm">
            <? } ?>
            </div>
        </nobr>
	</div>
<?php if($vars['pages']): ?>
    <?=STPL::Fetch('admin/modules/catalog/pages', ['pages' => $vars['pages']])?>
<?php endif; ?>
<table width="100%" id="composition-list" class="sortable table table-bordered table-hover table-striped">
	<tr>
		<th width="3%">ID</th>
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
		<th width="60%">
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
		<th width="15%">Цена, руб.</th>
        <? if(App::$User->IsInRole('u_bouquet_editor')
            // && App::$User->IsInRole('u_price_changer') == false
            || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
		<th width="5%">
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
        <? } ?>
		<? if(App::$User->IsInRole('u_bouquet_editor')
                // && App::$User->IsInRole('u_price_changer') == false
                || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
			<th width="5%">
				<input type="checkbox" onchange="if (this.checked) $('.ids_action').attr('checked', 'checked'); else $('.ids_action').attr('checked', '');"/>
			</th>
		<? } ?>
	</tr>
	<tr>
		<td></td>
		<td><input type="text" class="form-control filter-field" name="filter-article" value="<?= $vars['filterArticle'] ?>"></td>
		<td><input type="text" class="form-control filter-field" name="filter-name" value="<?= $vars['filterName'] ?>"></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<? if (is_array($vars['list']) && sizeof($vars['list']) > 0) { ?>
		<? foreach ($vars['list'] as $l) {
			?>
			<? $areaRefs = $l->GetAreaRefs($vars['section_id']); ?>
		<tr <?if(in_array($l->id, $updated)) echo 'class="success"';?>>
			<td align="center">
				<?=$l->id?>
			</td>

			<td align="center">
				<?= $l->article ?>
			</td>

			<td width="300">
				<a href="?section_id=<?=$vars['section_id']?>&action=edit_member&id=<?= $l->ID ?>" name="member<?= $l->ID ?>"><?= $l->Name ?></a>
				<br/>
			</td>

			<td align="center">
                <input type="text" name="price[<?=$l->id?>]" value="<?=$areaRefs['Price'] ?>" autocomplete="off" class="form-control input-price" />
				<? $areaRefs['Price'] ?>
			</td>

             <? if(App::$User->IsInRole('u_bouquet_editor')
                // && App::$User->IsInRole('u_price_changer') == false
                || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
    			<td align="center">
    				<a id="member_<?= $l->ID ?>" class="visible" href="?section_id=<?=$vars['section_id']?>&action=toggle_member_visible&id=<?=$l->ID ?>">
    					<? if ($areaRefs['IsVisible']==1) { ?>
    						<span class="glyphicon glyphicon-eye-open glyphicon-success"></span>
    					<? } else { ?>
    						<span class="glyphicon glyphicon-eye-close glyphicon-danger"></span>
    					<? } ?>
    				</a>
    			</td>
            <? } ?>

			<? if(App::$User->IsInRole('u_bouquet_editor')
                // && App::$User->IsInRole('u_price_changer') == false
                || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
				<td align="center">
					<input class="ids_action ids_action_<?= $l->ID ?>" type="checkbox" name="ids_action[<?=$l->id?>]" value="<?= $l->ID ?>"/>
				</td>
			<? } ?>
		</tr>
		<? } ?>
	<? } ?>
</table>
<?php if($vars['pages']): ?>
    <?=STPL::Fetch('admin/modules/catalog/pages', ['pages' => $vars['pages']])?>
<?php endif; ?>
    <div align="center">
        <nobr>
            <div class="form-group">
            <? if(App::$User->IsInRole('u_bouquet_editor')
                || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
				<select name="action" id="action" class="form-control" style="max-width: 200px; display: inline-block;">
                    <?/*
						<option value="">Выбрать действие</option>
						<option value="members_save">Сохранить изменения</option>
                    */?>
					<option value="members_delete">Удалить элементы</option>

				</select>
            <? } ?>
            <? if(App::$User->IsInRole('u_bouquet_editor')
                || App::$User->IsInRole('u_price_changer')
                || (App::$User->IsInRole('e_adm_execute_section') && App::$User->IsInRole('e_adm_execute_users'))) { ?>
                <input type="submit" value="ОK" class="btn btn-primary btn-sm">
            <? } ?>
            </div>
        </nobr>
    </div>

</form>

<? } ?>