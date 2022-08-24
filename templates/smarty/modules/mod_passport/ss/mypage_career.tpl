<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_place" />
<input type="hidden" name="type" value="{php}echo PlaceSimpleMgr::PT_GENERAL;{/php}" />
<div class="title">Карьера</div>
<p>Укажите ваше место работы и найдите своих коллег!</p>
<br/>
<div class="txt_color1"><b>Укажите своё место работы:</b></div>

<table border="0" cellspacing="0" cellpadding="0">
<tr><td>

{foreach from=$page.form.work_place_arr item=l key=k}

{*

	with_suggest - Использовать контекстный список
	country_arr - Список стран
	region_arr - Список регоинов
	city_arr - Список городов
	work_years_arr - Список рабочих лет
	placeinfo - Информация о месте
*}

{php}

	$this->_tpl_vars['res'] = array(
		'with_suggest'	=> true,
		'country_arr'		=> &$this->_tpl_vars['page']['form']['country_arr'],
		'region_arr'		=> isset($this->_tpl_vars['page']['form']['region_arr'][$this->_tpl_vars['l']['country']]) ? $this->_tpl_vars['page']['form']['region_arr'][$this->_tpl_vars['l']['country']] : array(),
		'city_arr'		=> isset($this->_tpl_vars['page']['form']['city_arr'][$this->_tpl_vars['l']['region']]) ? $this->_tpl_vars['page']['form']['city_arr'][$this->_tpl_vars['l']['region']] : array(),
		'years_arr'		=> &$this->_tpl_vars['page']['form']['work_years_arr'],
		'placeinfo'		=> &$this->_tpl_vars['l'],
		'position'		=> $this->_tpl_vars['k'],
	);

{/php}

	{include file=$TEMPLATE.ssections.place[$l.type] res = $res}
		
{/foreach}

</td></tr>

<tr><td align="right">

		<a href="javascript:void(0)" 
			onclick="mod_passport.getPlaceFormNew({php}echo PlaceSimpleMgr::PT_GENERAL;{/php}, this)" class="text11">Добавить еще одно место работы</a>

</td></tr>

<tr><td colspan="2" align="center">
	<br/>
	<br/>
	<input type="submit" value="Сохранить изменения" />
</td></tr>
</table>
</form>
<br/>
<br/>