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
</style>

<div class="col-sm-10">
	<?
	if($vars['action'] == 'new_store')
		$act = "Новый магазин";
	elseif($vars['action'] == 'edit_store')
		$act = "Редактирование магазина";
	?>

	<ol class="breadcrumb">
		<? foreach($vars['crumbs'] as $crumb) { ?>
	  		<li><a href="<?=$crumb['url']?>"><?=$crumb['name']?></a></li>
	  	<? } ?>
	  <li class="active"><?=$act?></li>
	</ol>

	<div class="panel panel-info ">
		<div class="panel-heading">
	    	<h3 class="panel-title">Магазин</h3>
	  	</div>


	  <div class="panel-body">
			<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="<?=$vars['action']?>" />
				<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
				<input type="hidden" name="id" value="<?=$vars['form']['StoreID']?>" />
				<input type="hidden" name="cityid" value="<?=$vars['form']['CityID']?>" />

			  	<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		      			<div class="checkbox">
		        			<label>
		        				<input type="checkbox" name="IsAvailable" value="1"<? if ($vars['form']['IsAvailable'] == 1) { ?> checked="checked"<? } ?> >
		        				Магазин активен
		        			</label>
		      			</div>
		    		</div>
		  		</div>

		  		<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		      			<div class="checkbox">
		        			<label>
		        				<input type="checkbox" name="HasPickup" value="1"<? if ($vars['form']['HasPickup'] == 1) { ?> checked="checked"<? } ?> >
		        				Возможен самовывоз
		        			</label>
		      			</div>
		    		</div>
		  		</div>

                <div class="form-group">
                    <label for="store-name" class="col-sm-2 control-label">Тип</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <select name="Type" class="form-control" autocomplete="off">
                                <option>- тип -</option>
                                <? foreach(CitiesMgr::$TYPES as $k => $type) { ?>
                                    <option value="<?=$k?>" <?if($vars['form']['Type']==$k){?> selected="selected"<?}?>><?=$type['name']?></option>
                                <? } ?>
                            </select>
                        </div>
                        <? if($err_txt) { ?>
                            <span class="help-block text-danger"><?=$err_txt?></span>
                        <? } ?>
                    </div>
                </div>

		  		<div class="form-group">
			    	<label for="store-name" class="col-sm-2 control-label">Магазин</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon"><span class="glyphicon glyphicon-shopping-cart"></span></span>
	  						<input type="text" class="form-control" id="store-name" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">
						</div>
						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

				<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Email')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
			  	<div class="form-group<?=$cls?>">
			    	<label for="store-email" class="col-sm-2 control-label">Email</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
	  						<input type="text" class="form-control" id="store-email" name="Email" value="<?=UString::ChangeQuotes($vars['form']['Email'])?>">
						</div>
						<? if($err_txt) { ?>
			  				<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
			  			<? } ?>
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="store-phonecode" class="col-sm-2 control-label">Код телефона</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
	  						<input type="text" class="form-control" id="store-phonecode" name="PhoneCode" value="<?=UString::ChangeQuotes($vars['form']['PhoneCode'])?>">
						</div>
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="store-phone" class="col-sm-2 control-label">Телефон</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
	  						<input type="text" class="form-control" id="store-phone" name="Phone" value="<?=UString::ChangeQuotes($vars['form']['Phone'])?>">
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
			    	<label for="store-address" class="col-sm-2 control-label">Адрес</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
	  						<input type="text" class="form-control" id="store-address" name="Address" value="<?=UString::ChangeQuotes($vars['form']['Address'])?>">
						</div>
						<? if($err_txt) { ?>
			  				<div class="alert alert-danger" role="alert"><?=$err_txt?></div>
			  			<? } ?>
			  		</div>
			  	</div>

                <? /*
			  	<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('PMAccount')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="pm-name" class="col-sm-2 control-label">Аккаунт ПС</label>
			    	<div class="col-sm-10">
			    		<select name="AccountID" class="form-control">
			    			<option value="0">- аккаунт платежной системы -</option>
			    		<? foreach($vars['pm_accounts'] as $account) { ?>
			    			<option value="<?=$account->ID?>" <? if($account->ID == $vars['form']['AccountID']) { ?>selected="selected"<? } ?>><?=$account->Name?> (<?=$account->type->Name?>)</option>
			    		<? } ?>
			    		</select>
						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>
                */?>

			  	<div class="form-group">
			    	<label for="store-longitude" class="col-sm-2 control-label">Время работы</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" name="Workmode" value="<?=UString::ChangeQuotes($vars['form']['Workmode'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="store-longitude" class="col-sm-2 control-label">Долгота</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="store-longitude" name="Longitude" value="<?=UString::ChangeQuotes($vars['form']['Longitude'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="store-latitude" class="col-sm-2 control-label">Широта</label>
			    	<div class="col-sm-10">
	  						<input type="text" class="form-control" id="store-latitude" name="Latitude" value="<?=UString::ChangeQuotes($vars['form']['Latitude'])?>">
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
						var address = "<?=$vars['city']->Name?>";
						var street = $("#store-address").val();

						if(street.length > 0)
							address += " " + street;

						if(address.length == 0)
							return false;

					   	ymaps.geocode(address, {
					        /**
					         * Опции запроса
					         * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
					         */
					        // boundedBy: myMap.getBounds(), // Сортировка результатов от центра окна карты
					        // strictBounds: true, // Вместе с опцией boundedBy будет искать строго внутри области, указанной в boundedBy
					        results: 1 // Если нужен только один результат, экономим трафик пользователей
					    }).then(function (res) {
				            // Выбираем первый результат геокодирования.
				            var firstGeoObject = res.geoObjects.get(0),
				                // Координаты геообъекта.
				                coords = firstGeoObject.geometry.getCoordinates(),
				                // Область видимости геообъекта.
				                bounds = firstGeoObject.properties.get('boundedBy');

				            myMap.setCenter(coords, 13);
				            myMap.geoObjects.add(new ymaps.Placemark(coords, {}));

				            $("#store-longitude").val(coords[0]);
							$("#store-latitude").val(coords[1]);
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
							$("#store-longitude").val(coords[0]);
							$("#store-latitude").val(coords[1]);

						});

						<? if($vars['form']['Longitude'] == 0 || $vars['form']["Latitude"] == 0) { ?>
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


<? } ?>
