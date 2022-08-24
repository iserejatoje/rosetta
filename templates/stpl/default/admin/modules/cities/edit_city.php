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

<!--  -->
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
	    	<h3 class="panel-title">Город</h3>
	  	</div>


	  <div class="panel-body">
			<form role="form" class="form-horizontal" name="new_object_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="<?=$vars['action']?>" />
				<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
				<input type="hidden" name="id" value="<?=$vars['form']['CityID']?>" />	

			  	<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		      			<div class="checkbox">
		        			<label>
		        				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?> >
		        				город отображается на сайте
		        			</label>
		      			</div>
		    		</div>
		  		</div>

		  		<div class="form-group">
		    		<div class="col-sm-offset-2 col-sm-10">
		      			<div class="checkbox">
		        			<label>
		        				<input type="checkbox" name="IsDefault" value="1"<? if ($vars['form']['IsDefault'] == 1) { ?> checked="checked"<? } ?> >
		        				город по-умолчанию
		        			</label>
		      			</div>
		    		</div>
		  		</div>

				<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('Name')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="city-name" class="col-sm-2 control-label">Название</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="city-name" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>">

						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

			  	<?
		    	$err_txt = '';
		    	if (($err = UserError::GetErrorByIndex('NameID')) != '' ) {
		    		$cls = " has-error";
		    		$err_txt = $err;
		    	} ?>
		  		<div class="form-group">
			    	<label for="city-nameid" class="col-sm-2 control-label">ID домена</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="city-nameid" name="NameID" value="<?=UString::ChangeQuotes($vars['form']['NameID'])?>">

						<? if($err_txt) { ?>
			  				<span class="help-block text-danger"><?=$err_txt?></span>
			  			<? } ?>
			  		</div>
			  	</div>

		  		<div class="form-group">
			    	<label for="city-domain" class="col-sm-2 control-label">Домен (Eng)</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="city-domain" name="Domain" value="<?=UString::ChangeQuotes($vars['form']['Domain'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="city-catalogid" class="col-sm-2 control-label">Идентификатор каталога</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="city-catalogid" name="CatalogId" value="<?=UString::ChangeQuotes($vars['form']['CatalogId'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="city-street" class="col-sm-2 control-label">Улица</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="city-street" name="Street" value="<?=UString::ChangeQuotes($vars['form']['Street'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="city-phonecode" class="col-sm-2 control-label">Код телефона</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
	  						<input type="text" class="form-control" id="city-phonecode" name="PhoneCode" value="<?=UString::ChangeQuotes($vars['form']['PhoneCode'])?>">
						</div>
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="city-phone" class="col-sm-2 control-label">Телефон</label>
			    	<div class="col-sm-10">
				    	<div class="input-group">
	  						<span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
	  						<input type="text" class="form-control" id="city-phone" name="Phone" value="<?=UString::ChangeQuotes($vars['form']['Phone'])?>">
						</div>
			  		</div>
			  	</div>

				<div class="form-group">
			    	<label for="city-latitude" class="col-sm-2 control-label">Широта</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="city-latitude" name="Latitude" value="<?=UString::ChangeQuotes($vars['form']['Latitude'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="city-longitude" class="col-sm-2 control-label">Долгота</label>
			    	<div class="col-sm-10">
  						<input type="text" class="form-control" id="city-longitude" name="Longitude" value="<?=UString::ChangeQuotes($vars['form']['Longitude'])?>">
			  		</div>
			  	</div>

			  	<div class="form-group">
					<div class="col-sm-2"></div>
					<div class="col-sm-10">
		  				<button type="button" class="btn btn-info btn-sm" onclick="searchByAddress()"><span class="glyphicon glyphicon-search"></span> Найти по адресу</button>
			  			<div id="map" style="width: 600px; height: 400px"></div>
					</div>
			  	</div>

			  	<div class="form-group">
			    	<label for="city-seotext" class="col-sm-2 control-label">SEO текст</label>
			    	<div class="col-sm-10">
			    		<textarea class="form-control" rows="5" id="city-seotext" name="SEOText"><?=UString::ChangeQuotes($vars['form']['SEOText'])?></textarea>
			  		</div>
			  	</div>

		  		<div class="form-group">
			    	<label for="city-metrika" class="col-sm-2 control-label">Метрика</label>
			    	<div class="col-sm-10">
			    		<textarea class="form-control" rows="5" id="city-metrika" name="Metrika"><?=UString::ChangeQuotes($vars['form']['Metrika'])?></textarea>
			  		</div>
			  	</div>


		  		<script type="text/javascript">
		  			ymaps.ready(init);
					var myMap;
					var myPlacemark;

					function searchByAddress()
					{
						var address = "<?=$vars['form']['Name']?>".length > 0 ? "<?=$vars['form']['Name']?>" : $("#city-name").val;
						var street = $("#city-street").val();

						if(street.length > 0)
							address += " " + street;

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

				            $("#city-longitude").val(coords[0]);
							$("#city-latitude").val(coords[1]);
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
<!--  -->

<?/*
<form name="new_object_form" method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />	
	<input type="hidden" name="id" value="<?=$vars['form']['CityID']?>" />	

	<table class="form">
		<tr>
			<td class="header-column">город отображается на сайте</td>
			<td class="data-column">
				<input type="checkbox" name="IsVisible" value="1"<? if ($vars['form']['IsVisible'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr>
			<td class="header-column">город по-умолчанию</td>
			<td class="data-column">
				<input type="checkbox" name="IsDefault" value="1"<? if ($vars['form']['IsDefault'] == 1) { ?> checked="checked"<? } ?>>
			</td>
		</tr>

		<tr>
			<td class="header-column">Название <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('Name')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>				
				<input type="text" class="input-text-field" name="Name" value="<?=UString::ChangeQuotes($vars['form']['Name'])?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">ID домена <span class="required">*</span></td>
			<td class="data-column">
				<? if (($err = UserError::GetErrorByIndex('NameID')) != '' ) { ?>
				<span class="error"><?=$err?></span><br/>
				<? } ?>				
				<input type="text" class="input-text-field" name="NameID" value="<?=UString::ChangeQuotes($vars['form']['NameID'])?>"><br/>
			</td>
		</tr>

		<tr>
			<td class="header-column">Домен (Eng)</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="Domain" value="<?=UString::ChangeQuotes($vars['form']['Domain'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Идентификатор каталога</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="CatalogId" value="<?=UString::ChangeQuotes($vars['form']['CatalogId'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Улица</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="Street" value="<?=UString::ChangeQuotes($vars['form']['Street'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Телефонный код</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="PhoneCode" value="<?=UString::ChangeQuotes($vars['form']['PhoneCode'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Телефон</td>
			<td class="data-column">
				<input type="text" class="input-text-field" name="Phone" value="<?=UString::ChangeQuotes($vars['form']['Phone'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Широта</td>
			<td class="data-column">
				<input type="text" id="lat" class="input-text-field coords" name="Latitude" value="<?=UString::ChangeQuotes($vars['form']['Latitude'])?>"><br/>
			</td>
		</tr>
		<tr>
			<td class="header-column">Долгота</td>
			<td class="data-column">
				<input type="text" id="lon" class="input-text-field coords" name="Longitude" value="<?=UString::ChangeQuotes($vars['form']['Longitude'])?>"><br/>
			</td>
		</tr>
		<tr>
		<tr>
			<td class="header-column">карта</td>
			<td class="data-column">
				<div id="map" style="width: 300px; height: 300px;">

				</div>
			</td>
		</tr>
	<tr><td class="separator" colspan="2"><div></div></td></tr>
		<tr>
			<td class="header-column">SEO текст</td>
			<td class="data-column">
				<textarea name="SEOText" class="input_100"><?=UString::ChangeQuotes(stripslashes($vars['form']['SEOText']))?></textarea>
			</td>
		</tr>
		<tr>
			<td class="header-column">Метрика</td>
			<td class="data-column">
				<textarea name="Metrika"><?=UString::ChangeQuotes(stripslashes($vars['form']['Metrika']))?></textarea>
			</td>
		</tr>
	<tr><td class="separator" colspan="2"><div></div></td></tr>
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
