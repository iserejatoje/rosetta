<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<table class="form">
		<tr>
			<td class="header-column">Ай-ай, ошибка</td>
			<td class="data-column">
				<span class="error"><?=$err?></span><br/>
			</td>
		</tr>
	</table>
<? } else { ?>

<style>
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	h1 { font-size: 1.2em; margin: .6em 0; }

	.acl-field {
		padding-top: 4px;
		padding-bottom: 4px;
		border-bottom: dotted 1px #898989;
	}

    .table > tbody > tr > td {
        vertical-align: middle;
    }
    .table.form > tbody > tr > td {
        text-shadow: none;
    }
</style>

<script>
	var placemark = null;
	var map  = null;

	$(function() {
		$(".input-number-field").keypress(function(e){
			if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
				return false;
		});

		$(".input-float-field").keypress(function(e){

			if( e.which!=8 && e.which!=0 && e.which != 46 && (e.which<48 || e.which>57))
				return false;
		});

		/*$( ".datepicker" ).datepicker($.datepicker.regional[ "ru" ]);

		$('.timepicker').timepicker({
			// <Options></Options>
			defaultTime: '12:34',         // Used as default time when input field is empty or for inline timePicker
										  // (set to 'now' for the current time, '' for no highlighted time, default value: now)

			zIndex: null,                 // Overwrite the default zIndex used by the time picker

			// Localization
			hourText: 'Часы',             // Define the locale text for "Hours"
			minuteText: 'Минуты',         // Define the locale text for "Minute"
			amPmText: ['', ''],       // Define the locale text for periods
			rows: 6

		});*/

	});

	<? if ($vars['form']['acls'] !== false) { ?>
	var counter_acl = <?=count($vars['form']['acls'])?>;
	<? } else { ?>
	var counter_acl = 0;
	<? } ?>
	function add_acl()
	{
		counter_acl++;
		var html = $('#acl_etalon tbody').html();
		html = html.replace(/etalon_/g, "");
		html = html.replace(/{id}/g, counter_acl+"");
		$('#acls').append(html);
		/*
		$(".datepicker-"+counter_acl).datepicker($.datepicker.regional[ "ru" ]);

		$(".timepicker-"+counter_acl).timepicker({
			// Options
			defaultTime: '00:00',         // Used as default time when input field is empty or for inline timePicker
										  // (set to 'now' for the current time, '' for no highlighted time, default value: now)

			zIndex: null,                 // Overwrite the default zIndex used by the time picker

			// Localization
			hourText: 'Часы',             // Define the locale text for "Hours"
			minuteText: 'Минуты',         // Define the locale text for "Minute"
			amPmText: ['', ''],       // Define the locale text for periods
			rows: 6

		});*/
	}

	$(document).ready(function(){
		/*$("input[class^=datepicker]").datepicker($.datepicker.regional[ "ru" ]);

		$("input[class^=timepicker]").timepicker({
			// Options
			defaultTime: '00:00',         // Used as default time when input field is empty or for inline timePicker
										  // (set to 'now' for the current time, '' for no highlighted time, default value: now)

			zIndex: null,                 // Overwrite the default zIndex used by the time picker

			// Localization
			hourText: 'Часы',             // Define the locale text for "Hours"
			minuteText: 'Минуты',         // Define the locale text for "Minute"
			amPmText: ['', ''],       // Define the locale text for periods
			rows: 6

		});*/
	});

	function show_rule_field(id, key)
	{
		$('.rule-'+id).hide();
		if (key == <?=BannerMgr::T_ACL_URL?>)
		{
			$('#rule_url_'+id).show();
		}
		else if (key == <?=BannerMgr::T_ACL_DATE?>)
		{
			$('#rule_datetime_'+id).show();
		}
		else if (key == <?=BannerMgr::T_ACL_DATE_MASK?>)
		{
			$('#rule_datepattern_'+id).show();
		}
	}

	function toggle_acl_visible(id, img)
	{
		var obj = $('#acl_visible_'+id);
		var curr_val = obj.val();
		if (curr_val == 1)
		{
			obj.val(0);
			$(img).attr({src:"/resources/images/admin/hided.png",title:"Обрабатывать правило"});
		}
		else
		{
			obj.val(1);
			$(img).attr({src:"/resources/images/admin/visibled.png",title:"Не обрабатывать правило"});
		}
	}

	function delete_acl(id)
	{
		$('#acl_'+id).remove();
	}

	function change_perm_bg(id, key)
	{
		if (key == <?=BannerMgr::PERM_ACL_ALLOW?>)
		{
			$('#acl_'+id).css({backgroundColor: '#d6ffd5'});
		}
		else if (key == <?=BannerMgr::PERM_ACL_DENY?>)
		{
			$('#acl_'+id).css({backgroundColor: '#ffcfca'});
		}
		else
			$('#acl_'+id).css({backgroundColor: ''});
	}
</script>

	<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="<?=$vars['action']?>" />
		<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />


		<table class="form table table-sriped">
			<tr>
				<td class="header-column">Баннер отображается на сайте</td>
				<td class="data-column"><input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?> ></td>
			</tr>

			<tr>
				<td class="header-column">Баннерное место</td>
				<td class="data-column">
					<? if($err_txt) { ?>
						<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
					<? } ?>
					<select name="PlaceID" class="form-control" id="banner-place">
						<option value="0">- укажите баннерное место -</option>
						<? foreach($vars['places'] as $item) { ?>
							<option value="<?=$item->ID?>" <? if($item->ID == $vars['form']['PlaceID']) { ?>selected="selected"<? } ?>><?=$item->Name?></option>
						<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td class="header-column">Тип баннера</td>
				<td class="data-column">
					<select name="Type" class="form-control" >
						<option value="0">- укажите тип баннера -</option>
						<? foreach(BannerMgr::$TYPES as $k => $v) { ?>
							<option value="<?=$k?>"<? if ($k == $vars['form']['Type']) { ?> selected="selected"<? } ?>><?=$v?></option>
						<? } ?>
					</select>
				</td>
			</tr>

			<tr>
				<td class="header-column">Ссылка</td>
				<td class="data-column"><input type="text" class="form-control" name="Url" value="<?=UString::ChangeQuotes($vars['form']['Url'])?>"></td>
			</tr>

			<tr>
				<td class="header-column">Текст баннера или код видео</td>
				<td class="data-column">
					<textarea class="form-control" name="BannerText"><?=UString::ChangeQuotes($vars['form']['BannerText'])?></textarea>
				</td>
			</tr>

			<tr>
				<td class="header-column">Ширина</td>
				<td class="data-column">
					<input type="text" class="form-control" name="Width" value="<?=UString::ChangeQuotes($vars['form']['Width'])?>">
				</td>
			</tr>

			<tr>
				<td class="header-column">Высота</td>
				<td class="data-column">
					<input type="text" class="form-control" name="Height" value="<?=UString::ChangeQuotes($vars['form']['Height'])?>">
				</td>
			</tr>

			<tr>
				<td class="header-column">
					Файл<br>
					<small>На главной: 1920х400px</small><br>
					<small>На других страницах : 1920х766px</small><br>
				</td>
				<td class="data-column">
					<? if (!empty($vars['form']['File']['f'])) { ?>

						<? if($vars['form']['Type'] == BannerMgr::T_IMAGE || $vars['form']['Type'] == BannerMgr::T_IMAGE_WITH_BTN) { ?>
							<img src="<?=$vars['form']['File']['f']?>" alt="" style="width: 900px;">
						<? } else { ?>
							<?=BannerMgr::GetHTML($vars['form']['PlaceID'], $vars['form']['BannerID'])?>
						<? } ?>
						<input type="checkbox" name="del_file" value="1"/> удалить<br/>
					<? } elseif ($vars['action'] == 'edit_banner' && ($vars['form']['Type'] == BannerMgr::T_TEXT || $vars['form']['Type'] == BannerMgr::T_JAVASCRIPT)) { ?>
							<div style="height: 350px">
								<?=BannerMgr::GetHTML($vars['form']['PlaceID'], $vars['form']['BannerID'])?>
							</div>
					<? } ?>

					<input type="file" name="File"><br/>
				</td>
			</tr>

			<td colspan="2" align="center">
				<br/>
				<button class="btn btn-success btn-large" type="submit">Сохранить</button>
			</td>

			<?/*
			<tr>
				<td class="header-column"></td>
				<td class="data-column"></td>
			</tr>
			*/?>
		</table>
	</form>
<?/*
	<div class="panel-body">
		<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="<?=$vars['action']?>" />
			<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

		 	<div class="form-group">
	    		<div class="col-sm-offset-2 col-sm-10">
	      			<div class="checkbox">
	        			<label>
	        				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?> >
	        				Баннер отображается на сайте
	        			</label>
	      			</div>
	    		</div>
	  		</div>

			<?
	    	$err_txt = '';
	    	if (($err = UserError::GetErrorByIndex('PlaceID')) != '' ) {
	    		$cls = " has-error";
	    		$err_txt = $err;
	    	} ?>
	  		<div class="form-group">
		    	<label for="pm-name" class="col-sm-2 control-label">Баннерное место</label>
		    	<div class="col-sm-10">
		    		<? if($err_txt) { ?>
						<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
		  			<? } ?>
		    		<select name="PlaceID" class="form-control" id="banner-place">
		    			<option value="0">- укажите баннерное место -</option>
		    		<? foreach($vars['places'] as $item) { ?>
		    			<option value="<?=$item->ID?>" <? if($item->ID == $vars['form']['PlaceID']) { ?>selected="selected"<? } ?>><?=$item->Name?></option>
		    		<? } ?>
		    		</select>
		  		</div>
		  	</div>


			<?
	    	$err_txt = '';
	    	if (($err = UserError::GetErrorByIndex('Type')) != '' ) {
	    		$cls = " has-error";
	    		$err_txt = $err;
	    	} ?>
	  		<div class="form-group">
		    	<label for="pm-name" class="col-sm-2 control-label">Тип баннера</label>
		    	<div class="col-sm-10">
		    		<? if($err_txt) { ?>
						<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
		  			<? } ?>
		    		<select name="Type" class="form-control" >
		    			<option value="0">- укажите тип баннера -</option>
			    		<? foreach(BannerMgr::$TYPES as $k => $v) { ?>
			    			<option value="<?=$k?>"<? if ($k == $vars['form']['Type']) { ?> selected="selected"<? } ?>><?=$v?></option>
			    		<? } ?>
		    		</select>
		  		</div>
		  	</div>

		  	<div class="form-group">
		    	<label for="store-name" class="col-sm-2 control-label">Ссылка</label>
		    	<div class="col-sm-10">
			    	<div class="input-group">
  						<span class="input-group-addon"><span class="glyphicon glyphicon-link"></span></span>
  						<input type="text" class="form-control" name="Url" value="<?=UString::ChangeQuotes($vars['form']['Url'])?>">
					</div>
		  		</div>
		  	</div>

	  		<div class="form-group">
		    	<label for="store-phonecode" class="col-sm-2 control-label">Текст баннера или код видео</label>
		    	<div class="col-sm-10">
						<textarea class="form-control" name="BannerText"><?=UString::ChangeQuotes($vars['form']['BannerText'])?></textarea>
		  		</div>
		  	</div>

		  	<div class="form-group">
		    	<label for="store-name" class="col-sm-2 control-label">Ширина</label>
		    	<div class="col-sm-10">
			    	<div class="input-group">
  						<span class="input-group-addon"><span class="glyphicon glyphicon-resize-horizontal"></span></span>
  						<input type="text" class="form-control" name="Width" value="<?=UString::ChangeQuotes($vars['form']['Width'])?>">
					</div>
		  		</div>
		  	</div>

		  	<div class="form-group">
		    	<label for="store-name" class="col-sm-2 control-label">Высота</label>
		    	<div class="col-sm-10">
			    	<div class="input-group">
  						<span class="input-group-addon"><span class="glyphicon glyphicon-resize-vertical"></span></span>
  						<input type="text" class="form-control" name="Height" value="<?=UString::ChangeQuotes($vars['form']['Height'])?>">
					</div>
		  		</div>
		  	</div>

		  	<div class="form-group">
				<label for="store-name" class="col-sm-2 control-label">Файл</label>
				<div class="col-sm-10">
					<? if (!empty($vars['form']['File']['f'])) { ?>
						<?=BannerMgr::GetHTML($vars['form']['PlaceID'], $vars['form']['BannerID'])?>
						<input type="checkbox" name="del_file" value="1"/> удалить<br/>
					<? } elseif ($vars['action'] == 'edit_banner' && ($vars['form']['Type'] == BannerMgr::T_TEXT || $vars['form']['Type'] == BannerMgr::T_JAVASCRIPT)) { ?>
						<div style="clear:boath">
						<?=BannerMgr::GetHTML($vars['form']['PlaceID'], $vars['form']['BannerID'])?>
						</div>
					<? } ?>

					<input type="file" name="File"><br/>
				</div>
			</div>


		  	<div class="form-group">
		    	<div class="col-sm-2"></div>
		    	<div class="col-sm-10">
					<input class="btn btn-success" type="submit" value="Сохранить" />
		  		</div>
		  	</div>
		</form>
	</div>
</div>

<?/*
<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />

	<table class="form">
		<tr>
			<td class="header-column">Баннер отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>
		<tr>
			<td class="header-column important">Баннерное место <span class="required-field">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('PlaceID')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<select name="PlaceID">
					<option value="0">- Выберите баннерное место -</option>
					<? foreach($vars['places'] as $place) { ?>
					<option value="<?=$place->ID?>"<? if ($place->ID == $vars['form']['PlaceID']) { ?> selected="selected"<? } ?>><?=$place->Name?> [<?=$place->Interval?>]</option>
					<? } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="header-column important">Тип баннера <span class="required-field">*</span></td>
			<td class="data-column">

				<select name="Type">
					<? foreach(BannerMgr::$TYPES as $k => $v) { ?>
					<option value="<?=$k?>"<? if ($k == $vars['form']['Type']) { ?> selected="selected"<? } ?>><?=$v?></option>
					<? } ?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="header-column important">Ссылка</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="Url" value="<?=UString::ChangeQuotes($vars['form']['Url'])?>"><br/>
			</td>
		</tr>
		<?/*<tr>
			<td class="header-column important">Email пользователя для уведомлений</td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Email')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>
				<input type="text" class="input-text-field<? if ( UserError::GetErrorByIndex('Email') != '' ) { ?> text-error<? } ?>" name="Email" value="<?=UString::ChangeQuotes($vars['form']['Email'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Дата снятия баннера</td>
			<td class="data-column">
				<input class="datepicker" type="text" name="RemovalDate" value="<?=date("d.m.Y", $vars['form']['RemovalDate'])?>" autocomplete="off">
				<input class="timepicker" type="text" name="RemovalTime" value="<?=date("H:i", $vars['form']['RemovalTime'])?>" autocomplete="off">
			</td>
		</tr>
		<tr>
			<td class="header-column">Текст баннера</td>
			<td class="data-column">
				<textarea name="BannerText" class="textarea"><?=$vars['form']['BannerText']?></textarea><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">Текст для футера банера</td>
			<td class="data-column">
				<input type="text" name="FooterTextLeft" value="<?=UString::ChangeQuotes($vars['form']['FooterTextLeft'])?>" size="70">
				<input type="text" name="FooterTextRight" value="<?=UString::ChangeQuotes($vars['form']['FooterTextRight'])?>"  size="70">
			</td>
		</tr>

		<?/*
		<tr>
			<td class="header-column">Правила показа</td>
			<td class="data-column">
				<table style="display:none" id="acl_etalon">
				<tbody>
					<tr id="acl_{id}">
						<td class="acl-field">
							<input type="text" class="rule-{id}" name="etalon_rule_url[]" id="rule_url_{id}" value="" style="width:200px;display:none" placeholder="Правило"/>

							<div class="rule-{id}" id="rule_datetime_{id}" style="display:none;">
								<table>
								<tr>
									<td>Показывать&nbsp;с</td>
									<td><input class="datepicker-{id}" type="text" name="etalon_rule_date_from[]" id="rule_date_from_{id}" value="" style="width:100px;"/>&nbsp;<input class="timepicker-{id}" type="text" name="etalon_rule_time_from[]" id="rule_time_from_{id}" value="" style="width:50px;"/></td>
								</tr>
								<tr>
									<td>Показывать&nbsp;до</td>
									<td><input class="datepicker-{id}" type="text" name="etalon_rule_date_to[]" id="rule_date_to_{id}" value="" style="width:100px;"/>&nbsp;<input class="timepicker-{id}" type="text" name="etalon_rule_time_to[]" id="rule_time_to_{id}" value="" style="width:50px;"/></td>
								</tr>
								</table>
							</div>

							<input type="text" class="rule-{id}" name="etalon_rule_datepattern[]" id="rule_datepattern_{id}" value="" style="width:200px;display:none" placeholder="Маска даты"/>
						</td>
						<td class="acl-field">
							<select name="etalon_acl_type[]" onchange="show_rule_field('{id}', this.value)">
								<option value="0">- Выберите тип -</option>
								<? foreach($vars['acl_types'] as $k => $v) { ?>
								<option value="<?=$k?>"><?=$v?></option>
								<? } ?>
							</select>
						</td>
						<td class="acl-field">
							<select name="etalon_perm_acl[]" onchange="change_perm_bg('{id}', this.value)">
								<option value="0">- Режим доступа -</option>
								<? foreach($vars['perms_acl'] as $k => $v) { ?>
								<option value="<?=$k?>"><?=$v?></option>
								<? } ?>
							</select>
						</td>
						<td class="acl-field">
							<input type="text" class="input-number-field" name="etalon_acl_ord[]"value="{id}" style="width:80px;text-align:center;" placeholder="Порядок"/>
						</td>
						<td class="acl-field">
							<img src="/resources/images/admin/visibled.png" title="Не обрабатывать правило" onclick="toggle_acl_visible({id}, this)"/>
							<input type="hidden" name="etalon_acl_visible[]" id="acl_visible_{id}" value="1"/>
						</td>
						<td class="acl-field">
							<img src="/resources/images/admin/delete.png" width="10px" title="Удалить правило" onclick="delete_acl('{id}')"/>
						</td>
					</tr>
				</tbody>
				</table>
				<a href="javascript:void(0)" class="link-plus" onclick="add_acl()" title="Добавить правило">
						Добавить&#160;правило
				</a>
				<table id="acls">
					<? if ($vars['form']['acls'] !== false) { ?>
						<? foreach($vars['form']['acls'] as $key => $acl) {
							$k = $key + 1;
						?>
							<tr id="acl_<?=$k?>"style="<? if ($acl['Permission'] == BannerMgr::PERM_ACL_ALLOW) { ?>background-color:#d6ffd5<? } elseif ($acl['Permission'] == BannerMgr::PERM_ACL_DENY) { ?>background-color:#ffcfca<? } ?>">
								<td class="acl-field">
									<?
										$acl_url = $acl['Type'] == BannerMgr::T_ACL_URL;
										$acl_date = $acl['Type'] == BannerMgr::T_ACL_DATE;
										$acl_date_mask = $acl['Type'] == BannerMgr::T_ACL_DATE_MASK;

										if ($acl_date)
										{
											list($from, $to) = explode(";", $acl['Rule']);
											list($fdate, $ftime) = explode(",", $from);
											list($tdate, $ttime) = explode(",", $to);
										}

									?>
									<input type="text" class="rule-<?=$k?>" name="rule_url[]" id="rule_url_<?=$k?>" value="<? if ($acl_url) { ?><?=$acl['Rule']?><? } ?>" style="width:200px;<? if (!$acl_url) { ?>display:none;<? } ?>" placeholder="Правило"/>

									<div class="rule-<?=$k?>" id="rule_datetime_<?=$k?>"<? if (!$acl_date) { ?> style="display:none;"<? } ?>>
										<table>
										<tr>
											<td>Показывать&nbsp;с</td>
											<td><input class="datepicker-<?=$k?>" type="text" name="rule_date_from[]" id="rule_date_from_<?=$k?>" value="<? if ($acl_date) { echo $fdate; } ?>" style="width:100px;"/>&nbsp;<input class="timepicker-<?=$k?>" type="text" name="rule_time_from[]" id="rule_time_from_<?=$k?>" value="<? if ($acl_date) { echo $ftime; } ?>" style="width:50px;"/></td>
										</tr>
										<tr>
											<td>Показывать&nbsp;до</td>
											<td><input class="datepicker-<?=$k?>" type="text" name="rule_date_to[]" id="rule_date_to_<?=$k?>" value="<? if ($acl_date) { echo $tdate; } ?>" style="width:100px;"/>&nbsp;<input class="timepicker-<?=$k?>" type="text" name="rule_time_to[]" id="rule_time_to_<?=$k?>" value="<? if ($acl_date) { echo $ttime; } ?>" style="width:50px;"/></td>
										</tr>
										</table>
									</div>

									<input type="text" class="rule-<?=$k?>" name="rule_datepattern[]" id="rule_datepattern_<?=$k?>" value="<? if ($acl_date_mask) { ?><?=$acl['Rule']?><? } ?>" style="width:200px;<? if (!$acl_date_mask) { ?>display:none;<? } ?>" placeholder="Маска даты"/>
								</td>
								<td class="acl-field">
									<select name="acl_type[]" onchange="show_rule_field('<?=$k?>', this.value)">
										<option value="0">- Выберите тип -</option>
										<? foreach($vars['acl_types'] as $kk => $v) { ?>
										<option value="<?=$kk?>"<? if ($kk == $acl['Type']) { ?> selected="selected"<? } ?>><?=$v?></option>
										<? } ?>
									</select>
								</td>
								<td class="acl-field">
									<select name="perm_acl[]" onchange="change_perm_bg('<?=$k?>', this.value)">
										<option value="0">- Режим доступа -</option>
										<? foreach($vars['perms_acl'] as $kk => $v) { ?>
										<option value="<?=$kk?>"<? if ($kk == $acl['Permission']) { ?> selected="selected"<? } ?>><?=$v?></option>
										<? } ?>
									</select>
								</td>
								<td class="acl-field">
									<input type="text" class="input-number-field" name="acl_ord[]" value="<?=$acl['Ord']?>" style="width:80px;text-align:center;" placeholder="Порядок"/>
								</td>
								<td class="acl-field">
									<? if ($acl['IsActive'] == 1) { ?>
									<img src="/resources/images/admin/visibled.png" title="Не обрабатывать правило" onclick="toggle_acl_visible(<?=$k?>, this)"/>
									<input type="hidden" name="acl_visible[]" id="acl_visible_<?=$k?>" value="1"/>
									<? } else { ?>
									<img src="/resources/images/admin/hided.png" title="Обрабатывать правило" onclick="toggle_acl_visible(<?=$k?>, this)"/>
									<input type="hidden" name="acl_visible[]" id="acl_visible_<?=$k?>" value="0"/>
									<? } ?>
								</td>
								<td class="acl-field">
									<img src="/resources/images/admin/delete.png" width="10px" title="Удалить правило" onclick="delete_acl('<?=$k?>')"/>
								</td>
							</tr>

						<? } ?>
					<? } ?>
				</table>
			</td>
		</tr>

		<tr>
			<td class="header-column">Ширина</td>
			<td class="data-column">
				<input type="text" class="input-number-field" name="Width" value="<?=UString::ChangeQuotes($vars['form']['Width'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Высота</td>
			<td class="data-column">
				<input type="text" class="input-number-field" name="Height" value="<?=UString::ChangeQuotes($vars['form']['Height'])?>"><br/>
			</td>
		</tr>
		<?/*
		<tr>
			<td class="header-column important">
				Вес баннера<br/>
				<small>Время показа баннера будет расчитываться по формуле:<br/>Вес * Временной_интервал_места</small>
			</td>
			<td class="data-column">
				<input type="text" class="input-number-field" name="Weight" value="<?=UString::ChangeQuotes($vars['form']['Weight'])?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">Файл</td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('File')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>

				<? if (!empty($vars['form']['File']['f'])) { ?>
					<?=BannerMgr::GetHTML($vars['form']['PlaceID'], $vars['form']['BannerID'])?>
					<input type="checkbox" name="del_file" value="1"/> удалить<br/>
				<? } elseif ($vars['action'] == 'edit_banner' && ($vars['form']['Type'] == BannerMgr::T_TEXT || $vars['form']['Type'] == BannerMgr::T_JAVASCRIPT)) { ?>
				<?=BannerMgr::GetHTML($vars['form']['PlaceID'], $vars['form']['BannerID'])?>
				<? } ?>
				<input type="file" name="File" value="" />
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<br/>
				<input type="submit" value="Сохранить">
			</td>
		</tr>
	</table>
</form>
<br/><br/>
*/?>
<? } ?>