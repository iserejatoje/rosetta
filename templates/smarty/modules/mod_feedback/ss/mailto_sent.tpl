{literal}<style>
.feedback_header{
	color:#03424A;
	font-family:verdana,tahoma,helvetica,sans-serif;
	font-size:12px;
	font-weight:bold;
}
.feedback_text{
	color:#03424A;
	font-family:verdana,tahoma,helvetica,sans-serif;
	font-size:12px;
	font-weight:normal;
}
</style>{/literal}
{if $page.email!=""}
<br><br><br><br><br><br><br><br>
<div align="center" style="font-size: 18px;" class="feedback_text">
E-mail:<br/>
<a href="mailto:{$page.email}" class="feedback_header">{$page.email}</a><br>
</div><br>
<div align="center"><a href="javascript:window.close();" class="feedback_header">Закрыть</a></div>
{else}
<br><br><br><br><br><br><br><br>
<div align="center">
<b class="feedback_text">Ваше письмо отправлено</b><br><br>
</div><br>
<div align="center"><a href="javascript:window.close();" class="feedback_header">Закрыть</a></div>
{/if}
