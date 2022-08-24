<table border="0" cellspacing="2" cellpadding="0" width="100%" style="padding-left:2px;">  
	<tr><td><img src="/_img/x.gif" width="5" height="1" border="0" alt="" /></td></tr>
	<tr><td>
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr><td style="width:22px;">
		<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" target="_blank" class="a16b"><img src="/img/icon_work_p.gif" border="0"></a></td><td>&nbsp;<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/"|escape:"url"}" {if $ENV.site.domain == "74.ru"} style="color:red;"{/if} target="_blank" class="a16b">Работа:</a>
		</td></tr>
		</table>
	</td></tr>
	<tr><td style="padding-left:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/vacancy/1.php"|escape:"url"}" target="_blank"><font color="red">Вакансии</font></a> <font class="txt_blue">(<font style="font-size:11px;font-weight:bold;">{$res.vacancy|number_format:0:' ':' '}</font>)</font></td></tr>
	<tr><td style="padding-left:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/resume/1.php"|escape:"url"}" target="_blank">Резюме</a> <font class="txt_blue">(<font style="font-size:11px;font-weight:bold;">{$res.resume|number_format:0:' ':' '}</font>)</font></td></tr>
{if $ENV.site.domain == "74.ru"}
	<tr><td style="padding-left:10px;"><a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/list/vacancy/firm.php"|escape:"url"}" target="_blank" style="color:red">Вакансии компаний</a></td></tr>	
{/if}
{if $CURRENT_ENV.regid == 66}
	<tr><td style="padding-left:10px;"><a href="/consult/rabota/1/" target="_blank" style="color:red">Консультация</a></td></tr>
{/if}
	<tr><td style="font-size:9px;color:#8AA3A6;">Добавить: <a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/my/vacancy/add.php"|escape:"url"}" target="_blank" style="font-size:9px;color:#8AA3A6;">вакансию</a>,<a href="/service/go/?url={"http://`$ENV.site.domain`/`$ENV.section`/my/resume/add.php"|escape:"url"}" style="font-size:9px;color:#8AA3A6;" target="_blank">резюме</a></td></tr>
	<tr><td><img src="/_img/x.gif" width="3" height="1" border="0" alt="" /></td></tr>
</table>
