
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr> 
	<td align="left">
		
		{if $BLOCK.uid}
		<ul class="lul">
			<li><a href="/{$BLOCK.section}/user/settings.html"><b>мой профиль</b></a></li>
			<li><a href="/{$BLOCK.section}/editlist.html"><b>мои компании</b></a></li>
			<li><a href="/{$BLOCK.section}/logout.html"><b>выйти</b></a></li>
		</ul>
		{else}
		<ul class="lul">
			<li><a href="javascript:void(0)" onclick="window.open('/{$BLOCK.section}/register.html', 'ereg', 'menubar=no, status=no, scrollbars=no, toolbar=no, top=20, left=20, width=500,height=350');"><b>регистрация</b></a></li>
			<li><a href="/{$BLOCK.section}/auth.html"><b>войти</b></a></li>
		</ul>
		{/if}
		<ul class="lul">
			<li><a href="/{$BLOCK.section}/"><b>главная</b></a></li>
			<li><a href="/{$BLOCK.section}/addorg.html"><b>добавить компанию</b></a></li>
			<li><a href="javascript:void(0)" onclick="window.open('http://rugion.ru/add_firm.html', 'ereg', 'menubar=no, status=no, scrollbars=no, toolbar=no, top=20, left=20, width=530,height=400');"><b>правила</b></a></li>
		</ul>
	</td>
</tr>
</table>