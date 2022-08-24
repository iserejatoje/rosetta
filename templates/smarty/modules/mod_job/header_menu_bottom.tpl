{* 
	:TODO:
	
	TRASH
	
	Переменные из модуля на прямую в смарти отдаваться не должны.
	Каждый логический блок должен генерироваться отдельным методом.
	
	Всё что идет ниже не верно!!!
*}
<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td class="menu_top2"><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$CURRENT_ENV.section}/?cmd=vacsearchfrm"><span>искать вакансию</span></a></td>
		<td class="menu_top2"><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$CURRENT_ENV.section}/?cmd=ressearchfrm"><span>искать резюме</span></a></td>
		<td class="menu_top2"><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$CURRENT_ENV.section}/?cmd=nvac"><span>разместить вакансию</span></a></td>
		<td class="menu_top2"><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$CURRENT_ENV.section}/?cmd=nres"><span>разместить резюме</span></a></td>
		{if !$uid}
			<td class="menu_top2"><a onmouseover="menu_top2_over(this.parentNode);" onmouseout="menu_top2_out(this.parentNode);" href="/{$CURRENT_ENV.section}/?cmd=remindfrm"><span>напомнить пароль</span></a></td>
		{/if}
		<td>&nbsp;&nbsp;</td>
	</tr>
</table>