<? if (($err = UserError::GetErrorByIndex('global')) != '' ) { ?>
	<table class="form">
		<tr>
			<td class="header-column">Ай-ай, ошибка</td>
			<td class="data-column">
				<span class="error"><?=$err?></span><br/>
			</td>
		</tr>
	</table>
<? } else {
	session_start();
?>

<style>
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	h1 { font-size: 1.2em; margin: .6em 0; }

	.acl-field {
		padding-top: 4px;
		padding-bottom: 4px;
		border-bottom: dotted 1px #898989;
	}
	.search {
		border:1px solid #DDD;
		border-radius: 3px;
		padding: 4px 7px;
		display:inline-block;
		cursor:pointer;

		transition: background .3s;
	}
	.search:hover {
		background: #EEE;
	}
</style>

<script>
	function addField(id)
	{
		var list = $('#'+id+'-list');
		var html = $('#'+id+'-etalon').html();

		html = html.replace(/etalon\-/g, "");
		list.append(html);
	}

	function removeField(obj)
	{
		$(obj).closest('.field-group').remove();
	}

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

	});

</script>

<ol class="breadcrumb">
	<li><a href="?section_id=<?=$vars['section_id']?>&action=cities">Города</a></li>
</ol>

<!--  -->
<? $message = $_SESSION['user_message']['message'] ?>
<? if (!empty($message)) { ?>
	<div class="alert alert-success" role="alert">
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
	<strong>Успешно!</strong> <?= $message ?></div>
	<? unset($_SESSION['user_message']); ?>
<? } ?>
<div class="col-sm-10">
	<?
	if($vars['action'] == 'new_city')
		$act = "Новый город";
	elseif($vars['action'] == 'edit_edit')
		$act = "Редактирование города";
	?>

	<div class="panel panel-info ">
		<div class="panel-heading">
	    	<h3 class="panel-title">Город</h3>
	  	</div>


	  <div class="panel-body">
			<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="<?=$vars['action']?>" />
				<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
				<input type="hidden" name="cityid" value="<?=$vars['city']->ID?>" />
				<input type="hidden" name="id" value="<?=$vars['form']['AddressID']?>">

				<div class="form-group">
			    	<label for="city-address" class="col-sm-2 control-label">Город</label>
			    	<div class="col-sm-10">
			    		<input type="text" class="form-control" value="<?=$vars['city']->Name?>" readonly="readonly">
			  		</div>
			  	</div>

			  	<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		      			<div class="checkbox">
		        			<label>
		        				<input type="checkbox" name="IsAvailable" value="1"<? if ($vars['form']['IsAvailable'] == 1) { ?> checked="checked"<? } ?> >
		        				Адрес доступен для отображения
		        			</label>
		      			</div>
		    		</div>
		  		</div>

				<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Address')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="city-address" class="col-sm-2 control-label">Адрес</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="city-address" name="Address" value="<?=UString::ChangeQuotes($vars['form']['Address'])?>">

						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

			  	<!-- ============================================================== -->

			  	<div id="phone-etalon" style="display:none">
				  	<div class="form-group form-group-sm field-group">
		    			<div class="col-sm-5">
		    				<input type="text" class="form-control" name="etalon-Phone[]">
		    			</div>
		    			<div class="col-sm-2">
		    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить</button>
		    			</div>
		    		</div>
		    	</div>

			  	<div class="form-group">
			    	<div class="col-sm-2 control-label"><strong>Телефоны</strong></div>
			    	<div class="col-sm-10">
			    		<button type="button" class="btn btn-info btn-xs" onclick="addField('phone')"><span class="glyphicon glyphicon-plus"></span> Добавить телефон</button>
			    		<div id="phone-list" style="margin: 10px 0 0 0">
			    		<? foreach($vars['form']['Phone'] as $phone) { ?>
				    		<div class="form-group form-group-sm field-group">
				    			<div class="col-sm-5">
				    				<input type="text" class="form-control" name="Phone[]" value="<?=$phone?>">
				    			</div>
				    			<div class="col-sm-2">
				    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить телефон</button>
				    			</div>
				    		</div>
			    		<? } ?>
			    		</div>
			  		</div>
			  	</div>

			  	<!-- ============================================================== -->

				<div id="skype-etalon" style="display:none">
				  	<div class="form-group form-group-sm field-group">
		    			<div class="col-sm-5">
		    				<input type="text" class="form-control" name="etalon-Skype[]">
		    			</div>
		    			<div class="col-sm-2">
		    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить</button>
		    			</div>
		    		</div>
		    	</div>

			  	<div class="form-group">
			    	<div class="col-sm-2 control-label"><strong>Skype</strong></div>
			    	<div class="col-sm-10">
			    		<button type="button" class="btn btn-info btn-xs" onclick="addField('skype')"><span class="glyphicon glyphicon-plus"></span> Добавить Skype</button>
			    		<div id="skype-list" style="margin: 10px 0 0 0">
			    		<? foreach($vars['form']['Skype'] as $skype) { ?>
				    		<div class="form-group form-group-sm field-group">
				    			<div class="col-sm-5">
				    				<input type="text" class="form-control" name="Skype[]" value="<?=$skype?>">
				    			</div>
				    			<div class="col-sm-2">
				    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить телефон</button>
				    			</div>
				    		</div>
			    		<? } ?>
			    		</div>
			  		</div>
			  	</div>

			  	<!-- ============================================================== -->

				<div id="icq-etalon" style="display:none">
				  	<div class="form-group form-group-sm field-group">
		    			<div class="col-sm-5">
		    				<input type="text" class="form-control" name="etalon-ICQ[]">
		    			</div>
		    			<div class="col-sm-2">
		    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить</button>
		    			</div>
		    		</div>
		    	</div>

			  	<div class="form-group">
			    	<div class="col-sm-2 control-label"><strong>ICQ</strong></div>
			    	<div class="col-sm-10">
			    		<button type="button" class="btn btn-info btn-xs" onclick="addField('icq')"><span class="glyphicon glyphicon-plus"></span> Добавить ICQ</button>
			    		<div id="icq-list" style="margin: 10px 0 0 0">
			    		<? foreach($vars['form']['ICQ'] as $icq) { ?>
				    		<div class="form-group form-group-sm field-group">
				    			<div class="col-sm-5">
				    				<input type="text" class="form-control" name="ICQ[]" value="<?=$icq?>">
				    			</div>
				    			<div class="col-sm-2">
				    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить</button>
				    			</div>
				    		</div>
			    		<? } ?>
			    		</div>
			  		</div>
			  	</div>

			  	<!-- ============================================================== -->

			  	<div id="email-etalon" style="display:none">
				  	<div class="form-group form-group-sm field-group">
		    			<div class="col-sm-5">
		    				<input type="text" class="form-control" name="etalon-Email[]">
		    			</div>
		    			<div class="col-sm-2">
		    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить</button>
		    			</div>
		    		</div>
		    	</div>

			  	<div class="form-group">
			    	<div class="col-sm-2 control-label"><strong>Email</strong></div>
			    	<div class="col-sm-10">
			    		<button type="button" class="btn btn-info btn-xs" onclick="addField('email')"><span class="glyphicon glyphicon-plus"></span> Добавить Email</button>
			    		<div id="email-list" style="margin: 10px 0 0 0">
			    		<? foreach($vars['form']['Email'] as $email) { ?>
				    		<div class="form-group form-group-sm field-group">
				    			<div class="col-sm-5">
				    				<input type="text" class="form-control" name="Email[]" value="<?=$email?>">
				    			</div>
				    			<div class="col-sm-2">
				    				<button type="button" class="btn btn-info btn-sm" onclick="removeField(this)"><span class="glyphicon glyphicon-minus"></span> Удалить</button>
				    			</div>
				    		</div>
			    		<? } ?>
			    		</div>
			  		</div>
			  	</div>

			  	<!-- ============================================================== -->


				<div class="form-group">
			    	<label for="city-latitude" class="col-sm-2 control-label">Широта</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="map-latitude" name="Latitude" value="<?=UString::ChangeQuotes($vars['form']['Latitude'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="city-longitude" class="col-sm-2 control-label">Долгота</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="map-longitude" name="Longitude" value="<?=UString::ChangeQuotes($vars['form']['Longitude'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
					<div class="col-sm-2"></div>
					<div class="col-sm-10">
		  				<button type="button" class="btn btn-info btn-sm" onclick="searchByAddress()"><span class="glyphicon glyphicon-search"></span> Найти по адресу</button>
			  			<div id="map" style="width: 600px; height: 400px"></div>
					</div>
			  	</div>

		  		<script type="text/javascript">
		  			ymaps.ready(init);
					var myMap;
					var myPlacemark;

					function searchByAddress()
					{
						var city = "<?=$vars['city']->Name?>".length > 0 ? "<?=$vars['city']->Name?>" : '';
						var street = $("#city-address").val();
						var address = '';

						if(street.length > 0)
							address = city + " " + street;
						else
							address = city;

						if(address.length == 0)
							return false;

					   	ymaps.geocode(address, {
					        results: 1 // Если нужен только один результат, экономим трафик пользователей
					    }).then(function (res) {
				            // Выбираем первый результат геокодирования.
				            var firstGeoObject = res.geoObjects.get(0),
				                coords = firstGeoObject.geometry.getCoordinates(),
				                bounds = firstGeoObject.properties.get('boundedBy');

				            myMap.setCenter(coords, 13);
				            myMap.geoObjects.add(new ymaps.Placemark(coords, {}));

				            $("#map-longitude").val(coords[0]);
							$("#map-latitude").val(coords[1]);
				        });
					}

					function init(){
				    	myMap = new ymaps.Map("map", {
				            center: [<?=$vars['form']['Longitude']?>, <?=$vars['form']['Latitude']?>],
				            zoom: 13
				        });

				        myPlacemark = new ymaps.Placemark([<?=$vars['form']['Longitude']?>, <?=$vars['form']['Latitude']?>], {
				        	iconContent: "<?=$vars['form']['Address']?>",
				        	// balloonContent: "<?=$vars['form']['Address']?>"
				       	},
				       	{
				       		preset: "islands#blueStretchyIcon"
				       	});
				        myMap.geoObjects.add(myPlacemark);

				        // ============================
				        myMap.events.add('click', function (e) {
							// Получение координат щелчка
							var coords = e.get('coords');

							// console.log($("#store-longitude"), $("#store-latitude"));

							myMap.geoObjects.add(new ymaps.Placemark(coords, {}));
							$("#map-longitude").val(coords[0]);
							$("#map-latitude").val(coords[1]);

						});

						<? if(empty($vars['form']['Longitude']) || empty($vars['form']["Latitude"])) { ?>

							searchByAddress();
						<? } ?>
				        // ============================
					}
				</script>

		  		<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		  				<button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-save"></span> Сохранить</button>
		    		</div>
		  		</div>

			</form>
		</div>
	</div>
</div>
<!--  -->


<? } ?>
