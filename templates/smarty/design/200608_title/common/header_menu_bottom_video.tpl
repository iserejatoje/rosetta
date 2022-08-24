<TABLE cellSpacing="0" cellPadding="0" border="0">
<TR vAlign="center" align="middle">
<TD>&nbsp;</TD>
{if $CURRENT_ENV.section == 'competition' || $CURRENT_ENV.section == 'pages'}
	{if in_array($CURRENT_ENV.params, array('5.php','6.php','7.php','8.php','9.php','10.php','11.php','12.php')) || ($CURRENT_ENV.regid == 34 && $CURRENT_ENV.params == 'novogod.html')} {* было {if $CURRENT_ENV.params == '1.php' || ($CURRENT_ENV.regid == 34 && $CURRENT_ENV.params == 'novogod.html')} *}
	<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/video/">Все видео</a></span></td>
	{/if}
{elseif $CURRENT_ENV.section == 'video'}
	{*if $CURRENT_ENV.regid == 34}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="http://v1.ru/pages/novogod.html">О проекте</a></span></td>
	{/if}
	{else*}

	{assign var="competition_link" value=""}
	{if $CURRENT_ENV.regid == 2}
		{assign var="competition_link" value="6.php"}
	{elseif $CURRENT_ENV.regid == 16}
		{assign var="competition_link" value="11.php"}
	{elseif $CURRENT_ENV.regid == 34}
		{assign var="competition_link" value="9.php"}
	{elseif $CURRENT_ENV.regid == 59}
		{assign var="competition_link" value="5.php"}
	{elseif $CURRENT_ENV.regid == 61}
		{assign var="competition_link" value="7.php"}
	{elseif $CURRENT_ENV.regid == 63}
		{assign var="competition_link" value="8.php"}
	{elseif $CURRENT_ENV.regid == 72}
		{assign var="competition_link" value="10.php"}
	{elseif $CURRENT_ENV.regid == 74}
		{assign var="competition_link" value="12.php"}
	{/if}

	{if !empty($competition_link)}
		<td onmouseover="menu_top2_over(this);" onmouseout="menu_top2_out(this);" class="menu_top2"><span><a href="/competition/{$competition_link}">Добавить видео</a></span></td>
	{/if}
	{*/if*}
{/if}
<TD>&nbsp;&nbsp;</TD>
</TR>
</TABLE>