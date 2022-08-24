{* 
	:TODO:
	
	TRASH
	
	Переменные из модуля на прямую в смарти отдаваться не должны.
	Каждый логический блок должен генерироваться отдельным методом.
	
	Всё что идет ниже не верно!!!
*}
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<tr>
						<td valign="top" height="20">
							<table width="100%"  border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="350">
										<span class="infa">За сутки добавлено: </span>
										<span class="infa2">вакансий - <a href="/{$CURRENT_ENV.section}/?cmd=vaclst"><font color="#FF0000">{$tod_vac|number_format:"0":",":" "}</font></a> , резюме - <a href="/{$CURRENT_ENV.section}/?cmd=reslst"><font color="#FF0000">{$tod_res|number_format:"0":",":" "}</font></a> </span>&nbsp;&nbsp;&nbsp;
									</td>
									<td>
										<span class="infa" style="padding: 3px 0px 0px 0px; margin: 0px;">Просмотренных страниц сегодня:</span>
										<span class="infa2" style="padding: 0px; margin: 0px;"><font color="#FF0000">{$tod_view|number_format:"0":",":" "}</font></span>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<span class="section_title">
											{$CURRENT_ENV.site.title[$CURRENT_ENV.section]}
										</span>
									</td>
									<td valign="middle" bgcolor="#E0F3F3">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												{if isset($BLOCKS.header.header_hot_link)}
												<td height="40" align="center">
													{$BLOCKS.header.header_hot_link}
												</td>
												{/if}
												{if isset($BLOCKS.header.header_bunner)}
													<td align="center">{$BLOCKS.header.header_bunner}</td>
												{elseif $SMARTY->is_template("design/199801_title_main/`$CURRENT_ENV.site.domain`/common/header_bunner.tpl")}
													<td align="center">{include file="design/199801_title_main/`$CURRENT_ENV.site.domain`/common/header_bunner.tpl"}</td>
												{else}
													<td align="center">{include file="design/200608_title/common/header_bunner.tpl"}</td>
												{/if}
											</tr>
										</table>
									</td>
									<td align="right">
										<table width="250" border="0" cellspacing="3" cellpadding="0" bgcolor="#D1EAEA">
											{if $uid!=0}
											<form name="login" method="post">
												<input type="hidden" name="cmd" value="exit">
											<tr>
												<td width="80" align="center" class="infa"><font color=#ff0000>{if $email}{$email}{else}{$user}{/if}</font></td>
												<td>
													<a href="/{$CURRENT_ENV.section}/?cmd=edvac" id="infa2">редактировать&nbsp;вакансию&nbsp;({$nvac})</a><br/>
													<a href="/{$CURRENT_ENV.section}/?cmd=edres" id="infa2">редактировать&nbsp;резюме&nbsp;({$nres})</a>
													{if $showotz}<br/><a href="/{$CURRENT_ENV.section}/?cmd=editquest" id="infa2">вопросы ({if $nquest!=0}<b>{$nquest}</b>{else}0{/if}/{$aquest})</a>{/if}
												</td>
												<td style="padding-right:20px;width:90px">
													<input type="submit" name="Submit" value="Выход">
												</td>
											</tr>
											</form>
											{else}
											<form name="login" method="post">
												<input type="hidden" name="cmd" value="enter" />
											<tr>
												<td width="80" class=infa style="padding-left:5px;">Имя</font></td>
												<td><input type="text" name="name" style="width:70px;font-size: 11px"></td>
												<td style="padding-right:20px;width:90px"><input type="submit" name="Submit" value="    Войти    "></td>
											</tr>
											<tr>
												<td width="80" class=infa style="padding-left:5px;">Пароль</td>
												<td><input type="password" name="password" style="width:70px;font-size: 11px"></td>
												<td>
													<table cellpadding=0 cellspacing=0 border=0>
														<tr>
															<td>
																<input type="checkbox" name="remember" value="1">
															</td>
															<td class="infa">&#160;Запомнить</td>
														</tr>
													</table>
												</td>
											</tr>
											</form>
											{/if}
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td height="20">
							<table width="100%"  border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td>
										<a href="/{$CURRENT_ENV.section}/" class="gl">Главная</a>&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="/{$CURRENT_ENV.section}/?cmd=showsl" class="gl">Подписка</a>&nbsp;&nbsp;&nbsp;&nbsp;
										{if $uid!=0}
											<a href="/{$CURRENT_ENV.section}/?cmd=card" class="gl">Настройка</a>&nbsp;&nbsp;&nbsp;&nbsp;
										{else}
											<a href="/{$CURRENT_ENV.section}/?cmd=regfrm" class="gl">Регистрация</a>&nbsp;&nbsp;&nbsp;&nbsp;
										{/if}
										<a href="/{$CURRENT_ENV.section}/?cmd=rules" class="gl"><font color=red>Правила</font></a>&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="/{$CURRENT_ENV.section}/?cmd=idealres" class="gl">Как писать резюме?</a>&nbsp;&nbsp;&nbsp;&nbsp; 
										<a href="/{$CURRENT_ENV.section}/?cmd=articles" class="gl">Аналитика</a>&nbsp;&nbsp;&nbsp;&nbsp; 
										<a href="/forum/view.html?id={$forum_id}" class="gl" target="_blank">Форум о работе</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>