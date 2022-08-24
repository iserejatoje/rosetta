

<div class="title" >Образование</div>
<p>Укажите ваше место учебы и найдите своих одноклассников и одногруппников!</p>
<br>
<div class="title">Высшее образование</div>
<br/>
<div class="txt_color1"><b>Укажите свое учебное заведение:</b></div>
<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_place" />
<input type="hidden" name="type" value="{php}echo PlaceSimpleMgr::PT_HIGHER_EDUCATION;{/php}" />
<table border="0" cellspacing="0" cellpadding="0">
<tr><td>
{php} foreach($this->_tpl_vars['page']['form']['education_place_arr'][constant('PlaceSimpleMgr::PT_HIGHER_EDUCATION')] as $this->_tpl_vars['k'] => $this->_tpl_vars['l']) { {/php}

{*

	with_suggest - Использовать контекстный список
	country_arr - Список стран
	region_arr - Список регоинов
	city_arr - Список городов
	grad_years_arr - Список года выпуска
	placeinfo - Информация о месте

*}

{php}

	$this->_tpl_vars['res'] = array(
		'with_suggest'		=> true,
		'country_arr'		=> &$this->_tpl_vars['page']['form']['country_arr'],
		'region_arr'		=> isset($this->_tpl_vars['page']['form']['region_arr'][$this->_tpl_vars['l']['country']]) ? $this->_tpl_vars['page']['form']['region_arr'][$this->_tpl_vars['l']['country']] : array(),
		'city_arr'			=> isset($this->_tpl_vars['page']['form']['city_arr'][$this->_tpl_vars['l']['region']]) ? $this->_tpl_vars['page']['form']['city_arr'][$this->_tpl_vars['l']['region']] : array(),
		'years_arr'		=> &$this->_tpl_vars['page']['form']['years_arr'],
		'grad_years_arr'	=> &$this->_tpl_vars['page']['form']['grad_years_arr'],
		'status_arr'		=> &$this->_tpl_vars['page']['form']['status_arr'],
		'course_form_arr'	=> &$this->_tpl_vars['page']['form']['course_form_arr'],
		'placeinfo'			=> &$this->_tpl_vars['l'],
		'position'			=> $this->_tpl_vars['k'],
	);
{/php}

	{include file=$TEMPLATE.ssections.place[$l.type] res = $res}

{php} } {/php}

</td></tr>

<tr><td align="right">

		<a id="append_education_{php}echo PlaceSimpleMgr::PT_HIGHER_EDUCATION;{/php}" href="javascript:void(0)" 
			onclick="mod_passport.getPlaceFormNew({php}echo PlaceSimpleMgr::PT_HIGHER_EDUCATION;{/php}, this)" class="text11">Добавить еще один ВУЗ</a>

</td></tr>

</table>

<br/><br/><div><input type="submit" value="Сохранить изменения" style="width:210px;" /></div>

</form>
<br/>
<br/>
	<div class="title">Среднее образование</div>

	<br/>
	<div class="txt_color1"><b>Укажите школу:</b></div>

{*if is_array($page.form.education_place_top_arr[$page.PT_SECONDARY_EDUCATION]) && sizeof($page.form.education_place_top_arr[$page.PT_SECONDARY_EDUCATION])}
	<div style="padding-left: 40px"><span class="title title_normal">Популярное:</span>
		{foreach from=$page.form.education_place_top_arr[$page.PT_SECONDARY_EDUCATION] item=top name=top}
			<a href="javascript:void(0)" title="Добавить место" onclick="mod_passport.getPlaceForm('education',  {php}echo PlaceSimpleMgr::PT_SECONDARY_EDUCATION;{/php}, $('#append_education_{php}echo PlaceSimpleMgr::PT_SECONDARY_EDUCATION;{/php}'), {$top.PlaceID})">{$top.Name}</a>{if $top.UsersCount > 0} <sup class="tip"> <a href="/{$CURRENT_ENV.section}/users_static.php?id={$page.PT_SECONDARY_EDUCATION}&val={$top.PlaceID}" title="Список пользователей" class="text11" style="color: red">{$top.UsersCount|number_format:0:'':' '}</a> </sup>{/if
			}{if !$smarty.foreach.top.last},{/if}
		{/foreach}
	</div>
{/if*}
	
<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_place" />
<input type="hidden" name="type" value="{php}echo PlaceSimpleMgr::PT_SECONDARY_EDUCATION;{/php}" />
<table border="0" cellspacing="0" cellpadding="0">
<tr><td>
{php} foreach($this->_tpl_vars['page']['form']['education_place_arr'][constant('PlaceSimpleMgr::PT_SECONDARY_EDUCATION')] as $this->_tpl_vars['k'] => $this->_tpl_vars['l']) { {/php}
{*
	with_suggest - Использовать контекстный список
	country_arr - Список стран
	region_arr - Список регоинов
	city_arr - Список городов
	years_arr - Список года обучения
	class_arr - Список классов
	placeinfo - Информация о месте
*}

{php}

	$this->_tpl_vars['res'] = array(
		'with_suggest'	=> true,
		'country_arr'		=> $this->_tpl_vars['page']['form']['country_arr'],
		'region_arr'		=> isset($this->_tpl_vars['page']['form']['region_arr'][$this->_tpl_vars['l']['country']]) ? $this->_tpl_vars['page']['form']['region_arr'][$this->_tpl_vars['l']['country']] : array(),
		'city_arr'		=> isset($this->_tpl_vars['page']['form']['city_arr'][$this->_tpl_vars['l']['region']]) ? $this->_tpl_vars['page']['form']['city_arr'][$this->_tpl_vars['l']['region']] : array(),
		'years_arr'		=> &$this->_tpl_vars['page']['form']['years_arr'],
		'grad_years_arr'	=> &$this->_tpl_vars['page']['form']['grad_years_arr'],
		'class_arr'		=> &$this->_tpl_vars['page']['form']['class_arr'],
		'placeinfo'		=> &$this->_tpl_vars['l'],
		'position'		=> $this->_tpl_vars['k'],
	);

{/php}

	{include file=$TEMPLATE.ssections.place[$l.type] res = $res}
	
{php} } {/php}

<tr><td align="right">

		<a id="append_education_{php}echo PlaceSimpleMgr::PT_SECONDARY_EDUCATION;{/php}" href="javascript:void(0)" 
			onclick="mod_passport.getPlaceFormNew({php}echo PlaceSimpleMgr::PT_SECONDARY_EDUCATION;{/php}, this)" class="text11">Добавить еще одну школу</a>

</td></tr>
</table>


<br/><br/><div><input type="submit" value="Сохранить изменения" style="width:210px;" /></div>
</form>

<br/>
{if is_array($page.form.education_place_top_arr[3]) && sizeof($page.form.education_place_top_arr[3])}
	<div><span class="title title_normal">Популярное:</span><br>
		{foreach from=$page.form.education_place_top_arr[3] item=top name=top}
			<a class="t11_grey" style="color:#666666;" href="javascript:void(0)" title="Добавить место"
onclick="mod_passport.getPlaceFormNew({$top.TypeID}, $('#append_education_{$top.TypeID}'), {$top.PlaceID});">{$top.Name}</a>{if $top.UsersCount > 0} <sup class="tip"> <a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_place.string}?id={$top.TypeID}&val={$top.PlaceID}" title="Список пользователей" class="text11" style="color: red">{$top.UsersCount|number_format:0:'':' '}</a> </sup>{/if
			}{if !$smarty.foreach.top.last},{/if}
		{/foreach}
	</div>
{/if}

<br/>
<br/>