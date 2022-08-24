{ if $res.converting!=1}
<table width=100% cellpadding=0 cellspacing=0 border=0>
	<tr>
		<td>
			<table cellpadding=0 cellspacing=0 border=0 width=100%>
				<tr>
					<td>
<form name=frmaddfolder method=POST onsubmit="return valid_frmaddfolder(this)">
<input type=hidden name=action value="{$res.action}">
<input type=hidden name=id value={$res.id}>
<input type=hidden name=gid value={$res.gid}>
<input type=hidden name=parentid value={$res.parentid}>
<input type=hidden name=p value={$res.p}>
						<table cellpadding=4 cellspacing=1 border=0 width=100%>	
							<tr>
								<td class="block_title2"><a name=addfolder></a><span>Добавить папку</span></td>
							</tr>
							{if $res.err.form}	
							<tr>
								<td align=center bgcolor=#ffffff>{include  file="`$TEMPLATE.errors`" errors_list=$res.err.form}</td>
							</tr>
							{/if}
							<tr>
								<td bgcolor=#ffffff style="padding:0;spacing:0">
									<table width=100% cellpadding=4 cellspacing=0 border=0>
										<tr bgcolor=#F5F9FA align=left valign=middle>
											<td>
												<a href='{$CONFIG.files.get.users_list.string}?id={$ENV.user.id}'><b>{$USER->NickName}</a>
											</td>
										</tr>
										<tr align=left>
											<td nowrap>Название:<INPUT class=input type=text name="name" style="width:50%" maxlength=255 value="{$res.name|escape:"html"}"></td>
										</tr>
										<tr align=left>
											<td>Доступ к папке:<br/>
<select class=input name=access size=1 type=select-one style="width:350">
{foreach from=$res.arr_access item=l key=k}
	<option value={$k} {if $k==$res.access}selected{/if}>{$l}</option>
{/foreach}
</select>
											</td>
										</tr>
										<tr>
											<td>
<INPUT class=button name=btnsave type=submit value="{if $res.action == 'gallery_addfolder'}Добавить{else}Сохранить{/if}" style="width:100">&nbsp;&nbsp;
<INPUT class=button type=button onclick="window.history.go(-1);" value="Назад" style="width:100">
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="/_img/x.gif" width=0 height=20 border=0></td>
	</tr>
</table>

<SCRIPT language="JavaScript">
{literal}

function valid_frmaddfolder(frm){
  if( frm.name.value.length ==0) {
    alert("Напишите название!");
    frm.name.focus();
    return false;
  }
  if( frm.name.value.length > 255) {
    alert("Название не может превышать 255 символов!");
    frm.name.focus();
    return false;
  }
	frm.btnsave.disabled=true;
  return true;
}
{/literal}
</SCRIPT>
{else}
<br/><br/><br/><br/><center><b>Раздел на модернизации</b></center>
{/if}