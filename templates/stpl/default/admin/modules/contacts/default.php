<script src="http://maps.api.2gis.ru/2.0/loader.js?pkg=full" data-id="dgLoader"></script>

<script>

	var api = null;
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

	//  ====================================

	function addField(fieldname)
	{
		var list = $('#'+fieldname+'-list');
		var html = $('#'+fieldname+'-etalon').html();

		html = html.replace(/etalon\-/g, "");
		list.append(html);
	}

	function removeField(obj)
	{
		$(obj).closest('tr').remove();
	}

</script>


<form method="post" enctype="multipart/form-data">

	<input type="hidden" name="action" value="<?=$vars['action']?>" />
	<input type="hidden" name="section_id" value="<?=$vars['section_id']?>" />
	<table class="form">
		<tr>
			<td class="header-column">E-mail</td>
			<td class="data-column">
				<div id="email-etalon" style="display:none">
					<table>
					<tr>
						<td>
							<input type="text" name="etalon-Emails[]" placeholder="E-mail" value="" size="100"/>
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить e-mail">Удалить</a>
						</td>
					</tr>
					</table>
				</div>
				<a href="javascript:void(0)" class="link-plus" onclick="addField('email')" title="Добавить e-mail">
					Добавить&#160;e-mail
				</a>
				<br/>
				<br/>
				<div id="email-list">
				<?
				if (is_array($vars['config']['email']) && count($vars['config']['email']) > 0) { ?>
					<table>
					<? foreach($vars['config']['email'] as $k => $mail) { ?>
					<tr>
						<td>
							<input type="text" name="Emails[]" placeholder="Email" value="<?=UString::ChangeQuotes($mail)?>" size="100"/>
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить e-mail">Удалить</a>
						</td>
					</tr>
					<? } ?>
					</table>
				<? } ?>
				</div>
			</td>
		</tr>
		<!-- ======================================= -->
		<tr>
			<td class="header-column">Телефон</td>
			<td class="data-column">
				<div id="email-etalon" style="display:none">
					<table>
					<tr>
						<td>
							<input type="text" name="etalon-Phones[]" placeholder="E-mail" value="" size="100"/>
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить телефон">Удалить</a>
						</td>
					</tr>
					</table>
				</div>
				<a href="javascript:void(0)" class="link-plus" onclick="addField('phone')" title="Добавить телефон">
					Добавить&#160;телефон
				</a>
				<br/>
				<br/>
				<div id="phone-list">
				<?
				if (is_array($vars['config']['phone']) && count($vars['config']['phone']) > 0) { ?>
					<table>
					<? foreach($vars['config']['phone'] as $k => $phone) { ?>
					<tr>
						<td>
							<input type="text" name="Phones[]" placeholder="Email" value="<?=UString::ChangeQuotes($phone)?>" size="100"/>
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить телефон">Удалить</a>
						</td>
					</tr>
					<? } ?>
					</table>
				<? } ?>
				</div>
			</td>
		</tr>
		<!-- ======================================= -->
		<?/*
		<tr>
			<td class="header-column">Адрес</td>
			<td class="data-column">
				<div id="address-etalon" style="display:none">
					<table>
					<tr>
						<td>
							<input type="text" name="etalon-Address[]" placeholder="Адрес" value="" size="100"/>
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить телефон">Удалить</a>
						</td>
					</tr>
					</table>
				</div>
				<a href="javascript:void(0)" class="link-plus" onclick="addField('address')" title="Добавить">
					Добавить&#160;адрес
				</a>
				<br/>
				<br/>
				<div id="address-list">
				<?
				if (is_array($vars['config']['address']) && count($vars['config']['address']) > 0) { ?>
					<table>
					<? foreach($vars['config']['address'] as $k => $address) { ?>
					<tr>
						<td>
							<input type="text" name="Address[]" placeholder="Адрес" value="<?=UString::ChangeQuotes($address)?>" size="100"/>
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить">Удалить</a>
						</td>
					</tr>
					<? } ?>
					</table>
				<? } ?>
				</div>
			</td>
		</tr>
		*/?>
		<!-- ======================================= -->
		<tr>
			<td class="header-column">Время работы</td>
			<td class="data-column">
				<div id="workmode-etalon" style="display:none">
					<table>
					<tr>
						<td>
							<input type="text" name="etalon-Workmode[]" placeholder="Время работы" value="" size="100"/>
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить">Удалить</a>
						</td>
					</tr>
					</table>
				</div>
				<a href="javascript:void(0)" class="link-plus" onclick="addField('workmode')" title="Добавить">
					Добавить&#160;время работы
				</a>
				<br/>
				<br/>
				<div id="workmode-list">
				<?
				if (is_array($vars['config']['workmode']) && count($vars['config']['workmode']) > 0) { ?>
					<table>
					<? foreach($vars['config']['workmode'] as $k => $workmode) { ?>
					<tr>
						<td>
							<input type="text" name="Workmode[]" placeholder="Время работы" value="<?=UString::ChangeQuotes($workmode)?>" size="100"/>
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить">Удалить</a>
						</td>
					</tr>
					<? } ?>
					</table>
				<? } ?>
				</div>
			</td>
		</tr>

		<!-- ======================================= -->
		<tr>
			<td class="header-column">Адрес</td>
			<td class="data-column">

				<div id="address-etalon" style="display:none">
					<table>
					<tr>
						<td>
							<input type="text" name="etalon-Address[]" placeholder="Адрес" value="" size="100"/><br/>
							<input type="text" name="etalon-Lon[]" placeholder="lon" class="lon" value="<?=UString::ChangeQuotes($item['map']['lon'])?>" size="20"/><br/>
							<input type="text" name="etalon-Lat[]" placeholder="lat" class="lat" value="<?=UString::ChangeQuotes($item['map']['lat'])?>" size="20"/>
							<input type="button" onclick="get_coords(this)" value="Получить координаты">
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить телефон">Удалить</a>
						</td>
					</tr>
					</table>
				</div>
				<a href="javascript:void(0)" class="link-plus" onclick="addField('address')" title="Добавить">
					Добавить&#160;адрес
				</a>
				<br/>
				<br/>
				<div id="address-list">
				<?
				if (is_array($vars['config']['address']) && count($vars['config']['address']) > 0) { ?>
					<table>
					<? foreach($vars['config']['address'] as $k => $item) { ?>
					<tr>
						<td>
							<input type="text" name="Address[]" placeholder="Адрес" class="address" value="<?=UString::ChangeQuotes($item['entry'])?>" size="100"/><br/>
							Координаты<br/>
							<input type="text" name="Lon[]" placeholder="lon" class="lon" value="<?=UString::ChangeQuotes($item['map']['lon'])?>" size="20"/><br/>
							<input type="text" name="Lat[]" placeholder="lat" class="lat" value="<?=UString::ChangeQuotes($item['map']['lat'])?>" size="20"/>
							<input type="button" onclick="get_coords(this)" value="Получить координаты">
						</td>
						<td>
							<a class="link-minus" onclick="removeField(this)" href="javascript:;" title="Удалить">Удалить</a>
						</td>
					</tr>
					<? } ?>
					</table>
				<? } ?>
				</div>
			</td>
		</tr>
		<!-- ======================================= -->

		<tr>
			<td class="header-column">Карта</td>
			<td class="data-column">
				<div class="contact-map" id="contact-map"></div>
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
<style>
	.contact-map {
	 	width: 550px;
	 	height: 300px;
	}
</style>
<?=App::$City->Name?>

<script>
	ymaps.ready(init);
	var myMap;
	var myPlacemark;

	function get_coords(obj)
	{
		var el = $(obj);
		var oLon = el.siblings('.lon');
		var oLat = el.siblings('.lat');
		var oAddress = el.siblings('.address');

		var address = oAddress.val();

		if(address.length == 0)
			address = "<?=App::$City->Name?>";

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

            oLon.val(coords[0]);
			oLat.val(coords[1]);
        });
	}

	function init(){
    	myMap = new ymaps.Map("contact-map", {
            center: [55.160283, 61.400856],
            zoom: 13
        });

        myPlacemark = new ymaps.Placemark([55.160283, 61.400856], {
        	iconContent: "Челябинск",
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
			// $("#store-longitude").val(coords[0]);
			// $("#store-latitude").val(coords[1]);

		});

		<? if($vars['form']['Longitude'] == 0 || $vars['form']["Latitude"] == 0) { ?>
			// searchByAddress();
		<? } ?>
        // ============================
	}
</script>