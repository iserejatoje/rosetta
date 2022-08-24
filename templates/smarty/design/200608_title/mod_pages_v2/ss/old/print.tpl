<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr><td style="padding: 10px;">


{if is_array($page) && $page.id > 0 }
<h3>{$page.name}</h3>
{$page.text}

<script language="javascript" type="text/javascript">
{literal}
<!--
window.print();
-->
{/literal}
</script>


{else}
	<br /><br /><br /><br />
	<center>
	Материал не найден.<br /><br />
	<a href="/{$ENV.section}/">Список материалов</a>
	</center>
{/if}


</td></tr>
</table>
<p align="center"><a href="javascript:window.close();" class="dop2">Закрыть</a></p>
