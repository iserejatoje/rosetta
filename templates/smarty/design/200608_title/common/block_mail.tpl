	<div class="login_form">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
		<tr>
			<td id="btn_1" class="login_form_title active_button" title="Поиск" width="100%" onclick="login_form.switch_form(1,'{$res.url}'); $('#login_email').focus(); $('#login_form_page_mail').css('display','none'); $('#login_form_page_search').css('display','block');"><img border="0" height="11" width="35" src="/_img/design/200608_title_blue/login_form/btn_search.gif" alt="Поиск"></td>
			<td id="btn_divider" class="login_form_title btn_divider_left"><img src="/_img/x.gif" border="0" width="10" height="16" /></td>
			<td id="btn_2" class="login_form_title inactive_button" title="Вход в почту" onclick="login_form.switch_form(2,'{$res.url}'); $('#login_email').focus(); $('#login_form_page_search').css('display','none'); $('#login_form_page_mail').css('display','block');"><img border="0" height="11" width="62" src="/_img/design/200608_title_blue/login_form/post-enter.gif" alt="Вход в почту"></td>
		</tr>
		</table>
		
		<div id="login_form_page_search">
		<table border="0" width="100%" cellpadding="4" cellspacing="0" class="form">
		<tr><td>
			<table cellspacing="0" cellpadding="0" bgcolor="#d3dfee" width="100%">
			<form action="/search/search.php" method="get" target="_blank" enctype="application/x-www-form-urlencoded" style="margin:0px" />
			<input type="hidden" value="search" name="action" />
			<input type="hidden" value="3" name="where" />
				<tr>
					<td align="left" colspan="2">
						<input type="text" style="width: 213px;" name="text" />
					</td>
				</tr>
				<tr>
					<td align="left">
						<select style="width: 147px;" name="a_t">
							<option selected="">Где искать</option>
							<option value="0">По сайтам</option>
							<option value="1">По текстам</option>
							<option value="3">По справочникам</option>
							{*<option value="5">По вакансиям</option>*}
						</select>
					</td>
					<td align="right">
						<input type="submit" value="Искать" tabindex="1003" name="submit2222" style="width:64px" />
					</td>
				</tr>
				<tr>
					<td align="center" colspan="2"><a href="/search/advanced.php?sortby=rlv&where=3&col_pp=10&text=" class="links">Расширенный поиск</a></td>
				</tr>
			</table>
			</form>
		</td></tr>
		</table>
		</div>

		<div id="login_form_page_mail" style="display:none">
		<form style="margin: 0px;" action="/passport/login.php" method="post">
		<input type="hidden" name="action" value="login" />
		<input id="login_url" type="hidden" name="url" value="/mail/" />
		<table border="0" width="100%" cellpadding="4" cellspacing="0" class="form">
		<tr><td>
			{$BLOCKS.header.login_mail}
		</td></tr>
		</table>
		</form>
		</div>
		
		
	</div>