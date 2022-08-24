<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="3" bcolor="#e0f3f3"></td>
		<td id="menu_td1" class="menu_top_p_2" onmouseout="menu_top2_out_p('1');" onmouseover="menu_top2_over_p('1');"><a href="/{$ENV.section}/"><span>Главная</span></a></td>
		<td id="menu_td2" class="menu_top_p_2" onmouseout="menu_top2_out_p('2');" onmouseover="menu_top2_over_p('2');"><a href="/{$ENV.section}/vacancy/search.php"><span>Искать вакансию</span></a></td>
{if $ENV.section!="job_centre"}		
		<td id="menu_td3" class="menu_top_p_2" onmouseout="menu_top2_out_p('3');" onmouseover="menu_top2_over_p('3');"><a href="/{$ENV.section}/resume/search.php"><span>Искать резюме</span></a></td>
{/if}
		<td id="menu_td4" class="menu_top_p_2" onmouseout="menu_top2_out_p('4');" onmouseover="menu_top2_over_p('4');"><a href="/{$ENV.section}/my/vacancy/add.php"><span>Добавить вакансию</span></a></td>
{if $ENV.section!="job_centre"}		
		<td id="menu_td5" class="menu_top_p_2" onmouseout="menu_top2_out_p('5');" onmouseover="menu_top2_over_p('5');"><a href="/{$ENV.section}/my/resume/add.php"><span>Добавить резюме</span></a></td>
{/if}
		<td valign="bottom">
			<div id="block0_big" class="menu2_p_s" onmouseout="this.style.visibility='hidden';menu_top2_out_p('0');" onmouseover="this.style.visibility='visible';menu_top2_over_p('0');">
				<div><a href="/{$ENV.section}/rules.html" style="color: red">Правила размещения</a></div>
				{if $CURRENT_ENV.regid==74}<div><a href="/career/">Строим карьеру</a></div>{/if}
				<div><a href="/{$ENV.section}/promotion.html">Способы продвижения</a></div>
				<div><a href="/{$ENV.section}/howto.html">Как писать резюме?</a></div>
				<div><a href="/{$ENV.section}/articles.html">Аналитика</a></div>
				<div><a href="/forum/view.php?id={$CONFIG.forum_id}">Обсуждение</a></div>
			</div>
		</td>
		<td id="menu_td0" class="menu_top_p_2" onmouseout="document.getElementById('block0_big').style.visibility='hidden';menu_top2_out_p('0');" onmouseover="document.getElementById('block0_big').style.visibility='visible';menu_top2_over_p('0');"><a href="/{$ENV.section}/rules.html"><span>Пользователям</span></a></td>

	</tr>
</table>


{if 1==2}
<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="3" bcolor="#e0f3f3"></td>
		<td valign="bottom">
		  <div id="block0_big" class="menu2_p_s" onmouseout="this.style.visibility='hidden';menu_top2_out_p('0');" onmouseover="this.style.visibility='visible';menu_top2_over_p('0');">
			{if $USER->IsAuth()}
			<div><a href="/{$ENV.section}/my/firm.php">Профиль работодателя</a></div>
			{/if}
{*
			<div><a href="/{$ENV.section}/my/vacancy/add.php">Разместить вакансию</a></div>
*}
			<div><a href="/{$ENV.section}/resume/search.php" style="color: red">Искать резюме</a></div>
			<div><a href="/{$ENV.section}/my/subscribe.php">Подписка на резюме</a></div>
			<div><a href="/{$ENV.section}/">Резюме по рубрикам</a></div>
			<div><a href="/{$ENV.section}/rules.html">Правила размещения</a></div>
			{if $res.questions}<div><a href="/{$ENV.section}/my/question/1.php">Ответить на вопросы</a></div>{/if}
			<div style="padding-bottom:10px"><a href="/{$ENV.section}/articles.html">Аналитика</a></div>
		  </div>
		</td>
		<td id="menu_td0" class="menu_top_p_2" onmouseout="document.getElementById('block0_big').style.visibility='hidden';menu_top2_out_p('0');" onmouseover="document.getElementById('block0_big').style.visibility='visible';menu_top2_over_p('0');"><a href="/{$ENV.section}/resume/search.php"><span>Работодателю</span></a></td>
		<td valign="bottom">
		  <div id="block1_big" class="menu2_p_s" onmouseout="document.getElementById('block1_big').style.visibility='hidden';menu_top2_out_p('1');" onmouseover="document.getElementById('block1_big').style.visibility='visible';menu_top2_over_p('1');">
{*
			<div><a href="/{$ENV.section}/my/resume/add.php">Разместить резюме</a></div>
*}
			<div><a href="/{$ENV.section}/vacancy/search.php" style="color: red">Искать вакансию</a></div>
			<div><a href="/{$ENV.section}/my/subscribe.php">Подписка на вакансии</a></div>
			<div><a href="/{$ENV.section}/">Вакансии по рубрикам</a></div>
			<div><a href="/{$ENV.section}/howto.html">Как писать резюме?</a></div>
			<div><a href="/{$ENV.section}/rules.html">Правила размещения</a></div>
			<div style="padding-bottom:10px"><a href="/{$ENV.section}/articles.html">Аналитика</a></div>
		  </div>
		</td>
		<td id="menu_td1" class="menu_top_p_2" onmouseout="document.getElementById('block1_big').style.visibility='hidden';menu_top2_out_p('1');" onmouseover="document.getElementById('block1_big').style.visibility='visible';menu_top2_over_p('1');"><a href="/{$ENV.section}/vacancy/search.php"><span>Соискателю</span></a></td>
{*
		<td valign="bottom">
		  <div id="block2_big" class="menu2_p_s" onmouseout="document.getElementById('block2_big').style.visibility='hidden';menu_top2_out_p('2');" onmouseover="document.getElementById('block2_big').style.visibility='visible';menu_top2_over_p('2');">
			<div><a href="/{$ENV.section}/newsline">С места в карьеру (Строим карьеру)</a></div>

			{if $CURRENT_ENV.regid == 74}<div><a href="http://www.ukon.su/" target="_blank">Консультации</a></div>
			<div><a href="http://www.chel.ru/rating/1.html" target="_blank">Рейтинг зарплат</a></div>
			{/if}
			<div style="padding-bottom:10px"><a href="/{$ENV.section}/articles.html">Статьи</a></div>
		  </div>
		</td>
		<td id="menu_td2" class="menu_top_p_2" onmouseout="document.getElementById('block2_big').style.visibility='hidden';menu_top2_out_p('2');" onmouseover="document.getElementById('block2_big').style.visibility='visible';menu_top2_over_p('2');"><a href="/{$ENV.section}/articles.html"><span>Аналитика</span></a></td>
		<td id="menu_td2" class="menu_top_p_2" onmouseout="menu_top2_out_p('2');" onmouseover="menu_top2_over_p('2');"><a href="/{$ENV.section}/articles.html"><span>Аналитика</span></a></td>
*}
{*
		<td valign="bottom">
		  <div id="block3_big" class="menu2_p_s" onmouseout="document.getElementById('block3_big').style.visibility='hidden';menu_top2_out_p('3');" onmouseover="document.getElementById('block3_big').style.visibility='visible';menu_top2_over_p('3');">
			<div style="padding-bottom:10px"><a href="/forum/view.html?id={$CONFIG.forum_id}" target="_blank">Форум о работе</a></div>
			<div><a href="/{$ENV.section}/">Юмор</a></div>
			<div><a href="/{$ENV.section}/">Опрос</a></div>

		  </div>
		</td>
		<td id="menu_td3" class="menu_top_p_2" onmouseout="document.getElementById('block3_big').style.visibility='hidden';menu_top2_out_p('3');" onmouseover="document.getElementById('block3_big').style.visibility='visible';menu_top2_over_p('3');"><a href="/forum/view.html?id={$CONFIG.forum_id}" target="_blank"><span>Обсуждаем</span></a></td>
*}
		<td id="menu_td3" class="menu_top_p_2" onmouseout="menu_top2_out_p('3');" onmouseover="menu_top2_over_p('3');"><a href="/{$ENV.section}/my/vacancy/add.php"><span>Добавить вакансию</span></a></td>
		<td id="menu_td4" class="menu_top_p_2" onmouseout="menu_top2_out_p('4');" onmouseover="menu_top2_over_p('4');"><a href="/{$ENV.section}/my/resume/add.php"><span>Добавить резюме</span></a></td>
		{if $USER->IsAuth()}
		<td id="menu_td5" class="menu_top_p_2" onmouseout="menu_top2_out_p('5');" onmouseover="menu_top2_over_p('5');"><a href="/{$ENV.section}/my/vacancy.php"><span>Мои вакансии{if $res.vac_count > 0} ({$res.vac_count|number_format:"0":",":" "}){/if}</span></a></td>
		<td id="menu_td6" class="menu_top_p_2" onmouseout="menu_top2_out_p('6');" onmouseover="menu_top2_over_p('6');"><a href="/{$ENV.section}/my/resume.php"><span>Мои резюме{if $res.res_count > 0} ({$res.res_count|number_format:"0":",":" "}){/if}</span></a></td>
		{/if}
	</tr>
</table>
{/if}

{if 1==2}
<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="3" bcolor="#e0f3f3"></td>
		<td valign="bottom">
		  <div id="block0_big" class="menu2_p_s" onmouseout="this.style.visibility='hidden';menu_top2_out_p('0');" onmouseover="this.style.visibility='visible';menu_top2_over_p('0');">
			{if $res.isAuth}
			<div><a href="/{$ENV.section}/my/vacancy.php">Мои вакансии</a></div>
			<div><a href="/{$ENV.section}/my/firm.php">Профиль работодателя</a></div>
			{/if}
			<div><a href="/{$ENV.section}/my/vacancy/add.php">Разместить вакансию</a></div>
			<div><a href="/{$ENV.section}/resume/search.php">Искать резюме</a></div>
			<div><a href="/{$ENV.section}/my/subscribe.php">Подписка на резюме</a></div>
			<div><a href="/{$ENV.section}/">Резюме по рубрикам</a></div>
			<div style="padding-bottom:10px"><a href="/{$ENV.section}/rules.html">Правила размещения</a></div>
		  </div>
		</td>
		<td id="menu_td0" class="menu_top_p_2" onmouseout="document.getElementById('block0_big').style.visibility='hidden';menu_top2_out_p('0');" onmouseover="document.getElementById('block0_big').style.visibility='visible';menu_top2_over_p('0');"><a href="/{$ENV.section}/resume/search.php"><span>Работодателям</span></a></td>
		<td valign="bottom">
		  <div id="block1_big" class="menu2_p_s" onmouseout="document.getElementById('block1_big').style.visibility='hidden';menu_top2_out_p('1');" onmouseover="document.getElementById('block1_big').style.visibility='visible';menu_top2_over_p('1');">
			{if $res.isAuth}
			<div><a href="/{$ENV.section}/my/resume.php">Мои резюме</a></div>
			{/if}
			<div><a href="/{$ENV.section}/my/resume/add.php">Разместить резюме</a></div>
			<div><a href="/{$ENV.section}/vacancy/search.php">Искать вакансию</a></div>
			<div><a href="/{$ENV.section}/my/subscribe.php">Подписка на вакансии</a></div>
			<div><a href="/{$ENV.section}/">Вакансии по рубрикам</a></div>
			<div><a href="/{$ENV.section}/howto.html">Как писать резюме?</a></div>
			<div style="padding-bottom:10px"><a href="/{$ENV.section}/rules.html">Правила размещения</a></div>
		  </div>
		</td>
		<td id="menu_td1" class="menu_top_p_2" onmouseout="document.getElementById('block1_big').style.visibility='hidden';menu_top2_out_p('1');" onmouseover="document.getElementById('block1_big').style.visibility='visible';menu_top2_over_p('1');"><a href="/{$ENV.section}/vacancy/search.php"><span>Соискателям</span></a></td>
{*
		<td valign="bottom">
		  <div id="block2_big" class="menu2_p_s" onmouseout="document.getElementById('block2_big').style.visibility='hidden';menu_top2_out_p('2');" onmouseover="document.getElementById('block2_big').style.visibility='visible';menu_top2_over_p('2');">
			<div><a href="/{$ENV.section}/newsline">С места в карьеру (Строим карьеру)</a></div>

			{if $CURRENT_ENV.regid == 74}<div><a href="http://www.ukon.su/" target="_blank">Консультации</a></div>
			<div><a href="http://www.chel.ru/rating/1.html" target="_blank">Рейтинг зарплат</a></div>
			{/if}
			<div style="padding-bottom:10px"><a href="/{$ENV.section}/articles.html">Статьи</a></div>
		  </div>
		</td>
		<td id="menu_td2" class="menu_top_p_2" onmouseout="document.getElementById('block2_big').style.visibility='hidden';menu_top2_out_p('2');" onmouseover="document.getElementById('block2_big').style.visibility='visible';menu_top2_over_p('2');"><a href="/{$ENV.section}/articles.html"><span>Аналитика</span></a></td>
*}
		<td id="menu_td2" class="menu_top_p_2" onmouseout="menu_top2_out_p('2');" onmouseover="menu_top2_over_p('2');"><a href="/{$ENV.section}/articles.html"><span>Аналитика</span></a></td>
{*
		<td valign="bottom">
		  <div id="block3_big" class="menu2_p_s" onmouseout="document.getElementById('block3_big').style.visibility='hidden';menu_top2_out_p('3');" onmouseover="document.getElementById('block3_big').style.visibility='visible';menu_top2_over_p('3');">
			<div style="padding-bottom:10px"><a href="/forum/view.html?id={$CONFIG.forum_id}" target="_blank">Форум о работе</a></div>
			<div><a href="/{$ENV.section}/">Юмор</a></div>
			<div><a href="/{$ENV.section}/">Опрос</a></div>

		  </div>
		</td>
		<td id="menu_td3" class="menu_top_p_2" onmouseout="document.getElementById('block3_big').style.visibility='hidden';menu_top2_out_p('3');" onmouseover="document.getElementById('block3_big').style.visibility='visible';menu_top2_over_p('3');"><a href="/forum/view.html?id={$CONFIG.forum_id}" target="_blank"><span>Обсуждаем</span></a></td>
*}
	</tr>
</table>

{/if}