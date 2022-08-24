<div class="container">
    <div class="personal-page" style="margin: 50px 0 150px;">
        <h2 class="title">Личная информация</h2>
        Пользователь: {php}echo App::$User->Email{/php}<br/><br/>

        {php}
            if(App::$User->IsInRole("e_adm_execute_section") ||
                App::$User->IsInRole("u_review_editor") ||
                App::$User->IsInRole("u_menu_editor") ||
                App::$User->IsInRole("u_banner_editor") ||
                App::$User->IsInRole("u_faq_editor") ||
                App::$User->IsInRole("u_client_editor") ||
                App::$User->IsInRole("u_city_editor") ||
                App::$User->IsInRole("u_payment_editor") ||
                App::$User->IsInRole("u_page_editor") ||
                App::$User->IsInRole("u_order_manager") ||
                App::$User->IsInRole("u_price_changer") ||
                App::$User->IsInRole("u_bouquet_editor") ||
                App::$User->IsInRole("u_discountcard_editor") ||
                App::$User->IsInRole("u_bouquet_type_editor")
            ) { {/php}
                <a href="/admin/">Административная панель</a>
                <br/><br/>
                <a href="/account/logout.php">Выход</a>
        {php} } {/php}
    </div>

    <form style="margin:0px" method="POST">
    <input type="hidden" name="action" value="mypage_person" />


{*
    <table class="padding4" width="550">
    {if $UERROR->GetErrorByIndex('lastname') != ''}
    	<tr>
    		<td>&nbsp;</td>
    		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('lastname')}</span></td>
    	</tr>
    {/if}
    	<tr>
    		<td align="right" class="bg_color2">Фамилия</td>
    		<td class="bg_color4" colspan="2"><input type="text" name="lastname" value="{$page.form.lastname}"{if in_array('LastName',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;" /></td>
    	</tr>
    {if $UERROR->GetErrorByIndex('firstname') != ''}
    	<tr>
    		<td>&nbsp;</td>
    		<td class="error"><span>{$UERROR->GetErrorByIndex('firstname')}</span>
    		</td>
    	</tr>
    {/if}
    	<tr>
    		<td align="right" class="bg_color2" width="150">Имя</td>
    		<td class="bg_color4" colspan="2">
    			<input id="firstname" type="text" name="firstname" value="{$page.form.firstname}"{if in_array('FirstName',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;" />
    		</td>
    	</tr>
    {if $UERROR->GetErrorByIndex('midname') != ''}
    	<tr>
    		<td>&nbsp;</td>
    		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('midname')}</span></td>
    	</tr>
    {/if}
    	<tr>
    		<td align="right" class="bg_color2">Отчество</td>
    		<td class="bg_color4" colspan="2"><input type="text" name="midname" value="{$page.form.midname}"{if in_array('MidName',$page.form.bad_fields)} class="profile_moderation_warning"{/if} style="width:100%;" /></td>
    	</tr>
    {if $UERROR->GetErrorByIndex('birthday') != ''}
    	<tr>
    		<td>&nbsp;</td>
    		<td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('birthday')}</span></td>
    	</tr>
    {/if}
    	<tr>
    		<td align="right" class="bg_color2">День рождения</td>
    		<td class="bg_color4" colspan="2">
    			День
    			<select name="birthday_day" width="">
    				<option value="0">----</option>
    {foreach from=$page.form.days_arr item=l}
    				<option value="{$l}"{if $page.form.birthday_day==$l} selected="selected"{/if}>{$l}</option>
    {/foreach}
    			</select>
    			Месяц
    			<select name="birthday_month" width="">
    				<option value="0">----</option>
    {foreach from=$page.form.months_arr item=l key=k}
    				<option value="{$k}"{if $page.form.birthday_month==$k} selected="selected"{/if}>{$l}</option>
    {/foreach}
    			</select>
    			Год
    			<select name="birthday_year" width="">
    				<option value="0">----</option>
    {foreach from=$page.form.years_arr item=l}
    				<option value="{$l}"{if $page.form.birthday_year==$l} selected="selected"{/if}>{$l}</option>
    {/foreach}
    			</select>
    		</td>
    	</tr>

    {if $UERROR->GetErrorByIndex('gender') != ''}
            <tr>
                    <td>&nbsp;</td>
                    <td class="error" colspan="2"><span>{$UERROR->GetErrorByIndex('gender')}</span></td>
            </tr>
    {/if}
    	<tr>
    		<td align="right" class="bg_color2">Пол</td>
    		<td class="bg_color4" colspan="2">
    			<input type="radio" name="gender" value="1" {if $page.form.gender==1} checked{/if} /> Мужской <br />
    			<input type="radio" name="gender" value="2" {if $page.form.gender==2} checked{/if}  /> Женский <br />
    		</td>
    	</tr>

    {if $UERROR->GetErrorByIndex('street') != ''}
    	<tr>
    		<td width="250px" align="right">&nbsp;</td>
    		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('street')}</span></td>
    	</tr>
    {/if}
    <tr valign="top" align="left">
    	<td align="right" width="250px">Улица <font color="red">*</font>:</td>
    	<td>
    		<input type="text" name="street" style="width:250px;" value="{$page.form.street}" /><br/>
    	 </td>
    </tr>
    {if $UERROR->GetErrorByIndex('house') != ''}
    	<tr>
    		<td width="250px" align="right">&nbsp;</td>
    		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('house')}</span></td>
    	</tr>
    {/if}
    <tr valign="top" align="left">
    	<td align="right" width="250px">Номер дома <font color="red">*</font>:</td>
    	<td>
    		<input type="text" name="house" style="width:250px;" value="{$page.form.house}" /><br/>
    	 </td>
    </tr>
    {if $UERROR->GetErrorByIndex('apartment') != ''}
    	<tr>
    		<td width="250px" align="right">&nbsp;</td>
    		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('apartment')}</span></td>
    	</tr>
    {/if}
    <tr valign="top" align="left">
    	<td align="right" width="250px">Квартира <font color="red">*</font>:</td>
    	<td>
    		<input type="text" name="apartment" style="width:250px;" value="{$page.form.apartment}" /><br/>
    	 </td>
    </tr>
    {if $UERROR->GetErrorByIndex('floor') != ''}
    	<tr>
    		<td width="250px" align="right">&nbsp;</td>
    		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('floor')}</span></td>
    	</tr>
    {/if}
    <tr valign="top" align="left">
    	<td align="right" width="250px">Этаж:</td>
    	<td>
    		<input type="text" name="floor" style="width:250px;" value="{$page.form.floor}" /><br/>
    	 </td>
    </tr>
    {if $UERROR->GetErrorByIndex('phone') != ''}
    	<tr>
    		<td width="250px" align="right">&nbsp;</td>
    		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('phone')}</span></td>
    	</tr>
    {/if}
    <tr valign="top" align="left">
    	<td align="right" width="250px">Номер телефона <font color="red">*</font>:</td>
    	<td>
    		<input type="text" name="phone" style="width:250px;" value="{$page.form.phone}" /><br/>
    		<small>Формат: +71234567890</small>
    	 </td>
    </tr>
    {if $UERROR->GetErrorByIndex('persons') != ''}
    	<tr>
    		<td width="250px" align="right">&nbsp;</td>
    		<td align="left" class="error"><span>{$UERROR->GetErrorByIndex('persons')}</span></td>
    	</tr>
    {/if}
    <tr valign="top" align="left">
    	<td align="right" width="250px">Количество персон:</td>
    	<td>
    		<input type="text" name="persons" style="width:250px;" value="{$page.form.persons}" /><br/>
    	 </td>
    </tr>
    </table>
    <table align="center" border="0" cellpadding="3" cellspacing="2" width="550">

    	<tr>
    		<td align="center"><input type="submit" value="Сохранить изменения" /></td>
    	</tr>
    </table>
    </form>
*}
</div>

