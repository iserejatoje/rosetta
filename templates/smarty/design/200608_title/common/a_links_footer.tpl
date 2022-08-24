{if in_array($CURRENT_ENV.regid,array(16,59,61,93))}
	<div id="links-for-footer">
	<table class="table_menu"><tr><td align="center">
		<div class="menu_block"><div class="menu">
		<ul>
		{if $CURRENT_ENV.regid == 93}
			<li><a href="/job/">работа в Краснодаре</a></li>
			<li><a href="/realty/">недвижимость в Краснодаре</a></li>
			<li><a href="/afisha/">афиша Краснодара</a></li>
			<li><a href="/firms/s_292/">гостиницы Краснодара</a></li>
			<li><a href="/car/">автосалоны Краснодара</a></li>
			<li><a href="/weather/Krasnodar/">погода в Краснодаре</a></li>
			<li><a href="/map/">карта Краснодара</a></li>
			<li><a href="/exchange/exchange.html">банки Краснодара</a></li>
		{elseif $CURRENT_ENV.regid == 59}
			<li><a href="http://59.ru/weather/Perm/">погода в Перми</a></li>
			<li><a href="http://59.ru/job/">работа в Перми</a></li>
			<li><a href="http://avto59.ru/" target="_blank">автомобили в Перми</a></li>
			<li><a href="http://afisha59.ru/" target="_blank">афиша Перми</a></li>
			<li><a href="http://59.ru/map/">карта Перми</a></li>
			<li><a href="http://dengi59.ru/" target="_blank">банки Перми</a></li>
			<li><a href="http://kvartira59.ru/" target="_blank">недвижимость в Перми</a></li>
			<li><a href="http://doctor59.ru/" target="_blank">медицина в Перми</a></li>
		{elseif $CURRENT_ENV.regid == 16}
			<li><a href="http://116.ru/job/">работа в Казани</a></li>
			<li><a href="http://116.ru/weather/">погода в Казани</a></li>
			<li><a href="http://116auto.ru/" target="_blank">автосалоны Казани</a></li>
			<li><a href="http://116vecherov.ru/" target="_blank">афиша Казани</a></li>
			<li><a href="http://116dengi.ru/" target="_blank">банки Казани</a></li>
			{if $CURRENT_ENV.section!='sitehome'}
			<li><a href="http://116metrov.ru/" target="_blank">недвижимость в Казани</a></li>
			{/if}
			<li><a href="http://116vecherov.ru/firms/turism/gost/" target="_blank">гостиницы Казани</a></li>
			{if $CURRENT_ENV.site.domain=="116.ru"}
				{if $CURRENT_ENV.section!='sitehome'}
				<li><a href="http://116.ru/map/">карта Казани</a></li>				
				{/if}
			{elseif $CURRENT_ENV.site.domain=="116auto.ru"}
				<li><a href="http://116auto.ru/car/" target="_blank">продажа автомобилей в Казани</a></li>
			{elseif $CURRENT_ENV.site.domain=="116dengi.ru"}
				<li><a href="http://116dengi.ru/firms/konsalt/" target="_blank">юридические услуги в Казани</a></li>
				<li><a href="http://116dengi.ru/firms/chel_445/" target="_blank">страховые компании Казани</a></li>
				<li><a href="http://116dengi.ru/firms/kollekt/" target="_blank">коллекторские фирмы в Казани</a></li>
				<li><a href="http://116dengi.ru/exchange/exchange.html" target="_blank">курсы валют в Казани</a></li>
			{elseif $CURRENT_ENV.site.domain=="116vecherov.ru"}
				<li><a href="http://116vecherov.ru/firms/turism/tour/" target="_blank">турфирмы Казани</a></li>
				<li><a href="http://116vecherov.ru/firms/wedding/" target="_blank">свадьба в Казани</a></li>
			{elseif $CURRENT_ENV.site.domain=="116metrov.ru"}
				<li><a href="http://116metrov.ru/realty/" target="_blank">квартиры в Казани</a></li>
				<li><a href="http://116metrov.ru/realty/" target="_blank">аренда квартир в Казани</a></li>
			{/if}
		{elseif $CURRENT_ENV.regid == 61}
			<li><a href="http://161.ru/job/">работа в Ростове</a></li>
			<li><a href="http://161.ru/weather/Rostov-na-Donu/">погода в Ростове</a></li>
			<li><a href="http://161vecher.ru/" target="_blank">афиша Ростова</a></li>
			<li><a href="http://161bank.ru/" target="_blank">банки Ростова</a></li>
			<li><a href="http://161metr.ru/" target="_blank">недвижимость Ростова</a></li>
			<li><a href="http://161auto.ru/" target="_blank">автомобили в Ростове</a></li>
		{/if}
		</ul>
		</div></div>
	</td></tr></table>
	</div>
	<div style="clear: both;"></div>
{/if}