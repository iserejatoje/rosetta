
{if $_nocomment == false && $res.converting!=1}
<a name="addcomment"></a>
<table  width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td align=center>
			<table cellpadding=0 cellspacing=0 border=0 width=100%>
				<tr>
					<td>
						<form name=frmaddcomment method=POST onsubmit="return valid_frmeditcomment(this)">
						<input type=hidden name=action value="{$res.action}">
						<input type=hidden name=cid value={$res.cid}>
						<input type=hidden name=rid value={$res.rid}>
						<input type=hidden name=id value={$res.id}>
						<input type=hidden name=p value={$res.p}>
						<input type=hidden name=gid value={$res.gid}>
						<input type=hidden name=parentid value={$res.parentid}>
						<table cellpadding=4 cellspacing=1 border=0 width=100%>
						<tr>
							<td class="block_title2">
								<a name=editcomment></a>
								<span>{if ereg('addcomment',$res.action)}Добавить комментарий{else}Редактировать комментарий{/if}</span>
							</td>
						</tr>
						{if $res.err.form}	
						<tr>
							<td align=center bgcolor=#ffffff>{include  file="`$TEMPLATE.errors`" errors_list=$res.err}</td>
						</tr>
						{/if}
						<tr>
							<td bgcolor=#ffffff style="padding:0;spacing:0">
								<table width=100% cellpadding=4 cellspacing=0 border=0>
									<tr bgcolor=#F5F9FA align=left valign=middle>
										<td>
										{if $USER->ID==0}
											<a><b>Гость</b></a>
										{else}
											<a href='{$CONFIG.files.get.journals_profile.string}?id={$USER->ID}'><b>{$USER->NickName}</a>
										{/if}
										</td>
									</tr>
									{include  file="`$TEMPLATE.vbcode`"}
									{include  file="`$TEMPLATE.smiles`"}
									<tr align=center>
										<td><TEXTAREA class=input style="width:100%" name="text" rows="10">{$res.text}</TEXTAREA></td>
									</tr>
									<tr bgcolor=#FFFFFF align=left>
										<td>
{if $res.action == 'journals_editcomment' || ($USER->isAuth() && !$_issubscribe)}
<input type=checkbox name=optsubscribe{if $res.optsubscribe} checked{/if} title="Уведомлять меня о новых комментариях"> Подписаться на новые комментарии<br>
{/if}
<input type=checkbox name=optnosmile{if $res.optnosmile} checked{/if}> Не преобразовывать смайлы
										</td>
									</tr>
									<tr>
										<td>
										{if ereg('addcomment',$res.action) && !$USER->isAuth()}
										<table border="0">
											<tr>
												<td align="right" nowrap="nowrap">Защита от роботов:</td>
												<td nowrap="nowrap">
													<img src="{$res.captcha_path}" align="absmiddle" width='150' height='50' alt='код' border=0> &gt;&gt;
												</td>
												<td align="left" width="100%">&#160;<input type='text' name="captcha_code" size=20 class="text_edit" style="width:80px;">
													<br/>Введите четырехзначное число, которое Вы видите на картинке
												</td>
											</tr>
										</table>
										{/if}
		<INPUT class=button name="btnsave" type=submit value="{if ereg('addcomment',$res.action)}Добавить{else}Сохранить{/if}" style="width:100">
		&nbsp;&nbsp;
		<INPUT class=button type=button onclick="window.history.go(-1);" value="Назад" style="width:100">
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</form>
<SCRIPT language="JavaScript">
{literal}

var myform = document.frmaddcomment;

function valid_frmeditcomment(frm){
  if( frm.text.value.length == 0) {
    alert("Но Вы же ничего не написали!");
    frm.text.focus();
    return false;
  }
	frm.btnsave.disabled=true;
  return true;
}
{/literal}
</SCRIPT>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width=0 height=20 border=0></td>
	</tr>
</table>
{/if}