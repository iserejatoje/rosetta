<form style="margin:0px" method="POST">
<input type="hidden" name="action" value="mypage_place" />
<input type="hidden" name="type" value="{php}echo PlaceSimpleMgr::PT_OTHER;{/php}" />
<div class="title">Места</div>
<p>Укажите ваши любимые места и найдите единомышленников!</p>
<br/>
<div class="txt_color1"><b>Укажите своё любимое место:</b></div>

<table border="0" cellspacing="0" cellpadding="0">
<tr><td>
{foreach from=$page.form.others_place_arr item=l key=k}

{*

	with_suggest - Использовать контекстный список
	country_arr - Список стран
	region_arr - Список регоинов
	city_arr - Список городов
	placeinfo - Информация о месте
*}

{php}

	$this->_tpl_vars['res'] = array(
		'with_suggest'	=> true,
		'country_arr'		=> &$this->_tpl_vars['page']['form']['country_arr'],
		'region_arr'		=> isset($this->_tpl_vars['page']['form']['region_arr'][$this->_tpl_vars['l']['country']]) ? $this->_tpl_vars['page']['form']['region_arr'][$this->_tpl_vars['l']['country']] : array(),
		'city_arr'		=> isset($this->_tpl_vars['page']['form']['city_arr'][$this->_tpl_vars['l']['region']]) ? $this->_tpl_vars['page']['form']['city_arr'][$this->_tpl_vars['l']['region']] : array(),
		'placeinfo'		=> &$this->_tpl_vars['l'],
		'position'		=> $this->_tpl_vars['k'],
	);

{/php}

	{include file=$TEMPLATE.ssections.place[$l.type] res = $res}
		
{/foreach}

<tr><td align="right">

		<a id="append_education_{php}echo PlaceSimpleMgr::PT_OTHER;{/php}" href="javascript:void(0)" 
			onclick="mod_passport.getPlaceFormNew({php}echo PlaceSimpleMgr::PT_OTHER;{/php}, this)" class="text11">Добавить еще одно место</a>

</td></tr>
<tr><td colspan="2" align="center">
	<br/>
	<br/>
	<input type="submit" value="Сохранить изменения" />
</td></tr>
</table>
</form>

<br/>
{if is_array($page.form.others_place_top_arr) && sizeof($page.form.others_place_top_arr)}
	<div><span class="title title_normal">Популярное:</span><br>
		{foreach from=$page.form.others_place_top_arr item=top name=top}
			<a href="javascript:void(0)" class="t11_grey" style="color:#666666;" title="Добавить место"
onclick="mod_passport.getPlaceFormNew({php}echo PlaceSimpleMgr::PT_OTHER;{/php}, $('#append_education_{php}echo PlaceSimpleMgr::PT_OTHER;{/php}'), {$top.PlaceID});">{$top.Name}</a>{if $top.UsersCount > 0} <sup class="tip"> <a href="/{$CURRENT_ENV.section}/{$CONFIG.files.get.users_place.string}?id={php}echo PlaceSimpleMgr::PT_OTHER;{/php}&val={$top.PlaceID}" title="Список пользователей" class="text11" style="color: red">{$top.UsersCount|number_format:0:'':' '}</a> </sup>{/if
			}{if !$smarty.foreach.top.last},{/if}
		{/foreach}
	</div><br/>
{/if}

<br/>
<br/>