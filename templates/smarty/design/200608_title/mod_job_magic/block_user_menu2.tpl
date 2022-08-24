{if $USER->IsAuth()}
	<table style="margin-bottom: 1px;" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr align="right">
			<td class="block_title"><span>Моя работа</span></td>
		</tr>
	</table>
	<table cellpadding="4" cellspacing="0" width="100%">
		<tr{if $res.page == 'my_vacancy'} class="bg_color2"{/if}>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/{$ENV.section}/my/vacancy.php">Мои вакансии</a></b>
			</td>
		</tr>
		<tr{if $res.page == 'my_resume'} class="bg_color2"{/if}>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/{$ENV.section}/my/resume.php">Мои резюме</a></b>
			</td>
		</tr>
		<tr>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/passport/im/messages.php"{if $res.messages_count > 0} style="color:red"{/if}>Мои сообщения{if $res.messages_count > 0} ({$res.messages_count}){/if}</a></b>
			</td>
		</tr>
		<tr{if $res.page == 'favorite_vacancy'} class="bg_color2"{/if}>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/{$ENV.section}/favorite/vacancy.php">Избранные вакансии</a></b>
			</td>
		</tr>
		<tr{if $res.page == 'favorite_resume'} class="bg_color2"{/if}>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/{$ENV.section}/favorite/resume.php">Избранные резюме</a></b>
			</td>
		</tr>
		{if $res.is_employer}
		<tr{if $res.page == 'my_firm'} class="bg_color2"{/if}>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/{$ENV.section}/my/firm.php">Профиль работодателя</a></b>
			</td>
		</tr>
		{/if}
		<tr{if $res.page == 'my_subscribe'} class="bg_color2"{/if}>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/{$ENV.section}/my/subscribe.php">Подписка</a></b>
			</td>
		</tr>
		<tr{if $res.page == 'rules'} class="bg_color2"{/if}>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/{$ENV.section}/rules.html"><font color='red'>Правила размещения</font></a></b>
			</td>
		</tr>
		{if $res.questions}
		<tr{if $res.page == 'my_list_question'} class="bg_color2"{/if}>
			<td class="text11" style="padding-right: 19px;" align="right">
				<b><a href="/{$ENV.section}/my/question/1.php">Ответить на вопросы</a></b>
			</td>
		</tr>
		{/if}
	</table>
{/if}