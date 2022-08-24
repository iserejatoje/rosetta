<div class = "content_margings">

	<form method="POST" >
		<input type="hidden" name="action" value="mypage_person" />
		{if $UERROR->GetErrorByIndex('lastname') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('lastname')}</span>
		{/if}
		<div class = "for_long_input">
			<input type = "text" name = "lastname"  placeholder ="Фамилия" class = "long_input" value="{$page.form.lastname}"/>
		</div>
		{if $UERROR->GetErrorByIndex('firstname') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('firstname')}</span>
		{/if}
		<div class = "for_long_input">
			<input type = "text" name = "firstname"  placeholder ="Имя" class = "long_input"  value="{$page.form.firstname}"/>
		</div>
		{if $UERROR->GetErrorByIndex('midname') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('midname')}</span>
		{/if}
		<div class = "for_long_input">
			<input type = "text" name = "midname"  placeholder ="Отчество" class = "long_input" value="{$page.form.midname}"/>
		</div>
		<div class = "form_text" >
			День рождения:
		</div>
		{if $UERROR->GetErrorByIndex('birthday') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('birthday')}</span>
		{/if}
		<table table width="100%" cellspacing="0" cellpadding="0" class="full_table">
			<tr>
				<td class = "for_one_third_input">
					<div class = "for_short_input" >
						<select name="birthday_day" class = "one_third_input">
							<option value="" disabled selected>День</option>
							{foreach from=$page.form.days_arr item=l}
								<option value="{$l}"{if $page.form.birthday_day==$l} selected="selected"{/if}>{$l}</option>
							{/foreach}
						</select>
					</div>
				</td>
				<td class = "inputs_distance">
				</td>
				<td class = "for_one_third_input">
					<div class = "for_short_input" >
						<select name="birthday_month" class = "one_third_input">
							<option value="" disabled selected>Месяц</option>
							{foreach from=$page.form.months_arr item=l key=k}
								<option value="{$k}"{if $page.form.birthday_month==$k} selected="selected"{/if}>{$l}</option>
							{/foreach}
						</select>
					</div>
				</td>
				<td class = "inputs_distance">
				</td>
				<td class = "for_one_third_input">
					<div class = "for_short_input" >
						<select name="birthday_year" class = "one_third_input">
							<option value="" disabled selected>Год</option>
							{foreach from=$page.form.years_arr item=l}
								<option value="{$l}"{if $page.form.birthday_year==$l} selected="selected"{/if}>{$l}</option>
							{/foreach}
						</select>
					</div>
				</td>
			</tr>
		</table>
		<div class = "form_text" style = "padding-bottom: 0px;">
			Пол:
		</div>
		{if $UERROR->GetErrorByIndex('gender') != ''}
		    <span class="error">{$UERROR->GetErrorByIndex('gender')}</span>
		{/if}
		<table table width="100%" cellspacing="0" cellpadding="0" class="full_table">
			<tr>
				<td class = "for_one_third_input">
					<input type = "radio" name = "gender" value = "1" {if $page.form.gender==1} checked{/if} class = "radio_input"/><span >Мужской</span>
				</td>
				<td class = "inputs_distance">
				</td>
				<td>
					<input type = "radio" name = "gender" value = "2" {if $page.form.gender==2} checked{/if} class = "radio_input" /><span>Женский</span>
				</td>
			</tr>
		</table>
		<div style = "height: 8px;"></div>
		{if $UERROR->GetErrorByIndex('street') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('street')}</span>
		{/if}
		<div class = "for_long_input">
			<input type = "text" name = "street"  placeholder ="Улица *" value="{$page.form.street}" class = "long_input" />
		</div>
		{if $UERROR->GetErrorByIndex('house') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('house')}</span><br/>
		{/if}
		{if $UERROR->GetErrorByIndex('apartment') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('apartment')}</span><br/>
		{/if}
		{if $UERROR->GetErrorByIndex('floor') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('floor')}</span>
		{/if}
		<table table width="100%" cellspacing="0" cellpadding="0" class="full_table">
			<tbody>
				<tr>
					<td class="for_one_third_input">
						<div class="for_short_input">
							<input type="text" name="house" placeholder="№ дома *" class="one_third_input" value="{$page.form.house}">
						</div>
					</td>
					<td class="inputs_distance">
					</td>
					<td class="for_one_third_input">
						<div class="for_short_input">
							<input type="text" name="apartment" placeholder="Квартира *" class="one_third_input" value="{$page.form.apartment}">
						</div>
					</td>
					<td class="inputs_distance">
					</td>
					<td class="for_one_third_input">
						<div class="for_short_input">
							<input type="text" name="floor" placeholder="Этаж *" class="one_third_input" value="{$page.form.floor}">
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		{if $UERROR->GetErrorByIndex('phone') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('phone')}</span>
		{/if}
		<div class = "for_long_input">
			<input type = "text" name = "phone"  placeholder ="Телефон *" class = "long_input" value="{$page.form.phone}" />
		</div>
		{if $UERROR->GetErrorByIndex('persons') != ''}
			<span class="error">{$UERROR->GetErrorByIndex('persons')}</span>
		{/if}
		<div class = "for_long_input">
			<input type = "text" name = "persons"  placeholder ="Количество персон" class = "long_input" value="{$page.form.persons}" />
		</div>
		
		<div class = "center" style = "margin-top: 15px;">
			<input type = "submit" class="orange_button login " value = "Сохранить">
		</div>
	</form>
</div>