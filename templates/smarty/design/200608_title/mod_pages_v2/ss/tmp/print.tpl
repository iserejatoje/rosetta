
{if is_array($page) && $page.id > 0 }
<table cellspacing="0" cellpadding="0" border="0" align="left" width="100%">
<tr class="title2_news">
	<td width="10"><img height="1" border="0" width="10" alt="" src="/_img/x.gif"/></td>
	<td class="title2_news"><span class="bl_date_news">17 августа 2009</span><br/>
			{$page.name}
	</td>
</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td style="padding: 10px;">
{$page.text}

<script language="javascript" type="text/javascript">
{literal}
<!--
window.print();
-->
{/literal}
</script>


{else}
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td style="padding: 10px;">
	<br /><br /><br /><br />
	<center>
	Материал не найден.<br /><br />
	<a href="/{$ENV.section}/">Список материалов</a>
	</center>
{/if}


</td></tr>
</table>
<p align="center"><a href="javascript:window.close();" class="copy">Закрыть</a></p>
